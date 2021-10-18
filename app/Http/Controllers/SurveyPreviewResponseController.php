<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Services\SurveyResults;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SurveyPreviewResponseController extends Controller
{
    public function __invoke(Survey $survey, $identifier = ''): InertiaResponse
    {
        $resultSet = SurveyResults::for($survey)->with($identifier)->getResults();

        return Inertia::render('Surveys/Preview', [
            'resultSet' => $resultSet
        ]);
    }
}
