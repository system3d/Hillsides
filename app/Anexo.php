<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Anexo extends Model
{
    protected $table = 'anexos';
    public $timestamps = false;
	protected $fillable = ['descricao', 'tamanho', 'tarefa_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

    public function tarefa() {
		return $this->belongsTo('App\Tarefa');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
