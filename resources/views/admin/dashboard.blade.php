<x-layouts.app>
    <div class="min-h-screen bg-slate-100 py-10">
        <div class="max-w-[1400px] mx-auto px-6">
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-[#00336E]">Dictionary Mainframe</h1>
                    <p class="text-slate-500">Manage viral content and community submissions.</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50">View Live Site</a>
                </div>
            </div>

            <!-- Stats Overview (Mini) -->
            <div class="grid grid-cols-4 gap-4 mb-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Words</div>
                    <div class="text-3xl font-black text-[#00336E]">{{ number_format($stats['all']) }}</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Verified</div>
                    <div class="text-3xl font-black text-blue-600">{{ number_format($stats['verified']) }}</div>
                </div>
                <div class="bg-[#00336E] p-6 rounded-xl shadow-sm border border-[#00336E] text-white">
                    <div class="text-xs font-bold text-white/50 uppercase tracking-wider">Viral Velocity</div>
                    <div class="text-3xl font-black">{{ number_format($stats['polar']) }}</div>
                </div>
                <!-- Pending Card -->
                 <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}" class="bg-amber-50 p-6 rounded-xl shadow-sm border border-amber-200 hover:bg-amber-100 transition-colors group">
                    <div class="text-xs font-bold text-amber-600 uppercase tracking-wider group-hover:underline">Pending Review</div>
                    <div class="text-3xl font-black text-amber-700">{{ number_format($stats['pending']) }}</div>
                </a>
            </div>

            <!-- Filter Tabs -->
            <div class="flex items-center gap-2 mb-6 border-b border-slate-200 pb-1">
                 <a href="{{ route('admin.dashboard') }}" 
                    class="px-4 py-2 text-sm font-bold rounded-t-lg transition-colors border-b-2 {{ $status === 'all' ? 'text-[#00336E] border-[#00336E] bg-white' : 'text-slate-500 border-transparent hover:text-slate-700' }}">
                    All Words
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}" 
                    class="px-4 py-2 text-sm font-bold rounded-t-lg transition-colors border-b-2 {{ $status === 'pending' ? 'text-amber-700 border-amber-500 bg-amber-50' : 'text-slate-500 border-transparent hover:text-amber-600' }}">
                    Pending Review ({{ $stats['pending'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'verified']) }}" 
                    class="px-4 py-2 text-sm font-bold rounded-t-lg transition-colors border-b-2 {{ $status === 'verified' ? 'text-blue-700 border-blue-500 bg-blue-50' : 'text-slate-500 border-transparent hover:text-blue-600' }}">
                    Verified
                </a>
                 <a href="{{ route('admin.dashboard', ['status' => 'polar']) }}" 
                    class="px-4 py-2 text-sm font-bold rounded-t-lg transition-colors border-b-2 {{ $status === 'polar' ? 'text-cyan-700 border-cyan-500 bg-cyan-50' : 'text-slate-500 border-transparent hover:text-cyan-600' }}">
                    Polar Trends
                </a>
            </div>

            <!-- Words Table -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Term</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Category</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Views</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Boost</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Viral Score</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($words as $word)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-[#00336E]">{{ $word->term }}</div>
                                        <div class="text-xs text-slate-400">{{ $word->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-bold">{{ $word->category }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono text-slate-600">
                                        {{ number_format($word->views) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($word->admin_boost > 0)
                                            <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-bold">+{{ $word->admin_boost }}</span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                       <div class="font-mono text-sm font-bold {{ $word->velocity_score > 100 ? 'text-green-600' : 'text-slate-500' }}">
                                            {{ number_format($word->velocity_score, 1) }}
                                       </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($word->is_polar_trend)
                                            <span class="inline-block w-3 h-3 bg-cyan-400 rounded-full animate-pulse" title="Polar Trend"></span>
                                        @endif
                                        @if($word->is_verified)
                                             <span class="inline-block w-3 h-3 bg-blue-600 rounded-full" title="Verified"></span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.words.edit', $word->id) }}" class="text-brand-primary font-bold hover:underline text-sm">Edit / Boost</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $words->links() }}
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
