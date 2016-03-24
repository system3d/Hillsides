<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Tipo_Tarefa extends Model
{
    protected $table = 'tipos_tarefa';
    public $timestamps = true;
	protected $fillable = ['descricao', 'icone', 'projeto_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

	public function projeto() {
		return $this->belongsTo('App\Projeto');
	}

	public function tarefas() {
		return $this->hasMany('App\Tarefa');
	}
}
