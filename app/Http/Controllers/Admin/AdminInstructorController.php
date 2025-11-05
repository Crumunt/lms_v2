<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Enrollment;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminInstructorController extends Controller
{
    public function index()
    {
        return view('admin.instructors.index');
    }

    /**
     * Display the specified instructor.
     */
    public function show(User $instructor)
    {
        $instructor->load('taughtCourses');
        return view('admin.instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified instructor.
     */
    public function edit(User $instructor)
    {
        return view('admin.instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified instructor.
     */
    public function update(Request $request, User $instructor)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($instructor->id)],
            'address' => 'required|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        DB::beginTransaction();
        try {
            $instructor->update([
                'email' => $validated['email'],
                'address' => $validated['address'],
            ]);

            $instructor->detail()->update([
                'address' => $validated['address'],
                'status' => $validated['status'],
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Something went wrong with updating the instructor ' . $e->getMessage());
            abort(500);
        }

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully.');
    }
}
