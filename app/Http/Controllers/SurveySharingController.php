<?php

namespace App\Http\Controllers;

use App\Models\QuestionType;
use App\Models\Survey;
use Inertia\Inertia;

class SurveySharingController extends Controller
{
    public function __invoke(Survey $survey)
    {
        $survey->load('questions.type', 'questions.answers');

        return Inertia::render('Surveys/Collect', [
            'survey' => $survey,
            'types' => QuestionType::all()
        ]);
    }
}
