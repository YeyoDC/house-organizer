<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroceryDashboardController extends Controller
{
    public function index()
    {
        return view('groceries.index');
    }



}
