<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Contato extends Model
{
    protected $table = 'contatos';
    public $timestamps = true;
	protected $fillable = ['razao', 'fantasia', 'tipocontato_id', 'documento', 'inscricao', 'fone', 'endereco', 'cep', 'responsavel', 'email', 'site', 'crea', 'cidade', 'user_id', 'locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

    public function tipo() {
		return $this->belongsTo('App\TipoContato');
	}

	public function user() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}

	public function obras() {
		return $this->belongsToMany('App\Projeto', 'projeto_contato');
	}
}
