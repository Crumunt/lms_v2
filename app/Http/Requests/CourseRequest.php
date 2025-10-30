<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $course = $this->route('course'); // route-model binding

        if ($course) {
            return $course->instructor_id === Auth::id();
        }

        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $courseId = $this->route('course')?->id;

        return [
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('courses', 'title')->ignore($courseId),
            ],
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('courses', 'code')->ignore($courseId),
            ],
            'difficulty' => ['required', 'string'],
            'status' => ['required', 'string'],
            'plain_description' => ['required', 'string', 'max:255', 'min:100'],
        ];

    }

    protected function prepareForValidation()
    {
        if ($this->has('description')) {
            $plain = strip_tags($this->description); // strip HTML
            $plain = preg_replace('/\s+/u', ' ', $plain); // collapse whitespace
            $plain = trim($plain); // trim spaces

            $this->merge([
                'plain_description' => $plain
            ]);
        }
    }
}
