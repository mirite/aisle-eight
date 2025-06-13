<?php

namespace App\Http\Controllers;

class GroceryListController extends Controller
{
    public static function getNewestListId()
    {
        return auth()->user()->groceryLists()->latest()->first()->id;
    }

    public function index()
    {
        return view('pages.list');
    }
}
