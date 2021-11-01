<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionSurvey extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['type'];

    protected $appends = ['is_slider'];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->question->delete();
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(
            QuestionType::class,
            'question_type_id'
        );
    }

    public function getIsSliderAttribute(): bool
    {
        return $this->type->name === 'Slider';
    }
}
