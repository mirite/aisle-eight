<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListItem extends Model
{
    protected $fillable = array( 'grocery_list_id', 'aisle_item_id', 'quantity', 'in_cart' );

    public function aisleItem(): BelongsTo
    {
        return $this->belongsTo(AisleItem::class);
    }

    public function groceryList(): BelongsTo
    {
        return $this->belongsTo(GroceryList::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
