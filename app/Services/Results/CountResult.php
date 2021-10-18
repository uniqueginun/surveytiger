<?php

namespace App\Services\Results;

use Illuminate\Database\Query\Builder;
use JetBrains\PhpStorm\NoReturn;

class CountResult implements ResultInterface
{
    #[NoReturn] public function getResult(Builder $builder): array
    {
        $responses = $builder
            ->join('offered_answers as f', 'f.id', '=', 'master.offered_answer_id')
            ->selectRaw('f.id, count(*) answer_count')
            ->groupBy('f.id')
            ->get()->flatten();

        return $responses->toArray();
    }
}
