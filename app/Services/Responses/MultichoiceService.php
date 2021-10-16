<?php

namespace App\Services\Responses;

use App\Models\Survey;

class MultichoiceService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data): bool
    {
        foreach($data as $answer)
        {

        }
    }

    public function forSurvey(Survey $survey): SurveyResponseInterface
    {
        $this->survey = $survey;
        return $this;
    }
}
