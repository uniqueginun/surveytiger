<?php

namespace App\Http\Controllers;

use App\Models\QuestionSurvey;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyCloningController extends Controller
{
    public function __invoke(Request $request)
    {

        DB::transaction(function () use ($request) {
            $survey = $request->user()->surveys()->create(
                $request->only('name', 'description', 'category_id')
            );
    
            collect($request->questions)->each(function ($question) use ($survey) {
                
                $details = $question['details'];
                $answers = $question['answers'];

                $details['survey_id'] = $survey->id;

                $QuestionSurvey = QuestionSurvey::create($details);

                $QuestionSurvey->load('type');

                if($QuestionSurvey->type->has_answers) {
                    foreach ($answers as $value) {
                        SurveyQuestionAnswer::create([
                            'survey_id' => $QuestionSurvey->survey_id,
                            'question_id' => $QuestionSurvey->question_id,
                            'offered_answer_id' => $value
                        ]);
                    }
                }

            });
        });
        
        return redirect()->route('surveys.index')
                        ->with('flash', 'Survey cloned successfully');
    }
}
