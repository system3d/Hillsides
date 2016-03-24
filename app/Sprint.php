<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Sprint extends Model
{
    protected $table = 'sprints';
    public $timestamps = true;
	protected $fillable = ['descricao', 'obs', 'projeto_id', 'user_id', 'locatario_id'];

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
		return $this->belongsTo('App\Projeto');
	}

	public function historias() {
		return $this->hasMany('App\Historia');
	}
}
