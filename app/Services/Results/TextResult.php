<?php

namespace App\Services\Results;

use Illuminate\Database\Query\Builder;

class TextResult implements ResultInterface
{

    public function getResult(Builder $builder): mixed
    {
        return $builder->select('answer_text')->whereNotNull('answer_text')->get('answer_text');
    }
}
