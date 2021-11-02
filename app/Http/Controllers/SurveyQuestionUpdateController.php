<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\OfferedAnswer;
use App\Models\Question;
use App\Models\QuestionSurvey;
use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;
use App\Services\QuestionAnswerService;
use App\Services\QuestionPayload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SurveyQuestionUpdateController extends Controller
{
    public function __invoke(SurveyQuestionStore $request, Survey $survey, Question $question)
    {

        DB::beginTransaction();

        try {

            $question->update($request->only(['question_text']));

            $condition = [
                'question_id' => $question->id,
                'survey_id' => $survey->id,
            ];

            $questionSurvey = QuestionSurvey::where($condition)->first();

            $questionSurvey->update([
                'question_type_id' => $request->question_type_id,
                'min' => $request->min ?? 0,
                'max' => $request->max ?? 0,
                'center' => $request->center ?? 0,
                'scale' => $request->scale ?? 0
            ]);


            if($questionSurvey->type->has_answers && !!$request->answers) {
                SurveyQuestionAnswer::where($condition)->delete();
                QuestionAnswerService::update(
                    QuestionPayload::run($request->toArray()), 
                    $questionSurvey->fresh()
                );
            }

            DB::commit();

            return redirect()->route('surveys.design', $survey->id)->with('flash', 'Question added successfully');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getTraceAsString());
            return redirect()->back()->withErrors([
                'question' => 'couldn\'t edit question',
                'message' => 'Something went wrong',
            ]);
        }

        return Redirect::route('survey.show', $survey->id);
    }
}
