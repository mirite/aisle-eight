<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AisleItem extends BaseModel
{
    protected $fillable = ['aisle_id', 'item_id', 'price','description','position'];
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
