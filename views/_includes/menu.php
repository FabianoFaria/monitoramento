<?php
/* carrega dados */
//$dadosNot = $modelo->notificacao();

/*
* CARREGA MODEL PARA ALARMES, INDEPENDENTE DA PÁGINA
*/
$alarmeModeloStatus  = $this->load_model('alarme/alarme-model');
$clienteModelo       = $this->load_model('cliente/cliente-model');
$userModelo          = $this->load_model('usuario/usuario-model');

//if($_SESSION['userdata']['cliente'] > ){
if(3 > 4){
    $clienteLogo     = $clienteModelo->carregarLogoCliente($_SESSION['userdata']['cliente']);
}else{
    $clienteLogo     = null;
}

$userAvatar          = $userModelo->carregarUserAvatar($_SESSION['userdata']['userId']);

//var_dump($clienteLogo,$userAvatar);

//VERIFICA SE ENCONTRA A IMAGEM DE AVATAR
$fileExiste = fileExists(HOME_URI."/views/_uploads/users/".$userAvatar['imagem_usuario']);

function fileExists($path){
    return (@fopen($path,"r")==true);
}

/*
* VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
*/
// switch ($_SESSION['userdata']['tipo_usu']) {
//     case 'Administrador':
//         //var_dump($_SESSION);
//
//         $notificacaoAlertas = $alarmeModeloStatus->recuperaNotificacoesAlarmes();
//
//     break;
//
//     case 'Cliente':
//
//
//         $notificacaoAlertas = $alarmeModeloStatus->recuperaNotificacoesAlarmesCliente($_SESSION['userdata']['cliente']);
//
//     break;
//
//     case 'Visitante':
//
//
//         $notificacaoAlertas = $alarmeModeloStatus->recuperaNotificacoesAlarmesCliente($_SESSION['userdata']['cliente']);
//     break;
//
//     case 'Tecnico':
//         $notificacaoAlertas = $alarmeModeloStatus->recuperaNotificacoesAlarmes();
//
//     break;
// }

// if($notificacaoAlertas['status']){
//     /* CARREGA TOTAL DE NOTIFICACAO */
//     //$t_not = sizeof($dadosNot);
//
//     /* NO LUGAR DE NOTIFICAÇÃO, ESTÁ SENDO COLOCADO, AS NOTIFICAÇÕES DE ALARMES */
//     $t_not      = sizeof($notificacaoAlertas['alarmes']);
//     $dadosNot   = $notificacaoAlertas['alarmes'];
//
// }else {
//     $t_not      = 0;
//     $dadosNot   = null;
// }

?>


   <div id="wrapper" style="min-height:560px;">

      <!-- Navigation -->
      <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div id="logoNavBar">
              <a href="<?php echo HOME_URI; ?>/home/"><img src="<?php echo HOME_URI; ?>/views/_images/logo-eficaz-system_small.png" class="img-responsive"></a>
            </div>

        </div>
        <!-- <div>
            <img src="<?php echo HOME_URI; ?>/views/_images/logo-eficaz-system.png" class="img-responsive" alt="Responsive image">
        </div> -->
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- TOTAL DE ALERTAS, SE EXISTIREM -->
            <li class="dropdown">
              <!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#"> -->
                <!-- <i class="fa fa-exclamation-triangle fa-1x"></i> <i class="fa fa-caret-down fa-1x"></i> -->
                <!-- <i class="fa fa-question-circle fa-1x"></i> <i class="fa fa-caret-down fa-1x"></i> -->

              <!-- </a> -->
              <a class="dropdown-toggle" data-toggle="dropdown" href="">
                  <!-- <i class="fa fa-user fa-1x"></i> -->
                  <?php
                      if(isset($_SESSION['userdata']['cliente']) && ($_SESSION['userdata']['cliente'] > 0) && ($clienteLogo[0]['foto'] != '')){
                      ?>
                          <!-- <img class="img-rounded" src="<?php //echo HOME_URI ?>/views/_uploads/clients/<?php //echo $clienteLogo[0]['foto']; ?>" width="64" height="32"/> -->
                      <?php
                      }else{
                      ?>
                          <!-- <i class="fa fa-building-o fa-1x"></i> -->
                      <?php
                      }
                  ?>

                  <!-- <i class="fa fa-caret-down fa-1x"></i> -->
              </a>
              <!-- <ul class="dropdown-menu dropdown-user"> -->
                  <!-- <li><span id="btn_sair"><a href="javascript:void(0)"><i class="fa fa-book fa-1x"></i> Ajuda</a></span></li>  -->
              <!-- </ul> -->
              <?php

                // IMPLEMENTAVA O CONTADOR DE ALARMES
                // SEGUNDO O ALLAN, SERIA ANBIGUO
                // if ($t_not != 0){
                //     echo "<span id='contadorNot'>{$t_not}</span>";
                // }else{
                //     echo "<span id='contadorNot' style='display:none;'>{$t_not}</span>";
                // }

              ?>
              <!-- <ul id="listaMenuAlarmes" class="dropdown-menu dropdown-messages"> -->
                <?php

                    //VERIFICA SE EXISTE E EH UM ARRAY
                    //  if(isset($dadosNot))
                    //  {
                    //     foreach ($dadosNot as $novoAlerta) {
                            ?>

                            <!-- <li>
                                <a href="<?php //echo HOME_URI ?>/home/">
                                    <div>
                                        <strong><?php //echo $novoAlerta['nome']; ?></strong>
                                    </div>
                                    <div>
                                       <?php //echo $novoAlerta['mensagem']; ?>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li> -->
                            <?php
                    //     }
                    //
                    // }else{
                        ?>
                        <!-- <li>
                            <div>
                                <strong>Nenhum alarme</strong>
                            </div>
                            <div>
                               Não há novos alarmes registrados.
                            </div>
                        </li> -->
                        <?php
                    //}

                    // verifica se existe e eh um array
                    // if (!empty($dadosNot) && is_array($dadosNot))
                    // {
                    //   // monta a estrutura
                    //   foreach ($dadosNot as $resul)
                    //   {
                    //     // inicia a lista de notificacao
                    //     echo "<li class=''>";
                    //     // verifica se eh um vinculo
                    //     if ($resul['modo'] == "vinculo")
                    //     {
                    //       // monta link do parametro
                    //       $paramlink = base64_encode($resul['id']."/".$resul['sim']);
                    //       // verifica o tipo, se eh um equipamento ou ambiente
                    //       if ($resul['tipo'] == "e")
                    //       {
                    //         // para equipamento
                    //         echo "<div class=''><strong>Vincular tabela ao equipamento</strong></div><br>";
                    //         echo "<strong>Cliente </strong> " .  $resul['nome'] . "<br>";
                    //         echo "<p><strong>Equipamento</strong> " . $resul['nome_equip'] . "</p>";
                    //         echo "<p><a href='".HOME_URI."/vinculo/vincularposicao/{$paramlink}'><i class='fa fa-link'></i> Clique aqui para vincular</a></p>";
                    //         echo "";
                    //       }
                    //       else if ($resul['tipo'] == "a")
                    //       {
                    //         // para ambiente
                    //           echo "<div class='notificacao-titulo'><strong>Vincular tabela ao ambiente</strong></div><br>";
                    //           echo "<strong>Cliente </strong> " .  $resul['nome'] . "<br>";
                    //           echo "<p><strong>Ambiente </strong>". $resul['nome_amb'] . "</p>";
                    //           echo "<p><a href='".HOME_URI."/vinculo/vincularposicao/{$paramlink}'><i class='fa fa-link'></i> Clique aqui para vincular</a></p>";
                    //       }
                    //     }
                    //       echo "</li>";
                    //        echo "<li class='divider'></li>";
                    //   }
                    // }
                    // else
                    // echo "<li>Nenhuma notifica&ccedil;&atilde;o</li>";
                ?>
              <!-- </ul> -->
              <!-- /.dropdown-messages -->
            </li>
            <!-- PESQUISAR -->
            <!-- <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa  fa-cogs fa-fw"></i> <i class="fa fa-caret-down"></i>
              </a> -->
              <!-- <ul class="dropdown-menu dropdown-tasks">
                <li><a href="<?php echo HOME_URI; ?>/pesquisar/clientecadastrado" class="link-menuCadastro">
                  <i class="fa fa-university fa-lg"></i>&nbsp;&nbsp;Cliente Cadastrado</a></li>
                <li><a href="<?php echo HOME_URI; ?>/pesquisar/filialcadastrado" class="link-menuCadastro">
                  <i class="fa fa-building-o fa-lg"></i>&nbsp;&nbsp;Filial Cadastro</a></li>
                <li><a href="<?php echo HOME_URI; ?>/pesquisar/fabricantecadastrado" class="link-menuCadastro">
                  <i class="fa fa-gavel fa-lg"></i>&nbsp;&nbsp;Fabricante Cadastrado</a></li>
                <li><a href="<?php echo HOME_URI; ?>/pesquisar/equipamentocadastrado" class="link-menuCadastro">
                  <i class="fa fa-hdd-o fa-lg"></i>&nbsp;&nbsp;Equipamento Cadastrado</a></li>
              </ul> -->
              <!-- /.dropdown-tasks -->
            <!-- </li> -->
            <!-- BOTAO VISUALIZAR DADOS DO USUÁRIO -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="">
                    <!-- <i class="fa fa-user fa-1x"></i> -->
                    <?php

                        if($fileExiste){
                        ?>
                            <img class="img-circle" src="<?php echo HOME_URI."/views/_uploads/users/".$userAvatar['imagem_usuario']; ?>" width="32" height="32"/>
                        <?php
                        }else{
                        ?>
                            <i class="fa fa-user fa-1x"></i>
                        <?php
                        }
                    ?>

                    <i class="fa fa-caret-down fa-1x"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                <li>
                    <span id="btn_sair">

                        <a href="<?php echo HOME_URI; ?>/usuario/"><i class="fa fa-user fa-1x"></i> Perfil do usuário</a>
                    </span>
                </li><!-- Fim Botao Sair -->
                </ul>
            </li>
            <!-- BOTAO SAIR -->
            <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="">
                        <i class="fa fa-power-off fa-2x"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><span id="btn_sair"><a href="<?php echo HOME_URI; ?>/login/sair"><i class="fa fa-power-off fa-1x"></i> Sair do sistema!</a></span></li><!-- Fim Botao Sair -->
                    </ul>
                    <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="menuPrincipalGeral navbar-default sidebar " role="navigation">
          <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <!-- HOME -->
                <li>
                  <a href="<?php echo HOME_URI; ?>/home/" data-toggle="">
                      <i class="fa fa-desktop fa-3x"></i> <span class="lb-side"> Tela de monitoramento</span><span class="fa arrow"></span>
                  </a>
                  <ul class="nav nav-second-level collapse in">
                      <li>
                          <!-- Cadastro de clientes -->
                          <a href="<?php echo HOME_URI; ?>/home/" class="">
                            <i class="fa fa-laptop  fa-1x"></i>
                            <span class="icon-side"></span>
                            <spam>Alarmes gerados</span>
                          </a>
                      </li>
                  </ul>
                </li>
                <!-- CADASTRO -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                  <li>
                    <a href="" class="menuCadastro" data-toggle="">
                      <i class="fa fa-download fa-3x"></i> <span class="lb-side">Cadastrar</span><span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse in">
                      <li>
                          <!-- Cadastro de clientes -->
                          <a href="<?php echo HOME_URI; ?>/cliente" class="">
                            <i class="fa fa-university fa-1x"></i>
                            <span class="icon-side"></span>
                            <spam>Clientes</span>
                          </a>
                      </li>
                      <!-- <li> -->
                        <!-- Cadastro de filiais -->
                       <!--  <a href="<?php echo HOME_URI; ?>/filial" class="">
                          <i class="fa fa-building-o fa-1x"></i>
                          <span class="icon-side"></span>
                          <spam>Filiais</span>
                        </a> -->
                  <!--     </li> -->
                        <li>
                        <!-- Cadastro Fabricantes -->
                          <a href="<?php echo HOME_URI; ?>/fabricante" class="">
                            <i class="fa fa-building fa-1x"></i>
                            <span class="icon-side"></span>
                            <spam>Fabricantes</span>
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo HOME_URI; ?>/equipamento" class="">
                            <i class="fa fa-hdd-o fa-1x"></i>
                            <span class="icon-side"></span>
                            <spam>Equipamentos</span>
                          </a>
                        </li>
                        <!-- <li>
                            <a href="">/alarme" class="">
                              <i class="fa fa-volume-up fa-1x"></i>
                              <span class="icon-side"></span>
                              <spam>Alarmes</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="<?php //echo HOME_URI; ?>/configuracao/configuracoesSistema" class="">
                              <i class="fa fa-gear fa-1x"></i>
                              <span class="icon-side"></span>
                              <spam>Configurações</span>
                            </a>
                        </li> -->
                        <li>
                            <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarChips" class="">
                              <i class="fa fa-credit-card fa-1x"></i>
                              <span class="icon-side"></span>
                              <spam>Gerenciar SIM</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarPlantaBaixa" class="">
                              <i class="fa fa-trello fa-1x"></i>
                              <span class="icon-side"></span>
                              <spam>Gerenciar planta baixa</span>
                            </a>
                        </li>
                       </ul>
                      <!-- /.nav-second-level -->
                  </li>
                <?php } ?>
                <!-- ANTIGO BI-GRAFI, ATUAL MONITORAR -->
                <?php if (isset($_SESSION['userdata']['local']) && $_SESSION['userdata']['per_mo'] == 1) { ?>
                <li>
                    <a class="link-side" href="<?php echo HOME_URI; ?>/monitoramento/">
                      <span class="icon-side"><i class="fa fa-tachometer fa-3x"></i></span>
                      <span class="lb-side">Monitorar</span>
                      <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse in">
                        <li>
                            <a href="<?php echo HOME_URI; ?>/monitoramento/"><i class="fa fa-tachometer fa-1x"></i><span> Monitorar</span></a>
                        </li>
                        <li>
                            <a href="<?php echo HOME_URI; ?>/monitoramento/equipamentoPlantaBaixa"><i class="fa fa-instagram fa-1x"></i><span> Monitorar planta baixa</span></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <!-- ANTIGO GRAFICO, ATUAL RELATORIO -->
                <?php if(isset($_SESSION['userdata']['local']) && $_SESSION['userdata']['per_pe'] == 1) { ?>
                <li>
                  <a class="link-side" href="#">
                    <span class="icon-side"><i class="fa fa-area-chart fa-3x"></i></span>
                    <span class="lb-side">Relatórios</span>
                    <span class="fa arrow"></span>
                  </a>
                  <ul class="nav nav-second-level collapse in">
                      <li>
                          <a href="<?php echo HOME_URI; ?>/grafico/"><i class="fa fa-area-chart fa-1x"></i><span> Relatório gráfico</span></a>
                      </li>
                      <li>
                          <a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoGerador"><i class="fa fa-clipboard fa-1x"></i> Relatório de equiapamentos</a>
                      </li>
                      <li>
                           <a href="<?php echo HOME_URI; ?>/grafico/graficoTratamentoAlarme"><i class="fa fa-volume-up fa-1x"></i> Relatório de alarmes</a>
                      </li>
                  </ul>
                </li>
                <?php } ?>
                <!-- ALARMES -->
                <li>
                    <a class="link-side" href="#">
                      <span class="icon-side"><i class="fa fa-envelope-o fa-3x"></i></span>
                      <span class="lb-side">Recebimento alarmes</span>
                      <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse in">
                        <li>
                             <a href="<?php echo HOME_URI; ?>/alarme/"><i class="fa fa-fax fa-1x"></i> <span class="lb-side"> Envio por locais</span></a>
                        </li>
                        <li>
                             <a href="<?php echo HOME_URI; ?>/alarme/alarmePorEquipamento"><i class="fa fa-crosshairs fa-1x"></i> <span class="lb-side">Envio por equipamento</span></a>
                        </li>
                    </ul>


                </li>

                <!-- CLIENTES -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                    <!-- <li>
                        <a href="<?php echo HOME_URI; ?>/cliente" class="">
                          <i class="fa fa-university fa-3x"></i>
                          <span class="icon-side"></span>
                          <spam>Clientes</span>
                        </a>
                    </li> -->
                <?php } ?>
                <!-- FABRICANTE -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                    <!-- <li>
                        <a href="<?php echo HOME_URI; ?>/fabricante" class="">
                          <i class="fa fa-building fa-3x"></i>
                          <span class="icon-side"></span>
                          <spam>Fabricantes</span>
                        </a>
                    </li> -->
                <?php } ?>
                <!-- FILIAL -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                    <!-- <li>
                        <a href="<?php echo HOME_URI; ?>/filial" class="">
                          <i class="fa fa-building-o fa-3x"></i>
                          <span class="icon-side"></span>
                          <spam>Filiais</span>
                        </a>
                    </li> -->
                <?php } ?>
                <!-- EQUIPAMENTO -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                    <!-- <li>
                        <a href="<?php echo HOME_URI; ?>/equipamento" class="">
                          <i class="fa fa-hdd-o fa-3x"></i>
                          <span class="icon-side"></span>
                          <spam>Equipamentos</span>
                        </a>
                    </li> -->
                <?php } ?>

                <!-- VINCULO -->
                <?php //if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                <!-- <li>
                  <a href="<?php //echo HOME_URI; ?>/vinculo/">
                    <i class="fa fa-link fa-3x"></i>
                    <span class="icon-side"></span>
                    <span class="lb-side">Vinculo</span>
                  </a>
                </li> -->
                <?php //} ?>

                <!-- OCULTANDO O MENU DE CONFIGURAÇÔES POR ESTAR DEFAZADO COM RELAÇÂO AS ATUALIZAÇÔES QUE FORAM FEITAS ATÈ O MOMENTO-->
                <!-- CONFIGURACAO -->
                <?php //if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_co'] == 1) { ?>
                <!-- <li>
                  <a class="link-side" href="<?php //echo HOME_URI; ?>/configuracao/">
                    <span class="icon-side"><i class="fa fa-cogs fa-3x"></i></span>
                    <span class="lb-side">Configura&ccedil;&atilde;o</span>
                  </a>
                </li> -->
                <?php //} ?>

                <!-- USUÁRIOS -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_pe'] == 1) { ?>
                    <li>
                        <a href="<?php echo HOME_URI; ?>/usuario/listar" class="">
                            <i class="fa fa-users fa-3x"></i>
                            <span class="icon-side"></span>
                            <spam>Usuários</span>
                            <span class="fa arrow"></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
          </div>
          <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->

      </nav>

      <script type="application/javascript">

       /*
       * Efetua a atualização do contador de alarmes a cada periodo de tempo
       */

       /*
        FUNÇÃO DE CONTADOR DE ALARMES NO MENU FOI DESATIVADO
       */


        //   var dotValue = $('#contadorNot').html();
          //
        //   setInterval(function(){
        //     var url = "<?php //echo HOME_URI; ?>/alarme/verificaNovoAlarme?clie=<?php //echo $_SESSION['userdata']['cliente']; ?>&total="+dotValue;
        //     $.getJSON(url,  function(data) {
          //
        //         if(data.status){
          //
        //             //NOVA CONTAGEM
        //             $('#contadorNot').html(data.contagem);
        //             //NOVA LISTA DE ALARMES
        //             $('#listaMenuAlarmes').html();
        //             $('#listaMenuAlarmes').html(data.alarmes);
          //
        //             //exit(json_encode(array('status' => $statusContagem, 'contagem' => $totalAlarmes, 'alarmes' => $alarmesNovos)));
          //
        //         }else{
        //             console.log('prossiga!');
        //         }
        //     });

            //   dotValue++;
            //   $('#contadorNot').html(dotValue);

        //   },5000);

      </script>

      <div id="page-wrapper" >
          <!-- DIV CONTENDO A LOCALIZAÇÃO ATUAL DO USUÁRIO NO SISTEMA -->
          <div class="row">
              <div id="listadir" class="col-lg-12 page-header">
              </div>
          </div>
