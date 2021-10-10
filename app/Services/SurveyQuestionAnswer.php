<?php

namespace App\Services;

use App\Models\OfferedAnswer;
use App\Models\SurveyQuestionAnswer as ModelsSurveyQuestionAnswer;

class SurveyQuestionAnswer
{
   public static function storeAnswers($data, $questionSurvey)
   {
      foreach($data as $answer) {

         if (! $answer['answer_text']) {
            continue;
         }

         $offeredAnswer = OfferedAnswer::updateOrCreate(['id' => $answer['id'] ?? null], [
             'answer_text' => $answer['answer_text'],
         ]);

         ModelsSurveyQuestionAnswer::create([
            'question_id' => $questionSurvey->question_id,
            'offered_answer_id' => $offeredAnswer->id,
            'survey_id' => $questionSurvey->survey_id,
         ]);
     }
   }
}