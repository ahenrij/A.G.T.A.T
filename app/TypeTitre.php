<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeTitre extends Model
{
    //
    protected $table = 'type_titres';

    protected $fillable = [
        'libelle', 'duree', 'prix'
    ];

    public function titres()
    {
        return $this->hasMany('App\Titre');
    }
}
