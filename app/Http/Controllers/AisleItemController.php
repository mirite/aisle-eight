<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AisleItemController extends Controller
{
    public function index()
    {
        return view('aisleItem');
    }
}
