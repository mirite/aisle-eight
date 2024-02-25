<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroceryList extends Model
{
    use HasFactory;

    public function aisleItems(): HasMany {
        return $this->hasMany(AisleItem::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['date','user_id'];
}
