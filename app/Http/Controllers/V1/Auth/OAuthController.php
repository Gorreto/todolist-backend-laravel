<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Socialite;

class OAuthController extends Controller
{
    /**
     * Get the redirect provider url.
     */
    public function redirectToProvider($provider): JsonResponse
    {
        return response()->json([
            'redirect_url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()
        ]);
    }

    /**
     * Obtain the user information from provider.
     */
    public function handleProviderCallback($provider): JsonResponse
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return redirect()->route('login');
        }

        return $this->respondWithToken(auth()->login(
            User::firstOrCreate(
                ['provider_id' => $user->id],
                [
                    'name' => $user->name ?? $user->email,
                    'email' => $user->email,
                    'provider' => $provider
                ]
            )
        ));
    }
}
