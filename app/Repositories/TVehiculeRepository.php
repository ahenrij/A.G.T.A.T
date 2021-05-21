<?php

namespace App\Repositories;

use App\TypeVehicule;

class TVehiculeRepository extends ResourceRepository
{
    public function __construct(TypeVehicule $typevehicule)
    {
        $this->model = $typevehicule;
    }
}