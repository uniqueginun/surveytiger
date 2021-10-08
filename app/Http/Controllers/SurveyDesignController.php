<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\QuestionType;
use App\Models\Survey;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SurveyDesignController extends Controller
{
    public function __invoke(Survey $survey)
    {
        if (! Gate::allows('update-survey', $survey)) {
            abort(403);
        }

        $survey->load('questions');

        return Inertia::render('Surveys/Design', [
            'survey' => $survey,
            'categories' => Category::all(),
            'types' => QuestionType::all()
        ]);
    }
}
