<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeTakenBy($builder, $conditions)
    {
        $builder->where($conditions);
    }

    public function scopeRecently($builder, $subMinutes = 5)
    {
        $builder->whereBetween(
            'created_at', 
            [now()->subMinutes($subMinutes), now()->subSeconds(5)]
        );
    }
}
