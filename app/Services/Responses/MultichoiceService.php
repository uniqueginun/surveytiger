<?php

namespace App\Services\Responses;

class MultichoiceService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data, $question_id)
    {
        return collect($data)->map(function ($answer) use ($question_id) {
            return $this->saveAnswer(
                array(
                    'question_id' => $question_id,
                    'offered_answer_id' => $answer,
                    'answer_text' => '',
                    'order' => 0
                )
            );
        })->flatten()->toArray();
    }
}
