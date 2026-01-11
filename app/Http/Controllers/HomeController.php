<?php

namespace App\Http\Controllers;

use App\Models\Definition;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use App\Services\TrendingService;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $timeframe = $request->string('timeframe')->toString();
        if (!in_array($timeframe, ['today', 'week', 'month'], true)) {
            $timeframe = 'today';
        }

        // Use the Viral Engine to get trending words
        $trendingWords = \App\Services\TrendingService::getTrending(12);

        // Word of the Day (Highest velocity from today, or all time fallback)
        $wordOfTheDay = Word::whereDate('created_at', now())
            ->orderByDesc('velocity_score')
            ->first() ?? Word::orderByDesc('velocity_score')->first();

        $mostAgreedDefinitions = Definition::query()
            ->with('word')
            ->whereHas('word')
            ->where(function ($query) {
                $query->where('agrees', '>', 0)
                    ->orWhere('disagrees', '>', 0);
            })
            ->orderByRaw('(agrees + disagrees) DESC')
            ->orderByDesc('agrees')
            ->limit(3)
            ->get()
            ->map(function ($definition) {
                $votes = max(1, (int) $definition->agrees + (int) $definition->disagrees);
                $accuracy = (int) round(((int) $definition->agrees / $votes) * 100);

                return [
                    'definition' => $definition,
                    'accuracy' => $accuracy,
                ];
            });

        $freshWords = Word::query()
            ->with('primaryDefinition')
            ->latest()
            ->limit(4)
            ->get();

        // Map Figma category labels to actual stored categories
        $categoryCards = collect([
            ['label' => 'Slang 🗣️', 'query' => ['Slang']],
            ['label' => 'TikTok Trends 🎵', 'query' => ['TikTok']],
            ['label' => 'Memes 🐸', 'query' => ['Memes']],
            ['label' => 'Audio Sounds 🔊', 'query' => ['TikTok']],
            ['label' => 'Acronyms 🔡', 'query' => ['Slang']],
            ['label' => 'Subcultures 🧛', 'query' => ['Internet', 'Gen-Z']],
            ['label' => 'Gaming 🎮', 'query' => ['Gaming']],
            ['label' => 'Stan Culture 💖', 'query' => ['Gen-Z']],
        ])->map(function ($card) {
            $count = Word::query()->whereIn('category', $card['query'])->count();

            return [
                'label' => $card['label'],
                'count' => $count,
                'countLabel' => Number::abbreviate($count) . ' words',
                'category' => $card['query'][0] ?? null,
            ];
        });

        $wordCount = Word::count();
        $definitionCount = Definition::count();

        return view('welcome', [
            'wordOfTheDay' => $wordOfTheDay,
            'trendingWords' => $trendingWords,
            'timeframe' => $timeframe,
            'mostAgreedDefinitions' => $mostAgreedDefinitions,
            'freshWords' => $freshWords,
            'categoryCards' => $categoryCards,
            'stats' => [
                'words' => $wordCount,
                'definitions' => $definitionCount,
                'wordsLabel' => Number::abbreviate($wordCount) . '+',
                'definitionsLabel' => Number::abbreviate($definitionCount) . '+',
            ],
        ]);
    }
}
