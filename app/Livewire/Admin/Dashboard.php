<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Word;
use App\Models\Definition;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $timeRange = '7'; // days

    public function render()
    {
        // Basic Stats
        $stats = $this->getBasicStats();

        // Today's Activity
        $todayStats = $this->getTodayStats();

        // Growth data for charts
        $chartData = $this->getChartData();

        // Trending/Popular words
        $trendingWords = $this->getTrendingWords();

        // Recent Activity Feed
        $recentActivity = $this->getRecentActivity();

        // Pending items requiring attention
        $pendingItems = $this->getPendingItems();

        // System health
        $systemHealth = $this->getSystemHealth();

        // Top contributors
        $topContributors = $this->getTopContributors();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'todayStats' => $todayStats,
            'chartData' => $chartData,
            'trendingWords' => $trendingWords,
            'recentActivity' => $recentActivity,
            'pendingItems' => $pendingItems,
            'systemHealth' => $systemHealth,
            'topContributors' => $topContributors,
        ])->layout('components.layouts.admin');
    }

    protected function getBasicStats(): array
    {
        return Cache::remember('admin.dashboard.stats', 300, function () {
            $totalDefinitions = Definition::count();
            $approvedDefinitions = Definition::where('is_approved', true)->count();

            return [
                'total_words' => Word::count(),
                'total_definitions' => $totalDefinitions,
                'approved_definitions' => $approvedDefinitions,
                'pending_definitions' => $totalDefinitions - $approvedDefinitions,
                'total_users' => User::count(),
                'total_votes' => Definition::sum('agrees') + Definition::sum('disagrees'),
                'total_agrees' => Definition::sum('agrees'),
                'total_disagrees' => Definition::sum('disagrees'),
            ];
        });
    }

    protected function getTodayStats(): array
    {
        $today = Carbon::today();

        return [
            'new_words' => Word::whereDate('created_at', $today)->count(),
            'new_definitions' => Definition::whereDate('created_at', $today)->count(),
            'new_users' => User::whereDate('created_at', $today)->count(),
            'votes_today' => DB::table('votes')->whereDate('created_at', $today)->count(),
        ];
    }

    protected function getChartData(): array
    {
        $days = (int) $this->timeRange;
        $labels = [];
        $wordsData = [];
        $definitionsData = [];
        $usersData = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M j');

            $wordsData[] = Word::whereDate('created_at', $date)->count();
            $definitionsData[] = Definition::whereDate('created_at', $date)->count();
            $usersData[] = User::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'words' => $wordsData,
            'definitions' => $definitionsData,
            'users' => $usersData,
        ];
    }

    protected function getTrendingWords()
    {
        return Word::select('words.*')
            ->selectRaw('(SELECT SUM(agrees) FROM definitions WHERE definitions.word_id = words.id) as total_agrees')
            ->selectRaw('(SELECT COUNT(*) FROM definitions WHERE definitions.word_id = words.id AND created_at >= ?) as recent_definitions', [Carbon::now()->subDays(7)])
            ->orderByRaw('(SELECT SUM(agrees) FROM definitions WHERE definitions.word_id = words.id AND created_at >= ?) DESC', [Carbon::now()->subDays(7)])
            ->take(5)
            ->get();
    }

    protected function getRecentActivity()
    {
        // Combine recent words and definitions
        $recentWords = Word::latest()->take(5)->get()->map(function ($word) {
            return [
                'type' => 'word',
                'title' => "New word: {$word->term}",
                'description' => $word->category ?? 'Uncategorized',
                'time' => $word->created_at,
                'link' => route('word.show', $word->slug),
                'icon' => 'word',
            ];
        });

        $recentDefinitions = Definition::with('word')->latest()->take(5)->get()->map(function ($def) {
            return [
                'type' => 'definition',
                'title' => "New definition for: {$def->word->term}",
                'description' => \Str::limit($def->definition, 50),
                'time' => $def->created_at,
                'link' => route('word.show', $def->word->slug),
                'icon' => 'definition',
            ];
        });

        $recentUsers = User::latest()->take(3)->get()->map(function ($user) {
            return [
                'type' => 'user',
                'title' => "New user: @{$user->username}",
                'description' => $user->email,
                'time' => $user->created_at,
                'link' => route('admin.users'),
                'icon' => 'user',
            ];
        });

        return $recentWords->concat($recentDefinitions)->concat($recentUsers)
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }

    protected function getPendingItems(): array
    {
        return [
            'words' => Word::where('is_verified', false)->count(),
            'definitions' => Definition::where('is_approved', false)->count(),
            'reports' => \App\Models\Flag::where('status', 'pending')->count(),
        ];
    }

    protected function getSystemHealth(): array
    {
        $maintenanceMode = Setting::get('maintenance_mode', 'false') === 'true';
        $aiEnabled = Setting::get('ai_enabled', 'true') === 'true';
        $apiKeySet = !empty(Setting::get('openai_api_key', ''));

        return [
            'maintenance_mode' => $maintenanceMode,
            'ai_status' => $aiEnabled && $apiKeySet ? 'active' : ($aiEnabled ? 'no_key' : 'disabled'),
            'cache_status' => Cache::has('admin.dashboard.stats') ? 'active' : 'cold',
            'database' => 'connected',
            'storage_used' => $this->getStorageUsage(),
        ];
    }

    protected function getStorageUsage(): string
    {
        try {
            $bytes = DB::select("SELECT SUM(data_length + index_length) as size FROM information_schema.tables WHERE table_schema = ?", [config('database.connections.mysql.database')])[0]->size ?? 0;
            return $this->formatBytes($bytes);
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    protected function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
    }

    protected function getTopContributors()
    {
        return Definition::select('submitted_by')
            ->selectRaw('COUNT(*) as total_definitions')
            ->selectRaw('SUM(agrees) as total_agrees')
            ->whereNotNull('submitted_by')
            ->where('submitted_by', '!=', 'Anonymous')
            ->groupBy('submitted_by')
            ->orderByDesc('total_definitions')
            ->take(5)
            ->get();
    }

    public function clearCache()
    {
        Cache::forget('admin.dashboard.stats');
        $this->dispatch('notify', 'Cache cleared successfully.');
    }

    public function toggleMaintenance()
    {
        $current = Setting::get('maintenance_mode', 'false');
        Setting::set('maintenance_mode', $current === 'true' ? 'false' : 'true');
        Cache::forget('setting.maintenance_mode');
        $this->dispatch('notify', $current === 'true' ? 'Maintenance mode disabled.' : 'Maintenance mode enabled.');
    }
}
