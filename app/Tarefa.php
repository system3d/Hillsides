<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Tarefa extends Model
{
     protected $table = 'tarefas';
    public $timestamps = true;
	protected $fillable = ['descricao', 'obs', 'peso', 'sprint_id', 'historia_id', 'assignee_id', 'tipo_id', 'estagio_id', 'status_id', 'projeto_id', 'disciplina_id', 'etapa_id', 'user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function user() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

	public function sprint() {
		return $this->belongsTo('App\Sprint');
	}

	public function historia() {
		return $this->belongsTo('App\Historia');
	}

	public function disciplina() {
		return $this->belongsTo('App\Disciplina');
	}

	public function etapa() {
		return $this->belongsTo('App\Etapa');
	}

	public function projeto() {
		return $this->belongsTo('App\Projeto');
	}

	public function assignee() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function tipo() {
		return $this->belongsTo('App\Tipo_Tarefa');
	}

	public function estagio() {
		return $this->belongsTo('App\Estagio', 'estagio_id');
	}

	public function status() {
		return $this->belongsTo('App\Status_Tarefa');
	}

	public function cronograma() {
		return $this->hasOne('App\Cronograma');
	}

	public function custo() {
		return $this->hasOne('App\Custo');
	}

	public function anexos() {
		return $this->hasMany('App\Anexo');
	}

	public function lideres() {
		if(!isset($this->assignee->id)){
			return null;
		}
		$peq = [];
		foreach($this->projeto->equipes as $e){
			array_push($peq, $e->id);
		}
		$lideres = [];
		foreach($this->assignee->equipes as $equipe){
			if(in_array($equipe->id, $peq)){
				if(!in_array($equipe->responsavel->id, $lideres)){
					array_push($lideres, $equipe->responsavel->id);
				}
			}
		}
		return $lideres;
	}

	public function membrosId(){
		if(!isset($this->assignee->id)){
			return null;
		}
		$members = [];
		foreach($this->assignee->equipes as $eq){
			foreach($eq->users as $e){
				if(!in_array($e->id, $members)){
					array_push($members, $e->id);
				}
			}
		}
		if(count($members) > 0)
			return $members;
		else
			return null;
	}
}
