<?php

namespace App\Services\Responses;

use App\Models\Survey;

class MultichoiceService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data, $question_id): bool
    {
        foreach($data as $answer)
        {

        }
    }
}
