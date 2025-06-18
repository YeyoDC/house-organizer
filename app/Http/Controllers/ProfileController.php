<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{



    public function showForm()
    {
        $user = auth()->user();
        return view('auth/complete-profile', compact('user'));

    }
    public function store(CompleteProfileRequest $request)
    {
        $user = auth()->user();
        $profileData = $request->only(['displayName', 'phone']);
        if($request->hasFile('profile_picture')){
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profileData['profile_picture'] = $path;
        }

        $user->profile()->updateOrCreate([], $profileData);

        return redirect()->route('dashboard')->with('success', 'Your profile has been updated.');
    }
}
