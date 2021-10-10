<?php

namespace App\Services;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\QuestionSurvey;

class QuestionAnswerService
{

   public $questionSurvey;

   public function __construct(QuestionSurvey $questionSurvey)
   {
      $this->questionSurvey = $questionSurvey;
   }

   public static function create(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      return (new static($questionSurvey))->createAnswers($request);
   }

   public static function update(SurveyQuestionStore $request, QuestionSurvey $questionSurvey)
   {
      return (new static($questionSurvey))->updateAnswers($request);
   }

   protected function createAnswers(SurveyQuestionStore $request)
   {
      $answerClass = $this->getServiceClassName($request);

      return $answerClass::create($request, $this->questionSurvey);
   }

   protected function updateAnswers(SurveyQuestionStore $request)
   {
      $answerClass = $this->getServiceClassName($request);

      return $answerClass::update($request, $this->questionSurvey);
   }

   private function getServiceClassName($request)
   {
      return 'App\\Services\\QuestionAnswers\\' . $request->className();
   }

}