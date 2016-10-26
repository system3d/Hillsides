@extends('frontend.layouts.login')

@section('content')

<style media="screen">
  body{
    background-color: #333 !important;
  }
  .hillsides-title{
    font-size: 65px !important;
    text-align: center;
    color: #fff;
    font-weight: bold;
    font-family: Helvetica;
  }
</style>

    <div class="login-box">
      <div  style='width:100%'>
       <h1 class="hillsides-title">Hillsides</h1>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        @include('includes.partials.messages')
        <p class="login-box-msg">Faça login para inicar sua sessão</p>
        {!! Form::open(['url' => 'login']) !!}

                        <div class="form-group has-feedback">
                            {!! Form::label('email', 'E-Mail:', ['class' => 'control-label']) !!}
                                {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('E-Mail')]) !!}
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div><!--form-group-->

                        <div class="form-group has-feedback">
                            {!! Form::label('password', 'Senha:', ['class' => 'control-label']) !!}
                                {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('Senha')]) !!}
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div><!--form-group-->

                        <div class="form-group" >
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('remember') !!} {{ 'Mantenha-me Conectado' }}

                                    </label>

                                    {!! Form::submit(trans('Login'), ['class' => 'btn btn-primary btn-flat', 'style' => 'float:right']) !!}
                                </div>
                        </div><!--form-group-->

                        <hr class="clearfix">
                         {!! link_to('password/reset', 'Esqueceu sua Senha?') !!}

                    {!! Form::close() !!}


                    <div class="row text-center">
                        {!! $socialite_links !!}
                    </div>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->


@endsection
