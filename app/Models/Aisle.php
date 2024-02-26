<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aisle extends BaseModel
{
    public function store(): BelongsTo {
        return $this->belongsTo(Store::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function aisleItems(): HasMany {
        return $this->hasMany(AisleItem::class);
    }

    protected $fillable = ['description','position','store_id'];
}
