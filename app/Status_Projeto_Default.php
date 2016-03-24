<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Status_Projeto_Default extends Model
{
    protected $table = 'status_projeto_default';
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
