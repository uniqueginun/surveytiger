<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
use App\Models\Category;
use App\Models\Survey;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $surveys = $request->user()->surveys()->get();

        return Inertia::render('Surveys/Index', [
            'surveys' => $surveys
        ]);
    }

    public function create()
    {  
        return Inertia::render('Surveys/Create', [
            'categories' => Category::all()
        ]);
    }

    public function store(SurveyRequest $request)
    {
        $survey = $request->user()->surveys()->create($request->only([
            'name', 'description', 'category_id'
        ]));

        if ($request->action === 'save') {
            return redirect()->route('surveys.create')->with('flash', 'Survey was created successfully.');
        }

        return redirect()->route('surveys.design', $survey);
    }

    public function update(SurveyRequest $request, Survey $survey)
    {
        $survey->update(
            $request->only(['name', 'category_id'])
        );

        return back()->with('status', 'survey-information-updated');
    }
}
