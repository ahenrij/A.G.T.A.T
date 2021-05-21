<?php

namespace App\Repositories;

use App\Log;
use Illuminate\Support\Arr;

class LogRepository extends ResourceRepository
{
    public function __construct(Log $log)
    {
        $this->model = $log;
    }
}