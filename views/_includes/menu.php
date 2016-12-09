<?php
/* carrega dados */
$dadosNot = $modelo->notificacao();
if ($dadosNot)
    /* carrega total de notificacao */
    $t_not = sizeof($dadosNot);
else
    $t_not = 0;
?>


    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
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

           <!-- MENU TOPO DIREITO -->
           <ul class="nav navbar-right top-nav navbar-top-links">
               <li id="btn_alertaNot" class="dropdown">
                   <i class="fa fa-exclamation-triangle fa-lg"></i>
                   <?php
                       if ($t_not != 0)
                           echo "<span id='contadorNot'>{$t_not}</span>";
                   ?>
                   <div id="div-notificacao">
                       <ul>
                           <?php
                               // verifica se existe e eh um array
                               if (!empty($dadosNot) && is_array($dadosNot))
                               {
                                   // monta a estrutura
                                   foreach ($dadosNot as $resul)
                                   {
                                       // inicia a lista de notificacao
                                       echo "<li>";
                                       // verifica se eh um vinculo
                                       if ($resul['modo'] == "vinculo")
                                       {
                                           // monta link do parametro
                                           $paramlink = base64_encode($resul['id']."/".$resul['sim']);
                                           // verifica o tipo, se eh um equipamento ou ambiente
                                           if ($resul['tipo'] == "e")
                                           {
                                                   // para equipamento
                                                   echo "<span class='notificacao-titulo'>Vincular tabela ao equipamento</span><br>";
                                                   echo "Cliente " .  $resul['nome'] . "<br>";
                                                   echo "Equipamento " . $resul['nome_equip'] . "<br>";
                                                   echo "<a href='".HOME_URI."/vinculo/vincularposicao/{$paramlink}'><i class='fa fa-link'></i> Clique aqui para vincular</a>";
                                           }
                                           else if ($resul['tipo'] == "a")
                                           {
                                               // para ambiente
                                               echo "<span class='notificacao-titulo'>Vincular tabela ao ambiente</span><br>";
                                               echo "Cliente " .  $resul['nome'] . "<br>";
                                               echo "Ambiente ". $resul['nome_amb'] . "<br>";
                                               echo "<a href='".HOME_URI."/vinculo/vincularposicao/{$paramlink}'><i class='fa fa-link'></i> Clique aqui para vincular</a>";
                                           }
                                       }
                                       echo "</li>";
                                   }
                               }
                               else
                                   echo "<li>Nenhuma notifica&ccedil;&atilde;o</li>";
                           ?>
                       </ul>
                   </div>
               </li> <!-- FIM BOTAO DE NOTIFICACAO -->
               <!-- PESQUISAR -->
               <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_pe'] == 1) { ?>
               <li id="btn_showConf">
                   <a href="#" class="menuSuperiorOpcao2">
                       <i class="fa fa-cog fa-lg"></i><b class="caret"></b>
                   </a>
                       <div id="menuCadastro">
                           <ul class="ul-menuCadastro">
                               <li><a href="<?php echo HOME_URI; ?>/pesquisar/clientecadastrado" class="link-menuCadastro">
                                   <i class="fa fa-university fa-lg"></i>&nbsp;&nbsp;Cliente Cadastrado</a></li>
                               <li><a href="<?php echo HOME_URI; ?>/pesquisar/filialcadastrado" class="link-menuCadastro">
                                   <i class="fa fa-building-o fa-lg"></i>&nbsp;&nbsp;Filial Cadastro</a></li>
                               <li><a href="<?php echo HOME_URI; ?>/pesquisar/fabricantecadastrado" class="link-menuCadastro">
                                   <i class="fa fa-gavel fa-lg"></i>&nbsp;&nbsp;Fabricante Cadastrado</a></li>
                               <li><a href="<?php echo HOME_URI; ?>/pesquisar/equipamentocadastrado" class="link-menuCadastro">
                                   <i class="fa fa-hdd-o fa-lg"></i>&nbsp;&nbsp;Equipamento Cadastrado</a></li>
                           </ul>
                       </div>
               </li><!-- Fim do pesquisar -->
               <?php }?>
               <!-- BOTAO SAIR -->
               <li id="btn_logout">
                   <a href="<?php echo HOME_URI; ?>/login/sair" class="menuSuperiorOpcao2"><i class="fa fa-power-off fa-lg"></i></a>
               </li><span id="btn_sair">Sair do sistema!</span><!-- Fim Botao Sair -->
           </ul>
            <!-- /.navbar-top-links -->

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav navbar-nav side-nav">
                    <!-- Home -->
                    <li>
                        <a class="link-side" href="<?php echo HOME_URI; ?>/home/">
                            <span class="icon-side"><i class="fa fa-home fa-lg"></i></span>
                            <span class="lb-side">Monitorar</span>
                        </a>
                    </li>
                    <!-- Fim Home -->
                    <!-- Cadastro -->
                    <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                        <li>
                            <a class="link-side" href="<?php echo HOME_URI; ?>/cadastrar/">
                                <span class="icon-side"><i class="fa fa-plus fa-lg"></i></span>
                                <span class="lb-side">Cadastrar</span>
                            </a>
                        </li><!-- Fim Cadastro -->
                    <?php } ?>
                    <!-- Vinculo -->
                    <?php
                    if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_vi'] == 1) { ?>
                        <li>
                            <a class="link-side" href="<?php echo HOME_URI; ?>/vinculo/">
                                <span class="icon-side"><i class="fa fa-link"></i></span>
                                <span class="lb-side">Vinculo</span>
                            </a>
                        </li><!-- Fim Vinculo -->
                    <?php } ?>
                    <!-- Configuracao -->
                    <?php
                    if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_co'] == 1) { ?>
                        <li>
                            <a class="link-side" href="<?php echo HOME_URI; ?>/configuracao/">
                                <span class="icon-side"><i class="fa fa-cogs fa-lg"></i></span>
                                <span class="lb-side">Configura&ccedil;&atilde;o</span>
                            </a>
                        </li><!-- Fim Configuracao -->
                    <?php } ?>
                    <!-- Bi-Grafi -->
                    <?php
                    if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_mo'] == 1) { ?>
                        <li>
                            <a class="link-side" href="<?php echo HOME_URI; ?>/monitoramento/">
                                <span class="icon-side"><i class="fa fa-tachometer fa-lg"></i></span>
                                <span class="lb-side">Bi-grafi</span>
                            </a>
                        </li><!-- fim Bi-Grafi -->

                    <?php } ?>
                    <!-- Grafico -->
                    <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_mo'] == 1) { ?>
                        <li>
                            <a class="link-side" href="<?php echo HOME_URI; ?>/grafico/">
                                <span class="icon-side"><i class="fa fa-area-chart fa-lg"></i></span>
                                <span class="lb-side">Gr&aacute;fico</span>
                            </a>
                        </li><!-- fim Grafico -->
                    <?php } ?>
                    <!-- Dados do usuário  -->

                    <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_mo'] == 1){ ?>
                        <li>
                            <a class="link-side" href="<?php echo HOME_URI; ?>/usuario/">
                              <span class="icon-side"><i class="fa fa-user fa-lg"></i></span>
                              <span class="lb-side">Dados usuário</span>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <div id="page-wrapper" style="min-height: 186px;">
