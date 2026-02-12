<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = [
        'boardgame_id',
        'name',
        'played_at',
        'notes'
    ];

    protected $casts = [
        'played_at' => 'datetime'
    ];

    public function boardgame()
    {
        return $this->belongsTo(Boardgame::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('score', 'winner')
            ->withTimestamps();
    }
}
