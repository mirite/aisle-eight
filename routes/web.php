<?php

use App\Http\Controllers\{AisleController, AisleItemController, GroceryListController, ItemController, StoreController};
use Illuminate\Http\Request;
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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return view('pages.welcome');
    }
});

Route::view('dashboard', 'pages.dashboard')
    ->middleware(array( 'auth', 'verified' ))
    ->name('dashboard');

Route::view('profile', 'pages.profile')
    ->middleware(array( 'auth' ))
    ->name('profile');

Route::get('items', array( ItemController::class, 'index' ))
     ->middleware(array( 'auth', 'verified' ))
     ->name('items');

Route::get('list', array( GroceryListController::class, 'index' ))
     ->middleware(array( 'auth', 'verified' ))
     ->name('list');

Route::get('list/view', function (Request $request) {

        $id = GroceryListController::getNewestListId();

    return view('pages.listviewer', array( 'id' => $id ));
})
     ->middleware(array( 'auth', 'verified' ))
     ->name('grocery-list/usenewestlist');

Route::get('list/view/{id}', function (Request $request, string $id) {

    return view('pages.listviewer', array( 'id' => $id ));
})
     ->middleware(array( 'auth', 'verified' ))
     ->name('grocery-list/uselist');

Route::get('list/edit/{id}', function (Request $request, string $id) {
    return view('pages.listbuilder', array( 'id' => $id ));
})
     ->middleware(array( 'auth', 'verified' ))
     ->name('grocery-list/listbuilder');

Route::get('aisles', array( AisleController::class, 'index' ))
     ->middleware(array( 'auth', 'verified' ))
     ->name('aisles');

Route::get('stores', array( StoreController::class, 'index' ))
     ->middleware(array( 'auth', 'verified' ))
     ->name('stores');

Route::get('aisle-items', array( AisleItemController::class, 'index' ))
     ->middleware(array( 'auth', 'verified' ))
     ->name('aisle-items');

require __DIR__ . '/auth.php';
