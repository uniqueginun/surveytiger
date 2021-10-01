<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SurveyDesignController extends Controller
{
    public function __invoke(Request $request, Survey $survey)
    {
        if (! Gate::allows('update-survey', $survey)) {
            abort(403);
        }

        return Inertia::render('Surveys/Design', [
            'survey' => $survey,
            'categories' => Category::all()
        ]);
    }
}
