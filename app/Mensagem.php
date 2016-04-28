<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LocatarioScope;

class Mensagem extends Model
{
     protected $table = 'messages';
    public $timestamps = true;
	protected $fillable = ['message','status','sender_id','receiver_id','locatario_id'];

	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocatarioScope);
    }

	public function sender() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function receiver() {
		return $this->belongsTo('App\Models\Access\User\User');
	}

	public function locatario() {
		return $this->belongsTo('App\Locatario');
	}
}
