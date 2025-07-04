<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Services\InvitationService;
use Carbon\Carbon;
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
        return view('notifications.index', compact('invitations', 'user'));
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

        return redirect('/household');

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
        if($action == 'accept'){
            return redirect('/household')->with('success', __('You have accepted the invitation'));
        }
        else
        {
            return redirect('/household')->with('success', __('You have declined the invitation'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
