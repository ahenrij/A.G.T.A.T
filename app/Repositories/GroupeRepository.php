<?php

namespace App\Repositories;

use App\Groupe;
use Illuminate\Support\Arr;

class GroupeRepository extends ResourceRepository
{
    public function __construct(Groupe $groupe)
    {
        $this->model = $groupe;
    }
}