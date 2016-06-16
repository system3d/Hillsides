<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->


          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header">MAIN NAVIGATION</li> -->
            <li class="{!! Active::pattern('/') !!}">
                <a href="{!! url('/') !!}"><i class="fa fa-dashboard"></i><span> Painel de Controle</span></a>
            </li>
            <li class="{!! Active::pattern('projetos') !!}">
                <a href="{!! url('projetos') !!}"><i class="fa fa-folder-open-o"></i></i><span> Meus Projetos</span></a>
            </li>
            @permission('ver-relatorios')
            <li class="{!! Active::pattern('relatorios/') !!}">
                <a href="{!! url('/') !!}"><i class="fa fa-print"></i></i><span> Relatórios</span></a>
            </li>
            @endauth
            @permission('create-users') 
            <li class="{!! Active::pattern('admin/access/*') !!}">
                <a href="{!! url('admin/access/users') !!}"><i class="fa fa-user"></i></i><span> Usuários</span></a>
            </li>
            @endauth
            @permission('ver-equipes')
            <li class="{!! Active::pattern('equipes') !!}">
                <a href="{!! url('equipes') !!}"><i class="fa fa-users"></i></i><span> Equipes</span></a>
            </li>
            @endauth
            @permission('ver-clientes')
            <li class="{!! Active::pattern('clientes') !!}">
                <a href="{!! url('clientes') !!}"><i class="fa fa-shopping-bag"></i></i><span> Clientes</span></a>
            </li>
            @endauth
                    
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>