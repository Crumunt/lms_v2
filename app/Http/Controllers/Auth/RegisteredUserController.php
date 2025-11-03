<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:instructor,student']
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->detail()->create([
                'full_name' => $request->full_name,
                'address' => 'to be added.',
                'status' => 'pending',
            ]);

            $user->assignRole($request->role);

            DB::commit();
        } catch (Exception $e) {
            //throw $th;
            DB::rollback();
            Log::error('Something went wrong with registering a user. ' . $e->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    private function redirectBasedOnRole($user)
    {
        if($user->hasRole('instructor')) {
            return redirect()->route('instructor.dashboard');
        }

        return redirect()->route('student.dashboard');
    }
}
