<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('index');
});*/
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::auth();

Route::resource('user', 'UserController');
Route::resource('zone','ZoneController', ['except' => ['create']]);
Route::resource('typevehicule','TypeVehiculeController', ['except' => ['create']]);
Route::resource('structure','StructureController', ['except' => ['create']]);
Route::resource('typetitre','TypeTitreController', ['except' => ['create']]);
Route::resource('vehicule','VehiculeController', ['except' => ['create']]);
Route::resource('groupe','GroupeController', ['except' => ['create']]);
Route::resource('typeuser','TypeUserController', ['except' => ['create']]);
Route::resource('log','LogController', ['only' => ['index', 'show']]);
Route::resource('titre','TitreController', ['except' => ['edit', 'update']]);
Route::resource('demande','DemandeController');

/* Routes for AJAX */
Route::post('/saveTypeTitreByAjax','TypeTitreController@saveByAjax')->name('saveTypeTitreByAjax');
Route::get('/type_titre_infos/{id}','TypeTitreController@getByIdToAjax');
Route::post('/verifyTypeTitreExist','TypeTitreController@verifyTypeTitreExist')->name('verifyTypeTitreExist');
Route::get('/user_infos/{id}','UserController@getByIdToAjax');
Route::post('/checkPhoneNumberExist','UserController@checkPhoneNumberExist')->name('checkPhoneNumberExist');
Route::post('/saveBeneficiaireByAjax','UserController@saveBeneficiaireByAjax')->name('saveBeneficiaireByAjax');
Route::get('/vehicule_infos/{id}','VehiculeController@getByIdToAjax');
Route::post('/saveVehiculeByAjax','VehiculeController@saveByAjax')->name('saveVehiculeByAjax');
Route::post('/saveZoneByAjax','ZoneController@saveByAjax')->name('saveZoneByAjax');
Route::post('/saveStructureByAjax','StructureController@saveByAjax')->name('saveStructureByAjax');

/* Others routes*/
Route::get('/point/global','PointsController@index'); //ou réduit
Route::post('/point/global','PointsController@index');

Route::get('/point/detail','PointsController@detail');
Route::post('/point/detail','PointsController@detail');

Route::get('/point/groupe','PointsController@groupe');
Route::post('/point/groupe','PointsController@groupe');

Route::get('/point/user','PointsController@user');
Route::post('/point/user','PointsController@user');

Route::get('/point/journalier','PointsController@journalier')->name('point.journalier');

Route::get('/caisse','HomeController@caisse');
Route::get('/caisse/close','HomeController@close_caisse')->name('caisse.close');

Route::get('/configurations','HomeController@configurations');
Route::get('/about','HomeController@about')->name('about');

Route::get('/demandes', 'TitreController@demandes')->name('demandes');
Route::get('/titre/validate/{id}','TitreController@valider')->name('titre.validate');
