<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseholdRequest;
use App\Services\HouseholdService;
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

//    return json for mobile/API request type
            return response()->json([
                'household' => $household,
                'members' => $members,
                'user' => $user,
            ]);

    }

    public function store(HouseholdRequest $request)
    {
        $user = Auth::user();

        $household = $this->householdService->createHousehold(
            user: $user,
            name: $request->input('name'),
            description: $request->input('description'),
        );

        return response()->json([
            'success' => true,
            'message' => 'Household created successfully.',
            'data' => $household,
        ], 201);
    }
}
