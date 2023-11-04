<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class OAuthController extends Controller
{

    public function OAuthApiLogin(Request $request)
    {
        if($request->provider == "google"){
            return Socialite::driver("google")->redirect();
        } else if($request->provider == "github") {
            return Socialite::driver("github")->redirect();
        }
    }

    public function googleCallback()
    {
        try{
            $user = Socialite::driver('google')->stateless()->user();

            $findUser = User::where('google_id', $user->id)->first();

            if($findUser) {
                Auth::login($findUser);
                return redirect()->intended('/');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make(Str::random(15)),
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

    public function githubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();

            $findUser = User::where('email', '=', $githubUser->getEmail())->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended('/');
            } else {
                $newUser = User::create([
                    'name' => $githubUser->getName(),
                    'email' => $githubUser->getEmail(),
                    'github_id' => $githubUser->getId(),
                    'password' => Hash::make(Str::random(15)),
                    'github_token' => $githubUser->token,
                    'github_refresh_token' => $githubUser->refreshToken,
                ]);
                $role = Role::findByName('user');
                $newUser->assignRole($role);
                Auth::login($newUser);
                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
