<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Exception;
use App\Providers\GoogleServiceProvider;
use App\Providers\GithubServiceProvider;
use Hash;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use InvalidArgumentException;

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
            $user = $this->getSocialiteUser('google');
            $this->loginOrCreateFromSocialite($user, 'google');
            return redirect()->intended('/');
        } catch (AuthenticationException $e)
        {
            dd($e->getMessage());
        }
    }

    public function githubCallback()
    {
        try {
            $user = $this->getSocialiteUser('github');
            $this->loginOrCreateFromSocialite($user, 'github');
            return redirect()->intended('/');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    private function getSocialiteUser(string $provider)
    {
        return Socialite::driver($provider)->stateless()->user();
    }

    private function loginOrCreateFromSocialite($user, $provider)
    {
        $providers = [
            'google' => ['service'=> GoogleServiceProvider::class],
            'github' => ['service'=> GithubServiceProvider::class],
        ];

        if(!isset($providers[$provider])) {
            throw new InvalidArgumentException("Invalid provider: $provider");
        }

        $serviceClass = $providers[$provider]['service'];

        $service = new $serviceClass();
        $findUser = User::where("email", $user->email)->first();

        if($findUser) {
            $service->auth($findUser, $user);
        } else {
            $service->store($user);
        }
    }
}
