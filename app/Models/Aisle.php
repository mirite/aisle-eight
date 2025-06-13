<?php

namespace App\Models;

use App\Traits\Movable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * @property string $description
 * @property int $position
 * @property int $store_id
 */
class Aisle extends Model
{
    use Movable;

    protected $fillable = array( 'description', 'position', 'store_id' );

    public function aisleItems(): HasMany
    {
        return $this->hasMany(AisleItem::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
