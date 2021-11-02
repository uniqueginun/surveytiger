<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyCloneRequest;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class SurveyCloningController extends Controller
{
    public function __invoke(SurveyCloneRequest $request)
    {
        DB::transaction(function () use ($request) {

            $survey = $request->user()->surveys()->create(
                $request->only('name', 'description', 'category_id')
            );
    
            collect($request->questions)->each(function ($question) use ($survey) {
                Question::createFromRequest($question, $survey);
            });
        });
        
        return redirect()->route('surveys.index')->with('flash', 'Survey cloned successfully');
    }
}
