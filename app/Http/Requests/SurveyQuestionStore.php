<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\QuestionType;

class SurveyQuestionStore extends FormRequest
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
        return [
            'question_text' => 'required|string|max:255',
            'question_type_id' => 'required|integer|exists:question_types,id',
            'answers' => 'sometimes|nullable|array',
            'answers.*.answer_text' => 'sometimes|string|max:255',
        ];
    }

    public function className()
    {
        return QuestionType::find($this->question_type_id)->component_name;
    }
}
