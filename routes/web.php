<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminInstructorController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Course\AssignmentController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseContentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use App\Models\CourseContent;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');
        Route::get('/courses', [StudentController::class, 'courses1'])->name('courses');
        Route::get('/catalog', [StudentController::class, 'catalog'])->name('catalog');
        Route::get('/courses/{id}', [StudentController::class, 'showCourse'])->name('course.show');

        Route::get('/course/{course}/assignment/{assignment}', [StudentController::class, 'showAssignment'])->name('course.assignment');
        Route::post('/course/{course}/assignment/{assignment}', [StudentController::class, 'submitAssignment'])->name('course.assignment.store');

    });

    Route::middleware('role:instructor')->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/dashboard', [InstructorController::class, 'index'])->name('dashboard');
        Route::resource('courses', CourseController::class);

        Route::prefix('/courses/{course}')->name('courses.')->group(function() {
            Route::resource('content', CourseContentController::class);
            Route::get('/{content}/download', [CourseContentController::class, 'download'])->name('content.download');
        });

        Route::get('/students', [InstructorController::class, 'students'])->name('students');
        Route::get('/students/{id}', [InstructorController::class, 'showStudent'])->name('student.show');

        Route::prefix('courses/{course}')->name('courses.')->group(function () {
            Route::resource('assignments', AssignmentController::class);
        });

    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Instructor Management
        Route::resource('instructors', AdminInstructorController::class);
        // Route::get('/instructors', [AdminInstructorController::class, 'index'])->name('instructors');
        // Route::get('/instructors/create', [AdminInstructorController::class, 'create'])->name('instructors.create');
        // Route::post('/instructors', [AdminInstructorController::class, 'store'])->name('instructors.store');
        // Route::get('/instructors/{instructor}', [AdminInstructorController::class, 'show'])->name('instructors.show');
        // Route::get('/instructors/{instructor}/edit', [AdminInstructorController::class, 'edit'])->name('instructors.edit');
        // Route::put('/instructors/{instructor}', [AdminInstructorController::class, 'update'])->name('instructors.update');

        // Student Management
        Route::get('/students', [AdminStudentController::class, 'index'])->name('students');
        Route::get('/students/create', [AdminStudentController::class, 'create'])->name('students.create');
        Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');

        // Course Management
        Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses');
        Route::get('/courses/{course}', [AdminCourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
    });
});

require __DIR__ . '/auth.php';
