@extends('frontend.layouts.master')

@section('content')

@include('backend.kanban.navigation')

@include('backend.kanban.table')

{{-- @include('backend.kanban.tarefa') --}}
	
@endsection

@section('scripts')

{!! Html::script('js/kanban.js') !!}

@endsection
