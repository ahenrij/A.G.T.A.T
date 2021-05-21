<?php

namespace App\Repositories;

use App\TypeTitre;

class TypeTitreRepository extends ResourceRepository
{
    protected $typeTitre;
    public function __construct(TypeTitre $typeTitre)
    {
        $this->model = $typeTitre;
    }
}