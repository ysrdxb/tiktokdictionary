<div>
    <h1 class="text-3xl font-bold mb-6">Users Manager</h1>

    <div class="bg-[#001f42] p-4 rounded-t-xl border border-white/10 flex flex-col md:flex-row gap-4 justify-between items-center">
         <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search users..." 
                   class="w-full md:w-96 pl-4 pr-4 py-2 bg-black/20 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent">
        
         <select wire:model.live="filterRole" class="bg-black/20 border border-white/10 rounded-lg text-white text-sm px-3 py-2">
            <option value="all">All Roles</option>
            <option value="regular">Regular</option>
            <option value="admin">Admin</option>
            <option value="moderator">Moderator</option>
        </select>
    </div>

    <div class="bg-[#001f42] rounded-b-xl border border-white/10 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-[#00152e] text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Joined</th>
                    <th class="px-6 py-4 text-center">Banned</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $user->username }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email ?? 'No email' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold uppercase 
                                {{ $user->role === 'admin' ? 'bg-purple-500/10 text-purple-400' : 
                                  ($user->role === 'moderator' ? 'bg-blue-500/10 text-blue-400' : 'bg-white/5 text-gray-400') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->banned_at)
                                <span class="text-red-400 font-bold text-xs uppercase">Yes</span>
                            @else
                                <span class="text-gray-600">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                             <div class="flex items-center justify-end gap-2">
                                 @if($user->role !== 'admin')
                                    <button wire:click="changeRole({{ $user->id }}, 'admin')" class="text-xs text-purple-400 hover:text-white">Make Admin</button>
                                @else
                                    <button wire:click="changeRole({{ $user->id }}, 'regular')" class="text-xs text-gray-400 hover:text-white">Demote</button>
                                @endif
                                
                                <button wire:click="toggleBan({{ $user->id }})" class="text-xs font-bold {{ $user->banned_at ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $user->banned_at ? 'Unban' : 'Ban' }}
                                </button>
                             </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <div class="px-6 py-4 border-t border-white/5 bg-[#00152e]">
            {{ $users->links() }}
        </div>
    </div>
</div>
