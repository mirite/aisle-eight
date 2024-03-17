<?php

namespace App\Models;

use Livewire\Attributes\Validate;

trait StoreFields
{
    #[Validate('required|string|max:255')]
    public string $name = '';
}
