<div class="form-group">
	<a href="#" class="pull-right btn-xs btn-google close-info-small"><i class="fa fa-times"></i></a>
   <label class="control-label">{{$equipe->descricao}}</label>
    <p class="form-static">Membros:  <br>
      <small>
      <strong data-toggle="tooltip" data-html="true" title='Responsavel'>{{$equipe->responsavel->name}}</strong> - {{$equipe->responsavel->roles()->first()->name}}
      @foreach($equipe->users as $meq)
        
        @if($meq->id != $equipe->responsavel_id) 
        <br> {{$meq->name}} - {{$meq->roles()->first()->name}}
       @endif
      @endforeach
      </small>
    </p>
</div>