<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_surveys')
                    ->withPivot('question_type_id', 'min', 'max', 'center', 'scale');
    }
}
