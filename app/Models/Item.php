<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Item extends Model
{
    protected $fillable = array( 'name', 'user_id', 'isTaxable' );

    public function aisleItems(): HasMany
    {
        return $this->hasMany(AisleItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
