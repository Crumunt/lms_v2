<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //
    public function showRoleSelection()
    {
        // If user already has a role, redirect them
        if (Auth::user()->hasRole(['instructor', 'student'])) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.select-role');
    }

    public function selectRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:student,instructor'
        ]);

        $user = Auth::user();
        $user->assignRole($request->role);

        return $this->redirectBasedOnRole($user);
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->hasRole('instructor')) {
            return redirect()->route('instructor.dashboard')
                ->with('success', 'Welcome to your instructor dashboard!');
        }
        
        return redirect()->route('student.dashboard')
            ->with('success', 'Welcome to your student dashboard!');
    }
}
