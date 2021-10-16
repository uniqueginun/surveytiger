<?php

namespace App\Models;

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
}
