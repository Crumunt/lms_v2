<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseContentRequest;
use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseContentController extends Controller
{

    public function index(Course $course)
    {
        $course->load('contents');

        $course_content = $course->contents;

        $contents = (object) [
            'total' => $course->contents()->count(),
            'published' => $course->contents()->published()->count(),
            'draft' => $course->contents()->draft()->count(),
            'archived' => $course->contents()->archived()->count()
        ];
        return view('instructor.course.content.index', compact('course', 'contents', 'course_content'));
    }

    public function create(Course $course)
    {
        return view('instructor.course.content.create', compact('course'));
    }

    /**
     * Store a newly created course content.
     */
    public function store(CourseContentRequest $request, Course $course)
    {
        $data = $request->getValidatedWithFile();

        try {
            $course->contents()->create($data);
        } catch (\Throwable $th) {
            Log::error('Something went wrong ' . $th->getMessage());
            abort(500);
        }

        return redirect()
            ->route('instructor.courses.content.index', $course)
            ->with('success', 'Content uploaded successfully!');
    }

    public function edit(Course $course, CourseContent $content)
    {
        return view('instructor.course.content.edit', compact('course', 'content'));
    }

    /**
     * Update the specified course content.
     */
    public function update(CourseContentRequest $request, Course $course, CourseContent $content)
    {
        $data = $request->getValidatedWithFileUpdate($content);

        try {
            $content->update($data);
        } catch (\Exception $e) {
            Log::error('Something went wrong with updating the content ' . $e->getMessage());
            abort(500);
        }

        return redirect()
            ->route('instructor.courses.content.index', $course)
            ->with('success', 'Content uploaded successfully!');
    }

    /**
     * Remove the specified course content.
     */
    public function destroy(Course $course, CourseContent $content)
    {

        if($course->instructor_id !== Auth::id()) {
            abort(403, "You aren't authorized to delete this data.");
        }

        try {

            // * DELETE FILE
            Storage::disk('public')->delete($content->file_path);

            $content->delete();
        } catch (\Exception $e) {
            Log::error('Something went wrong with deleting the object. ' . $e->getMessage());
            abort(500);
        }

        return redirect()
            ->route('instructor.courses.content.index', $course)
            ->with('success', 'Content uploaded successfully!');
    }

    /**
     * Serve course content files.
     */
    public function serve(Request $request, $instructor, $file)
    {
        try {
            // Build file path
            $filePath = "course_contents/{$instructor}/{$file}";

            // Check if file exists
            if (!Storage::disk('public')->exists($filePath)) {
                abort(404, 'File not found');
            }

            // Get file info
            $fullPath = Storage::disk('public')->path($filePath);
            $mimeType = Storage::disk('public')->mimeType($filePath);

            // Validate it's a PDF
            if ($mimeType !== 'application/pdf') {
                abort(400, 'Invalid file type');
            }

            // Set headers for PDF viewing
            return response()->file($fullPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
                'Cache-Control' => 'public, max-age=3600',
            ]);

        } catch (\Exception $e) {
            abort(404, 'File not found');
        }
    }

    public function download(Course $course, CourseContent $courseContent)
    {

    }
}