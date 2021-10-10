<?php

namespace App\Services\QuestionAnswers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\OfferedAnswer;
use App\Models\QuestionSurvey;
use App\Models\SurveyQuestionAnswer;

class Multichoice
{
   public static function create(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      foreach($request->answers as $answer) {
         $answer = OfferedAnswer::create([
             'answer_text' => $answer['answer_text'],
         ]);

         SurveyQuestionAnswer::create([
            'question_id' => $questionSurvey->question_id,
            'offered_answer_id' => $answer->id,
            'survey_id' => $questionSurvey->survey_id,
         ]);
     }
   }

   public static function update(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      foreach($request->answers as $answer) {
                
         if(isset($answer['id'])) {
             $offeredAnswer = OfferedAnswer::find($answer['id']);
             unset($answer['id']);
             $offeredAnswer->update($answer);
             $offeredAnswer->fresh();
         } else {
             $offeredAnswer = OfferedAnswer::create([
                 'answer_text' => $answer['answer_text'],
             ]);
         }

         SurveyQuestionAnswer::create([
            'question_id' => $questionSurvey->question_id,
            'offered_answer_id' => $offeredAnswer->id,
            'survey_id' => $questionSurvey->survey_id,
         ]);
     }
   }
}