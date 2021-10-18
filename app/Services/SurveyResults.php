<?php

namespace App\Services;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SurveyResults
{
    public string $identifier = '';

    public Collection $questions;

    public function __construct(public Survey $survey)
    {
        $this->questions = $this->survey->questions->sortBy('id');
    }

    public static function for(Survey $survey): SurveyResults
    {
        $survey->load(['questions.type']);

        return new self($survey);
    }

    public function with(string $identifier): SurveyResults
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getResults(): mixed
    {
        return $this->questions->transform(function ($question) {
            $resultClass = $this->getResultClass($question);
            $question['answers'] = $question->answers()->where('survey_id', $this->survey->id)->get();
            $question['question_results'] = (new $resultClass())->getResult(
                $this->buildResultQuery()->where('question_id', $question->id)
            );
            return $question;
        });
    }

    private function buildResultQuery(): Builder
    {
        $conditions = [
            'survey_id' => $this->survey->id,
        ];

        if ($this->identifier) {
            $conditions = $conditions + ['identifier' => $this->identifier];
        }

        return DB::table('survey_responses as master')->where($conditions);
    }

    private function getResultClass($question)
    {
        return "App\\Services\\Results\\" . $question->type->result_type;
    }
}
