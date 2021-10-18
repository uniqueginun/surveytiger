<?php

namespace App\Services\Responses;

class TextboxService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data, $question_id)
    {
        return $this->saveAnswer(array(
            'question_id' => $question_id,
            'offered_answer_id' => 0,
            'answer_text' => $data,
            'order' => 0
        ));
    }
}
