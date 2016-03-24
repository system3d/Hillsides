<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Disciplina extends Model
{
    protected $table = 'disciplinas';
    public $timestamps = true;
	protected $fillable = ['descricao', 'obs', 'projeto_id', 'user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

    public function projeto() {
		return $this->belongsTo('App\Projeto');
	}

	public function tarefas() {
		return $this->hasMany('App\Tarefa');
	}

	public function user() {
		return $this->belongsTo('App\Model\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
