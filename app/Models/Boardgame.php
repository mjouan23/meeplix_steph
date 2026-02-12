<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boardgame extends Model
{
    protected $fillable = ['name', 'acronym', 'image'];

    public function files()
    {
        return $this->hasMany(BoardgameFile::class)->orderBy('display_order');
    }

    public function parties()
    {
        return $this->hasMany(Party::class)->latest();
    }
}
