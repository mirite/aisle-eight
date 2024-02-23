<?php

use App\Http\Controllers\AisleController;
use App\Http\Controllers\GroceryListController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('items', [ ItemController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('items');

Route::get('list', [ GroceryListController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('list');

Route::get('aisles', [ AisleController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('aisles');

Route::get('stores', [ StoreController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('stores');

require __DIR__.'/auth.php';
