<nav class="navbar navbar-default navbar-static-top menuSuperior">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <a class="navbar-brand" href="<?php echo HOME_URI; ?>/home/">
                <!--<img src="<?php echo HOME_URI; ?>/views/_images/logo_br.png" class="imgLogoBarra"></a>-->
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- Home -->
                <li>
                    <a href="<?php echo HOME_URI; ?>/home/" class="menuSuperiorOpcao">
                        <span aria-hidden="true" class="icon_house"></span> Home</a>
                </li><!-- Fim do home -->

                <?php if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_ca'] == 1) { ?>
                <!-- Cadastrar -->
                <li>
                    <a href="<?php echo HOME_URI; ?>/cadastrar/" class="menuSuperiorOpcao">
                        <span aria-hidden="true" class="icon_pencil-edit"></span><span> Cadastrar</span></a>
                </li><!-- Fim do cadastrar -->

                <?php } if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_pe'] == 1) { ?>

                <!-- Pesquisar -->
                <li><a href="<?php echo HOME_URI; ?>/pesquisar/" class="menuSuperiorOpcao">
                    <span aria-hidden="true" class="icon_search"></span><span> Pesquisar</span></a>
                </li><!-- Fim do pesquisar -->

                <?php } if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_vi'] == 1) { ?>

                <!-- Equipamento -->
                <li><a href="<?php echo HOME_URI; ?>/equipamento/" class="menuSuperiorOpcao">
                    <span aria-hidden="true" class="icon_key_alt"></span><span> Vinculos</span></a>
                </li><!-- Fim do equipamento -->

                <?php } if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_co'] == 1) { ?>

                <!-- Configuracoes -->
                <li>
                    <a href="<?php echo HOME_URI; ?>/configuracao/" class="menuSuperiorOpcao">
                        <span aria-hidden="true" class="icon_adjust-horiz"></span><span> Configura&ccedil;&otilde;es</span></a>
                </li><!-- Fim do configuracoes -->

                <?php } if ($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_mo'] == 1) { ?>

                <!-- monitoramento -->
                <li>
                    <a href="<?php echo HOME_URI; ?>/monitoramento/" class="menuSuperiorOpcao">
                        <span aria-hidden="true" class="icon_datareport"></span><span> Monitoramento</span></a>
                </li><!-- Fim do monitoramento -->

                <?php } if($_SESSION['userdata']['local'] == 1 && $_SESSION['userdata']['per_mo'] == 1) { ?>

                <!-- editar dados usuários -->
                <li>

                    <a href="<?php echo HOME_URI; ?>/usuario/" class="menuSuperiorOpcao">
                        <span aria-hidden="true" class="icon_datareport"> </span><span> Dados usuário</span>
                    </a>

                </li>  Fim do dados do usuário


                <?php } ?>
            </ul>
        <ul class="nav navbar-nav navbar-right">

            <!-- Sair -->
            <li>
                <a href="<?php echo HOME_URI; ?>/login/sair" class="menuSuperiorOpcao">
                    <span aria-hidden="true" class="icon_lock_alt"></span><span> Sair</span>
                </a>
            </li><!-- Fim do sair -->
        </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
