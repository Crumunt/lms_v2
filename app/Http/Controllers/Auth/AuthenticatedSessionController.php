<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


        return $this->redirectBasedOnRole();
    }

    protected function redirectBasedOnRole()
    {

        $user = Auth::user();


        // GET USER ROLE
        $role = $user->roles->first()->name;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'instructor' => redirect()->route('dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default => redirect()->route('login')->with('error', 'Invalid user role.')
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
