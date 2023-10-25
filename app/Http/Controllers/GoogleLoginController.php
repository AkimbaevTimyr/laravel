<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Mockery\Exception;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try{
            $user = Socialite::driver('google')->user();

            $findUser = User::where('google_id', $user->id)->first();

            if($findUser) {
                Auth::login($findUser);
                return redirect()->intended('/');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => "password"
                ]);
                $role = Role::findByName('user');
                $newUser->assignRole($role);
                Auth::login($newUser);
                return redirect()->intended('/');
            }

        } catch (Exception $e)
        {
            dd($e->getMessage());
        }
    }
}
