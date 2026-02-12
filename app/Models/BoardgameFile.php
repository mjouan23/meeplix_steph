<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardgameFile extends Model
{
    protected $fillable = ['display_name', 'file_path', 'display_order', 'boardgame_id'];

    public function boardgame()
    {
        return $this->belongsTo(Boardgame::class);
    }
}
