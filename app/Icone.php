<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icone extends Model
{
    protected $table = 'icones';
    public $timestamps = 'false';
	protected $fillable = ['icone'];
}
