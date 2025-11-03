<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        $course = $this->route('course');

        if (!Auth::user()) {
            return false;
        }

        if ($course instanceof Course) {
            return $course->instructor_id && Auth::id();
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'status' => ['required', 'in:draft,published,archived'],
        ];

        // For create (store), file is required
        // For update, file is optional
        if ($this->isMethod('POST')) {
            $rules['file'] = ['required', 'file', 'mimes:pdf', 'max:10240']; // 10MB
        } else {
            $rules['file'] = ['nullable', 'file', 'mimes:pdf', 'max:10240'];
        }

        return $rules;
    }

    public function getValidatedWithFile(): array
    {
        $validated = $this->validated();

        if ($this->hasFile('file')) {
            $file = $this->file('file');

            // Generate unique filename
            $fileName = time() . '_' . $file->hashName();

            // Store file in storage/app/public/course-contents
            $filePath = $file->storeAs('course-contents', $fileName, 'public');

            // Add file information to validated data
            $validated['file_path'] = $filePath;
        }

        return $validated;
    }

    /**
     * Handle file upload for update (deletes old file if new one uploaded)
     */
    public function getValidatedWithFileUpdate($existingContent): array
    {
        $validated = $this->validated();

        // If new file is uploaded, replace the old one
        if ($this->hasFile('file')) {
            // Delete old file
            if ($existingContent->file_path && Storage::disk('public')->exists($existingContent->file_path)) {
                Storage::disk('public')->delete($existingContent->file_path);
            }

            // Upload new file
            $file = $this->file('file');
            $fileName = time() . '_' . $file->hashName();
            $filePath = $file->storeAs('course-contents', $fileName, 'public');

            $validated['file_path'] = $filePath;
        }

        return $validated;
    }
}
