<header class="main-header">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="{{ asset('img/icon.png') }}" class='iconHeader' alt="Steel4Web"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
             <img src="{{ asset('img/lolgo.png') }}" class='logoHeader' alt="Steel4Web">
          </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" id='returnLastKanban' class='logout-header' role="button" data-toggle="tooltip" data-html="true" data-placement='right' title='Voltar Para Kanban'>
            <i style='font-size:15px' class="fa fa-th-large"></i></a>
          </a>
          <a href="{{url('logout')}}" data-toggle="tooltip" data-html="true" data-placement='right' title='Logout' class='logout-header'><i style='font-size:15px' class="fa fa-sign-out"></i></a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

               <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="" class="dropdown-toggle notifysDown" data-toggle="dropdown">
                        <i style='font-size:15px' class="fa fa-bell-o labelWrapper"></i>
                    </a>
                    <ul class="dropdown-menu notify_dropdown">
                        <li class='liNotMenu'>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu notify_menu">
                            </ul>
                        </li>
                        <li class="li footer notFooter"><a href="#" id="limparNotifys">Limpar Notificações</a><a href="{{url('notificacoes')}}" id="listarNotifys">Ver Todas</a></li>
                    </ul>

                </li>
                <?php $lastMessages = getLastMessages(); ?>
                 <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <i style='font-size:15px' class="fa fa-comments"></i>
                        @if($lastMessages['total'] > 0)
                        <span class="label bg-maroon" id='msgsTotalHeader'>{{$lastMessages['total']}}</span>
                        @else
                        <span class="label bg-maroon hidden" id='msgsTotalHeader'>{{$lastMessages['total']}}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu message-header-menu" id='ulHeaderMenuChat'>
                              @foreach($lastMessages['msgs'] as $msg)
                                <li><!-- start message -->
                                <a href="#" class='chat-user-header chat-msg-header-{{$msg->status}}' data-id='{{$msg->sender_id}}'>
                                  <div class="pull-left">
                                    <img src="{{ asset('img/avatar/'.$msg->sender->avatar) }}" class="img-circle" alt="User Image">
                                  </div>
                                  <h4>
                                    {{str_limit($msg->sender->name,20)}}
                                    <small><i class="fa fa-clock-o"></i> {{datePtFormat($msg->created_at)}}</small>
                                  </h4>
                                  <p>{{str_limit($msg->message,30)}}
                                    @if(isset($lastMessages['num'][$msg->sender_id]))
                                      <span class="label label-info count-unread" data-id='{{$msg->sender_id}}'>{{$lastMessages['num'][$msg->sender_id]}}</small>
                                    @else
                                      <i class="fa fa-check text-success pull-right"></i>
                                    @endif
                                 </p>
                                </a>
                              </li>
                              @endforeach
                             
                            </ul>
                        </li>
                         <li class='footer msg-footer'>
                                <button class='btn btn-block' id='go-to-message' href="{{url('mensagens')}}">Ver Todas</button>
                              </li>
                    </ul>

                </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li>
                <a href="#" data-toggle="control-sidebar" id='controlSidebarIcon'><i style='font-size:15px' class="fa fa-gears"></i></a>
              </li>
              <!-- Control Sidebar Toggle Button
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li> -->
               
            </ul>
          </div>
        </nav>
      </header>