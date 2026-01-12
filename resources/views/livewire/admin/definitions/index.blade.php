<div>
    <!-- Page Header -->
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center shadow-lg shadow-indigo-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white">Definitions Manager</h1>
            <p class="text-gray-400 text-sm">Moderate community-submitted definitions</p>
        </div>
    </div>

    <!-- Filters & Toolbar -->
    <div class="bg-[#001f42] p-4 rounded-t-xl border border-white/10 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-96">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search content..."
                   class="w-full pl-10 pr-4 py-2.5 bg-black/20 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent transition-colors">
            <svg class="w-5 h-5 text-gray-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <select wire:model.live="filterStatus" class="bg-black/20 border border-white/10 rounded-lg text-white text-sm px-4 py-2.5 focus:outline-none focus:border-brand-accent transition-colors">
            <option value="all">All Definitions</option>
            <option value="controversial">Controversial (More Disagrees)</option>
        </select>
    </div>

    <div class="bg-[#001f42] rounded-b-xl border border-white/10 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-[#00152e] text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Word</th>
                    <th class="px-6 py-4 w-1/2">Definition</th>
                    <th class="px-6 py-4 text-center">Votes</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($definitions as $def)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 font-bold text-white">
                            <a href="{{ route('word.show', $def->word->slug) }}" target="_blank" class="hover:underline">
                                {{ $def->word->term }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-300">
                            <p class="mb-1">{{ Str::limit($def->definition, 100) }}</p>
                            @if($def->example)
                                <p class="text-xs text-gray-500 italic">"{{ Str::limit($def->example, 50) }}"</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-green-400 font-bold">+{{ $def->agrees }}</span>
                            <span class="text-gray-600 mx-1">/</span>
                            <span class="text-red-400 font-bold">-{{ $def->disagrees }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             <button wire:click="deleteDefinition({{ $def->id }})" wire:confirm="Delete this definition?" class="text-red-400 hover:text-white text-xs font-bold uppercase">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <div class="px-6 py-4 border-t border-white/5 bg-[#00152e]">
            {{ $definitions->links() }}
        </div>
    </div>
</div>
