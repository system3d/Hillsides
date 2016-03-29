<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Status_Projeto extends Model
{
    protected $table = 'status_projeto';
    public $timestamps = true;
	protected $fillable = ['descricao', 'user_id', 'locatario_id'];

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

	public function projetos() {
		return $this->hasMany('App\Projeto');
	}

}
