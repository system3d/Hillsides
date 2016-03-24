<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Estagio_Default extends Model
{
    protected $table = 'estagios_default';
    public $timestamps = true;
	protected $fillable = ['descricao', 'ordem', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
