<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grave extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'grave_layout',
        'gmaps_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function corpses(): HasMany
    {
        return $this->hasMany(Corpse::class);
    }
}
