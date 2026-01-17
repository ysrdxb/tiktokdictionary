<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Definition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WordController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return redirect()->route('word.browse');
        }

        // 1. "Starts With" matches (Highest Relevance)
        $startsWith = Word::where('is_verified', true)
            ->where('term', 'like', $query . '%')
            ->with('primaryDefinition')
            ->orderBy('term', 'asc')
            ->get();

        $startsWithIds = $startsWith->pluck('id');

        // 2. "Contains" matches (Lower Relevance, exclude startsWith)
        $contains = Word::where('is_verified', true)
            ->where('term', 'like', '%' . $query . '%')
            ->whereNotIn('id', $startsWithIds)
            ->with('primaryDefinition')
            ->orderBy('term', 'asc')
            ->get();

        return view('word.search-results', compact('startsWith', 'contains', 'query'));
    }

    public function show($slug)
    {
        $word = Word::where('slug', $slug)
            ->with(['definitions' => function($query) {
                $query->orderBy('agrees', 'desc');
            }, 'lore'])
            ->firstOrFail();

        // Increment View Count (Viral Engine)
        \App\Services\TrendingService::incrementView($word->id);

        return view('word.show', compact('word'));
    }

    public function browse(Request $request)
    {
        $category = $request->get('category');
        $sort = $request->get('sort', 'today');
        
        $query = Word::where('is_verified', true)->with('primaryDefinition');
        
        if ($category) {
            $query->where('category', $category);
        }

        // Vibe Check Search (Phase 14)
        $vibe = $request->get('vibe');
        if ($vibe) {
            $query->whereJsonContains('vibes', $vibe);
            
            // If searching by vibe, we return a flat list instead of the complex browse dashboard
            $words = $query->orderBy('velocity_score', 'desc')->paginate(20);
            return view('word.browse-results', compact('words', 'vibe'));
        }
        
        // Apply time filter
        switch ($sort) {
            case 'week':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case 'month':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            case 'today':
                $query->where('created_at', '>=', now()->subDay());
                break;
            // 'all' = no time filter
        }
        


        
        // Fix: Use the robust service (same as Homepage) to ensure we always get trending words even with filters
        // Pass 'all' as timeframe to get general trending, OR use $sort if we want it strictly filtered.
        // User complaint: "It is empty".
        // Solution: Use fallback-capable service.
        $trendingWords = \App\Services\TrendingService::getTrending(12, $sort ?? 'all');
        $fastestGrowing = Word::with('primaryDefinition')
            ->where('is_verified', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('total_agrees', 'desc')
            ->limit(9)
            ->get();
        
        $mostControversial = Word::with('primaryDefinition')
            ->where('is_verified', true)
            ->whereRaw('total_disagrees > total_agrees * 0.3')
            ->orderBy('total_disagrees', 'desc')
            ->limit(6)
            ->get();

        $memeWords = Word::query()
            ->where('is_verified', true)
            ->whereIn('category', ['Memes', 'Internet'])
            ->with('primaryDefinition')
            ->orderBy('velocity_score', 'desc')
            ->limit(3)
            ->get();

        $audioTrendWords = Word::query()
            ->where('is_verified', true)
            ->where(function($q) {
                $q->where('term', 'like', '#%')
                  ->orWhereIn('category', ['TikTok', 'Music']);
            })
            ->with('primaryDefinition')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();

        $subcultureWords = Word::query()
            ->where('is_verified', true)
            ->whereIn('category', ['Gaming', 'AAVE', 'Stan Culture', 'Anime', 'Fitness'])
            ->limit(4)
            ->get();

        return view('word.browse', compact('trendingWords', 'fastestGrowing', 'mostControversial', 'memeWords', 'audioTrendWords', 'subcultureWords'));
    }

    public function create()
    {
        return view('word.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|string|max:100',
            'definition' => 'required|string|max:1000',
            'example' => 'required|string|max:500',
            'category' => 'required|string|max:50',
            'source_url' => 'nullable|url|max:255',
            'alternate_spellings' => 'nullable|string|max:255',
            'hashtags' => 'nullable|string|max:255',
        ]);

        // Create or find the word
        $word = Word::firstOrCreate(
            ['term' => $validated['term']],
            [
                'slug' => Str::slug($validated['term']),
                'category' => $validated['category'],
            ]
        );

        // Create the definition
        $definition = Definition::create([
            'word_id' => $word->id,
            'definition' => $validated['definition'],
            'example' => $validated['example'],
            'submitted_by' => 'Anonymous',
            'source_url' => $validated['source_url'] ?? null,
            'agrees' => 0,
            'disagrees' => 0,
        ]);

        // Recalculate word stats
        $word->recalculateStats();

        return redirect()->route('word.show', $word->slug)
            ->with('success', 'Word submitted successfully!');
    }
    public function check(Request $request)
    {
        $term = $request->query('term');
        $word = Word::where('term', $term)->orWhere('slug', Str::slug($term))->first();
        
        if ($word) {
            $count = $word->definitions()->count();
            return response()->json([
                'exists' => true,
                'slug' => $word->slug,
                'count' => $count,
                'message' => "{$count} people already submitted this word."
            ]);
        }
        
        return response()->json(['exists' => false]);
    }

    public function storeDefinition(Request $request, Word $word)
    {
        $validated = $request->validate([
            'definition' => 'required|string|max:1000',
        ]);

        Definition::create([
            'word_id' => $word->id,
            'definition' => $validated['definition'],
            'example' => $request->input('example', ''), // Optional or from context
            'submitted_by' => 'Anonymous',
            'agrees' => 0,
            'disagrees' => 0,
        ]);

        $word->recalculateStats();

        return redirect()->route('word.show', $word->slug)
            ->with('success', 'Definition added successfully!');
    }
}
