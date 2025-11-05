<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminStudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        return view('admin.students.index');
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified student.
     */
    public function show(User $student)
    {
        $student->load('courses');

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($student->id)],
            'address' => 'required|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
        ]);


        DB::beginTransaction();
        try {
            $student->update([
                'email' => $validated['email']
            ]);

            $student->detail()->update([
                'full_name' => $validated['name'],
                'address' => $validated['address'],
                'status' => $validated['status']
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            Log::error('Something went wrong with updating a user. ' . $th->getMessage());
            abort(500);
        }

        return redirect()->route('admin.students')->with('success', 'Student updated successfully.');
    }
}
