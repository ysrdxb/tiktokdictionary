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
        'creator_handle'
    ];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
