<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $appends = ['component_name', 'has_options', 'has_answers'];

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
        return ! in_array($this->name, array('Textbox', 'Slider'));
    }

}
