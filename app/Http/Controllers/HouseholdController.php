<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseholdRequest;
use App\Models\Household;
use App\Services\HouseholdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HouseholdController extends Controller
{

    protected HouseholdService $householdService;

    public function __construct(HouseholdService $householdService)
    {
        $this->householdService = $householdService;
    }

    public function manage()
    {
        $user = Auth::user();
        $household = $user->household;
        $members = $household ? $household->members : collect();

        return view('household.manage', compact('household', 'members', 'user'));
    }

    public function store(HouseholdRequest $request)
    {
        $user = Auth::user();

        $household = $this->householdService->createHousehold(
            user: Auth::user(),
            name: $request->input('name'),
            description: $request->input('description'),
        );

//        return response()->smart($request, fn() => redirect('/household'),[
//            'message' => 'Household added successfully',
//            'data' => $household,
//        ]);
        return redirect('/household')
            ->with('message', 'Household added successfully');
    }
    public function update(Request $request, Household $household)
    {
        $user = Auth::user();
        $this->householdService->leaveHousehold($user, $household);
        return redirect('household')->with('success', 'You have left the household');
    }

}
