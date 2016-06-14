<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Event;
use App\Events\TesteEvent;
use App\Setting as set;
use App\Projeto as proj;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $fs = set::where('model','projeto')->where('name','favorito')->get();
        $favoritos = [];
        if($fs->count() > 0){
            foreach($fs as $f){
                $pro = proj::find($f->param);
                if(isset($pro->id)){
                    $favoritos[] = $pro;
                }
            }
        }
        $favoritos = collect($favoritos);
        return view('frontend.index', compact('favoritos'));
    }

    public function teste()
    {
        Event::fire(new TesteEvent('Testenado Aqui'));
    }
}
