<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Services\TrendingService;

class LiveTrendGrid extends Component
{
    public function render()
    {
        // Fetch trending words using the service
        // The service already caches, but we want fresh data every poll if cache expires
        // effectively, the poll triggers a re-render
        $trendingWords = TrendingService::getTrending(12);

        return view('livewire.home.live-trend-grid', [
            'items' => $trendingWords
        ]);
    }
}
