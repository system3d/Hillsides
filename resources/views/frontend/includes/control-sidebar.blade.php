      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark" id='control-sidebar-principal'>
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class='active'><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <ul class="control-sidebar-menu">
                  <li class="user-header">
                      <div class="profile-pic">
                        <img src="{{ asset('img/avatar/'.access()->user()->avatar) }}" class="img-circle" alt="User Image" id='this-user-avatar'>
                        <div class="edit"><a href="#" class='edit-user-avatar'><i class="fa fa-pencil fa-lg"></i></a></div>
                      </div>
                    <p>
                      {{access()->user()->name}}
                      <small>{{access()->user()->roles->first()->name}}</small>
                    </p>
                  </li>
            </ul><!-- /.control-sidebar-menu -->

            <h4 class="control-sidebar-heading">Contatos</h4>

        <div id="control-sidebar-tab-chat">

          <ul class="chat_menu" id='chat_menu_list'>

      @foreach(access()->user()->locatario->users->sortBy('name') as $chat_user)
      @if($chat_user->isOnline() && $chat_user->id != access()->user()->id)

      <li class='chat_user' data-id="{{$chat_user->id}}" data-name='{{$chat_user->name}}'  data-off='false'><!-- start message -->
          <div class="pull-left">
            <img src="{{ asset('img/avatar/'.$chat_user->avatar) }}" class="img-circle chat_list_img" alt="User Image">
          </div>
          <h4>
            {{str_limit($chat_user->name,20,'...')}}
          </h4>
            <?php $lastActivityObj =  timeDiff($chat_user->lastActivity->data);?>
          <small class='chat_user_status' data-time='{{$lastActivityObj["t"]}}'>
            <i class="fa fa-circle text-success"></i> Online
          </small>
      </li><!-- end message -->
      @endif
      @endforeach
      @foreach(access()->user()->locatario->users->sortBy('name') as $chat_user)
      @if(!$chat_user->isOnline() && $chat_user->id != access()->user()->id)
      <li class='chat_user' data-id="{{$chat_user->id}}" data-name='{{strtolower($chat_user->name)}}' data-off='true'><!-- start message -->
          <div class="pull-left">
            <img src="{{ asset('img/avatar/'.$chat_user->avatar) }}" class="img-circle chat_list_img" alt="User Image">
          </div>
          <h4>
            {{str_limit($chat_user->name,20,'...')}}
          </h4>
            @if(isset($chat_user->lastActivity->data))
            <?php $lastActivityObj =  timeDiff($chat_user->lastActivity->data);?>
              @if($lastActivityObj['t'] < 86000)
              <small class='chat_user_status' data-time='{{$lastActivityObj["t"]}}'>
                Visto(a) por último à 
                @if($lastActivityObj['h'] > 0)
                    @if($lastActivityObj['h'] == 1)
                      {{$lastActivityObj['h']}} hora
                    @else
                      {{$lastActivityObj['h']}} horas
                    @endif
                @elseif($lastActivityObj['m'] > 0)
                  @if($lastActivityObj['m'] == 1)
                    {{$lastActivityObj['m']}} minuto
                  @else
                    {{$lastActivityObj['m']}} minutos
                  @endif
                @else
                  1 minuto
                @endif
              @else
              <small class='chat_user_status' data-time='0'>
              <i class="fa fa-circle text-danger"></i> Offline
              @endif
            @else
            <small class='chat_user_status' data-time='0'>
            <i class="fa fa-circle text-danger"></i> Offline
            @endif
          </small>
      </li><!-- end message -->
      @endif
      @endforeach
     
    </ul>
    <form id='chat_search'>
      <div class="input-group input-fa-wrapper">
        <i class="fa fa-search fa-search-input"></i>
        <input type="text" name="message" id='chat_search_field' placeholder="Procurar..." class="form-control">
    </form>
      </div>
        
 </div>


</div>















          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">Configurações Gerais</h3>
              <small>Configurações a serem aplicadas na criação do projeto.</small>
              <br> <br>
              <div class="form-group">
                <label class="control-sidebar-subheading fa-side-drop" id='fa-estagios-sidebar'>
                  Estágios
                  <i class="fa fa-plus-square pull-right fa-sidebar"></i>
                </label>

                <div class='settings-content hidden' id='set-est-side'>
                  <small>Novo:</small> <br>
                  <div class="row">
                    <div class="col-xs-8">
                      <input type="text" id='novo-estagio-set' class='form-control input-sm'>
                      </div>
                      <div class="col-xs-4">
                        <a href="#" class="btn btn-xs btn-success pull-left" id='new-est-side'><i class="fa fa-check"></i></a>
                     </div>
                  </div>
                  <br>
                  <p>Backlog <a href='#' class="pull-right text-muted" data-toggle="tooltip" data-html="true" title='Sistema'><i class="fa fa-trash"></i></a></p>
                  <div id="estagios-sets-wrap">
                    @foreach(access()->user()->locatario->estagios_default->sortBy('ordem') as $estag)
                      <p data-id='{{$estag->id}}'>{{$estag->descricao}} <a href="#" data-toggle="tooltip" data-html="true" title='Deletar' class="pull-right delete-estagio text-red"><i class="fa fa-trash"></i></a></p>
                    @endforeach
                  </div>
                  <p>Arquivado <a href="#" class="pull-right text-muted" data-toggle="tooltip" data-html="true" title='Sistema'><i class="fa fa-trash"></i></a></p>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading fa-side-drop" id='fa-stp-sidebar'>
                  Status de Projeto
                  <i class="fa fa-plus-square pull-right fa-sidebar"></i>
                </label>

               <div class='settings-content hidden' id='set-stp-side'>
                  <small>Novo:</small> <br>
                  <div class="row">
                    <div class="col-xs-8">
                      <input type="text" id='novo-stp-set' class='form-control input-sm'>
                      </div>
                      <div class="col-xs-4">
                        <a href="#" class="btn btn-xs btn-success pull-left" id='new-stp-side'><i class="fa fa-check"></i></a>
                     </div>
                  </div>
                  <br>
                  <p>Ativo <a href='#' class="pull-right text-muted" data-toggle="tooltip" data-html="true" title='Sistema'><i class="fa fa-trash"></i></a></p>
                  <div id="stp-sets-wrap">
                    @foreach(access()->user()->locatario->status_projeto_default as $stp)
                      <p data-id='{{$stp->id}}'>{{$stp->descricao}} <a href="#" data-toggle="tooltip" data-html="true" title='Deletar' class="pull-right delete-stp text-red"><i class="fa fa-trash"></i></a></p>
                    @endforeach
                  </div>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading fa-side-drop" id='fa-sfp-sidebar'>
                  Status de Tarefas
                  <i class="fa fa-plus-square pull-right fa-sidebar"></i>
                </label>

               <div class='settings-content hidden' id='set-sfp-side'>
                  <small>Nova:</small> <br>
                  <div class="row">
                    <div class="col-xs-8">
                      <input type="text" id='novo-sfp-set' class='form-control input-sm'>
                      </div>
                      <div class="col-xs-4">
                        <a href="#" class="btn btn-xs btn-success pull-left" id='new-sfp-side'><i class="fa fa-check"></i></a>
                     </div>
                  </div>
                  <br>
                  <p>Aberta <a href='#' class="pull-right text-muted" data-toggle="tooltip" data-html="true" title='Sistema'><i class="fa fa-trash"></i></a></p>
                  <div id="sfp-sets-wrap">
                    @foreach(access()->user()->locatario->status_tarefa_default as $sfp)
                      <p data-id='{{$sfp->id}}'>{{$sfp->descricao}} <a href="#" data-toggle="tooltip" data-html="true" title='Deletar' class="pull-right delete-sfp text-red"><i class="fa fa-trash"></i></a></p>
                    @endforeach
                  </div>
                </div>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading fa-side-drop" id='fa-trp-sidebar'>
                  Tipos de Tarefas
                  <i class="fa fa-plus-square pull-right fa-sidebar"></i>
                </label>

                <div class='settings-content hidden' id='set-trp-side'>
                  <small>Novo:</small> <br>
                  <div class="row">
                    <div class="col-xs-8">
                      <input type="text" id='novo-trp-set' class='form-control input-sm'>
                      </div>
                      <div class="col-xs-4">
                        <a href="#" class="btn btn-xs btn-success pull-left" id='new-trp-side'><i class="fa fa-check"></i></a>
                     </div>
                  </div>
                  <br>
                  <p>Sem Classificação
                        <span class="pull-right">
                          <span class='back-t-change' style='background:#fff'></span>
                          <img class='img-circle img-icon' src="{{ asset('img/icones/default.png') }}">
                        <a href="#" data-toggle="tooltip" data-html="true" title='Sistema' class="text-muted"><i class="fa fa-trash"></i></a>
                        </span>
                      </p>
                  <div id="trp-sets-wrap">
                    @foreach(access()->user()->locatario->tipo_tarefa_default as $trp)
                      <p data-id='{{$trp->id}}'>{{$trp->descricao}} 
                        <span class="pull-right">
                          <a href="#" data-id='{{$trp->id}}' data-toggle="tooltip" data-html="true" title='Cor de Fundo' class='fire-bck-change'>
                            <span id='BTCS{{$trp->id}}' class="back-t-change" style='background:{{$trp->cor}}'></span>
                          </a> 
                        <a href="#" data-id='{{$trp->id}}' data-toggle="tooltip" data-html="true" title='Icone' class='icon-t-change'>
                          <img class='img-icon' src="{{ asset('img/icones/'.$trp->icone) }}" id='t-icon-{{$trp->id}}'>
                        </a>
                        
                        <a href="#" data-toggle="tooltip" data-html="true" title='Deletar' class="delete-trp text-red"><i class="fa fa-trash"></i></a>
                        </span>
                      </p>
                    @endforeach
                  </div>
                </div>
              </div><!-- /.form-group -->
              
              

              <h3 class="control-sidebar-heading">Configurações do Chat</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Desabilitar Sons
                  <input type="checkbox" class="pull-right chat-config-check" data-type='sounds' checked id='chat-settingss-sound'>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->

        </div>
      </aside><!-- /.control-sidebar -->
       <div class="control-sidebar-bg"></div>