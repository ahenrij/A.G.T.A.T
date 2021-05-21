<?php
/**
 * Created by PhpStorm.
 * User: HenriJ
 * Date: 10/01/2018
 * Time: 13:05
 */

namespace App\Repositories;


use App\Titre;

class TitreRepository extends ResourceRepository
{
    protected $titre;

    public function __construct(Titre $titre)
    {
        $this->model = $titre;
    }
}