<div class="box box-primary box-kanban">
  <div class="box-header with-border">
    <h3 class="box-title">{{$projeto->descricao}}</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Navegação"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
      <form accept-charset="UTF-8" class="form-inline" role="form" id='navForm'>


          <div class="form-group">
            <a href="#" class="btn btn-primary" id='loadProjInfoKanban' data-id='{{$projeto->id}}'>
              <i class="fa fa-folder"></i>&nbsp;&nbsp;Projeto</a>
             <a href="#" class="btn btn-warning projeto-sprints" id='loadProjSprintKanban' data-id='{{$projeto->id}}'>
              <i class="fa fa-refresh"></i>&nbsp;&nbsp;Sprints</a>
            <a href="#" class="btn btn-info" id='hist-proj' data-id='{{$projeto->id}}'>
              <i class="fa fa-book"></i>&nbsp;&nbsp;Histórias</a>
            <a href="#" class="btn btn-success" id='novaTarefaKanban' data-id='{{$projeto->id}}'>
              <i class="fa fa-external-link"></i>&nbsp;&nbsp;Nova Tarefa</a>

          </div>

          <div class="form-group check-group">
            <label>
                  <input  type="checkbox" name="backlogToggle" id='backlogToggle' value="1" checked> <span>Backlog</span>
                </label>
                &nbsp;&nbsp;
                <label> <input  type="checkbox" name="arquivToggle" id='arquivToggle' value="1" checked> <span>Arquivadas</span> </label>
          </div>

          <div class="form-group selectSprints pull-right">
             <input type="text" placeholder='Pesquisar' class='form-control'>
          </div>
    
         <hr>

          <div class="form-group selectSprints">
          <label for="sprints">Sprints: </label>
           <select id="selectSprints" class="form-control" required="required" name="obra">
            <option value="0">Todos</option>
            @foreach($projeto->sprints as $sprint)
              <option value="{{$sprint->id}}">{{$sprint->descricao}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectStory">
          <label for="sprints">Histórias: </label>
           <select id="selectStory" class="form-control" required="required" name="obra">
            <option value="0">Todas</option>
            @foreach($projeto->historias() as $historia)
              <option value="{{$historia->id}}">{{$historia->descricao}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectSprints">
          <label for="sprints">Equipes: </label>
           <select id="selectEquipe" class="form-control" required="required" name="obra">
            <option value="0">Todas</option>
            @foreach($projeto->equipes as $equipe)
              <option value="{{$equipe->id}}">{{$equipe->descricao}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectSprints">
          <label for="sprints">Encarregado: </label>
           <select id="selectUser" class="form-control" required="required" name="obra">
            <option value="0">Todos</option>
            @foreach($users as $user)
              <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectSprints">
          <label for="sprints">Disciplinas: </label>
           <select id="selectDisc" class="form-control" required="required" name="obra">
            <option value="0">Todas</option>
            @foreach($projeto->disciplinas as $disciplina)
              <option value="{{$disciplina->id}}">{{$disciplina->descricao}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectSprints">
          <label for="sprints">Etapas: </label>
           <select id="selectEtapa" class="form-control" required="required" name="obra">
            <option value="0">Todas</option>
            @foreach($projeto->etapas as $etapa)
              <option value="{{$etapa->id}}">{{$etapa->descricao}}</option>
            @endforeach
           </select>
          </div>

          <div class="form-group">
            <a href="#" class="btn btn-info" data-toggle="tooltip" data-id='{{$projeto->id}}' title='Carregar Tarefas' id='load_tasks'><i class="fa fa-refresh"></i>&nbsp;&nbsp;Caregar</a>
          </div>
         
      </form>
  </div><!-- /.box-body -->
</div>