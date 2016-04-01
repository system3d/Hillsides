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
Route::post('equipes/infoSmall', array('middleware' => 'admin', 'as' => 'equipes/infoSmall', 'uses' => 'EquipesController@infoSmall'));
Route::post('equipes/criar', array('middleware' => 'admin', 'as' => 'equipes/criar', 'uses' => 'EquipesController@criar'));
Route::post('equipes/editar', array('middleware' => 'admin', 'as' => 'equipes/editar', 'uses' => 'EquipesController@editar'));
Route::post('equipes/update', array('middleware' => 'admin', 'as' => 'equipes/update', 'uses' => 'EquipesController@update'));
Route::post('equipes/delete', array('middleware' => 'admin', 'as' => 'equipes/delete', 'uses' => 'EquipesController@delete'));
Route::post('equipes/novoMembro', array('middleware' => 'admin', 'as' => 'equipes/novoMembro', 'uses' => 'EquipesController@novoMembro'));
Route::post('equipes/removerMembro', array('middleware' => 'admin', 'as' => 'equipes/removerMembro', 'uses' => 'EquipesController@removerMembro'));

Route::post('settings/gravarEstagio', array('middleware' => 'admin', 'as' => 'settings/gravarEstagio', 'uses' => 'SettingsController@gravarEstagio'));
Route::post('settings/deleteEstagio', array('middleware' => 'admin', 'as' => 'settings/deleteEstagio', 'uses' => 'SettingsController@deleteEstagio'));
Route::post('settings/setOrder', array('middleware' => 'admin', 'as' => 'settings/setOrder', 'uses' => 'SettingsController@setOrder'));

Route::post('settings/gravarStp', array('middleware' => 'admin', 'as' => 'settings/gravarStp', 'uses' => 'SettingsController@gravarStp'));
Route::post('settings/deleteStp', array('middleware' => 'admin', 'as' => 'settings/deleteStp', 'uses' => 'SettingsController@deleteStp'));

Route::post('settings/gravarSfp', array('middleware' => 'admin', 'as' => 'settings/gravarSfp', 'uses' => 'SettingsController@gravarSfp'));
Route::post('settings/deleteSfp', array('middleware' => 'admin', 'as' => 'settings/deleteSfp', 'uses' => 'SettingsController@deleteSfp'));

Route::post('settings/gravarTrp', array('middleware' => 'admin', 'as' => 'settings/gravarTrp', 'uses' => 'SettingsController@gravarTrp'));
Route::post('settings/deleteTrp', array('middleware' => 'admin', 'as' => 'settings/deleteTrp', 'uses' => 'SettingsController@deleteTrp'));
Route::post('settings/setIcon', array('middleware' => 'admin', 'as' => 'settings/setIcon', 'uses' => 'SettingsController@setIcon'));
Route::post('settings/storeIcon', array('middleware' => 'admin', 'as' => 'settings/storeIcon', 'uses' => 'SettingsController@storeIcon'));

Route::get('projetos', array('middleware' => 'admin', 'as' => 'projetos', 'uses' => 'ProjetosController@index'));
Route::post('projetos/criar', array('middleware' => 'admin', 'as' => 'projetos/criar', 'uses' => 'ProjetosController@criar'));
Route::post('projetos/store', array('middleware' => 'admin', 'as' => 'projetos/store', 'uses' => 'ProjetosController@store'));
Route::post('projetos/getProjetos', array('middleware' => 'admin', 'as' => 'projetos/getProjetos', 'uses' => 'ProjetosController@getProjetos'));
Route::post('projetos/info', array('middleware' => 'admin', 'as' => 'projetos/info', 'uses' => 'ProjetosController@info'));
Route::post('projetos/toggleFavorite', array('middleware' => 'admin', 'as' => 'projetos/toggleFavorite', 'uses' => 'ProjetosController@toggleFavorite'));
Route::post('projetos/editar', array('middleware' => 'admin', 'as' => 'projetos/editar', 'uses' => 'ProjetosController@editar'));
Route::post('projetos/update', array('middleware' => 'admin', 'as' => 'projetos/update', 'uses' => 'ProjetosController@update'));

Route::post('projetos/equipes', array('middleware' => 'admin', 'as' => 'projetos/equipes', 'uses' => 'ProjetosController@equipes'));
Route::post('projetos/novaEquipe', array('middleware' => 'admin', 'as' => 'projetos/novaEquipe', 'uses' => 'ProjetosController@novaEquipe'));
Route::post('projetos/removerEquipe', array('middleware' => 'admin', 'as' => 'projetos/removerEquipe', 'uses' => 'ProjetosController@removerEquipe'));

Route::post('projetos/sprints', array('middleware' => 'admin', 'as' => 'projetos/sprints', 'uses' => 'ProjetosController@sprints'));
Route::post('projetos/criarSprint', array('middleware' => 'admin', 'as' => 'projetos/criarSprint', 'uses' => 'ProjetosController@criarSprint'));
Route::post('projetos/editarSprint', array('middleware' => 'admin', 'as' => 'projetos/editarSprint', 'uses' => 'ProjetosController@editarSprint'));
Route::post('projetos/updateSprint', array('middleware' => 'admin', 'as' => 'projetos/updateSprint', 'uses' => 'ProjetosController@updateSprint'));
Route::post('projetos/excluirSprint', array('middleware' => 'admin', 'as' => 'projetos/excluirSprint', 'uses' => 'ProjetosController@excluirSprint'));

Route::post('projetos/historias', array('middleware' => 'admin', 'as' => 'projetos/historias', 'uses' => 'ProjetosController@historias'));
Route::post('projetos/criarHistoria', array('middleware' => 'admin', 'as' => 'projetos/criarHistoria', 'uses' => 'ProjetosController@criarHistoria'));
Route::post('projetos/editarHistoria', array('middleware' => 'admin', 'as' => 'projetos/editarHistoria', 'uses' => 'ProjetosController@editarHistoria'));
Route::post('projetos/updateHistoria', array('middleware' => 'admin', 'as' => 'projetos/updateHistoria', 'uses' => 'ProjetosController@updateHistoria'));
Route::post('projetos/excluirHistoria', array('middleware' => 'admin', 'as' => 'projetos/excluirHistoria', 'uses' => 'ProjetosController@excluirHistoria'));

Route::post('projetos/disciplinas', array('middleware' => 'admin', 'as' => 'projetos/disciplinas', 'uses' => 'ProjetosController@disciplinas'));
Route::post('projetos/criarDisciplinas', array('middleware' => 'admin', 'as' => 'projetos/criarDisciplinas', 'uses' => 'ProjetosController@criarDisciplinas'));
Route::post('projetos/editarDisciplinas', array('middleware' => 'admin', 'as' => 'projetos/editarDisciplinas', 'uses' => 'ProjetosController@editarDisciplinas'));
Route::post('projetos/updateDisciplinas', array('middleware' => 'admin', 'as' => 'projetos/updateDisciplinas', 'uses' => 'ProjetosController@updateDisciplinas'));
Route::post('projetos/excluirDisciplinas', array('middleware' => 'admin', 'as' => 'projetos/excluirDisciplinas', 'uses' => 'ProjetosController@excluirDisciplinas'));

Route::post('projetos/etapas', array('middleware' => 'admin', 'as' => 'projetos/etapas', 'uses' => 'ProjetosController@etapas'));
Route::post('projetos/criarEtapas', array('middleware' => 'admin', 'as' => 'projetos/criarEtapas', 'uses' => 'ProjetosController@criarEtapas'));
Route::post('projetos/editarEtapas', array('middleware' => 'admin', 'as' => 'projetos/editarEtapas', 'uses' => 'ProjetosController@editarEtapas'));
Route::post('projetos/updateEtapas', array('middleware' => 'admin', 'as' => 'projetos/updateEtapas', 'uses' => 'ProjetosController@updateEtapas'));
Route::post('projetos/excluirEtapas', array('middleware' => 'admin', 'as' => 'projetos/excluirEtapas', 'uses' => 'ProjetosController@excluirEtapas'));
