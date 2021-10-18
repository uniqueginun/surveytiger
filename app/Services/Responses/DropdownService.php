<?php

namespace App\Services\Responses;

class DropdownService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data, $question_id)
    {
        $payload = array(
            'question_id' => $question_id,
            'offered_answer_id' => $data,
            'answer_text' => '',
            'order' => 0
        );

        return $this->saveAnswer($payload);
    }
}
