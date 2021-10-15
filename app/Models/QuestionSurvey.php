<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSurvey extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['type'];

    protected $appends = ['is_slider'];

    public function type()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function getIsSliderAttribute()
    {
        return $this->type->name === 'Slider';
    }
}
