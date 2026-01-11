<div>
    <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
    <p class="text-gray-400 mb-8">Welcome back, Admin.</p>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-[#00356B] rounded-xl p-6 border border-white/5 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l-.9.9a2 2 0 01-2.76 0l-.9-.9H5a2 2 0 01-2-2V5z"></path></svg>
            </div>
            <div class="text-sm font-medium text-gray-300 uppercase tracking-wider mb-1">Total Words</div>
            <div class="text-3xl font-bold text-white">{{ number_format($stats['total_words']) }}</div>
            <div class="{{ $stats['pending_words'] > 0 ? 'text-amber-400' : 'text-green-400' }} text-xs font-bold mt-2">
                {{ $stats['pending_words'] }} Waiting Review
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-[#00356B] rounded-xl p-6 border border-white/5 relative overflow-hidden">
            <div class="text-sm font-medium text-gray-300 uppercase tracking-wider mb-1">Total Users</div>
            <div class="text-3xl font-bold text-white">{{ number_format($stats['total_users']) }}</div>
            <div class="text-green-400 text-xs font-bold mt-2">
                +12% vs last week
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-[#00356B] rounded-xl p-6 border border-white/5 relative overflow-hidden">
            <div class="text-sm font-medium text-gray-300 uppercase tracking-wider mb-1">Engagement</div>
            <div class="text-3xl font-bold text-white">{{ number_format($stats['total_votes']) }}</div>
            <div class="text-xs text-gray-400 mt-2">Total Votes Cast</div>
        </div>

        <!-- Card 4 -->
        <div class="bg-gradient-to-br from-brand-primary to-orange-600 rounded-xl p-6 border border-white/5 relative overflow-hidden text-white">
            <div class="text-sm font-medium uppercase tracking-wider mb-1 opacity-90">Flags / Reports</div>
            <div class="text-3xl font-bold">{{ $flagsCount }}</div>
            <div class="text-xs opacity-80 mt-2">Action required</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Submissions -->
        <div class="bg-[#001f42] rounded-xl border border-white/10 overflow-hidden">
            <div class="p-6 border-b border-white/10 flex justify-between items-center">
                <h3 class="font-bold text-lg">Recent Submissions</h3>
                <a href="{{ route('admin.words') }}" class="text-sm text-blue-400 hover:text-blue-300">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#00152e] text-gray-400 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 font-medium">Term</th>
                            <th class="px-6 py-3 font-medium">Verified</th>
                            <th class="px-6 py-3 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($recentWords as $word)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-bold text-white">{{ $word->term }}</td>
                                <td class="px-6 py-4">
                                    @if($word->is_verified)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/10 text-green-400">Verified</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-500/10 text-amber-400">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-400">{{ $word->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Status (Mock) -->
        <div class="bg-[#001f42] rounded-xl border border-white/10 p-6">
            <h3 class="font-bold text-lg mb-6">System Health</h3>
            
            <div class="space-y-6">
                <!-- Item -->
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-400">Database Connection</span>
                        <span class="text-green-400 font-bold">Stable</span>
                    </div>
                    <div class="w-full bg-white/5 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                 <!-- Item -->
                 <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-400">Redis Cache Hit Rate</span>
                        <span class="text-blue-400 font-bold">94%</span>
                    </div>
                    <div class="w-full bg-white/5 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 94%"></div>
                    </div>
                </div>
                 <!-- Item -->
                 <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-400">Storage Usage</span>
                        <span class="text-orange-400 font-bold">62%</span>
                    </div>
                    <div class="w-full bg-white/5 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: 62%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
