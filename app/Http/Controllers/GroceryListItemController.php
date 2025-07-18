<?php

namespace App\Http\Controllers;

use App\Models\GroceryList;
use App\Models\GroceryListItem;
use Illuminate\Http\Request;

class GroceryListItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(GroceryList $groceryList)
    {
        return view('groceries.create', [
            'groceryList' => $groceryList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GroceryListItem $groceryListItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GroceryList $groceryList)
    {

        return view('groceries.edit', compact('groceryList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GroceryListItem $groceryListItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroceryListItem $groceryListItem)
    {
        //
    }
}
