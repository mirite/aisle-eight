<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [ 'name', 'user_id' ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function aisleItems(): HasMany
    {
        return $this->hasMany(AisleItem::class);
    }
}
