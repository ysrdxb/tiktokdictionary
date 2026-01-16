<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-primary to-orange-500 flex items-center justify-center shadow-lg shadow-brand-primary/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">Dashboard</h1>
                <p class="text-gray-400 text-sm">Welcome back! Here's what's happening today</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="clearCache" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-sm font-medium text-gray-300 transition-colors">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh
            </button>
            <button wire:click="toggleMaintenance" class="px-4 py-2 {{ $systemHealth['maintenance_mode'] ? 'bg-red-500/20 text-red-400 border-red-500/30' : 'bg-green-500/20 text-green-400 border-green-500/30' }} border rounded-lg text-sm font-medium transition-colors">
                {{ $systemHealth['maintenance_mode'] ? 'Disable Maintenance' : 'Enable Maintenance' }}
            </button>
        </div>
    </div>

    <!-- Today's Activity Banner -->
    <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-2xl p-6 mb-8 border border-blue-500/20">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <h2 class="text-lg font-bold text-white">Today's Activity</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <p class="text-3xl font-bold text-white">{{ $todayStats['new_words'] }}</p>
                <p class="text-sm text-gray-400">New Words</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">{{ $todayStats['new_definitions'] }}</p>
                <p class="text-sm text-gray-400">New Definitions</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">{{ $todayStats['new_users'] }}</p>
                <p class="text-sm text-gray-400">New Users</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">{{ $todayStats['votes_today'] }}</p>
                <p class="text-sm text-gray-400">Votes Cast</p>
            </div>
        </div>
    </div>

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <!-- Total Words -->
        <div class="stat-card bg-gradient-to-br from-[#00336E] to-[#001a3a] rounded-2xl p-6 border border-white/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-colors"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-400 font-medium mb-1">Total Words</p>
                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_words']) }}</p>
            </div>
        </div>

        <!-- Total Definitions -->
        <div class="stat-card bg-gradient-to-br from-[#00336E] to-[#001a3a] rounded-2xl p-6 border border-white/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-colors"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded-full">{{ $stats['approved_definitions'] }} approved</span>
                </div>
                <p class="text-sm text-gray-400 font-medium mb-1">Total Definitions</p>
                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_definitions']) }}</p>
            </div>
        </div>

        <!-- Total Users -->
        <div class="stat-card bg-gradient-to-br from-[#00336E] to-[#001a3a] rounded-2xl p-6 border border-white/10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-colors"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
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
                    <span class="text-xs font-bold text-green-400 bg-green-500/10 px-2 py-1 rounded-full">{{ number_format($stats['total_agrees']) }} agrees</span>
                </div>
                <p class="text-sm text-gray-400 font-medium mb-1">Total Votes</p>
                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_votes']) }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Items Alert -->
    @if($pendingItems['words'] > 0 || $pendingItems['definitions'] > 0)
    <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-6 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-amber-400">Items Pending Review</h3>
                    <p class="text-sm text-amber-400/70">{{ $pendingItems['words'] }} words, {{ $pendingItems['definitions'] }} definitions awaiting approval</p>
                </div>
            </div>
            <a href="{{ route('admin.moderation') }}" class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-black font-bold rounded-lg transition-colors text-center">
                Review Now
            </a>
        </div>
    </div>
    @endif

    <!-- Chart Section -->
    <div class="bg-[#001a3a] rounded-2xl border border-white/10 p-6 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h3 class="font-bold text-lg text-white">Growth Overview</h3>
                <p class="text-sm text-gray-500">Content and user growth over time</p>
            </div>
            <select wire:model.live="timeRange" class="bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                <option value="7">Last 7 days</option>
                <option value="14">Last 14 days</option>
                <option value="30">Last 30 days</option>
            </select>
        </div>

        <div class="h-64" x-data="chartComponent(@js($chartData))" x-init="initChart()">
            <canvas x-ref="chart"></canvas>
        </div>
    </div>

    <!-- Three Column Layout -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        <!-- Recent Activity Feed -->
        <div class="xl:col-span-2 bg-[#001a3a] rounded-2xl border border-white/10 overflow-hidden">
            <div class="p-6 border-b border-white/10">
                <h3 class="font-bold text-lg text-white">Recent Activity</h3>
                <p class="text-sm text-gray-500">Latest actions across the platform</p>
            </div>
            <div class="divide-y divide-white/5 max-h-96 overflow-y-auto">
                @forelse($recentActivity as $activity)
                <a href="{{ $activity['link'] }}" class="flex items-center gap-4 p-4 hover:bg-white/5 transition-colors">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center
                        {{ $activity['type'] === 'word' ? 'bg-blue-500/20' : '' }}
                        {{ $activity['type'] === 'definition' ? 'bg-emerald-500/20' : '' }}
                        {{ $activity['type'] === 'user' ? 'bg-purple-500/20' : '' }}">
                        @if($activity['type'] === 'word')
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        @elseif($activity['type'] === 'definition')
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @else
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-white text-sm truncate">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $activity['description'] }}</p>
                    </div>
                    <span class="text-xs text-gray-500 whitespace-nowrap">{{ $activity['time']->diffForHumans() }}</span>
                </a>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    No recent activity
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Top Contributors -->
            <div class="bg-[#001a3a] rounded-2xl border border-white/10 p-6">
                <h3 class="font-bold text-lg text-white mb-4">Top Contributors</h3>
                <div class="space-y-3">
                    @forelse($topContributors as $index => $contributor)
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $index === 0 ? 'from-yellow-400 to-orange-500' : ($index === 1 ? 'from-gray-300 to-gray-400' : 'from-amber-600 to-amber-700') }} flex items-center justify-center text-xs font-bold text-white">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-white text-sm truncate">{{ $contributor->submitted_by }}</p>
                            <p class="text-xs text-gray-500">{{ $contributor->total_definitions }} definitions</p>
                        </div>
                        <span class="text-xs font-medium text-green-400">{{ number_format($contributor->total_agrees ?? 0) }} agrees</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">No contributors yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Trending Words -->
            <div class="bg-[#001a3a] rounded-2xl border border-white/10 p-6">
                <h3 class="font-bold text-lg text-white mb-4">Trending Words</h3>
                <div class="space-y-2">
                    @forelse($trendingWords as $word)
                    <a href="{{ route('word.show', $word->slug) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <span class="font-medium text-white text-sm">{{ $word->term }}</span>
                        <span class="text-xs text-green-400">{{ $word->total_agrees ?? 0 }} agrees</span>
                    </a>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">No trending words</p>
                    @endforelse
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-[#001a3a] rounded-2xl border border-white/10 p-6">
                <h3 class="font-bold text-lg text-white mb-4">System Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Maintenance Mode</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold {{ $systemHealth['maintenance_mode'] ? 'text-red-400' : 'text-green-400' }}">
                            <span class="w-2 h-2 {{ $systemHealth['maintenance_mode'] ? 'bg-red-400' : 'bg-green-400' }} rounded-full {{ $systemHealth['maintenance_mode'] ? 'animate-pulse' : '' }}"></span>
                            {{ $systemHealth['maintenance_mode'] ? 'Active' : 'Off' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">AI Service</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold {{ $systemHealth['ai_status'] === 'active' ? 'text-green-400' : ($systemHealth['ai_status'] === 'no_key' ? 'text-amber-400' : 'text-gray-500') }}">
                            <span class="w-2 h-2 {{ $systemHealth['ai_status'] === 'active' ? 'bg-green-400' : ($systemHealth['ai_status'] === 'no_key' ? 'bg-amber-400' : 'bg-gray-500') }} rounded-full"></span>
                            {{ $systemHealth['ai_status'] === 'active' ? 'Active' : ($systemHealth['ai_status'] === 'no_key' ? 'No API Key' : 'Disabled') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Cache</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold {{ $systemHealth['cache_status'] === 'active' ? 'text-green-400' : 'text-amber-400' }}">
                            <span class="w-2 h-2 {{ $systemHealth['cache_status'] === 'active' ? 'bg-green-400' : 'bg-amber-400' }} rounded-full"></span>
                            {{ $systemHealth['cache_status'] === 'active' ? 'Warm' : 'Cold' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Database Size</span>
                        <span class="text-xs font-bold text-blue-400">{{ $systemHealth['storage_used'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.words') }}" class="bg-[#001a3a] rounded-2xl border border-white/10 p-6 hover:bg-white/5 transition-colors group">
            <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            </div>
            <h4 class="font-bold text-white mb-1">Manage Words</h4>
            <p class="text-xs text-gray-500">Edit, verify, delete words</p>
        </a>

        <a href="{{ route('admin.moderation') }}" class="bg-[#001a3a] rounded-2xl border border-white/10 p-6 hover:bg-white/5 transition-colors group">
            <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h4 class="font-bold text-white mb-1">Moderation</h4>
            <p class="text-xs text-gray-500">Review pending content</p>
        </a>

        <a href="{{ route('admin.users') }}" class="bg-[#001a3a] rounded-2xl border border-white/10 p-6 hover:bg-white/5 transition-colors group">
            <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h4 class="font-bold text-white mb-1">Users</h4>
            <p class="text-xs text-gray-500">Manage user accounts</p>
        </a>

        <a href="{{ route('admin.settings') }}" class="bg-[#001a3a] rounded-2xl border border-white/10 p-6 hover:bg-white/5 transition-colors group">
            <div class="w-12 h-12 rounded-xl bg-gray-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h4 class="font-bold text-white mb-1">Settings</h4>
            <p class="text-xs text-gray-500">Configure your site</p>
        </a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chartComponent', (chartData) => ({
            chart: null,
            chartData: chartData,
            initChart() {
                const ctx = this.$refs.chart.getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.chartData.labels,
                        datasets: [
                            {
                                label: 'Words',
                                data: this.chartData.words,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                fill: true,
                                tension: 0.4,
                            },
                            {
                                label: 'Definitions',
                                data: this.chartData.definitions,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                fill: true,
                                tension: 0.4,
                            },
                            {
                                label: 'Users',
                                data: this.chartData.users,
                                borderColor: '#8b5cf6',
                                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                                fill: true,
                                tension: 0.4,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: { color: '#9ca3af' }
                            }
                        },
                        scales: {
                            x: {
                                grid: { color: 'rgba(255,255,255,0.05)' },
                                ticks: { color: '#9ca3af' }
                            },
                            y: {
                                grid: { color: 'rgba(255,255,255,0.05)' },
                                ticks: { color: '#9ca3af' },
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }));
    });
</script>
@endpush
