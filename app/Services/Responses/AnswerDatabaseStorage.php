<?php

namespace App\Services\Responses;

use App\Models\Survey;
use App\Models\SurveyResponse;

abstract class AnswerDatabaseStorage
{
    public $survey;

    public function forSurvey(Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }

    protected function saveAnswer($answer, $question): SurveyResponse
    {
        return SurveyResponse::create([
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'survey_id' => $this->survey->id,
            'question_id' => $question,
            'offered_answer_id' => $answer,
            'answer_text' => $answer,
            'order' => $answer
        ]);
    }
}
