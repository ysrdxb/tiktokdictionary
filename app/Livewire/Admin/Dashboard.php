<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Word;
use App\Models\Definition;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // Basic Stats
        $stats = [
            'total_words' => Word::count(),
            'pending_words' => Word::where('is_verified', false)->count(),
            'total_users' => User::count(),
            'total_votes' => Definition::sum('agrees') + Definition::sum('disagrees'),
        ];

        // Recent Activity (Mocked if ActivityLog empty)
        $recentWords = Word::latest()->take(5)->get();
        // $flags = \DB::table('flags')->where('status', 'pending')->count(); // If table exists

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentWords' => $recentWords,
            'flagsCount' => 0 // Placeholder until Flags seeded
        ])->layout('components.layouts.admin');
    }
}
