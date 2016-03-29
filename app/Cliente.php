<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = true;
	protected $fillable = ['razao', 'fantasia', 'documento', 'inscricao', 'fone', 'endereco', 'cep', 'responsavel', 'email', 'site', 'obs', 'cidade', 'user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

    public function projetos() {
		return $this->hasMany('App\Projeto');
	}

	public function user() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
