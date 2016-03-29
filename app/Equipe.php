<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Equipe extends Model
{
    protected $table = 'equipes';
    public $timestamps = true;
	protected $fillable = ['descricao', 'obs', 'responsavel_id','user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function user() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function responsavel() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

	public function projetos() {
		return $this->belongsToMany('App\Projeto', 'projeto_equipe');
	}

	public function users() {
		return $this->belongsToMany('App\Models\Access\User\User', 'user_equipe');
	}
}
