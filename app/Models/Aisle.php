<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aisle extends Model
{
    use HasFactory;
    public function store(): BelongsTo {
        return $this->belongsTo(Store::class);
    }

    public function items(): BelongsToMany {
        return $this->belongsToMany(Item::class)->withPivot('price');
    }

    protected $fillable = ['description'];
}
