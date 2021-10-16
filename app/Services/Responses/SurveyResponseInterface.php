<?php

namespace App\Services\Responses;

use App\Models\Survey;

interface SurveyResponseInterface
{
    public function forSurvey(Survey $survey): self;

    public function storeResponse($data): Bool;
}
