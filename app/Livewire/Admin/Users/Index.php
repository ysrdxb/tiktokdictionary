<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Definition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = 'all';
    public $filterStatus = 'all';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $perPage = 20;

    // User detail modal
    public $showUserModal = false;
    public $selectedUser = null;
    public $userStats = [];

    // Edit user modal
    public $showEditModal = false;
    public $editingUser = null;
    public $editForm = [
        'username' => '',
        'email' => '',
        'role' => 'user',
        'new_password' => '',
    ];

    // Bulk actions
    public $selectedUsers = [];
    public $selectAll = false;

    // Ban modal
    public $showBanModal = false;
    public $banUserId = null;
    public $banReason = '';
    public $banDuration = 'permanent';

    protected $queryString = ['search', 'filterRole', 'filterStatus'];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUsers = $this->getUsersQuery()->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function viewUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->userStats = $this->getUserStats($id);
        $this->showUserModal = true;
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->selectedUser = null;
        $this->userStats = [];
    }

    protected function getUserStats($userId)
    {
        $user = User::find($userId);
        $username = '@' . $user->username;

        return [
            'definitions_count' => Definition::where('submitted_by', $username)->count(),
            'total_agrees' => Definition::where('submitted_by', $username)->sum('agrees'),
            'total_disagrees' => Definition::where('submitted_by', $username)->sum('disagrees'),
            'recent_definitions' => Definition::where('submitted_by', $username)
                ->with('word')
                ->latest()
                ->take(5)
                ->get(),
            'join_date' => $user->created_at->format('M d, Y'),
            'last_active' => $user->updated_at->diffForHumans(),
        ];
    }

    public function editUser($id)
    {
        $this->editingUser = User::find($id);
        $this->editForm = [
            'username' => $this->editingUser->username,
            'email' => $this->editingUser->email,
            'role' => $this->editingUser->role ?? 'user',
            'new_password' => '',
        ];
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingUser = null;
        $this->editForm = ['username' => '', 'email' => '', 'role' => 'user', 'new_password' => ''];
    }

    public function saveUser()
    {
        $this->validate([
            'editForm.username' => 'required|string|max:50|unique:users,username,' . $this->editingUser->id,
            'editForm.email' => 'required|email|unique:users,email,' . $this->editingUser->id,
            'editForm.role' => 'required|in:user,moderator,admin',
            'editForm.new_password' => 'nullable|min:8',
        ]);

        $data = [
            'username' => $this->editForm['username'],
            'email' => $this->editForm['email'],
            'role' => $this->editForm['role'],
            'is_admin' => $this->editForm['role'] === 'admin',
        ];

        if (!empty($this->editForm['new_password'])) {
            $data['password'] = Hash::make($this->editForm['new_password']);
        }

        $this->editingUser->update($data);

        $this->closeEditModal();
        $this->dispatch('notify', 'User updated successfully.');
    }

    public function openBanModal($id)
    {
        $this->banUserId = $id;
        $this->banReason = '';
        $this->banDuration = 'permanent';
        $this->showBanModal = true;
    }

    public function closeBanModal()
    {
        $this->showBanModal = false;
        $this->banUserId = null;
        $this->banReason = '';
    }

    public function confirmBan()
    {
        $user = User::find($this->banUserId);

        $bannedUntil = null;
        if ($this->banDuration !== 'permanent') {
            $bannedUntil = now()->addDays((int) $this->banDuration);
        }

        $user->update([
            'banned_at' => now(),
            'ban_reason' => $this->banReason ?: 'Violation of terms',
            'banned_until' => $bannedUntil,
        ]);

        $this->closeBanModal();
        $this->dispatch('notify', 'User has been banned.');
    }

    public function unbanUser($id)
    {
        User::find($id)->update([
            'banned_at' => null,
            'ban_reason' => null,
            'banned_until' => null,
        ]);
        $this->dispatch('notify', 'User has been unbanned.');
    }

    public function changeRole($id, $role)
    {
        $user = User::find($id);

        // Prevent removing own admin status
        if ($user->id === auth()->id() && $role !== 'admin') {
            $this->dispatch('notify', 'Cannot remove your own admin privileges.');
            return;
        }

        $user->update([
            'role' => $role,
            'is_admin' => $role === 'admin',
        ]);

        $this->dispatch('notify', "User role updated to {$role}.");
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            $this->dispatch('notify', 'Cannot delete your own account.');
            return;
        }

        $user->delete();
        $this->dispatch('notify', 'User deleted successfully.');
    }

    // Bulk actions
    public function bulkBan()
    {
        User::whereIn('id', $this->selectedUsers)
            ->where('id', '!=', auth()->id())
            ->update([
                'banned_at' => now(),
                'ban_reason' => 'Bulk admin action',
            ]);

        $count = count($this->selectedUsers);
        $this->selectedUsers = [];
        $this->selectAll = false;
        $this->dispatch('notify', "{$count} users banned.");
    }

    public function bulkUnban()
    {
        User::whereIn('id', $this->selectedUsers)
            ->update([
                'banned_at' => null,
                'ban_reason' => null,
            ]);

        $count = count($this->selectedUsers);
        $this->selectedUsers = [];
        $this->selectAll = false;
        $this->dispatch('notify', "{$count} users unbanned.");
    }

    public function bulkDelete()
    {
        User::whereIn('id', $this->selectedUsers)
            ->where('id', '!=', auth()->id())
            ->delete();

        $count = count($this->selectedUsers);
        $this->selectedUsers = [];
        $this->selectAll = false;
        $this->dispatch('notify', "{$count} users deleted.");
    }

    public function exportUsers()
    {
        // Generate CSV export
        $users = $this->getUsersQuery()->get();

        $csv = "ID,Username,Email,Role,Status,Created At\n";
        foreach ($users as $user) {
            $status = $user->banned_at ? 'Banned' : 'Active';
            $csv .= "{$user->id},{$user->username},{$user->email},{$user->role},{$status},{$user->created_at}\n";
        }

        $this->dispatch('download-csv', [
            'filename' => 'users_export_' . date('Y-m-d') . '.csv',
            'content' => $csv,
        ]);
    }

    protected function getUsersQuery()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('username', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterRole !== 'all') {
            $query->where('role', $this->filterRole);
        }

        if ($this->filterStatus === 'active') {
            $query->whereNull('banned_at');
        } elseif ($this->filterStatus === 'banned') {
            $query->whereNotNull('banned_at');
        }

        return $query->orderBy($this->sortBy, $this->sortDir);
    }

    public function render()
    {
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'moderators' => User::where('role', 'moderator')->count(),
            'banned' => User::whereNotNull('banned_at')->count(),
            'new_today' => User::whereDate('created_at', today())->count(),
        ];

        return view('livewire.admin.users.index', [
            'users' => $this->getUsersQuery()->paginate($this->perPage),
            'stats' => $stats,
        ])->layout('components.layouts.admin');
    }
}
