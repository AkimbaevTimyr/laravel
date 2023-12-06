<?php

namespace App\Providers;

use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;
use Spatie\Permission\Models\Role;


class GoogleServiceProvider 
{
    public function auth(User $user)
    {
        try{
            Auth::login($user);
        } catch (AuthenticationException $e)
        {
            dd($e->getMessage());
        }
    }

    public function store($user)
    {
        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->id,
            'password' => Hash::make(Str::random(15)),
        ]);
        $role = Role::findByName('user');
        $newUser->assignRole($role);
        Auth::login($newUser);
    }
}