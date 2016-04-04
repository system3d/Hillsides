<div class="panel panel-info">
   <div class="panel-heading">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h4>Trocar Cor de Fundo de {{$tarefa->descricao}}</h4>
   </div>
   <div class="panel-body">
       <form id="trocar_cor" data-parsley-validate="">
       <input type="hidden" name="tarefa" value="{{$tarefa->id}}">
       	<div class="row">
       		<div class="col-md-12">
            <div class="form-group">
              <div class="input-group">
                 <input type="text" name='cor' value="{{$tarefa->cor}}" required='' class="form-control colorPickBck" />
                 <span class="input-group-addon" id="colorSelected" style='width:30%;background:{{$tarefa->cor}}'></span>
              </div>

                    

                </div>


                <br><br>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm">Gravar</button> <button data-dismiss="modal" aria-hidden="true" class="btn btn-danger btn-sm">Cancelar</button>
              </div>
       		</div>
       	</div> 
       </form>
   </div>
</div>

<style>
    .colorpicker .colorpicker-saturation {
        width: 100px;
    }
    .colorpicker .colorpicker-hue,
    .colorpicker .colorpicker-alpha {
        width: 25px;
    }
    .colorpicker .colorpicker-color,
    .colorpicker .colorpicker-color div{
        height: 15px;
    }
</style>