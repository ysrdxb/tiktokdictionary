<div>
    <!-- Page Header -->
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-primary to-orange-500 flex items-center justify-center shadow-lg shadow-brand-primary/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        </div>
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white">Dashboard</h1>
            <p class="text-gray-400 text-sm">Welcome back! Here's what's happening with TikTokDictionary</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <!-- Total Words -->
        <div class="stat-card bg-gradient-to-br from-[#002B5B] to-[#001a3a] rounded-2xl p-6 border border-white/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-colors"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-green-400 bg-green-500/10 px-2 py-1 rounded-full">+12%</span>
                </div>
                <p class="text-sm text-gray-400 font-medium mb-1">Total Words</p>
                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_words']) }}</p>
            </div>
        </div>

        <!-- Pending Review -->
        <div class="stat-card bg-gradient-to-br from-[#002B5B] to-[#001a3a] rounded-2xl p-6 border border-white/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-colors"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    @if($stats['pending_words'] > 0)
                        <span class="text-xs font-bold text-amber-400 bg-amber-500/10 px-2 py-1 rounded-full animate-pulse">Action needed</span>
                    @endif
                </div>
                <p class="text-sm text-gray-400 font-medium mb-1">Pending Review</p>
                <p class="text-3xl font-bold text-white">{{ number_format($stats['pending_words']) }}</p>
            </div>
        </div>

        <!-- Total Users -->
        <div class="stat-card bg-gradient-to-br from-[#002B5B] to-[#001a3a] rounded-2xl p-6 border border-white/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-colors"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-purple-400 bg-purple-500/10 px-2 py-1 rounded-full">Active</span>
                </div>
                <p class="text-sm text-gray-400 font-medium mb-1">Total Users</p>
                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_users']) }}</p>
            </div>
        </div>

        <!-- Total Votes -->
        <div class="stat-card bg-gradient-to-br from-brand-primary/20 to-orange-600/20 rounded-2xl p-6 border border-brand-primary/30 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-brand-primary/20 rounded-full blur-2xl group-hover:bg-brand-primary/30 transition-colors"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-primary/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-green-400 bg-green-500/10 px-2 py-1 rounded-full">Engagement</span>
                </div>
                <p class="text-sm text-gray-400 font-medium mb-1">Total Votes</p>
                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_votes']) }}</p>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Recent Submissions (2 cols) -->
        <div class="xl:col-span-2 bg-[#001a3a] rounded-2xl border border-white/10 overflow-hidden">
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-lg text-white">Recent Submissions</h3>
                    <p class="text-sm text-gray-500">Latest words added to the dictionary</p>
                </div>
                <a href="{{ route('admin.words') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#00152e] text-gray-400 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-medium">Term</th>
                            <th class="px-6 py-4 font-medium">Category</th>
                            <th class="px-6 py-4 font-medium text-center">Status</th>
                            <th class="px-6 py-4 font-medium text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($recentWords as $word)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('word.show', $word->slug) }}" class="font-bold text-white hover:text-blue-400 transition-colors">
                                        {{ $word->term }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-white/5 text-gray-400 text-xs font-medium rounded-lg border border-white/10">
                                        {{ $word->category ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($word->is_verified)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold bg-green-500/10 text-green-400">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-gray-400 text-sm">
                                    {{ $word->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    No submissions yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-[#001a3a] rounded-2xl border border-white/10 p-6">
            <h3 class="font-bold text-lg text-white mb-6">Quick Actions</h3>

            <div class="space-y-3">
                <a href="{{ route('admin.words') }}?filterStatus=pending" class="flex items-center gap-4 p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-white text-sm">Review Pending</p>
                        <p class="text-xs text-gray-500">{{ $stats['pending_words'] }} words waiting</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="{{ route('admin.categories') }}" class="flex items-center gap-4 p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-white text-sm">Manage Categories</p>
                        <p class="text-xs text-gray-500">Add or edit categories</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center gap-4 p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-white text-sm">User Management</p>
                        <p class="text-xs text-gray-500">Roles & permissions</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="{{ route('admin.settings') }}" class="flex items-center gap-4 p-4 bg-white/5 rounded-xl hover:bg-white/10 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-gray-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-white text-sm">Site Settings</p>
                        <p class="text-xs text-gray-500">Configure your site</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <!-- Site Status -->
            <div class="mt-8 pt-6 border-t border-white/10">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Site Status</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Database</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            Connected
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Cache</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            Active
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Queue</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold text-gray-500">
                            <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
                            Sync Mode
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
