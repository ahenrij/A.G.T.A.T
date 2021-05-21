<?php

namespace App\Repositories;

use App\Vehicule;

class VehiculeRepository extends ResourceRepository
{
    protected $vehicule;

    public function __construct(Vehicule $vehicule)
    {
        $this->model = $vehicule;
    }
}