<?php

namespace App\Repositories;

use App\Structure;

class StructureRepository extends ResourceRepository
{
    protected $structure;

    public function __construct(Structure $structure)
    {
        $this->model = $structure;
    }
}