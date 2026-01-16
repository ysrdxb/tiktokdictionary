<?php

namespace App\Services;

use App\Models\Word;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TrendingService
{
    /**
     * The Master Formula for Viral Velocity
     * Score = ((Votes + Boost) / (Age^1.5)) * ViewsFactor
     */
    public static function calculateScore(Word $word)
    {
        // 1. Data Points
        $netVotes = ($word->total_agrees - $word->total_disagrees);
        $boost = $word->admin_boost;
        
        // 2. Age Factor (Hours)
        $hoursOld = $word->created_at->diffInHours(now());
        $gravity = pow(($hoursOld + 2), 1.5);
        
        // 3. Views Factor (Recent views matter more, but we use total for MVP)
        // ideally we use velocity (views in last hour) but total_views is safer for now
        $views = $word->views + $word->views_buffer; 
        
        // Avoid division by zero
        if ($gravity == 0) $gravity = 1;
        
        // 4. Calculation
        $baseScore = ($netVotes + $boost) / $gravity;
        
        // View Multiplier (0.1 weight)
        $viewBonus = $views * 0.1;
        
        // Final Score
        $finalScore = round($baseScore + $viewBonus, 4);

        // --- AUTOMATED POLAR TREND DETECTION ---
        // If a word has high engagement but mixed votes (controversial), it's "Polar".
        // OR simply if velocity is extremely high.
        // For MVP: If score > 50 (arbitrary high number) we mark it as Polar Trend.
        // We will do this check here to save a DB write, or return a composite.
        // Actually, let's just return the score, and let the caller or a Listener update the flag.
        // But to be "Kinetic", let's update it right here if it changes.
        
        if ($finalScore > 50 && !$word->is_polar_trend) {
             $word->update(['is_polar_trend' => true]);
        } elseif ($finalScore < 20 && $word->is_polar_trend) {
             // Downgrade if it falls off
             $word->update(['is_polar_trend' => false]);
        }

        return $finalScore;
    }

    /**
     * Get Trending Words (Cached for speed)
     */
    public static function getTrending($limit = 12, $timeframe = 'today')
    {
        // Cache this query for 2 minutes to serve Bento Grid instantly
        $cacheKey = "homepage_trending_{$timeframe}";
        
        return Cache::remember($cacheKey, 120, function() use ($limit, $timeframe) {
            $query = Word::where('is_verified', true)
                ->with('primaryDefinition');

            // Apply logic similar to HomeController browsing
            switch ($timeframe) {
                case 'week':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'today':
                default:
                    $query->where('created_at', '>=', now()->subDay());
                    break;
            }

            return $query->orderBy('velocity_score', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Increment View Count (Buffer Strategy)
     */
    public static function incrementView($wordId)
    {
        // 1. Increment in Buffer (Cache/Redis)
        $key = "word_views:{$wordId}";
        
        // If using Redis, we could do atomic increment. 
        // For shared hosting file cache, we use a simple put/get or rely on DB update for safety
        
        // Simplified Strategy for MVP: Direct DB increment for now is risky.
        // Better: Update a 'views_buffer' column in DB? No, that's write heavy.
        
        // Cache Strategy:
        if (Cache::has($key)) {
            Cache::increment($key);
        } else {
            Cache::put($key, 1, 600); // 10 mins ttl
        }
        
        // We need a way to know WHICH keys to sync. 
        // For MVP, we might just increment DB directly if traffic is low.
        // "TikTok Scale" requires the Cron Job.
        // Let's implement the 'Direct DB Increment' for Phase 1 MVP 
        // but wrapped in this service so we can swap to Redis later.
        
        // TEMPORARY: Direct DB update (Safe for < 1000 users)
         Word::where('id', $wordId)->increment('views');
    }
}
