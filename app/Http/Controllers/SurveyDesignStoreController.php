<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyQuestionStore;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyDesignStoreController extends Controller
{
    public function __invoke(SurveyQuestionStore $request, Survey $survey)
    {
        Question::createFromRequest(
            $request->toArray(), 
            $survey
        );

        return back();
        
        DB::beginTransaction();

        try {

            Question::createFromRequest(
                $request->toArray(), 
                $survey
            );

            DB::commit();

            return redirect()->route('surveys.design', $survey->id)->with('flash', 'Question added successfully');

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
