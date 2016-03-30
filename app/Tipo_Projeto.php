<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tipo_Projeto extends Model
{
    protected $table = 'tipos_projeto';
    public $timestamps = true;
	protected $fillable = ['descricao'];


	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

}
