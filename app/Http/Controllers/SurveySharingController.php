<?php

namespace App\Http\Controllers;

use App\Models\QuestionType;
use App\Models\Survey;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SurveySharingController extends Controller
{
    public function __invoke(Request $request, Survey $survey)
    {

        abort_if(
            $survey->alreadyTakenBythisDevice($request), 
            401,
            'You have already taken this survey recently!'
        );

        $survey->load('questions.type', 'questions.answers');

        return Inertia::render('Surveys/Collect', [
            'survey' => $survey,
            'types' => QuestionType::all()
        ]);
    }
}
