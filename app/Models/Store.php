<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Store extends Model
{
    protected $fillable = array( 'name', 'user_id' );
    public function aisles(): HasMany
    {
        return $this->hasMany(Aisle::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
