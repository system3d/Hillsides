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
}
