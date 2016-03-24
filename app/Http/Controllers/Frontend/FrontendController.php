<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Event;
use App\Events\TesteEvent;

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
       
        return view('frontend.index');
    }

    public function teste()
    {
        Event::fire(new TesteEvent('Testenado Aqui'));
    }
}
