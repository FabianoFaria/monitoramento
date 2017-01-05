<?php
/* carrega dados */
$dadosNot = $modelo->notificacao();
if ($dadosNot)
    /* carrega total de notificacao */
    $t_not = sizeof($dadosNot);
else
    $t_not = 0;

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
              <a href="<?php echo HOME_URI; ?>/home/"><img src="<?php echo HOME_URI; ?>/views/_images/logos.png" class="imgLogoBarra"></a>
            </div>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- TOTAL DE ALERTAS, SE EXISTIREM -->
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-exclamation-triangle fa-fw"></i> <i class="fa fa-caret-down"></i>
              </a>
              <?php
                if ($t_not != 0)
                echo "<span id='contadorNot'>{$t_not}</span>";
              ?>
              <ul class="dropdown-menu dropdown-messages">
                <?php
                    // verifica se existe e eh um array
                    if (!empty($dadosNot) && is_array($dadosNot))
                    {
                      // monta a estrutura
                      foreach ($dadosNot as $resul)
                      {
                        // inicia a lista de notificacao
                        echo "<li class=''>";
                        // verifica se eh um vinculo
                        if ($resul['modo'] == "vinculo")
                        {
                          // monta link do parametro
                          $paramlink = base64_encode($resul['id']."/".$resul['sim']);
                          // verifica o tipo, se eh um equipamento ou ambiente
                          if ($resul['tipo'] == "e")
                          {
                            // para equipamento
                            echo "<div class=''><strong>Vincular tabela ao equipamento</strong></div><br>";
                            echo "<strong>Cliente </strong> " .  $resul['nome'] . "<br>";
                            echo "<p><strong>Equipamento</strong> " . $resul['nome_equip'] . "</p>";
                            echo "<p><a href='".HOME_URI."/vinculo/vincularposicao/{$paramlink}'><i class='fa fa-link'></i> Clique aqui para vincular</a></p>";
                            echo "";
                          }
                          else if ($resul['tipo'] == "a")
                          {
                            // para ambiente
                              echo "<div class='notificacao-titulo'><strong>Vincular tabela ao ambiente</strong></div><br>";
                              echo "<strong>Cliente </strong> " .  $resul['nome'] . "<br>";
                              echo "<p><strong>Ambiente </strong>". $resul['nome_amb'] . "</p>";
                              echo "<p><a href='".HOME_URI."/vinculo/vincularposicao/{$paramlink}'><i class='fa fa-link'></i> Clique aqui para vincular</a></p>";
                          }
                        }
                          echo "</li>";
                           echo "<li class='divider'></li>";
                      }
                    }
                    else
                    echo "<li>Nenhuma notifica&ccedil;&atilde;o</li>";
                ?>
              </ul>
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
                    <i class="fa fa-user fa-fw"></i>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                <li><span id="btn_sair"><a href="<?php echo HOME_URI; ?>/usuario/"><i class="fa fa-folder-open fa-fw"></i>Perfil do usuário</a></span></li><!-- Fim Botao Sair -->
                </ul>
            </li>
            <!-- BOTAO SAIR -->
            <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="">
                        <i class="fa fa-power-off fa-fw"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><span id="btn_sair"><a href="<?php echo HOME_URI; ?>/login/sair"><i class="fa fa-power-off fa-fw"></i>Sair do sistema!</a></span></li><!-- Fim Botao Sair -->
                    </ul>
                    <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
          <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <!-- HOME -->
                <li>
                  <a href="<?php echo HOME_URI; ?>/home/"><i class="fa fa-home fa-3x"></i> <span class="lb-side">Painel inicial</span></a>
                </li>
                <!-- CADASTRO -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                  <li>
                    <a href="" class="menuCadastro" data-toggle="dropdown">
                      <i class="fa fa-plus fa-3x"></i> <span class="lb-side">Cadastrar</span><span class="fa arrow"></span>
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
                     <!--  <li> -->
                        <!-- Cadastro Fabricantes -->
                        <!--   <a href="<?php echo HOME_URI; ?>/fabricante" class="">
                            <i class="fa fa-building fa-1x"></i>
                            <span class="icon-side"></span>
                            <spam>Fabricantes</span>
                          </a> -->
                      <!--   </li> -->
                        <li>
                          <a href="<?php echo HOME_URI; ?>/equipamento" class="">
                            <i class="fa fa-hdd-o fa-1x"></i>
                            <span class="icon-side"></span>
                            <spam>Equipamentos</span>
                          </a>
                        </li>
                        <li>
                            <a href="<?php echo HOME_URI; ?>/alarme" class="">
                              <i class="fa fa-volume-up fa-1x"></i>
                              <span class="icon-side"></span>
                              <spam>Alarmes</span>
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
                    </a>
                </li>
                <?php } ?>
                <!-- ANTIGO GRAFICO, ATUAL RELATORIO -->
                <?php if(isset($_SESSION['userdata']['local']) && $_SESSION['userdata']['per_pe'] == 1) { ?>
                <li>
                  <a class="link-side" href="#">
                    <span class="icon-side"><i class="fa fa-area-chart fa-3x"></i></span>
                    <span class="lb-side">Relatório</span>
                     <span class="fa arrow"></span>
                  </a>
                  <ul class="nav nav-second-level">
                      <li>
                          <a href="<?php echo HOME_URI; ?>/grafico/"><i class="fa fa-area-chart fa-1x"></i><span> Relatorio gráfico</span></a>
                      </li>
                      <li>
                          <a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoGerador"><i class="fa fa-clipboard fa-1x"></i> Relatorio fisico</a>
                      </li>
                  </ul>
                </li>
                <?php } ?>
                <!-- ALARMES -->
                <!-- <li>
                  <a href="<?php //echo HOME_URI; ?>/alarme/"><i class="fa fa-volume-up fa-3x"></i> <span class="lb-side">Alarmes</span></a>
                </li> -->

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
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                <li>
                  <a href="<?php echo HOME_URI; ?>/vinculo/">
                    <i class="fa fa-link fa-3x"></i>
                    <span class="icon-side"></span>
                    <span class="lb-side">Vinculo</span>
                  </a>
                </li>
                <?php } ?>
                <!-- CONFIGURACAO -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_co'] == 1) { ?>
                <li>
                  <a class="link-side" href="<?php echo HOME_URI; ?>/configuracao/">
                    <span class="icon-side"><i class="fa fa-cogs fa-3x"></i></span>
                    <span class="lb-side">Configura&ccedil;&atilde;o</span>
                  </a>
                </li>
                <?php } ?>

                <!-- USUÁRIOS -->
                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                    <li>
                        <a href="<?php echo HOME_URI; ?>/usuario/listar" class="">
                          <i class="fa fa-users fa-3x"></i>
                          <span class="icon-side"></span>
                          <spam>Usuários</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
          </div>
          <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->

      </nav>

      <div id="page-wrapper" >
          <!-- DIV CONTENDO A LOCALIZAÇÃO ATUAL DO USUÁRIO NO SISTEMA -->
          <div class="row">
              <div id="listadir" class="col-lg-12 page-header">
              </div>
          </div>
