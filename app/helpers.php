<?php
/**
 * Created by PhpStorm.
 * User: HenriJ
 * Date: 30/12/2017
 * Time: 16:58
 */
use \Illuminate\Support\Facades\DB;

define('USAGER_LABEL', 'Usager');
define('AGENT_LABEL', 'Agent');
define('CAISSIER_LABEL', 'Caissier');
define('DISTRIBUTEUR_LABEL', 'Distributeur');
define('ADMIN_LABEL', 'Administrateur');
define('CHAUFFEUR_LABEL', 'Chauffeur');
define('AUCUN_DISTRIBUTEUR', 'Aucun distributeur');
define('AUCUN_GROUPE', 'Aucun groupe');
define('LOG_INFORMATION', 'I');
define('LOG_MODIFICATION', 'M');
define('LOG_SUPPRESSION', 'S');
define('LOG_CAISSE_FERMEE', 'C');


function pieceJustificatifs(){
    return array('CNI' => 'Carte Nationale d\'Identité', 'PSP' => 'Passeport');
}

function profil_link($avatar){
//    return (is_file(profils_path().$avatar) ? profils_path().$avatar : profils_path().$avatar);
//TODO    return (is_file(profils_path().$avatar) ? profils_path().$avatar : image_path().'avatar_circle_grey.png');
    return (!empty($avatar) ? profils_path().$avatar : profils_path().'man-'.rand(1,10).'.png');
}

function image_path(){
    return URL::to('/').'/img/';
}

function profils_path(){
    return URL::to('/').'/img/profils/';
}

function getLabelTypeUser($id){
    return DB::table('type_users')
        ->join('users', 'type_users.id', '=', 'users.type_user_id')
        ->where('users.id', $id)
        ->value('libelle');
}

function getIdTypeUser($libelle){
    return DB::table('type_users')
        ->where('libelle', $libelle)
        ->value('id');
}

function getNoGroupId(){
    return DB::table('groupes')
        ->where('libelle', AUCUN_GROUPE)
        ->value('id');
}

function getNoAgentId(){
    return DB::table('users')
        ->where('nom', AUCUN_DISTRIBUTEUR)
        ->value('id');
}

function getDemandNbr(){
    return DB::table('titres')
        ->where(['etat' => 'N', 'demande' => 1])
        ->count();
}

function caisseIsClosed(){
    return DB::table('logs')
        ->whereRaw("DATE(date_log)='".date('Y-m-d')."' AND type_log='".LOG_CAISSE_FERMEE."'")
        ->count() == 1;
}

function save_trace($message, $type){
    DB::table('logs')->insert([
        'date_log' => date('Y-m-d H:i:s'),
        'message' => $message,
        'type_log' => $type,
        'user_id' => Auth::user()->id,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
}

function getLastDemandes($limit){
    return DB::table('titres')
        ->join('users', 'titres.usager_id', '=', 'users.id')
        ->select('users.nom', 'users.prenom', 'titres.created_at', 'titres.id')
        ->where(['demande' => 1, 'etat' => 'N'])
        ->oldest()
        ->limit($limit)
        ->get();
}