<?php

namespace App\Http\Requests;

use App\Models\Survey;
use Illuminate\Foundation\Http\FormRequest;

class SurveyCloneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->cloningRules(), Survey::$rules);
    }

    public function cloningRules()
    {
        return [
            'questions' => [
                'array',
                'required',
                'min:1',
            ],

            'questions.*.question_text' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages()
    {
        return [
            'questions.*.question_text.required' => 'Question text is required.',
            'questions.*.question_text.max' => 'Question text must be less than 255 characters.',
        ];
    }
}
