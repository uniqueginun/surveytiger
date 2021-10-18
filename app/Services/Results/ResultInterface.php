<?php

namespace App\Services\Results;

use Illuminate\Database\Query\Builder;

interface ResultInterface
{
    public function getResult(Builder $builder): mixed;
}
