<div class="panel panel-success">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Encarregado de {{$tarefa->descricao}}</h4>
   </div>

   <div class="panel-body no-padding">
      <div class="box box-widget widget-user">
        <div class="widget-user-header bg-aqua">
          <h3 class="widget-user-username">{{$user->name}}</h3>
          <h5 class="widget-user-desc">{{$user->roles->first()->name}}</h5>
        </div>
        <div class="widget-user-image">
          <img src="{{ asset('img/avatar/'.$user->avatar) }}" class="img-circle" alt="User Image">
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">{{$user->tarefasAssigned->count()}}</h5>
                <span class="description-text">Tarefas</span>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">Equipe(s)</h5>
                <span class="description-text">
                  @foreach($user->equipes as $equipe)
                    {{$equipe->descricao}} <br>
                  @endforeach
                </span>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header">E-Mail:</h5>
                <span class="description-text">{{$user->email}}</span>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div>
      </div>
   </div>
   <div class="panel-footer">
     <button data-dismiss="modal" aria-hidden="true" class="btn btn-google pull-right">Voltar</button>
     <button class="btn-primary btn" id="sendMessage">Mensagem</button>
   </div>
</div>