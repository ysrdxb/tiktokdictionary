<?php

namespace App\Livewire\Tools;

use Livewire\Component;
use App\Models\Word;

class InvestorDashboard extends Component
{
    public $assets = [];

    public function mount()
    {
        $words = Word::with('primaryDefinition')
            ->orderBy('velocity_score', 'desc')
            ->take(20)
            ->get();

        $this->assets = $words->map(function ($word) {
            // Mock Data for "Investor" Simulation
            $isAvailable = rand(1, 100) <= 30; // 30% chance
            $price = $isAvailable ? rand(1299, 500000) / 100 : 0; // $12.99 to $5000.00
            
            // Random daily change percentage
            $change = rand(-50, 150) / 10; // -5.0% to +15.0%

            return [
                'term' => $word->term,
                'slug' => $word->slug,
                'definition' => $word->primaryDefinition->definition ?? 'No definition',
                'velocity' => $word->velocity_score,
                'views' => $word->views,
                'is_available' => $isAvailable,
                'price' => $price,
                'change_24h' => $change,
                'domain' => str_replace(' ', '', strtolower($word->term)) . '.com'
            ];
        });
    }

    public function render()
    {
        return view('livewire.tools.investor-dashboard');
    }
}
