    <div class="pull-right" style="margin-bottom:10px">
      <div class="btn-group">
              <a href="{{ url('admin/access/users') }}" class="btn btn-primary btn-xs">Usuários Ativos</a>
        </div><!--btn group-->
        <div class="btn-group">
              <a href="{{ route('admin.access.users.create') }}" class="btn btn-primary btn-xs">{{ trans('menus.backend.access.users.create') }}</a>
        </div><!--btn group-->
        @permission('reactivate-users')
        <div class="btn-group">
              <a href="{{ route('admin.access.users.deleted') }}" class="btn btn-primary btn-xs">Usuários Deletados </a>
        </div><!--btn group-->
        @endauth
    </div><!--pull right-->

    <div class="clearfix"></div>
