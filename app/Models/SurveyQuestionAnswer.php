<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->offeredAnswer()->delete();
        });
    }

    public function offeredAnswer()
    {
        return $this->hasOne(OfferedAnswer::class, 'id', 'offered_answer_id');
    }
}
