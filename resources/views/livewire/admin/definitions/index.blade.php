<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2">Definitions Manager</h1>
            <p class="text-gray-400">Moderate community submissions.</p>
        </div>
    </div>

    <div class="bg-[#001f42] p-4 rounded-t-xl border border-white/10 flex justify-between items-center">
         <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search content..." 
                   class="w-full md:w-96 pl-4 pr-4 py-2 bg-black/20 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent">
        
         <select wire:model.live="filterStatus" class="bg-black/20 border border-white/10 rounded-lg text-white text-sm px-3 py-2">
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
