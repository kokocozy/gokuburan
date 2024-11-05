<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Corpse extends Model
{
    protected $fillable = [
        'grave_id',
        'name',
        'coordinates',
        'lat',
        'lng',
    ];

    public function grave(): BelongsTo
    {
        return $this->belongsTo(Grave::class);
    }
}
