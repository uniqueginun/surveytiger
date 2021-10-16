<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveySendResponse extends Controller
{

    public function __invoke(Request $request, Survey $survey)
    {
        foreach ($request->all() as $questionType => $response) {
            $serviceClass = Str::of($questionType)
                ->append('Service')
                ->studly()
                ->prepend('App\\Services\\Responses\\');

            app((string) $serviceClass)->forSurvey($survey)->storeResponse($response);
        }
    }
}
