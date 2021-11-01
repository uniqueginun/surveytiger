<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
use App\Models\Category;
use App\Models\OfferedAnswer;
use App\Models\Survey;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SurveyController extends Controller
{
    public function index(Request $request): Response
    {
        $surveys = $request->user()->surveys()
            ->with('questions.answers', 'questions.type')
            ->withCount('questions')
            ->get();

        $categories = Category::all();

        return Inertia::render('Surveys/Index', [
            'surveys' => $surveys,
            'categories' => $categories
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Surveys/Create', [
            'categories' => Category::all()
        ]);
    }

    public function store(SurveyRequest $request): RedirectResponse
    {
        $survey = $request->user()->surveys()->create($request->only([
            'name', 'description', 'category_id'
        ]));

        if ($request->action === 'save') {
            return redirect()->route('surveys.create')->with('flash', 'Survey was created successfully.');
        }

        return redirect()->route('surveys.design', $survey);
    }

    public function update(SurveyRequest $request, Survey $survey): RedirectResponse
    {
        $survey->update(
            $request->only(['name', 'category_id'])
        );

        return back()->with('status', 'survey-information-updated');
    }

    public function destroy(Survey $survey): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $survey->questionSurvey->each(function($questionSurvey) {

                SurveyQuestionAnswer::where([
                    'survey_id' => $questionSurvey->survey_id,
                    'question_id' => $questionSurvey->question_id
                ])->get()->each(function($answer) {
                    OfferedAnswer::find($answer->offered_answer_id)->delete();
                    $answer->delete();
                });

                $questionSurvey->delete();
            });

            $survey->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('surveys.index');
    }
}
