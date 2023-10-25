<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Cart;
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
            $myUser = User::where([
                ['provider_id', $user->id],
                ['provider_name', 'facebook']
            ])->first();

            if (!$myUser)
                $myUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_id' => $user->id,
                    'provider_name' => 'facebook',
                ]);

            Cart::userCartOrCreate($myUser->id);
            $token = $myUser->createToken("Facebook")->plainTextToken;
            return response()->json(['token' => $token, 'user' => new UserResource($myUser)], 201);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
