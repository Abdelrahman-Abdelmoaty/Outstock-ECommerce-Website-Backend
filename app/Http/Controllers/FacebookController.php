<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class FacebookController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {

            $user = Socialite::driver('facebook')->user();
            $myUser = User::where('fb_id', $user->id)->first();

            if (!$myUser)
                $myUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_id' => $user->id,
                    'provider_name' => 'facebook',
                ]);

            $token = $myUser->createToken("Facebook")->plainTextToken;
            return response()->json($token, 201);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
