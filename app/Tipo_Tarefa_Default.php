<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Tipo_Tarefa_Default extends Model
{
    protected $table = 'tipos_tarefa_default';
    public $timestamps = true;
	protected $fillable = ['descricao', 'icone', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
