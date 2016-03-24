<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProjetosController extends Controller
{
   public function cadastro(){
   		$data = projeto_cadastro();
   		return $data;
   }
}
