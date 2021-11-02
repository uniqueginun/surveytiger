<?php

namespace App\Services;

use App\Models\QuestionSurvey;

class QuestionAnswerService
{

   public $questionSurvey;

   public function __construct(QuestionSurvey $questionSurvey)
   {
      $this->questionSurvey = $questionSurvey;
   }


   public static function create(array $request, QuestionSurvey $questionSurvey)
   {
      return (new static($questionSurvey))->createAnswers($request);
   }

   public static function update(array $request, QuestionSurvey $questionSurvey)
   {
      return (new static($questionSurvey))->updateAnswers($request);
   }

   protected function createAnswers(array $request)
   {
      $answerClass = $this->getServiceClassName($request);

      return $answerClass::create($request, $this->questionSurvey);
   }

   protected function updateAnswers(array $request)
   {
      $answerClass = $this->getServiceClassName($request);

      return $answerClass::update($request, $this->questionSurvey);
   }

   private function getServiceClassName($request)
   {
      return 'App\\Services\\QuestionAnswers\\' . $request['className'];
   }

}