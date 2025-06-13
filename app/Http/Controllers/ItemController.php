<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        return view('pages.items', array());
    }
}
