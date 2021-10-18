<?php

namespace App\Services\Results;

use Illuminate\Database\Query\Builder;

class AvgResult implements ResultInterface
{

    public function getResult(Builder $builder): mixed
    {
        $responses = $builder->selectRaw('avg(master.offered_answer_id) avg_answer')->get();

        return !empty($responses) ? (int) $responses[0]->avg_answer : 0;
    }
}
