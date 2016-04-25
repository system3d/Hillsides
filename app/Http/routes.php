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
Route::post('settings/setColor', array('middleware' => 'admin', 'as' => 'settings/setColor', 'uses' => 'SettingsController@setColor'));
Route::post('settings/storeColor', array('middleware' => 'admin', 'as' => 'settings/storeColor', 'uses' => 'SettingsController@storeColor'));

Route::get('projetos', array('middleware' => 'admin', 'as' => 'projetos', 'uses' => 'ProjetosController@index'));
Route::post('projetos/criar', array('middleware' => 'admin', 'as' => 'projetos/criar', 'uses' => 'ProjetosController@criar'));
Route::post('projetos/store', array('middleware' => 'admin', 'as' => 'projetos/store', 'uses' => 'ProjetosController@store'));
Route::post('projetos/getProjetos', array('middleware' => 'admin', 'as' => 'projetos/getProjetos', 'uses' => 'ProjetosController@getProjetos'));
Route::post('projetos/info', array('middleware' => 'admin', 'as' => 'projetos/info', 'uses' => 'ProjetosController@info'));
Route::post('projetos/toggleFavorite', array('middleware' => 'admin', 'as' => 'projetos/toggleFavorite', 'uses' => 'ProjetosController@toggleFavorite'));
Route::post('projetos/editar', array('middleware' => 'admin', 'as' => 'projetos/editar', 'uses' => 'ProjetosController@editar'));
Route::post('projetos/update', array('middleware' => 'admin', 'as' => 'projetos/update', 'uses' => 'ProjetosController@update'));
Route::post('projetos/excluir', array('middleware' => 'admin', 'as' => 'projetos/excluir', 'uses' => 'ProjetosController@excluir'));

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

Route::post('projetos/conf/estagios', array('middleware' => 'admin', 'as' => 'projetos/conf/estagios', 'uses' => 'SettingsController@proj_estagios'));
Route::post('projetos/conf/setOrder', array('middleware' => 'admin', 'as' => 'projetos/conf/setOrder', 'uses' => 'SettingsController@proj_setOrder'));
Route::post('projetos/conf/estagioEdit', array('middleware' => 'admin', 'as' => 'projetos/conf/estagioEdit', 'uses' => 'SettingsController@proj_estagioEdit'));
Route::post('projetos/conf/estagioNovo', array('middleware' => 'admin', 'as' => 'projetos/conf/estagioNovo', 'uses' => 'SettingsController@proj_estagioNovo'));
Route::post('projetos/conf/estagioExcluir', array('middleware' => 'admin', 'as' => 'projetos/conf/estagioExcluir', 'uses' => 'SettingsController@proj_estagioExcluir'));

Route::post('projetos/conf/stProjeto', array('middleware' => 'admin', 'as' => 'projetos/conf/stProjeto', 'uses' => 'SettingsController@proj_stProjeto'));
Route::post('projetos/conf/stEdit', array('middleware' => 'admin', 'as' => 'projetos/conf/stEdit', 'uses' => 'SettingsController@proj_stEdit'));
Route::post('projetos/conf/stNovo', array('middleware' => 'admin', 'as' => 'projetos/conf/stNovo', 'uses' => 'SettingsController@proj_stNovo'));
Route::post('projetos/conf/stExcluir', array('middleware' => 'admin', 'as' => 'projetos/conf/stExcluir', 'uses' => 'SettingsController@proj_stExcluir'));

Route::post('projetos/conf/srTarefa', array('middleware' => 'admin', 'as' => 'projetos/conf/srTarefa', 'uses' => 'SettingsController@proj_srTarefa'));
Route::post('projetos/conf/srEdit', array('middleware' => 'admin', 'as' => 'projetos/conf/srEdit', 'uses' => 'SettingsController@proj_srEdit'));
Route::post('projetos/conf/srNovo', array('middleware' => 'admin', 'as' => 'projetos/conf/srNovo', 'uses' => 'SettingsController@proj_srNovo'));
Route::post('projetos/conf/srExcluir', array('middleware' => 'admin', 'as' => 'projetos/conf/srExcluir', 'uses' => 'SettingsController@proj_srExcluir'));

Route::post('projetos/conf/tpTarefa', array('middleware' => 'admin', 'as' => 'projetos/conf/tpTarefa', 'uses' => 'SettingsController@proj_tpTarefa'));
Route::post('projetos/conf/setColor', array('middleware' => 'admin', 'as' => 'projetos/conf/setColor', 'uses' => 'SettingsController@proj_setColor'));
Route::post('projetos/conf/storeColor', array('middleware' => 'admin', 'as' => 'projetos/conf/storeColor', 'uses' => 'SettingsController@proj_storeColor'));
Route::post('projetos/conf/setIcon', array('middleware' => 'admin', 'as' => 'projetos/conf/setIcon', 'uses' => 'SettingsController@proj_setIcon'));
Route::post('projetos/conf/storeIcon', array('middleware' => 'admin', 'as' => 'projetos/conf/storeIcon', 'uses' => 'SettingsController@proj_storeIcon'));
Route::post('projetos/conf/ttCreate', array('middleware' => 'admin', 'as' => 'projetos/conf/ttCreate', 'uses' => 'SettingsController@proj_ttCreate'));
Route::post('projetos/conf/ttExcluir', array('middleware' => 'admin', 'as' => 'projetos/conf/ttExcluir', 'uses' => 'SettingsController@proj_ttExcluir'));
Route::post('projetos/conf/ttEdit', array('middleware' => 'admin', 'as' => 'projetos/conf/ttEdit', 'uses' => 'SettingsController@proj_ttEdit'));

Route::get('kanban/{id}', array('middleware' => 'admin', 'as' => 'kanban', 'uses' => 'KanbanController@index'));
Route::post('kanban/historia', array('middleware' => 'admin', 'as' => 'kanban/historia', 'uses' => 'KanbanController@historia'));
Route::post('kanban/criarHistoria', array('middleware' => 'admin', 'as' => 'kanban/criarHistoria', 'uses' => 'KanbanController@criarHistoria'));
Route::post('kanban/setHistory', array('middleware' => 'admin', 'as' => 'kanban/setHistory', 'uses' => 'KanbanController@setHistory'));

Route::post('tarefa', array('middleware' => 'admin', 'as' => 'tarefa', 'uses' => 'TarefasController@index'));
Route::post('tarefa/criar', array('middleware' => 'admin', 'as' => 'tarefa/criar', 'uses' => 'TarefasController@criar'));
Route::post('tarefa/store', array('middleware' => 'admin', 'as' => 'tarefa/store', 'uses' => 'TarefasController@store'));
Route::post('getTarefas', array('middleware' => 'admin', 'as' => 'getTarefas', 'uses' => 'TarefasController@getTarefas'));
Route::post('getTarefa', array('middleware' => 'admin', 'as' => 'getTarefa', 'uses' => 'TarefasController@getTarefaSingle'));
Route::post('tarefa/moved', array('middleware' => 'admin', 'as' => 'tarefa/moved', 'uses' => 'TarefasController@moved'));
Route::post('tarefa/editar', array('middleware' => 'admin', 'as' => 'tarefa/editar', 'uses' => 'TarefasController@editar'));
Route::post('tarefa/update', array('middleware' => 'admin', 'as' => 'tarefa/update', 'uses' => 'TarefasController@update'));
Route::post('tarefa/excluir', array('middleware' => 'admin', 'as' => 'tarefa/excluir', 'uses' => 'TarefasController@excluir'));
Route::post('tarefa/user', array('middleware' => 'admin', 'as' => 'tarefa/user', 'uses' => 'TarefasController@user'));
Route::post('tarefa/anexos', array('middleware' => 'admin', 'as' => 'tarefa/anexos', 'uses' => 'TarefasController@anexos'));
Route::post('tarefa/excluirAnexo', array('middleware' => 'admin', 'as' => 'tarefa/excluirAnexo', 'uses' => 'TarefasController@excluirAnexo'));
Route::get('tarefa/download/{id}', array('middleware' => 'admin', 'as' => 'tarefa/download', 'uses' => 'TarefasController@download'));
Route::post('tarefa/upload', array('middleware' => 'admin', 'as' => 'tarefa/upload', 'uses' => 'TarefasController@anexoUpload'));
Route::post('tarefa/storeAnexo', array('middleware' => 'admin', 'as' => 'tarefa/storeAnexo', 'uses' => 'TarefasController@storeAnexo'));

Route::get('teste', array('middleware' => 'admin', 'as' => 'teste', 'uses' => 'KanbanController@teste'));