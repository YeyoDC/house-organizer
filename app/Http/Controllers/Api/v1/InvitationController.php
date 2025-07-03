<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationRequest;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    protected $invitationService;

    public function __construct(InvitationService $invitationService){
        $this->invitationService = $invitationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $invitations = $user->getPendingInvitations();
        return response()->json($invitations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvitationRequest $request)
    {
        $user = Auth::user();
        $email = $request->input('email');
        $household = $user->ownedHousehold;
        $invitation = $this->invitationService->sendInvitation($household, $user, $email);

        return response()->json($invitation);
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
    public function update(Request $request, $invitationId)
    {
        $action = $request->input('action');
        $invitation = $this->invitationService->confirmInvitation($invitationId, $action);
        return response()->json($invitation);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
