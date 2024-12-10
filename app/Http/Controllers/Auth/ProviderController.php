<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function redirect($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback($driver)
    {
        $providerUser = Socialite::driver($driver)->user();

        $user = User::firstOrCreate([
            'email' => $providerUser->email,
        ], [
            'name' => $providerUser->name,
            'provider_id' => $providerUser->id,
            'provider_name' => $driver,
            'provider_token' => $providerUser->token,
            'provider_refresh_token' => $providerUser->refreshToken,
            'provider_avatar' => $providerUser->avatar
        ]);

        Auth::login($user);
        
        return redirect()->back();
    }

}
