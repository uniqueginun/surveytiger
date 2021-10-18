<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public array $mapResult = [
        'Multichoice' => 'CountResult',
        'Singlechoice' => 'CountResult',
        'Dropdown' => 'CountResult',
        'Rating' => 'AvgResult',
        'Slider' => 'AvgResult',
        'Ranking' => 'RankingResult',
        'Textbox' => 'TextResult'
    ];

    protected $appends = ['component_name', 'has_options', 'has_answers', 'result_type'];

    public function getComponentNameAttribute()
    {

        if (in_array($this->name, ['Multichoice', 'Singlechoice', 'Dropdown', 'Ranking'])) {
            return 'Multichoice';
        }

        return $this->name;
    }

    public function getHasOptionsAttribute()
    {
        return $this->name !== 'Textbox';
    }

    public function getHasAnswersAttribute()
    {
        return !in_array($this->name, array('Textbox', 'Slider'));
    }

    public function getResultTypeAttribute()
    {
        return $this->mapResult[$this->name] ?? null;
    }
}
