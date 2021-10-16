<?php

namespace App\Services\Responses;

class RatingService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data, $question_id): bool
    {
        $this->saveAnswer($data, $question_id);
    }
}
