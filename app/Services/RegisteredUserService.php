<?php
// App\Services\AuthService.php
namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisteredUserService
{

    public function register(array $data): User
    {

        try{
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

        }catch (\Exception $e){
            throw ValidationException::withMessages([
                'email' => $e->getMessage()
            ]);
        }
        event(new Registered($user));

        return $user;
    }
}
