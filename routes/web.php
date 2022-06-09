<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('wasd', function(){
//     $arr= [
//         0 => 'test',
//         1 => 'test1',
//         'wow' => 'wow',
//         'array' => [
//             'nice' => 'wew',
//             'pew' => 'pew',
//         ],
//         'lol' => 'he'
//     ];


    // foreach($arr as $ar){
    //     echo $ar;
    // }

    // for ($i= 0; $i < count($arr); $i++) {
    //     if(){

    //     }
    //     else{

    //     }
    //     for ($j= 0; $j < ; $j++) {

    //     }
    //     echo $ar;
    // }

// });

Route::get('/home', 'HomeController@index')->name('home');

##User
## View
Route::get('/subjects', 'SubjectsController@index')->name('subjects');

##datatables
Route::post('allusers', 'SubjectsController@allusers')->name('allusers');

## Create
Route::get('/subjects/create', 'SubjectsController@create')->name('subjects.create');
Route::post('/subjects/store', 'SubjectsController@store')->name('subjects.store');

## Update
Route::get('/subjects/edit/{id}', 'SubjectsController@edit')->name('subjects.edit');
Route::post('/subjects/update/{id}', 'SubjectsController@update')->name('subjects.update');

## Delete
Route::get('/subjects/delete/{id}', 'SubjectsController@destroy')->name('subjects.delete');


##Role
## View
Route::get('/role', 'RoleController@index')->name('role');

##datatables
Route::post('allroles', 'RoleController@allroles')->name('allroles');

## Create
Route::get('/role/create', 'RoleController@create')->name('role.create');
Route::post('/role/store', 'RoleController@store')->name('role.store');

## Update
Route::get('/role/store/{id}', 'RoleController@edit')->name('role.edit');
Route::post('/role/update/{id}', 'RoleController@update')->name('role.update');

## Delete
Route::get('/role/delete/{id}', 'RoleController@destroy')->name('role.delete');


##Species
## View
Route::get('/species', 'SpeciesController@index')->name('species');

##datatables
Route::post('allspecies', 'SpeciesController@allspecies')->name('allspecies');

## Create
Route::get('/species/create', 'SpeciesController@create')->name('species.create');
Route::post('/species/store', 'SpeciesController@store')->name('species.store');

## Update
Route::get('/species/store/{id}', 'SpeciesController@edit')->name('species.edit');
Route::post('/species/update/{id}', 'SpeciesController@update')->name('species.update');

## Delete
Route::get('/species/delete/{id}', 'SpeciesController@destroy')->name('species.delete');


##PetName
## View
Route::get('/petnames', 'PetnamesController@index')->name('petnames');

##datatables
Route::post('allpetnames', 'PetnamesController@allpetnames')->name('allpetnames');

## Create
Route::get('/petnames/create', 'PetnamesController@create')->name('petnames.create');
Route::post('/petnames/store', 'PetnamesController@store')->name('petnames.store');

## Update
Route::get('/petnames/store/{id}', 'PetnamesController@edit')->name('petnames.edit');
Route::post('/petnames/update/{id}', 'PetnamesController@update')->name('petnames.update');

## Delete
Route::get('/petnames/delete/{id}', 'PetnamesController@destroy')->name('petnames.delete');


##Pets
## View
Route::get('/pets', 'PetsController@index')->name('pets');

##datatables
Route::post('allpets', 'PetsController@allpets')->name('allpets');

## Create
Route::get('/pets/create', 'PetsController@create')->name('pets.create');
Route::post('/pets/store', 'PetsController@store')->name('pets.store');

## Update
Route::get('/pets/store/{id}', 'PetsController@edit')->name('pets.edit');
Route::post('/pets/update/{id}', 'PetsController@update')->name('pets.update');

## Delete
Route::get('/pets/delete/{id}', 'PetsController@destroy')->name('pets.delete');

//Route::get('/html')->name('html');

Route::get('/web', function () {
    return view('web');
});

Route::get('/javascript', function () {
    return view('javascript');
});

// Route::get('/API', function () {
//     return view('API');
// });

##API
Route::get('/API','APIController@runAPI');
