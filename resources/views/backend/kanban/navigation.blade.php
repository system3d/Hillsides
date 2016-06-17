<div class="box box-primary box-kanban">
  <div class="box-header with-border">
    <h3 class="box-title">{{$projeto->descricao}}
    @if($projeto->tipo->descricao == 'Teamplate')
     (Teamplate)
    @endif
    </h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Navegação"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
      <form accept-charset="UTF-8" class="form-inline" role="form" id='navForm'>


          <div class="form-group">
            <a href="#" class="btn btn-primary" id='loadProjInfoKanban' data-id='{{$projeto->id}}'>
              <i class="fa fa-folder"></i>&nbsp;&nbsp;Projeto</a>
            @permission('ver-sprints')
             <a href="#" class="btn btn-warning projeto-sprints" id='loadProjSprintKanban' data-id='{{$projeto->id}}'>
              <i class="fa fa-refresh"></i>&nbsp;&nbsp;SubProj.</a>
            @endauth
            @permission('ver-sprints')
            <a href="#" class="btn btn-info" id='hist-proj' data-id='{{$projeto->id}}'>
              <i class="fa fa-book"></i>&nbsp;&nbsp;Agrup.</a>
            @endauth
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
             <input type="text" id='kanban-search' placeholder='Pesquisar' class='form-control'>
          </div>
    
         <hr>

          <div class="form-group selectSprints">
          <label for="sprints">Subprojeto: </label>
           <select id="selectSprints" class="form-control chosen-select" required="required" name="obra">
            <option value="0">Todos</option>
            @if(isAllowed('ver-tarefa'))
              @foreach($projeto->sprints as $sprint)
                <option value="{{$sprint->id}}" <?php if((int) $dados['sprint'] == $sprint->id) echo 'selected'; ?>>{{$sprint->descricao}}</option>
              @endforeach
            @else
              @foreach(access()->user()->sprintsProjeto($projeto->id) as $sprint)
                   <option value="{{$sprint->id}}" <?php if((int) $dados['sprint'] == $sprint->id) echo 'selected'; ?>>{{$sprint->descricao}}</option>
              @endforeach
            @endif
           </select>
          </div>

           <div class="form-group selectStory">
          <label for="sprints">Agrupamento: </label>
           <select id="selectStory" class="form-control chosen-select" required="required" name="obra">
            <option value="0">Todas</option>
            @if(isAllowed('ver-tarefa'))
              @foreach($projeto->historias() as $historia)
                <option data-sprint='{{$historia->sprint_id}}' value="{{$historia->id}}" class='storyOption' <?php if((int) $dados['story'] == $historia->id) echo 'selected'; ?>>{{$historia->descricao}}</option>
              @endforeach
            @else
              @foreach(access()->user()->historiasProjeto($projeto->id) as $historia)
                <option data-sprint='{{$historia->sprint_id}}' value="{{$historia->id}}" class='storyOption' <?php if((int) $dados['story'] == $historia->id) echo 'selected'; ?>>{{$historia->descricao}}</option>
              @endforeach
            @endif
           </select>
          </div>

           <div class="form-group" id='selectEquipes'>
          <label for="sprints">Equipes: </label>
           <select id="selectEquipe" class="form-control chosen-select" required="required" name="obra">
             <option value="0">Todas</option>
            @if(isAllowed('ver-tarefa'))
              @foreach($projeto->equipes as $equipe)
                <option class='equipeOption' value="{{$equipe->id}}" <?php if((int) $dados['equipe'] == $equipe->id) echo 'selected'; ?>>{{$equipe->descricao}}</option>
              @endforeach
            @else
              @foreach($projeto->equipes as $equipe)
                @if(in_array($equipe->id, access()->user()->equipesIds()))
                  <option class='equipeOption' value="{{$equipe->id}}" <?php if((int) $dados['equipe'] == $equipe->id) echo 'selected'; ?>>{{$equipe->descricao}}</option>
                @endif
              @endforeach
            @endif
           </select>
          </div>

           <div class="form-group selectUsers">
          <label for="sprints">Responsável: </label>
           <select id="selectUser" class="form-control chosen-select" required="required" name="obra">
            <option value="0">Todos</option>
            @if(isAllowed('ver-tarefa'))
              @foreach($users as $user)
                <option class='assigneeOption' value="{{$user->id}}" <?php if((int) $dados['user'] == $user->id) echo 'selected'; ?>>{{$user->name}}</option>
              @endforeach
            @else
              @foreach($users as $user)
                  @if(in_array($user->id, access()->user()->comradesId()))
                    <option class='assigneeOption' value="{{$user->id}}" <?php if((int) $dados['user'] == $user->id) echo 'selected'; ?>>{{$user->name}}</option>
                  @endif
                @endforeach
            @endif
            <option value="null">Nenhum</option>
           </select>
          </div>

           <div class="form-group selectDiscs">
          <label for="sprints">Disciplinas: </label>
           <select id="selectDisc" class="form-control chosen-select" required="required" name="obra">
            <option value="0">Todas</option>
            @if(isAllowed('ver-tarefa'))
              @foreach($projeto->disciplinas as $disciplina)
                <option value="{{$disciplina->id}}" <?php if((int) $dados['dis'] == $disciplina->id) echo 'selected'; ?>>{{$disciplina->descricao}}</option>
              @endforeach   
            @else
              @foreach(access()->user()->discProjeto($projeto->id) as $disciplina)
                <option value="{{$disciplina->id}}" <?php if((int) $dados['dis'] == $disciplina->id) echo 'selected'; ?>>{{$disciplina->descricao}}</option>
              @endforeach
            @endif
           </select>
          </div>

           <div class="form-group selectEtapas">
          <label for="sprints">Etapas: </label>
           <select id="selectEtapa" class="form-control chosen-select" required="required" name="obra">
            <option value="0">Todas</option>
            @if(isAllowed('ver-tarefa'))
              @foreach($projeto->etapas as $etapa)
                <option value="{{$etapa->id}}" <?php if((int) $dados['etapa'] == $etapa->id) echo 'selected'; ?>>{{$etapa->descricao}}</option>
              @endforeach
            @else
              @foreach(access()->user()->etapasProjeto($projeto->id) as $etapa)
                <option value="{{$etapa->id}}" <?php if((int) $dados['etapa'] == $etapa->id) echo 'selected'; ?>>{{$etapa->descricao}}</option>
              @endforeach
            @endif
           </select>
          </div>

          <div class="form-group">
          <br>
            <a href="#" class="btn btn-info" data-toggle="tooltip" data-id='{{$projeto->id}}' title='Carregar Tarefas' id='load_tasks'><i class="fa fa-refresh"></i>&nbsp;&nbsp;Carregar</a>
          </div>
         
      </form>
  </div><!-- /.box-body -->
</div>

<input type="hidden" id='actualSprint' value=' {{$dados["sprint"]}}'>
<input type="hidden" id='actualStory' value='  {{$dados["story"]}}'>
<input type="hidden" id='actualEquipe' value=' {{$dados["equipe"]}}'>
<input type="hidden" id='actualUser' value='   {{$dados["user"]}}'>
<input type="hidden" id='actualDisc' value='   {{$dados["dis"]}}'>
<input type="hidden" id='actualEtapa' value='{{$dados["etapa"]}}'>