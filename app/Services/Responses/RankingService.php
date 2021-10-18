<?php

namespace App\Services\Responses;

class RankingService extends AnswerDatabaseStorage implements SurveyResponseInterface
{

    public function storeResponse($data, $question_id)
    {
        return collect($data)
            ->map(fn($item) => $item['id'])
            ->sortKeysDesc()
            ->values()
            ->map(function ($answer, $key) use ($question_id) {
                return $this->saveAnswer(
                    array(
                        'question_id' => $question_id,
                        'offered_answer_id' => $answer,
                        'answer_text' => '',
                        'order' => $key + 1
                    )
                );
            })->flatten()->toArray();
    }
}
