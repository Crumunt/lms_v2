<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    //
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::where('email', $socialUser->getEmail())->first();

            $name = $socialUser->getName()
                ?? $socialUser->getNickname()
                ?? $socialUser->user['given_name']
                ?? $socialUser->user['first_name']
                ?? 'Unnamed User';


            if ($user) {
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId()
                ]);
            } else {
                DB::beginTransaction();

                try {
                    $user = User::create([
                        'email' => $socialUser->getEmail(),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'email_verified_at' => now(),
                        'password' => null
                    ]);

                    $user->detail()->create([
                        'full_name' => $name,
                        'address' => 'to be added',
                        'status' => 'pending'
                    ]);

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    Log::error('Something went wrong with Socialite ' . $e->getMessage());
                }
            }

            Auth::login($user);

            if (!$user->hasRole(['instructor', 'student'])) {
                return redirect()->route('role.select');
            }

            return $this->redirectBasedOnRole($user);


        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Unable to login. Please try again.');
        }
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->hasRole('instructor')) {
            return redirect()->route('instructor.dashboard');
        }

        return redirect()->route('student.dashboard');
    }

}
