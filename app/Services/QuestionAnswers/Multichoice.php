<?php

namespace App\Services\QuestionAnswers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\QuestionSurvey;
use App\Services\SurveyQuestionAnswer as ServicesSurveyQuestionAnswer;

class Multichoice
{
   public static function create(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      ServicesSurveyQuestionAnswer::storeAnswers(
         $request->answers, 
         $questionSurvey
      );
   }

   public static function update(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      ServicesSurveyQuestionAnswer::storeAnswers(
         $request->answers, 
         $questionSurvey
      );
   }

}