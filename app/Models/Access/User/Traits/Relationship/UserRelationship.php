<?php

namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Access\User\SocialLogin;

/**
 * Class UserRelationship
 * @package App\Models\Access\User\Traits\Relationship
 */
trait UserRelationship
{

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.assigned_roles_table'), 'user_id', 'role_id');
    }

    /**
     * Many-to-Many relations with Permission.
     * ONLY GETS PERMISSIONS ARE NOT ASSOCIATED WITH A ROLE
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('access.permission'), config('access.permission_user_table'), 'user_id', 'permission_id');
    }

    public function locatario() {
        return $this->belongsTo('App\Locatario');
    }

    public function clientes() {
        return $this->hasMany('App\Cliente');
    }

    public function projetos() {
        return $this->hasMany('App\Projetos');
    }

    public function equipes() {
        return $this->belongsToMany('App\Equipe', 'user_equipe');
    }

    public function equipes() {
        return $this->hasMany('App\Equipe');
    }

    public function sprints() {
        return $this->hasMany('App\Sprint');
    }

    public function etapas() {
        return $this->hasMany('App\Etapa');
    }

    public function disciplinas() {
        return $this->hasMany('App\Disciplina');
    }

    public function tarefas() {
        return $this->hasMany('App\Tarefa');
    }

    public function historias() {
        return $this->hasMany('App\Historia');
    }

    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialLogin::class);
    }
}