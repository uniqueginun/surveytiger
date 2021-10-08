<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offeredAnswer()
    {
        return $this->hasOne(OfferedAnswer::class, 'id', 'offered_answer_id');
    }
}
