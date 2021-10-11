<?php

namespace App\Services\QuestionAnswers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\QuestionSurvey;
use App\Services\SurveyQuestionAnswer as ServicesSurveyQuestionAnswer;

class Multichoice extends ServicesSurveyQuestionAnswer
{
   public static function create(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      static::storeAnswers(
         $request->answers, 
         $questionSurvey
      );
   }

   public static function update(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      static::storeAnswers(
         $request->answers, 
         $questionSurvey
      );
   }

}