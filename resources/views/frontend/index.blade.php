@extends('frontend.layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4>Projetos Favoritos</h4>
                </div>
                <div class="panel-body" style='margin-bottom: 0 !important;'>
                    <ul id='dashboard-favorites'>
                        @foreach($favoritos as $favorito)
                        <li>
                            {{$favorito->descricao}}
                                <a href='{{url("kanban")."/".$favorito->id}}' type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-html="true" title='Kanbam do Projeto'><i class="fa fa-th-large"></i></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <a href="{{url('projetos')}}" class='btn btn-primary pull-right'>Ver Todos</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-success">
                <div class="panel-heading" style='text-align: center;'>
                    <h4>การอำลา</h4>
                </div>
                <div class="panel-body" style='text-align: center;'>
                   <i>Ai! laurië lantar lassi súrinen, <br>
                    Yéni únótimë ve rámar aldaron! <br>
                    Yéni ve lintë yuldar avánier <br>
                    mi oromardi lissë-miruvóreva <br>
                    Andúnë pella, Vardo tellumar <br>
                    nu luini yassen tintilar i eleni <br>
                    ómaryo airetári-lírinen. <br>
                    Sí man i yulma nin enquantuva? <br>
                    An sí Tintallë Varda Oiolossëo <br>
                    ve fanyar máryat Elentári ortanë <br>
                    ar ilyë tier undulávë lumbulë <br>
                    ar sindanóriello caita mornië <br>
                    i falmalinnar imbë met, ar hísië <br>
                    untúpa Calaciryo míri oialë. <br>
                    Sí vanwa ná, Rómello vanwa, Valimar! <br>
                    Namárië! Nai hiruvalyë Valimar! <br>
                    Nai elyë hiruva! Namárië!</i>
                </div>
            </div>
        </div>
   </div><!--row-->

@endsection
