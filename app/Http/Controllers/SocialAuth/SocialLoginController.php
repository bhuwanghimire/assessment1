<?php

namespace App\Http\Controllers\SocialAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SocialLoginService;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    protected $authService;

    public function __construct(SocialLoginService $authService)
    {
        $this->authService = $authService;
    }
    public function redirectProvider($provider){


        return Socialite::driver($provider)->redirect();

    }

    public function handleCallBack($provider)
    {
        $authUser = $this->authService->handleProviderCallback($provider);

  // Log the user in
            auth()->login($authUser, true);
        return redirect()->route('dashboard');
        dd($authUser);
    }
}
