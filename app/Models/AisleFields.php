<?php

namespace App\Models;

use Livewire\Attributes\Validate;

trait AisleFields
{
    #[Validate('required|string|max:256')]
    public string $description = '';

    #[Validate('integer|min:0|max:100')]
    public int $position = 0;

    #[Validate('required|exists:stores,id')]
    public int $store_id;
}
