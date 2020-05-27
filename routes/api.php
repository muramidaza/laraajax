<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => '/v1', 
   'namespace' => 'Api\V1', 
   'as' => 'api.'], function () {
        Route::resource('companies', 'CompaniesController');
			
        Route::resource('departments', 'DepartmentsController');

        Route::resource('persons', 'PersonsController');
		
		Route::resource('equipments', 'EquipmentsController');
		
		Route::resource('users', 'UsersController');
		
		Route::get('search/departments/{id}', 'DepartmentsController@searchdepartments');
		Route::get('search/companies', 'CompaniesController@searchcompanies');
		Route::get('search/persons', 'PersonsController@searchpersons');
		Route::get('search/extenddepartments/{id}', 'DepartmentsController@extendsearchdepartments');
		
		Route::get('equipments/indexpage/{count}/{id}', 'EquipmentsController@indexpage');
    });
