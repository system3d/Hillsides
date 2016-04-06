@extends('frontend.layouts.master')

@section('styles')
	{{Html::style('css/kanban.css')}}
	{{Html::style('css/kanban-skins.css')}}
@endsection

@section('content')

@include('backend.kanban.navigation')

@include('backend.kanban.table')

{{-- @include('backend.kanban.tarefa') --}}
	
@endsection

@section('scripts')

{!! Html::script('js/kanban.js') !!}

@endsection
