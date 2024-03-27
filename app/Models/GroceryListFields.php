<?php

namespace App\Models;

use Livewire\Attributes\Validate;

trait GroceryListFields {
    #[Validate('string|max:255')]
public string $title = "";
}
