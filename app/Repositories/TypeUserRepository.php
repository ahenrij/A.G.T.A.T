<?php

namespace App\Repositories;

use App\TypeUser;
use Illuminate\Support\Arr;

class TypeUserRepository extends ResourceRepository
{
    public function __construct(TypeUser $typeUser)
    {
        $this->model = $typeUser;
    }
}