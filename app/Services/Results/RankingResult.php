<?php

namespace App\Services\Results;

use Illuminate\Database\Query\Builder;

class RankingResult implements ResultInterface
{

    public function getResult(Builder $builder): mixed
    {
        return $builder
            ->join('offered_answers as f', 'f.id', '=', 'master.offered_answer_id')
            ->selectRaw('f.answer_text, sum(master.order) answer_count')
            ->groupBy('f.answer_text')
            ->orderByRaw('answer_count desc')
            ->get()->flatten();
    }
}
