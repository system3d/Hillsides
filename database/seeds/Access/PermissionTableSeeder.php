<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionTableSeeder
 */
class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::table(config('access.permissions_table'))->truncate();
            DB::table(config('access.permission_role_table'))->truncate();
            DB::table(config('access.permission_user_table'))->truncate();
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.permissions_table'));
            DB::statement('DELETE FROM ' . config('access.permission_role_table'));
            DB::statement('DELETE FROM ' . config('access.permission_user_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.permissions_table') . ' CASCADE');
            DB::statement('TRUNCATE TABLE ' . config('access.permission_role_table') . ' CASCADE');
            DB::statement('TRUNCATE TABLE ' . config('access.permission_user_table') . ' CASCADE');
        }

        /**
         * Don't need to assign any permissions to administrator because the all flag is set to true
         * in RoleTableSeeder.php
         */

        /**
         * Projetos
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'criar-projetos';
        $new_permission->display_name = 'Criar Projetos';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 1;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-projetos';
        $new_permission->display_name = 'Ver Projetos';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 2;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'editar-projetos';
        $new_permission->display_name = 'Editar Projetos';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 3;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'deletar-projetos';
        $new_permission->display_name = 'Deletar Projetos';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 4;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        /**
         * User
         */
        $permission_model          = config('access.permission');
        $createUsers               = new $permission_model;
        $createUsers->name         = 'create-users';
        $createUsers->display_name = 'Criar Usuários';
        $createUsers->system       = true;
        $createUsers->group_id     = 1;
        $createUsers->sort         = 5;
        $createUsers->created_at   = Carbon::now();
        $createUsers->updated_at   = Carbon::now();
        $createUsers->save();

        $permission_model        = config('access.permission');
        $editUsers               = new $permission_model;
        $editUsers->name         = 'edit-users';
        $editUsers->display_name = 'Editar Usuários';
        $editUsers->system       = true;
        $editUsers->group_id     = 1;
        $editUsers->sort         = 6;
        $editUsers->created_at   = Carbon::now();
        $editUsers->updated_at   = Carbon::now();
        $editUsers->save();

        $permission_model          = config('access.permission');
        $deleteUsers               = new $permission_model;
        $deleteUsers->name         = 'delete-users';
        $deleteUsers->display_name = 'Deletar Usuários';
        $deleteUsers->system       = true;
        $deleteUsers->group_id     = 1;
        $deleteUsers->sort         = 7;
        $deleteUsers->created_at   = Carbon::now();
        $deleteUsers->updated_at   = Carbon::now();
        $deleteUsers->save();

        $permission_model                 = config('access.permission');
        $changeUserPassword               = new $permission_model;
        $changeUserPassword->name         = 'change-user-password';
        $changeUserPassword->display_name = 'Mudar Senha de Usuários';
        $changeUserPassword->system       = true;
        $changeUserPassword->group_id     = 1;
        $changeUserPassword->sort         = 8;
        $changeUserPassword->created_at   = Carbon::now();
        $changeUserPassword->updated_at   = Carbon::now();
        $changeUserPassword->save();

        $permission_model             = config('access.permission');
        $deactivateUser               = new $permission_model;
        $deactivateUser->name         = 'deactivate-users';
        $deactivateUser->display_name = 'Desativar Usuários';
        $deactivateUser->system       = true;
        $deactivateUser->group_id     = 1;
        $deactivateUser->sort         = 9;
        $deactivateUser->created_at   = Carbon::now();
        $deactivateUser->updated_at   = Carbon::now();
        $deactivateUser->save();

        $permission_model             = config('access.permission');
        $reactivateUser               = new $permission_model;
        $reactivateUser->name         = 'reactivate-users';
        $reactivateUser->display_name = 'Reativar Usuários';
        $reactivateUser->system       = true;
        $reactivateUser->group_id     = 1;
        $reactivateUser->sort         = 11;
        $reactivateUser->created_at   = Carbon::now();
        $reactivateUser->updated_at   = Carbon::now();
        $reactivateUser->save();

        $permission_model           = config('access.permission');
        $undeleteUser               = new $permission_model;
        $undeleteUser->name         = 'undelete-users';
        $undeleteUser->display_name = 'Restaurar Usuários';
        $undeleteUser->system       = true;
        $undeleteUser->group_id     = 1;
        $undeleteUser->sort         = 13;
        $undeleteUser->created_at   = Carbon::now();
        $undeleteUser->updated_at   = Carbon::now();
        $undeleteUser->save();

        $permission_model                    = config('access.permission');
        $permanentlyDeleteUser               = new $permission_model;
        $permanentlyDeleteUser->name         = 'permanently-delete-users';
        $permanentlyDeleteUser->display_name = 'Deletar Usuários Permanentemente';
        $permanentlyDeleteUser->system       = true;
        $permanentlyDeleteUser->group_id     = 1;
        $permanentlyDeleteUser->sort         = 14;
        $permanentlyDeleteUser->created_at   = Carbon::now();
        $permanentlyDeleteUser->updated_at   = Carbon::now();
        $permanentlyDeleteUser->save();

        $permission_model                      = config('access.permission');
        $resendConfirmationEmail               = new $permission_model;
        $resendConfirmationEmail->name         = 'resend-user-confirmation-email';
        $resendConfirmationEmail->display_name = 'Re-Enviar E-mail de Confirmação';
        $resendConfirmationEmail->system       = true;
        $resendConfirmationEmail->group_id     = 1;
        $resendConfirmationEmail->sort         = 15;
        $resendConfirmationEmail->created_at   = Carbon::now();
        $resendConfirmationEmail->updated_at   = Carbon::now();
        $resendConfirmationEmail->save();

        /**
         * Sprints
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'criar-sprints';
        $new_permission->display_name = 'Criar Sprints';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 16;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-sprints';
        $new_permission->display_name = 'Ver Sprints';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 17;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'editar-sprints';
        $new_permission->display_name = 'Editar Sprints';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 18;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'deletar-sprints';
        $new_permission->display_name = 'Deletar Sprints';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 19;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        /**
         * Etapas
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'criar-etapas';
        $new_permission->display_name = 'Criar Etapas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 20;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-etapas';
        $new_permission->display_name = 'Ver Etapas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 21;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'editar-etapas';
        $new_permission->display_name = 'Editar Etapas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 22;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'deletar-etapas';
        $new_permission->display_name = 'Deletar Etapas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 23;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        /**
         * Disciplinas
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'criar-disciplinas';
        $new_permission->display_name = 'Criar Disciplinas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 24;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-disciplinas';
        $new_permission->display_name = 'Ver Disciplinas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 25;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'editar-disciplinas';
        $new_permission->display_name = 'Editar Disciplinas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 26;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'deletar-disciplinas';
        $new_permission->display_name = 'Deletar Disciplinas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 27;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        /**
         * Clientes
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'criar-clientes';
        $new_permission->display_name = 'Criar Clientes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 28;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-clientes';
        $new_permission->display_name = 'Ver Clientes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 29;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'editar-clientes';
        $new_permission->display_name = 'Editar Clientes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 30;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'deletar-clientes';
        $new_permission->display_name = 'Deletar Clientes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 31;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        /**
         * Equipes
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'criar-equipes';
        $new_permission->display_name = 'Criar Equipes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 32;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-equipes';
        $new_permission->display_name = 'Ver Equipes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 33;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'editar-equipes';
        $new_permission->display_name = 'Editar Equipes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 34;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'deletar-equipes';
        $new_permission->display_name = 'Deletar Equipes';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 35;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        /**
         * Tarefas
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'criar-tarefas';
        $new_permission->display_name = 'Criar Tarefas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 36;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-tarefas';
        $new_permission->display_name = 'Ver Tarefas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 37;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'editar-tarefas';
        $new_permission->display_name = 'Editar Tarefas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 38;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'deletar-tarefas';
        $new_permission->display_name = 'Deletar Tarefas';
        $new_permission->system       = true;
        $new_permission->group_id     = 1;
        $new_permission->sort         = 39;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        /**
         * App
         */
        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'ver-relatorios';
        $new_permission->display_name = 'Ver Relatorios';
        $new_permission->system       = true;
        $new_permission->group_id     = 2;
        $new_permission->sort         = 40;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'tarefa-propia';
        $new_permission->display_name = 'Avançar Tarefas';
        $new_permission->system       = true;
        $new_permission->group_id     = 2;
        $new_permission->sort         = 41;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'tarefa-equipe';
        $new_permission->display_name = 'Avançar Tarefas da Equipe';
        $new_permission->system       = true;
        $new_permission->group_id     = 2;
        $new_permission->sort         = 42;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'tarefa-geral';
        $new_permission->display_name = 'Avançar Qualquer Tarefa';
        $new_permission->system       = true;
        $new_permission->group_id     = 2;
        $new_permission->sort         = 43;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        $permission_model          = config('access.permission');
        $new_permission               = new $permission_model;
        $new_permission->name         = 'config-geral';
        $new_permission->display_name = 'Setar Configurações Gerais';
        $new_permission->system       = true;
        $new_permission->group_id     = 2;
        $new_permission->sort         = 44;
        $new_permission->created_at   = Carbon::now();
        $new_permission->updated_at   = Carbon::now();
        $new_permission->save();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}