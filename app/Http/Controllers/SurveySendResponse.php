<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SurveySendResponse extends Controller
{

    public function __invoke(Request $request, Survey $survey)
    {
        foreach ($request->all() as ['type' => $type, 'question_id' => $question_id, 'value' => $value]) {

            $serviceClass = Str::of($type)
                ->append('Service')
                ->studly()
                ->prepend('App\\Services\\Responses\\');

            app((string) $serviceClass)->forSurvey($survey)->storeResponse($value, $question_id);
        }
    }
}
