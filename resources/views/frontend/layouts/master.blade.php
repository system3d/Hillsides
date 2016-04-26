<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{{ asset('img/steel4web.ico') }}}">
    <meta name="_token" content="{{ csrf_token() }}" />

    <title>@yield('title', app_name())</title>

    <!-- Meta -->
    <meta name="description" content="@yield('meta_description', 'Default Description')">
    <meta name="author" content="@yield('meta_author', 'System3d')">

    @yield('meta')

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('frontend.includes.styles')

    <!-- Inject the custom styles from view -->
    @yield('styles')

    


</head>
<body class="hold-transition sidebar-collapse sidebar-mini skin-{!! config('frontend.theme') !!}">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include('frontend.includes.header')

        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        @include('frontend.includes.sidebar')

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

      <section class="content">

        @include('includes.partials.messages')

        @yield('content')

        <div class="overlay dark loader" id='loader'>
             <i class="fa loading"></i>
        </div>

        <div id="go-to-top" class='btn btn-primary hidden'><i class="fa fa-chevron-up"></i></div>

        @include('includes.partials.modal')
        @include('backend.includes.chat')

      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Versão</b> {{app_version()}}
    </div>
    <small><strong>Copyright &copy; {{ date('Y') }} <a href="http://stee4web.com.br">System3D</a>.</strong> Todos os direitos reservados.</small>
  </footer>
 @include('frontend.includes.control-sidebar')
</div><!-- ./wrapper -->


<!-- Includes all the global required JS libs -->
@include('frontend.includes.scripts')

<!-- Inject the custom scripts from view -->
@yield('scripts')

</body>
</html>