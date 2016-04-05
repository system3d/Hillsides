<div class="tarefa" data-story='{{$historia->id}}'>
	<span class="red-pin"></span>
	<div class="tarefa-body">
		<p class='tarefa-title'><span data-toggle="tooltip" data-html="true" title='Titulo'>Titulo</span></p>
		<ul class='tarefa-list'>
			<li>Status</li>
			<li>Disciplina</li>
			<li>Etapa</li>
		</ul>
	</div>
	<div class="tarefa-footer">
		<img class='img-circle tarefa-img tarefa-img-user' src="{{ asset('img/avatar/'.access()->user()->avatar) }}"  data-toggle="tooltip" data-html="true" title='UserName'>
		<img class='img-circle tarefa-img tarefa-img-tipo' src="{{ asset('img/icones/default.png') }}"  data-toggle="tooltip" data-html="true" title='Tipo'>
	</div>
</div>