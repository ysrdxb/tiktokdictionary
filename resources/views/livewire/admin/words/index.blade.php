<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2">Words Manager</h1>
            <p class="text-gray-400">Review content, manage trends, and verify submissions.</p>
        </div>
        <a href="{{ route('word.create') }}" target="_blank" class="px-4 py-2 bg-brand-primary text-white font-bold rounded-lg hover:bg-brand-primary/90 transition-colors">
            + New Word
        </a>
    </div>

    <!-- Filters & Toolbar -->
    <div class="bg-[#001f42] p-4 rounded-t-xl border border-white/10 flex flex-col md:flex-row gap-4 justify-between items-center">
        <!-- Search -->
        <div class="relative w-full md:w-96">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search terms, categories..." 
                   class="w-full pl-10 pr-4 py-2 bg-black/20 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent">
            <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <!-- Filters -->
        <div class="flex gap-2">
            <select wire:model.live="filterStatus" class="bg-black/20 border border-white/10 rounded-lg text-white text-sm px-3 py-2 focus:outline-none focus:border-brand-accent">
                <option value="all">All Status</option>
                <option value="pending">Pending Review</option>
                <option value="verified">Verified</option>
                <option value="polar">Polar Trends</option>
            </select>
        </div>
    </div>

    <!-- Bulk Actions (Visible when checked) -->
    @if(count($selected) > 0)
        <div class="bg-brand-dark/50 border-x border-white/10 p-3 flex items-center gap-4 text-sm animate-fade-in-down">
            <span class="font-bold text-white">{{ count($selected) }} selected</span>
            <button wire:click="verifySelected" class="text-green-400 hover:text-green-300 font-bold">Verify All</button>
            <button wire:click="deleteSelected" wire:confirm="Are you sure you want to delete these words?" class="text-red-400 hover:text-red-300 font-bold">Delete All</button>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-[#001f42] rounded-b-xl border border-white/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#00152e] text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-600 bg-gray-700 text-brand-primary focus:ring-offset-gray-900">
                        </th>
                        <th class="px-6 py-4 cursor-pointer hover:text-white" wire:click="sortBy('term')">
                            Term
                            @if($sortField === 'term') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th class="px-6 py-4 cursor-pointer hover:text-white" wire:click="sortBy('category')">
                            Category
                            @if($sortField === 'category') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th class="px-6 py-4 text-right cursor-pointer hover:text-white" wire:click="sortBy('views')">
                            Views
                            @if($sortField === 'views') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th class="px-6 py-4 text-center cursor-pointer hover:text-white" wire:click="sortBy('velocity_score')">
                            Viral Score
                             @if($sortField === 'velocity_score') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($words as $word)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4">
                                <input type="checkbox" wire:model.live="selected" value="{{ $word->id }}" class="rounded border-gray-600 bg-gray-700 text-brand-primary focus:ring-offset-gray-900">
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-white text-base">{{ $word->term }}</div>
                                <div class="text-xs text-gray-500">{{ $word->slug }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-white/5 rounded text-xs text-gray-300 border border-white/10">{{ $word->category }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-gray-300">
                                {{ number_format($word->views) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-mono font-bold {{ $word->velocity_score > 100 ? 'text-green-400' : 'text-gray-500' }}">
                                    {{ number_format($word->velocity_score, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="toggleVerified({{ $word->id }})" class="mr-2 focus:outline-none transition-transform active:scale-95" title="Toggle Verification">
                                    <span class="w-3 h-3 inline-block rounded-full {{ $word->is_verified ? 'bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]' : 'bg-gray-600' }}"></span>
                                </button>
                                <button wire:click="togglePolar({{ $word->id }})" class="focus:outline-none transition-transform active:scale-95" title="Toggle Polar Trend">
                                    <span class="w-3 h-3 inline-block rounded-full {{ $word->is_polar_trend ? 'bg-cyan-400 animate-pulse shadow-[0_0_8px_rgba(34,211,238,0.6)]' : 'bg-gray-600' }}"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.words.edit', $word->id) }}" class="text-blue-400 hover:text-white font-bold text-xs uppercase">Edit</a>
                                    <a href="{{ route('word.show', $word->slug) }}" target="_blank" class="text-gray-400 hover:text-white text-xs uppercase">View</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No words found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-white/5 bg-[#00152e]">
            {{ $words->links() }}
        </div>
    </div>
</div>
