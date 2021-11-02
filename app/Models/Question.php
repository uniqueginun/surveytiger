<?php

namespace App\Models;

use App\Services\QuestionAnswerService;
use App\Services\QuestionPayload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type()
    {
        return $this->hasOneThrough(
            QuestionType::class,
            QuestionSurvey::class,
            'question_id',
            'id',
            'id',
            'question_type_id'
        );
    }

    public function answers()
    {
        return $this->belongsToMany(
            OfferedAnswer::class,
            'survey_question_answers',
            'question_id'
        );
    }

    public static function createFromRequest($request, $survey)
    {
        $question = new static;
        $question->question_text = $request['question_text'];
        $question->user_id = auth()->id();
        $question->save();

        $QuestionSurvey = QuestionSurvey::create([
            'question_id' => $question->id,
            'survey_id' => $survey->id,
            'question_type_id' => $request['question_type_id'],
            'min' => $request['min'] ?? 0,
            'max' => $request['max'] ?? 0,
            'center' => $request['center'] ?? 0,
            'scale' => $request['scale'] ?? 0
        ]);

        $QuestionSurvey->load('type');

        if($QuestionSurvey->type->has_answers) {
            QuestionAnswerService::create(
                QuestionPayload::run($request), 
                $QuestionSurvey
            );
        }

        return $question;
    }
}
