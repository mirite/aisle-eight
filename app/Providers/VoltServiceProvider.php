<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class VoltServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Volt::mount(array(
            config('livewire.view_path', resource_path('views/livewire')),
            resource_path('views/pages'),
        ));
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
}
