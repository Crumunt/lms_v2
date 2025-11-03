<?php

namespace App\Http\Requests;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isInstanceOf;

class AssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $course = $this->route('course');
        $assignment = $this->route('assignment');

        if(!Auth::check()) {
            return false;
        }

        if($assignment instanceof Assignment) {
            if($assignment->course_id !== $course->id) {
                return false;
            }

            return $course->instructor_id === Auth::id();
        }

        if($course instanceof Course) {
            return $course->instructor_id === Auth::id();
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
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'total_points' => ['required', 'integer', 'min:1', 'max:100'],
            'due_date' => ['nullable', 'date', 'after:now'],
            'allow_late_submission' => ['nullable', 'boolean'],
            'submission_type' => ['required', 'in:file,text,both'],
            'status' => ['required', 'in:draft,published,closed'],
        ];
    }
}
