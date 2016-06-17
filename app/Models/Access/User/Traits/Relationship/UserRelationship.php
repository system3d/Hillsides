<?php

namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Access\User\SocialLogin;
use App\Projeto as proj;
use Cache;

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

    public function creator() {
        return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    }

    public function clientes() {
        return $this->hasMany('App\Cliente');
    }

    public function messages() {
        return $this->hasMany('App\Mensagem');
    }

     public function settings() {
        return $this->hasMany('App\Setting');
    }

    public function projetos() {
        return $this->hasMany('App\Projetos');
    }

    public function equipes() {
        return $this->belongsToMany('App\Equipe', 'user_equipe');
    }

    public function equipes_creator() {
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

    public function tarefasAssigned() {
        return $this->hasMany('App\Tarefa','assignee_id');
    }

    public function historias() {
        return $this->hasMany('App\Historia');
    }

     public function lastActivity() {
        return $this->hasOne('App\Online');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function equipesIds(){
        $eqs = [];
        foreach($this->equipes as $e){
            array_push($eqs, $e->id);
        }
        return $eqs;
    }

    public function equipesLider(){
        $eqs = [];
        foreach($this->equipes as $e){
            if($e->responsavel_id == $this->id)
                array_push($eqs, $e);
        }
        return collect($eqs);
    }

    public function handleLider(){
        $lider = false;
        $this->detachRole(3);
        foreach($this->equipes as $e){
            if($e->responsavel_id == $this->id)
                $lider = true;
        }
        if($lider === true){
            $this->attachRole(3);
        }
    }

    public function equipesResponsible(){
        $equipos = [];
        foreach($this->equipes as $e){
            if($e->responsavel_id === $this->id){
                array_push($equipos, $e);
            }
        }
        return collect($equipos);
    }

    public function responsible(){
        $assignees = [];
        $assigneesID = [];
        foreach($this->equipesResponsible() as $e){
            foreach($e->users as $m){
                if(!in_array($m->id, $assigneesID)){
                    array_push($assignees, $m);
                    array_push($assigneesID, $m->id);
                }
            }
        }
        return collect($assignees);
    }

    public function comradesId(){
        $comrades = [];
        foreach($this->equipes as $e){
            foreach($e->users as $m){
                if(!in_array($m->id, $comrades)){
                    array_push($comrades, $m->id);
                }
            }
        }
        return $comrades;
    }

    public function sprintsProjeto($pid){
        $projeto = proj::find($pid);
        $haveIt = [];
        $sprits = [];
        $comradesId = $this->comradesId();
        foreach($projeto->sprints as $sprint){
           foreach($sprint->tarefas as $tarefa){
              if(in_array($tarefa->assignee_id,$comradesId) && !in_array($sprint->id,$haveIt)){
                array_push($haveIt, $sprint->id);
                array_push($sprits, $sprint);
              }
           }
        }
        return collect($sprits);
    }

    public function historiasProjeto($pid){
        $projeto = proj::find($pid);
        $haveIt = [];
        $storys = [];
        $comradesId = $this->comradesId();
        foreach($projeto->historias() as $historias){
           foreach($historias->tarefas as $tarefa){
              if(in_array($tarefa->assignee_id,$comradesId) && !in_array($historias->id,$haveIt)){
                array_push($haveIt, $historias->id);
                array_push($storys, $historias);
              }
           }
        }
        return collect($storys);
    }

    public function etapasProjeto($pid){
        $projeto = proj::find($pid);
        $haveIt = [];
        $etaps = [];
        $comradesId = $this->comradesId();
        foreach($projeto->etapas as $etapas){
           foreach($etapas->tarefas as $tarefa){
              if(in_array($tarefa->assignee_id,$comradesId) && !in_array($etapas->id,$haveIt)){
                array_push($haveIt, $etapas->id);
                array_push($etaps, $etapas);
              }
           }
        }
        return collect($etaps);
    }

    public function discProjeto($pid){
        $projeto = proj::find($pid);
        $haveIt = [];
        $discs = [];
        $comradesId = $this->comradesId();
        foreach($projeto->disciplinas as $disc){
           foreach($disc->tarefas as $tarefa){
              if(in_array($tarefa->assignee_id,$comradesId) && !in_array($disc->id,$haveIt)){
                array_push($haveIt, $etapas->id);
                array_push($discs, $disc);
              }
           }
        }
        return collect($discs);
    }

    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialLogin::class);
    }
}