<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['updated_at'];

    protected static function booted()
    {
        static::creating(function($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

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
