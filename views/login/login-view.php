<!doctype html>

<?php
    if (! defined('EFIPATH')) exit;
?>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Eficaz System - Monitoramento | Login Monitor</title>
        <!-- Font files -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

        <!-- Bootstrap -->
        <link href="<?php echo HOME_URI; ?>/views/_css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo HOME_URI; ?>/views/_css/bootstrap-reset.css" rel="stylesheet" type="text/css">
        <!-- CSS files -->
        <link rel="stylesheet" href="<?php echo HOME_URI; ?>/views/_css/login.css">

        <!-- Jquery file -->
        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.js"></script>
        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.mask.js"></script>
        <script src="<?php echo HOME_URI; ?>/views/_js/bootstrap.min.js"> </script>

    </head>

    <body>

        <!-- Condição para verificar se está sendo efetuado uma atualização de senha ou uma tentativa de login -->
        <?php

            if (isset($this->pedidoSenha_info) && ($this->pedidoSenha_error == "_"))
            {
        ?>
            <div class="container">
                <div class="imgLogin"><img src="<?php echo HOME_URI; ?>/views/_images/logo.png"></div>

                <div class="campoForm">
                    <form method="post" action="<?php echo HOME_URI; ?>/login/validarNovaSenha">

                        <h3 class="esquecisenha">Recuperação de senha</h3>

                        <input type="hidden" name="usuarioIdenctificado" value="<?php echo $this->pedidoSenha_info; ?>">
                        <input type="hidden" name="token" value="<?php echo $this->pedidoSenha_token; ?>">
                        <p><input type="password" name="novaSenha" placeholder="Nova senha" class="txt_form" required></p>
                        <p><input type="password" name="confirmarNovaSenha" placeholder="Confirma nova senha" class="txt_form" required></p>
                        <p><input type="submit" name="btnEnviarSenha" value="Atualizar nova senha" class="btn_form"></p>
                    </form>
                </div>
                <p><a href="<?php echo HOME_URI; ?>" target="_self" class="esquecisenha" data-toggle="" data-target=""> Cancelar </a></p>

                <!-- class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" -->

            </div>

        <?php
            }
            else{
        ?>



            <div class="container">
                <div class="imgLogin"><img src="<?php echo HOME_URI; ?>/views/_images/logo.png"></div>

                <div class="campoForm">
                    <form method="post">
                        <p><input type="text" name="userdata[user]" placeholder="USU&Aacute;RIO" class="txt_form"></p>
                        <p><input type="password" name="userdata[userpass]" placeholder="SENHA" class="txt_form"></p>
                        <p><input type="submit" name="btnenviar" value="ENTRAR" class="btn_form"></p>
                    </form>
                </div>
                <p><a href="" class="esquecisenha" data-toggle="modal" data-target="#myModal"> Esqueci a senha ?</a></p>

                <!-- class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" -->

            </div>

            <!-- modal para recuperação de email -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Formulario de envio de email para recuperação de senha -->
                    <form method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" style="text-align:center;">Informe seu email para recuperação de senha!</h4>
                        </div>
                        <div class="modal-body" style="background-color:#cccccc;">
                            <div class="campoForm">
                                <p><input type="text" name="userEmail" placeholder="Endereço de email" class="txt_form"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" name="solicitarSenha">Enviar email</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>


            <?php
                if (isset($_POST['btnenviar']))
                {
                    if (isset($this->login_error))
                    {
                        echo "<div class='div-respostaLogin'><span>{$this->login_error}</span></div>";
                    }
                }

                //Para recuperação de senha
                if(isset($_POST['solicitarSenha']))
                {
                    //var_dump($this->solicitacao_email);

                    //Caso o email não tenha sido encontrado.
                    if ($this->login_error != "")
                    {
                        echo "<div class='div-respostaLogin'><span>{$this->login_error}</span></div>";
                    }elseif (isset($this->login_info))
                    {
                        echo "<div class='div-solicitacoSenha'><span>{$this->login_info}</span></div>";
                    }
                }
            ?>

        <?php
            }
        ?>

    </body>
</html>
