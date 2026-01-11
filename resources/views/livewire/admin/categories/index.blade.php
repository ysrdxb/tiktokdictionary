<div>
    <h1 class="text-3xl font-bold mb-6">Categories Manager</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="bg-[#001f42] p-6 rounded-xl border border-white/10 h-fit">
            <h2 class="font-bold mb-4">{{ $editingId ? 'Edit Category' : 'Create Category' }}</h2>
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Name</label>
                    <input wire:model="name" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-2 text-white">
                    @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Color (Hex)</label>
                    <div class="flex gap-2">
                        <input wire:model="color" type="color" class="h-10 w-10 rounded cursor-pointer border-0 p-0">
                        <input wire:model="color" type="text" class="flex-1 bg-black/20 border border-white/10 rounded-lg p-2 text-white uppercase">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Icon (Optional)</label>
                    <input wire:model="icon" type="text" placeholder="e.g. fire, trending-up" class="w-full bg-black/20 border border-white/10 rounded-lg p-2 text-white">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-brand-primary font-bold rounded-lg text-white hover:bg-brand-primary/90">
                        {{ $editingId ? 'Update' : 'Create' }}
                    </button>
                    @if($editingId)
                        <button type="button" wire:click="reset(['name', 'color', 'icon', 'editingId'])" class="px-3 py-2 bg-gray-600 rounded-lg text-white">Cancel</button>
                    @endif
                </div>
            </form>
        </div>

        <!-- List -->
         <div class="md:col-span-2 bg-[#001f42] rounded-xl border border-white/10 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#00152e] text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Color</th>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-6 h-6 rounded border border-white/20" style="background-color: {{ $cat->color }}"></div>
                            </td>
                            <td class="px-6 py-4 font-bold text-white">{{ $cat->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $cat->slug }}</td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="edit({{ $cat->id }})" class="text-blue-400 hover:text-white font-bold text-xs uppercase mr-3">Edit</button>
                                <button wire:click="delete({{ $cat->id }})" wire:confirm="Are you sure?" class="text-red-400 hover:text-white font-bold text-xs uppercase">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-4 text-center text-gray-500">No categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
