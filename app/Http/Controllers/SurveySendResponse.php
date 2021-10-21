<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SurveySendResponse extends Controller
{

    public function __invoke(Request $request, Survey $survey, $anonymous = 'false')
    {

        DB::beginTransaction();

        $responseIdentifier = Str::uuid()->toString();

        try {

            foreach ($request->all() as ['type' => $type, 'question_id' => $question_id, 'value' => $value]) {

                $serviceClass = Str::of($type)
                    ->append('Service')
                    ->studly()
                    ->prepend('App\\Services\\Responses\\');

                app((string) $serviceClass)
                    ->forSurvey($survey)
                    ->setIdentifier($responseIdentifier)
                    ->storeResponse($value, $question_id);
            }

            DB::commit();

        } catch (\Throwable $exception) {
            DB::rollBack();
        }

        if ($anonymous !== 'false') {
            return back()->with('success', true);
        }

        return redirect()->route('surveys.preview-result', [
            $survey, $responseIdentifier
        ]);
    }
}
