<?php

namespace App\Http\Controllers;

use App\Models\Chore;
use App\Models\ChoreAction;
use App\Models\ChoreLocation;
use App\Models\ChoreOccurrence;
use App\Models\ChoreTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $occurrences = ChoreOccurrence::with(['chore.action', 'chore.location'])
            ->where('assigned_to', $user->id)
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->orderBy('due_date')
            ->get();

        $groupedOccurrences = $occurrences->groupBy(fn($item) =>
        $item->due_date->format('Y-m-d')
        )->map(function ($group) {
            return $group->map(fn($occurrence) => [
                'chore' => $occurrence->chore,
                'occurrence' => $occurrence
            ]);
        });

        return view('chores.index', compact('groupedOccurrences'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chores.create', [
            'actions' => ChoreAction::all(),
            'locations' => ChoreLocation::all(),
            'householdUsers' => Auth::user()->household->members()->get(),
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
