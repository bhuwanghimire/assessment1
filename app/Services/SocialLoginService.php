<?php

namespace App\Services;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginService
{


    public function handleProviderCallback($provider)
    {

        $user = Socialite::driver($provider)->user();
        if ($provider == 'github') {
            $authUser = $this->findOrCreateUser($user,$provider);


            return $authUser;
        }
    }

    protected function findOrCreateUser($user,$provider)
    {

        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->name?? $user->nickname,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }
}
