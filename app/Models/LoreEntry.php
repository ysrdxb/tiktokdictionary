<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoreEntry extends Model
{
    protected $fillable = [
        'word_id',
        'platform', // tiktok, twitter, instagram
        'source_url',
        'description',
        'creator_handle',
        'date_event',
        'title',
    ];

    protected $casts = [
        'date_event' => 'datetime',
    ];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
