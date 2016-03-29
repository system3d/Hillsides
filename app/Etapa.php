<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Etapa extends Model
{
    protected $table = 'etapas';
    public $timestamps = true;
	protected $fillable = ['descricao', 'obs', 'projeto_id', 'user_id', 'locatario_id'];

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

	public function projeto() {
		return $this->belongsTo('App\Projeto');
	}
}
