<?php

namespace App\Models;

use Livewire\Attributes\Validate;

trait AisleItemFields
{
    #[Validate('string|max:255')]
    public string $price = '';

    #[Validate('string|max:255')]
    public string $description = '';

    #[Validate('integer|min:0|max:100')]
    public int $position = 0;

    #[Validate('required|exists:aisles,id')]
    public string $aisle_id = '';

    #[Validate('required|exists:items,id')]
    public string $item_id = '';
}
