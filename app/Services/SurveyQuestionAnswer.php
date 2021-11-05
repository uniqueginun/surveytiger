<?php

namespace App\Services;

use App\Models\OfferedAnswer;
use App\Models\SurveyQuestionAnswer as ModelsSurveyQuestionAnswer;

abstract class SurveyQuestionAnswer
{
   public static function storeAnswers($data, $questionSurvey)
   {
      foreach($data as $answer) {

         if (! $answer['answer_text']) {
            continue;
         }

         $offeredAnswer = self::createOrUpdateOfferedAnswer($answer);

         ModelsSurveyQuestionAnswer::create([
            'question_id' => $questionSurvey->question_id,
            'offered_answer_id' => $offeredAnswer->id,
            'survey_id' => $questionSurvey->survey_id,
         ]);
     }
   }

   protected static function createOrUpdateOfferedAnswer(array $answer)
   {
      $pk = $answer['id'] ?? null;

      $offeredAnswer = !is_null($pk) ? OfferedAnswer::find($pk) : new OfferedAnswer();
      $offeredAnswer->answer_text = $answer['answer_text'];
      $offeredAnswer->save();

      $offeredAnswer->fresh();

      return $offeredAnswer;
   }
}