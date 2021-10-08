<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\OfferedAnswer;
use App\Models\Question;
use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;
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

            SurveyQuestionAnswer::where($condition)->delete();

            foreach($request->answers as $answer) {
                
                if(isset($answer['id'])) {
                    $offeredAnswer = OfferedAnswer::find($answer['id']);
                    unset($answer['id']);
                    $offeredAnswer->update($answer);
                    $offeredAnswer->fresh();
                } else {
                    $offeredAnswer = OfferedAnswer::create([
                        'answer_text' => $answer['answer_text'],
                    ]);
                }

                SurveyQuestionAnswer::create(
                    array_merge($condition, [
                        'offered_answer_id' => $offeredAnswer->id
                    ])
                );
            }

            DB::commit();

            return redirect()->route('surveys.design', $survey->id);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());

            return redirect()->back()->withErrors([
                'question' => 'couldn\'t edit question',
                'message' => 'Something went wrong',
            ]);
        }

        return Redirect::route('survey.show', $survey->id);
    }
}
