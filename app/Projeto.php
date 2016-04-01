<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;
use App\Tarefa;
use App\Historia;

class Projeto extends Model
{
    protected $table = 'projetos';
    public $timestamps = true;
	protected $fillable = ['descricao', 'obs', 'favorito', 'cliente_id', 'tipo_id', 'status_id', 'user_id', 'locatario_id'];

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

	public function cliente() {
		return $this->belongsTo('App\Cliente');
	}

	public function tipo() {
		return $this->belongsTo('App\Tipo_Projeto');
	}

	public function status() {
		return $this->belongsTo('App\Status_Projeto');
	}

	public function statuses() {
		return $this->hasMany('App\Status_Projeto');
	}

	public function status_tarefa() {
		return $this->hasMany('App\Status_Tarefa');
	}

	public function tipos_tarefa() {
		return $this->hasMany('App\Tipo_Tarefa');
	}

	public function estagios() {
		return $this->hasMany('App\Estagio');
	}

	public function sprints() {
		return $this->hasMany('App\Sprint');
	}

	public function disciplinas() {
		return $this->hasMany('App\Disciplina');
	}

	public function etapas() {
		return $this->hasMany('App\Etapa');
	}

	public function equipes() {
		return $this->belongsToMany('App\Equipe', 'projeto_equipe');
	}

	public function historias(){
       $id = $this->id;
       $historias = Historia::all();
       $historias = $historias->filter(function ($item) use ($id) {
			return ($item->sprint->projeto_id == $id);
		});
       
	return $historias;
    }

    public function tarefas(){
        return $this->hasManyThrough('App\Tarefa', 'App\Sprint');
    }

}
