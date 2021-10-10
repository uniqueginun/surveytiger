<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionSurvey;
use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;

class SurveyQuestionAnswersController extends Controller
{
    public function __invoke(Survey $survey, Question $question)
    {
        $offeredAnswers = SurveyQuestionAnswer::where('survey_id', $survey->id)
            ->where('question_id', $question->id)
            ->with('offeredAnswer')
            ->get()
            ->map(function ($item) {
                return $item->offeredAnswer;
            });

        $questionSurvey = QuestionSurvey::where('survey_id', $survey->id)
            ->where('question_id', $question->id)
            ->first();

        return response()->json([
            'offeredAnswers' => $offeredAnswers,
            'questionSurvey' => $questionSurvey,
        ]);
    }
}
