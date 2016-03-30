<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projeto as proj; 

class ProjetosController extends Controller
{
    public function index(){
    	return view('backend.projetos');
    }

     public function criar(){
      return view('backend.modals.projetos.criar');
   }
}
