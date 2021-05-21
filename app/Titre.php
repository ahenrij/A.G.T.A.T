<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Titre extends Model
{
    protected $fillable = [
        'numero','duree','date_delivrance','demande','etat','zone_id','agent_id','usager_id','type_titre_id'
    ];
    public function zone(){
        return $this->belongsTo('App\Zone');
    }
    public function typeTitre(){
        return $this->belongsTo('App\TypeTitre');
    }
    public function agent(){
        return $this->belongsTo('App\User');
    }
    public function usager(){
        return $this->belongsTo('App\User');
    }

    public function estMacaron(){



        return false;
    }

}
