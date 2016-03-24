<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Cronograma extends Model
{
    protected $table = 'cronogramas';
    public $timestamps = true;
	protected $fillable = ['previsto', 'realizado', 'tarefa_id', 'user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

    public function tarefa() {
		return $this->belongsTo('App\Tarefa');
	}

	public function user() {
		return $this->belongsTo('App\Model\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
