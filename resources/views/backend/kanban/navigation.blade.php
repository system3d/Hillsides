<div class="box box-primary box-kanban">
  <div class="box-header with-border">
    <h3 class="box-title">{{$projeto->descricao}}</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Navegação"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
      <form accept-charset="UTF-8" class="form-inline" role="form">


          <div class="form-group">
            <a href="#" class="btn btn-primary">Projeto</a>
            <a href="#" class="btn btn-primary">Nova Tarefa</a>
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
           <select id="selectSprints" class="form-control" required="required" name="obra">
            <option value="0">Todas</option>
            @foreach($projeto->equipes as $equipe)
              <option value="{{$equipe->id}}">{{$equipe->descricao}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectSprints">
          <label for="sprints">Encarregado: </label>
           <select id="selectSprints" class="form-control" required="required" name="obra">
            <option value="0">Todos</option>
            @foreach($projeto->sprints as $sprint)
              <option value="{{$sprint->id}}">{{$sprint->descricao}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectSprints">
          <label for="sprints">Disciplinas: </label>
           <select id="selectSprints" class="form-control" required="required" name="obra">
            <option value="0">Todas</option>
            @foreach($projeto->disciplinas as $disciplina)
              <option value="{{$disciplina->id}}">{{$disciplina->descricao}}</option>
            @endforeach
           </select>
          </div>

           <div class="form-group selectSprints">
          <label for="sprints">Etapas: </label>
           <select id="selectSprints" class="form-control" required="required" name="obra">
            <option value="0">Todas</option>
            @foreach($projeto->etapas as $etapa)
              <option value="{{$etapa->id}}">{{$etapa->descricao}}</option>
            @endforeach
           </select>
          </div>

          <div class="form-group selectSprints pull-right">
          <input type="text" placeholder='Pesquisar' class='form-control'>
          </div>
         
      </form>
  </div><!-- /.box-body -->
</div>