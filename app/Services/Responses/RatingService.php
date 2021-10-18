<?php

namespace App\Services\Responses;

class RatingService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data, $question_id)
    {
        return $this->saveAnswer(array(
            'question_id' => $question_id,
            'offered_answer_id' => $data,
            'answer_text' => '',
            'order' => 0
        ));
    }
}
