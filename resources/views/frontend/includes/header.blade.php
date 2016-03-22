<header class="main-header">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
             <img src="{{ asset('img/lolgo.png') }}" class='logoHeader' alt="Steel4Web">
          </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
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