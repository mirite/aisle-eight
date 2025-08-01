<?php

namespace App\Models;

use App\Traits\Movable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AisleItem extends Model
{
    use Movable;

    protected $fillable = array( 'aisle_id', 'item_id', 'price', 'description', 'position','units','size' );

    public function aisle(): BelongsTo
    {
        return $this->belongsTo(Aisle::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
