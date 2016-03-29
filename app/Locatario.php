<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locatario extends Model
{
    protected $table = 'locatarios';
    public $timestamps = false;
	protected $fillable = ['razao', 'fantasia', 'documento', 'inscricao', 'fone', 'endereco', 'cep', 'responsavel', 'email', 'site', 'logo', 'cidade'];

	public function users() {
		return $this->hasMany('App\Models\Access\User\User');
	}

	public function clientes() {
		return $this->hasMany('App\Cliente');
	}

	public function projetos() {
		return $this->hasMany('App\Projetos');
	}

	public function equipes() {
		return $this->hasMany('App\Equipe');
	}

	public function sprints() {
		return $this->hasMany('App\Sprint');
	}

	public function etapas() {
		return $this->hasMany('App\Etapa');
	}

	public function disciplinas() {
		return $this->hasMany('App\Disciplina');
	}

	public function tarefas() {
		return $this->hasMany('App\Tarefa');
	}

	public function historias() {
		return $this->hasMany('App\Historia');
	}

	public function status_projeto_default() {
		return $this->hasMany('App\Status_Projeto_Default');
	}

	public function status_tarefa_default() {
		return $this->hasMany('App\Status_Tarefa_Default');
	}

	public function tipo_tarefa_default() {
		return $this->hasMany('App\Tipo_Tarefa_Default');
	}

	public function tipos_contato() {
		return $this->hasMany('App\TipoContato');
	}

	public function tipos_custo() {
		return $this->hasMany('App\Tipo_Custo');
	}

	public function estagios_default() {
		return $this->hasMany('App\Estagio_Default');
	}
}
