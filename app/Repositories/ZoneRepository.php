<?php

namespace App\Repositories;

use App\Zone;

class ZoneRepository extends ResourceRepository
{
    public function __construct(Zone $zone)
    {
        $this->model = $zone;
    }
}
