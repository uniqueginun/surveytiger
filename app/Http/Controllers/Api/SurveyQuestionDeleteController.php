<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class SurveyQuestionDeleteController extends Controller
{
    public function __invoke(Survey $survey, Question $question)
    {

        DB::beginTransaction();

        try {
            $survey->questions()->detach($question->id);

            SurveyQuestionAnswer::where([
                'survey_id' => $survey->id,
                'question_id' => $question->id,
            ])->delete();
            
            DB::commit();

            $flash = [
                'message' => 'Question deleted successfully',
                'type' => 'success',
            ];
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            DB::rollBack();
            $flash = [
                'message' => 'Error deleting question',
                'type' => 'error',
            ];
        }

        return Redirect::route('surveys.design', $survey)
                ->with('flash', $flash);
    }
}
