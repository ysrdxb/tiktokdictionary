<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\LoreEntry;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Word::query()
            ->withCount('definitions')
            ->orderByDesc('created_at');

        if ($status === 'pending') {
            $query->where('is_verified', false);
        } elseif ($status === 'verified') {
             $query->where('is_verified', true);
        } elseif ($status === 'polar') {
             $query->where('is_polar_trend', true);
        }

        $words = $query->paginate(50);
        
        // Counts for tabs
        $stats = [
            'all' => Word::count(),
            'pending' => Word::where('is_verified', false)->count(),
            'verified' => Word::where('is_verified', true)->count(),
            'polar' => Word::where('is_polar_trend', true)->count(),
        ];

        return view('admin.dashboard', compact('words', 'stats', 'status'));
    }

    public function edit(Word $word)
    {
        $word->load('lore');
        return view('admin.edit', compact('word'));
    }

    public function update(Request $request, Word $word)
    {
        $validated = $request->validate([
            'term' => 'required|string|max:100',
            'category' => 'required|string',
            'admin_boost' => 'required|integer|min:0|max:10000',
            'is_verified' => 'boolean',
            'is_polar_trend' => 'boolean',
        ]);

        $word->update([
            'term' => $validated['term'],
            'category' => $validated['category'],
            'admin_boost' => $validated['admin_boost'],
            'is_verified' => $request->boolean('is_verified'),
            'is_polar_trend' => $request->boolean('is_polar_trend'),
        ]);

        // Trigger Viral Recalc
        $word->recalculateStats();

        return redirect()->route('admin.dashboard')->with('success', 'Word updated & viral score recalculated.');
    }
    
    public function storeLore(Request $request, Word $word)
    {
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_event' => 'required|date',
            'source_url' => 'nullable|url',
        ]);
        
        LoreEntry::create([
            'word_id' => $word->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date_event' => $validated['date_event'],
            'source_url' => $validated['source_url'],
        ]);
        
        return redirect()->back()->with('success', 'Lore entry added.');
    }

    public function destroy(Word $word)
    {
        $word->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Word deleted.');
    }
}
