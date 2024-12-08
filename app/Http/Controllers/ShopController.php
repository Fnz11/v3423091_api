<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function index()
    {
        $clothes = Clothes::all();
        return view('shop.index', compact('clothes'));
    }

    public function show(Clothes $clothes)
    {
        return view('shop.show', compact('clothes'));
    }
}
