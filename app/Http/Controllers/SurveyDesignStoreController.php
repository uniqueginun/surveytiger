<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\OfferedAnswer;
use App\Models\QuestionSurvey;
use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;
use App\Services\QuestionAnswerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyDesignStoreController extends Controller
{
    public function __invoke(SurveyQuestionStore $request, Survey $survey)
    {
        DB::beginTransaction();

        try {
            $authenicatedUser = $request->user();

            $question = $authenicatedUser->questions()->create($request->only(['question_text']));

            $QuestionSurvey = QuestionSurvey::create([
                'question_id' => $question->id,
                'survey_id' => $survey->id,
                'question_type_id' => $request->question_type_id,
                'min' => $request->min ?? 0,
                'max' => $request->max ?? 0,
                'center' => $request->center ?? 0,
                'scale' => $request->scale ?? 0
            ]);

            $QuestionSurvey->load('type');

            if($QuestionSurvey->type->has_options) {
                QuestionAnswerService::create($request, $QuestionSurvey);
            }

            DB::commit();

            return redirect()->route('surveys.design', $survey->id)
                        ->with('flash', 'Question added successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withErrors([
                'question' => 'couldn\'t add the question',
                'message' => 'Something went wrong',
            ]);
        }

    }
}
