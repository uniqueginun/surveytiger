<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
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

        static::deleting(function ($model) {
            $model->responses()->delete();
        });
    }

    public static $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id'
    ];

    public function questionSurvey()
    {
        return $this->hasMany(QuestionSurvey::class);
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_surveys')
                    ->withPivot('question_type_id', 'min', 'max', 'center', 'scale');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function alreadyTakenBythisDevice(Request $request): bool
    {
        return !! $this->responses()->takenBy([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ])->recently(2)->exists();
    }
}
