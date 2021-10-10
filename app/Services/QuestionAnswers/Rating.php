<?php

namespace App\Services\QuestionAnswers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\OfferedAnswer;
use App\Models\QuestionSurvey;
use App\Models\SurveyQuestionAnswer;

class Rating
{
   public static function create(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {      
      $answerArray = count($request->answers) ? $request->answers : range(1, $request->scale);

      foreach($answerArray as $answer)
      {

         $answer = OfferedAnswer::updateOrCreate(
            ['id' =>  $answer['id']],
            ['answer_text' => $answer['answer_text']]
        );

        SurveyQuestionAnswer::create([
            'question_id' => $questionSurvey->question_id,
            'offered_answer_id' => $answer->id,
            'survey_id' => $questionSurvey->survey_id,
        ]);
      }
   }

   public static function update(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {      
      self::create($request, $questionSurvey);
   }
}