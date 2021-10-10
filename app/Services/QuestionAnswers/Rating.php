<?php

namespace App\Services\QuestionAnswers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\QuestionSurvey;
use App\Services\SurveyQuestionAnswer as ServicesSurveyQuestionAnswer;

class Rating
{
   public static function create(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {      
      $answerArray = count($request->answers) ? $request->answers : range(1, $request->scale);

      dd($answerArray);

      ServicesSurveyQuestionAnswer::storeAnswers($answerArray, $questionSurvey);
   }

   public static function update(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {      
      self::create($request, $questionSurvey);
   }
}