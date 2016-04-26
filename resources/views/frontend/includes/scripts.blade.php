   <script type="text/javascript">
        var urlbaseGeral = {!! json_encode(url('/')) !!};
        var modal_history = [false];
        var modal_width = ['60%'];
        var isKanban = false;
        var shouldReload = false;
    </script>

    <script type="text/javascript"> var app_env = '{!! env('APP_ENV') !!}' </script>

    @if(isset(access()->user()->id))
    <script type="text/javascript"> var thisUserId = {!! json_encode(access()->user()->id) !!} </script>
    @endif

    <!-- jQuery 2.1.4 -->
    {!! Html::script('plugins/jQuery/jQuery-2.1.4.min.js') !!}
    {{-- Toaster(Notificações) --}}
    {!! Html::script('plugins/toasts/src/jquery.toast.js') !!}

    {!! Html::script('plugins/linkify/jquery-linkify.min.js') !!}
    <!-- Messages -->
    {!! Html::script('js/messages.js') !!}
    <!-- Jquery UI -->
    {!! Html::script('plugins/jQueryUI/jquery-ui.js') !!}
     {!! Html::script('js/touch-punch.js') !!}
    <!-- Bootstrap 3.3.5 -->
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('plugins/parsley.js') !!}
    {!! Html::script('plugins/parsleyBR.js') !!}
    <!-- Datatables -->
    {!! Html::script('plugins/datatables/datatables.min.js') !!}
    <!-- SlimScroll -->
    {!! Html::script('plugins/slimScroll/jquery.slimscroll.min.js') !!}
   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.min.js"></script>
    {!! Html::script('js/websocket.js') !!} -->

    <!-- Socket.IO  
     <script src="{{ asset('plugins/socket.io.js') }}"></script> -->
     
      <!--  <script src='http://localhost:3000/socket.io/socket.io.js'></script>  -->
    <!-- Notifications --> 
   {{--  {!! Html::script('js/notifications.js') !!}
     <!-- Notifications Real Time -->
    @if(app_real() == true)
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.min.js"></script>
        {!! Html::script('js/notificationsReal.js') !!}
    @endif --}}
    <!-- FastClick -->
    {!! Html::script('plugins/fastclick/fastclick.min.js') !!}
    <!-- Editable
    {!! Html::script('plugins/editable/bootstrap-editable.min.js') !!}-->
    <!-- Moment -->
    {!! Html::script('plugins/moment.js') !!}
    <!-- Masks -->
    {!! Html::script('plugins/jquery.mask.min.js') !!}

     {!! Html::script('js/datatables_plugin.js') !!}


    <!-- Bootstrap Select -->
    {!! Html::script('js/bootstrap-select.min.js') !!}
    {!! Html::script('js/i18n/defaults-pt_BR.min.js') !!}
    {!! Html::script('plugins/colorpicker/bootstrap-colorpicker.min.js') !!}

    <!-- AdminLTE -->
    {!! Html::script('js/app.min.js') !!}
    <!-- Dropdown Fix -->
    <script type="text/javascript"> $(document).ready(function () { $('.dropdown-toggle').dropdown(); });</script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="js/demo.js"></script> -->

    <!-- datepicker -->
    {!! Html::script('plugins/datepicker/bootstrap-datepicker.min.js') !!}
    {!! Html::script('plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') !!}

    <!-- Main Scripts -->
    {!! Html::script('js/tables.js') !!}
     {!! Html::script('js/settings.js') !!}
    {!! Html::script('js/script.js') !!}
    {!! Html::script('js/modals.js') !!}
    {!! Html::script('js/chat.js') !!}