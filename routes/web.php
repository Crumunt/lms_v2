<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Course\AssignmentController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');
        Route::get('/courses', [StudentController::class, 'courses1'])->name('courses');
        Route::get('/catalog', [StudentController::class, 'catalog'])->name('catalog');
        Route::get('/courses/{id}', [StudentController::class, 'showCourse'])->name('course.show');
        Route::post('/courses/{id}/enroll', [EnrollmentController::class, 'enroll'])->name('course.enroll');
        Route::post('/courses/{id}/unenroll', [EnrollmentController::class, 'unenroll'])->name('course.unenroll');

        Route::get('/schedule', function () {
            return view('student.schedule');
        })->name('schedule');

        Route::get('/assignments', function () {
            return view('student.assignments');
        })->name('assignments');

        Route::get('/course/{course}/assignment/{assignment}', [StudentController::class, 'showAssignment'])->name('course.assignment');
        Route::post('/course/{course}/assignment/{assignment}', [StudentController::class, 'submitAssignment'])->name('course.assignment.store');

        Route::get('/grades', function () {
            return view('student.grades');
        })->name('grades');

        Route::get('/discussions', function () {
            return view('student.discussions');
        })->name('discussions');

        Route::get('/resources', function () {
            return view('student.resources');
        })->name('resources');
    });

    Route::middleware('role:instructor')->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/dashboard', [InstructorController::class, 'index'])->name('dashboard');
        Route::resource('courses', CourseController::class);

        Route::prefix('/courses/{course}')->name('courses.')->group(function() {
            Route::resource('content', CourseContentController::class);
            Route::get('/{content}/download', [CourseContentController::class, 'download'])->name('content.download');
        });

        Route::post('/courses/{id}/contents', [CourseContentController::class, 'store'])->name('course.content.store');
        Route::put('/courses/{id}/contents/{contentId}', [CourseContentController::class, 'update'])->name('course.content.update');
        Route::delete('/courses/{id}/contents/{contentId}', [CourseContentController::class, 'destroy'])->name('course.content.delete');


        Route::get('/students', [InstructorController::class, 'students'])->name('students');
        Route::get('/students/{id}', [InstructorController::class, 'showStudent'])->name('student.show');

        Route::prefix('courses/{course}')->name('courses.')->group(function () {
            Route::resource('assignments', AssignmentController::class);
        });

        Route::get('/grades', [InstructorController::class, 'grades'])->name('grades');
        Route::get('/analytics', [InstructorController::class, 'analytics'])->name('analytics');
        Route::get('/discussions', [InstructorController::class, 'discussions'])->name('discussions');
        Route::get('/resources', [InstructorController::class, 'resources'])->name('resources');
        Route::get('/schedule', [InstructorController::class, 'schedule'])->name('schedule');
        Route::get('/settings', [InstructorController::class, 'settings'])->name('settings');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Instructor Management
        Route::get('/instructors', [AdminController::class, 'instructors'])->name('instructors');
        Route::get('/instructors/create', [AdminController::class, 'createInstructor'])->name('instructors.create');
        Route::post('/instructors', [AdminController::class, 'storeInstructor'])->name('instructors.store');
        Route::get('/instructors/{instructor}', [AdminController::class, 'showInstructor'])->name('instructors.show');
        Route::get('/instructors/{instructor}/edit', [AdminController::class, 'editInstructor'])->name('instructors.edit');
        Route::put('/instructors/{instructor}', [AdminController::class, 'updateInstructor'])->name('instructors.update');
        Route::delete('/instructors/{instructor}', [AdminController::class, 'destroyInstructor'])->name('instructors.destroy');

        // Student Management
        Route::get('/students', [AdminController::class, 'students'])->name('students');
        Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{student}', [AdminController::class, 'showStudent'])->name('students.show');
        Route::get('/students/{student}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
        Route::put('/students/{student}', [AdminController::class, 'updateStudent'])->name('students.update');
        Route::delete('/students/{student}', [AdminController::class, 'destroyStudent'])->name('students.destroy');

        // Course Management
        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::get('/courses/{course}', [AdminController::class, 'showCourse'])->name('courses.show');
        Route::get('/courses/{course}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
        Route::put('/courses/{course}', [AdminController::class, 'updateCourse'])->name('courses.update');
        Route::delete('/courses/{course}', [AdminController::class, 'destroyCourse'])->name('courses.destroy');
    });
});

require __DIR__ . '/auth.php';
