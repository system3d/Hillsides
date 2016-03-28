<?php

Route::group(['middleware' => 'web'], function() {
    /**
     * Switch between the included languages
     */
    Route::group(['namespace' => 'Language'], function () {
        require (__DIR__ . '/Routes/Language/Language.php');
    });

    /**
     * Frontend Routes
     * Namespaces indicate folder structure
     */
    Route::group(['namespace' => 'Frontend'], function () {
        require (__DIR__ . '/Routes/Frontend/Frontend.php');
        require (__DIR__ . '/Routes/Frontend/Access.php');
    });
});

/**
 * Backend Routes
 * Namespaces indicate folder structure
 * Admin middleware groups web, auth, and routeNeedsPermission
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    /**
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    require (__DIR__ . '/Routes/Backend/Dashboard.php');
    require (__DIR__ . '/Routes/Backend/Access.php');
    require (__DIR__ . '/Routes/Backend/LogViewer.php');
});
Route::get('cadastro/getClientes', array('middleware' => 'admin', 'as' => 'cadastro/getClientes', 'uses' => 'ClienteController@getClientes'));
Route::get('teste', array('middleware' => 'web', 'as' => 'teste', 'uses' => 'Frontend\FrontendController@teste'));
Route::post('cadastro/projeto', array('middleware' => 'admin', 'as' => 'cadastro/projeto', 'uses' => 'ClienteController@projeto'));
Route::post('cadastro/cliente', array('middleware' => 'admin', 'as' => 'cadastro/cliente', 'uses' => 'ClienteController@cliente'));
Route::post('cadastro/store', array('middleware' => 'admin', 'as' => 'cadastro/store', 'uses' => 'ClienteController@store'));
Route::get('clientes', array('middleware' => 'admin', 'as' => 'clientes', 'uses' => 'ClienteController@clientesIndex'));
Route::post('cadastro/clienteinfo', array('middleware' => 'admin', 'as' => 'cadastro/clienteinfo', 'uses' => 'ClienteController@clienteinfo'));
Route::post('cadastro/clienteEdit', array('middleware' => 'admin', 'as' => 'cadastro/clienteEdit', 'uses' => 'ClienteController@clienteEdit'));
Route::post('cadastro/clienteUpdate', array('middleware' => 'admin', 'as' => 'cadastro/clienteUpdate', 'uses' => 'ClienteController@clienteUpdate'));
Route::post('cadastro/clienteDelete', array('middleware' => 'admin', 'as' => 'cadastro/clienteDelete', 'uses' => 'ClienteController@clienteDelete'));

Route::get('equipes', array('middleware' => 'admin', 'as' => 'equipes', 'uses' => 'EquipesController@index'));
Route::get('equipes/getEquipes', array('middleware' => 'admin', 'as' => 'equipes/getEquipes', 'uses' => 'EquipesController@getEquipes'));
Route::post('equipes/info', array('middleware' => 'admin', 'as' => 'cadastro/equipes/info', 'uses' => 'EquipesController@info'));

