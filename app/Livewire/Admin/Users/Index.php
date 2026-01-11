<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = 'all';

    public function toggleBan($id)
    {
        $user = User::find($id);
        if ($user->banned_at) {
            $user->update(['banned_at' => null, 'ban_reason' => null]);
            $this->dispatch('notify', 'User unbanned.');
        } else {
            $user->update(['banned_at' => now(), 'ban_reason' => 'Admin action']);
            $this->dispatch('notify', 'User banned.');
        }
    }

    public function changeRole($id, $role)
    {
        $user = User::find($id);
        
        // Safety: Don't demo self if I am that user? 
        // For simplicity, we allow it but in real app check auth()->id() != $id
        
        $user->update(['role' => $role, 'is_admin' => ($role === 'admin')]);

        $this->dispatch('notify', "Role updated to $role.");
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
             $query->where('username', 'like', '%' . $this->search . '%')
                   ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        if ($this->filterRole !== 'all') {
             $query->where('role', $this->filterRole);
        }

        return view('livewire.admin.users.index', [
            'users' => $query->latest()->paginate(20)
        ])->layout('components.layouts.admin');
    }
}
