<?php

namespace App\Providers;

use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Models\Role;


class GithubServiceProvider
{
    // public function updateOrCreate($user, $githubUser)
    // {
    //     try{
    //         $user = User::updateOrCreate([
    //             'github_id' => $githubUser->getId(),
    //         ], [
    //             'name' => $githubUser->name,
    //             'email' => $githubUser->email,
    //             'github_token' => $githubUser->token,
    //             'github_refresh_token' => $githubUser->refreshToken,
    //         ]);
    //         Auth::login($user);
    //     } catch(AuthenticationException $e)
    //     {
    //         dd($e->getMessage());
    //     }
       
    // }

    public function auth($user, $githubUser)
    {
        try{
            $user->github_id = $githubUser->getId();
            $user->github_token = $githubUser->token;
            $user->github_refresh_token = $githubUser->refreshToken;
            $user->save();
            Auth::login($user);
        } catch (AuthenticationException $e)
        {
            dd($e->getMessage());
        }
    }

    public function store($user)
    {
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'github_id' => $user->getId(),
            'password' => Hash::make(Str::random(15)),
            'github_token' => $user->token,
            'github_refresh_token' => $user->refreshToken,
        ]);
        $role = Role::findByName('user');
        $newUser->assignRole($role);
        Auth::login($newUser);
    }
}