<?php

namespace App\Services\QuestionAnswers;

use App\Models\QuestionSurvey;
use App\Services\SurveyQuestionAnswer as ServicesSurveyQuestionAnswer;

class Multichoice extends ServicesSurveyQuestionAnswer
{
   public static function create(array $request, QuestionSurvey $questionSurvey)
   {
      static::storeAnswers(
         $request['answers'], 
         $questionSurvey
      );
   }

   public static function update(array $request, QuestionSurvey $questionSurvey)
   {
      static::storeAnswers(
         $request['answers'], 
         $questionSurvey
      );
   }

}