<?php

namespace App\Services\QuestionAnswers;

use App\Models\QuestionSurvey;
use App\Services\SurveyQuestionAnswer as ServicesSurveyQuestionAnswer;

class Rating extends ServicesSurveyQuestionAnswer
{
   public static function create(array $request, QuestionSurvey $questionSurvey)
   {      
      $answerArray = count($request['answers']) ? $request['answers'] : range(1, $request['scale']);

      static::storeAnswers($answerArray, $questionSurvey);
   }

   public static function update(array $request, QuestionSurvey $questionSurvey)
   {      
      self::create($request, $questionSurvey);
   }
}