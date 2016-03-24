<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Historia extends Model
{
    protected $table = 'historias';
    public $timestamps = true;
	protected $fillable = ['descricao', 'ordem', 'sprint_id', 'user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function user() {
		return $this->belongsTo('App\Model\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

	public function sprint() {
		return $this->belongsTo('App\Sprint');
	}

	public function tarefas() {
		return $this->hasMany('App\Tarefa');
	}
}
