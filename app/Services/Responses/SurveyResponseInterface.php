<?php

namespace App\Services\Responses;

use App\Models\Survey;

interface SurveyResponseInterface
{
    public function forSurvey(Survey $survey);

    public function storeResponse($data, $question_id);
}
