
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
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

        <!-- Bootstrap -->
        <link href="<?php echo HOME_URI; ?>/views/_css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo HOME_URI; ?>/views/_css/bootstrap-reset.css" rel="stylesheet" type="text/css">
        <!-- CSS files -->
        <link rel="stylesheet" href="<?php echo HOME_URI; ?>/views/_css/login.css">

        <!-- Jquery file -->
        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.js"></script>
        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.mask.js"></script>
        <script src="<?php echo HOME_URI; ?>/views/_js/bootstrap.min.js"> </script>
        <script src="<?php echo HOME_URI; ?>/views/_js/jquery.validate.js"></script>

        <script>

            $().ready(function() {

                /*
                * VERIFICA SE SENHAS ESTÃO IGUAIS
                */

                $('#btnEnviarSenha').click(function(){

                    $('#solicitacaoNovaSenha').validate({

                        rules: {
                            novaSenha : {
                                required : true
                            },
                            confirmarNovaSenha : {
                                required : true,
                                equalTo : "#novaSenha"
                            },
                        },
                        messages: {
                            novaSenha : {
                                required : "Campo obrigatório!"
                            },
                            confirmarNovaSenha : {
                                required : "Campo obrigatório!",
                                equalTo : "Senhas devem ser iguais"
                            }
                        }

                    });

                    if($('#solicitacaoNovaSenha').valid()){
                        $('#solicitacaoNovaSenha').submit();
                    }

                });


            });


        </script>

    </head>

    <!-- FAVICON -->
    <link rel="shortcut icon" href="<?php echo HOME_URI; ?>/views/_images/favicon2.ico">
    <link rel="apple-touch-icon" href="<?php echo HOME_URI; ?>/views/_images/apple-icon.png">

    <body>

        <!-- Condição para verificar se está sendo efetuado uma atualização de senha ou uma tentativa de login -->
        <?php

            if (isset($this->pedidoSenha_info) && ($this->pedidoSenha_error == "_"))
            {
        ?>
            <div class="site-wrapper-inner">

                <div class="cover-container">

                    <div class="container">

                        <div class="imgLogin"><img src="<?php echo HOME_URI; ?>/views/_images/logo.png"></div>

                        <div class="campoForm">
                            <form id="solicitacaoNovaSenha" method="post" action="<?php echo HOME_URI; ?>/login/validarNovaSenha">

                                <h3 class="esquecisenha">Recuperação de senha</h3>

                                <input type="hidden" name="usuarioIdenctificado" value="<?php echo $this->pedidoSenha_info; ?>">
                                <input type="hidden" name="token" value="<?php echo $this->pedidoSenha_token; ?>">
                                <p><input type="password" id="novaSenha" name="novaSenha" placeholder="Nova senha" class="txt_form" required></p>
                                <p><input type="password" id="confirmarNovaSenha" name="confirmarNovaSenha" placeholder="Confirma nova senha" class="txt_form" required></p>
                                <p><input type="submit" id="btnEnviarSenha" name="btnEnviarSenha" value="Atualizar nova senha" class="btn_form"></p>
                            </form>
                        </div>

                        <p><a href="<?php echo HOME_URI; ?>" target="_self" class="esquecisenha" data-toggle="" data-target=""> Cancelar </a></p>

                        <div class="mastfoot">
                          <div class="inner">
                            <p class="footerLinha">© 2016 - <?php echo date('Y'); ?> Eficaz system - Sistema de Monitoramento Infraweb. Todos os direitos reservados.</p>
                          </div>
                        </div>

                    </div>

                </div>

            </div>

        <?php
            }
            else{
        ?>

        <div class="site-wrapper-inner">

            <div class="cover-container">

              <div class="masthead clearfix">
                <div class="inner">

                  <nav>
                    <ul class="nav masthead-nav">

                    </ul>
                  </nav>
                </div>
              </div>

              <!-- <div class="inner cover">
                <h1 class="cover-heading">Cover your page.</h1>
                <p class="lead">Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</p>
                <p class="lead">
                  <a href="#" class="btn btn-lg btn-default">Learn more</a>
                </p>
              </div> -->

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

                    <div class="mastfoot">
                      <div class="inner">
                        <p class="footerLinha">© 2016 - <?php echo date('Y'); ?> Eficaz system - Sistema de Monitoramento Infraweb. Todos os direitos reservados.</p>
                      </div>
                    </div>

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

    </body>
</html>
