@extends('frontend.layouts.master')

@section('styles')

{{Html::style('css/kanban.css')}}
{{Html::style('css/kanban-skins.css')}}
{{Html::style('plugins/iCheck/all.css')}}
{{Html::style('plugins/jQueryUI/jquery-ui.min.css')}}

@endsection

@section('content')

@include('backend.kanban.navigation')

@include('backend.kanban.table')
	
@endsection

@section('scripts')
 <script type="text/javascript"> var isKanban = true; </script>
{!! Html::script('plugins/iCheck/icheck.min.js') !!}
{!! Html::script('plugins/jquery-cookie-master/jquery.cookie.js') !!}
{!! Html::script('js/equipes.js') !!}
{!! Html::script('js/clientes.js') !!}
{!! Html::script('js/projetos.js') !!}
{!! Html::script('js/kanban.js') !!}

@endsection
