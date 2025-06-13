<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class GroceryList extends Model
{
    protected $fillable = array( 'date','user_id','title' );
    public function listItems(): HasMany
    {
        return $this->hasMany(ListItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
