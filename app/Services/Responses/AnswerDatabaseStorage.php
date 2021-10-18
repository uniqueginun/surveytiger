<?php

namespace App\Services\Responses;

use App\Models\Survey;
use App\Models\SurveyResponse;
use phpDocumentor\Reflection\Types\Mixed_;

abstract class AnswerDatabaseStorage
{
    public Survey $survey;

    public string $identifier = '';

    protected function answerBody(): array
    {
        return array(
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'survey_id' => $this->survey->id,
            'identifier' => $this->identifier
        );
    }

    public function forSurvey(Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    protected function saveAnswer(array $answer): int|null
    {
        $response = SurveyResponse::create(
            array_merge($this->answerBody(), $answer)
        );

        return $response?->id;
    }
}
