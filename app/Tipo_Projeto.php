<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Tipo_Projeto extends Model
{
    protected $table = 'tipos_projeto';
    public $timestamps = true;
	protected $fillable = ['descricao', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

}
