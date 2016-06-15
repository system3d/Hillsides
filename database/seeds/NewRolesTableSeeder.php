<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon as Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class NewRolesTableSeeder extends Seeder
{
    public function run()
    {
	    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

	    DB::table(config('access.roles_table'))->truncate();

        //Create admin role, id of 1
        $role_model        = config('access.role');
        $admin             = new $role_model;
        $admin->name       = 'Administrador';
        $admin->all        = true;
        $admin->sort       = 1;
        $admin->created_at = Carbon::now();
        $admin->updated_at = Carbon::now();
        $admin->save();

        $userPermissions = [


        ];

        $liderPermissions = [

            

        ];

        //id = 2
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Usuário';
        $user->sort       = 2;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();
        $user->permissions()->attach($userPermissions);

        //id = 2
        $role_model       = config('access.role');
        $lider             = new $role_model;
        $lider->name       = 'Líder';
        $lider->sort       = 3;
        $lider->created_at = Carbon::now();
        $lider->updated_at = Carbon::now();
        $lider->save();
        $lider->permissions()->attach($liderPermissions);

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
