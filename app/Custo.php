<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Custo extends Model
{
    protected $table = 'custos';
    public $timestamps = true;
	protected $fillable = ['valor', 'obs', 'tipo_id', 'user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

    public function tipo() {
		return $this->belongsTo('App\Tipo_Custo');
	}

	public function tarefa() {
		return $this->belongsTo('App\Tarefa');
	}

	public function user() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
