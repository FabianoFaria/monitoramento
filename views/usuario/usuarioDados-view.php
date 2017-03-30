<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

// Carrega os dados necessários
$dadosUsuario = $modelo->dadosUsuario($_SESSION['userdata']['userId']);

//var_dump($dadosUsuario);


//efetua o primeiro tratamento dos dados para atualizar o usuário
if (isset($_POST['btn_salvar']))
{
    $modelo->atualizarUsuario();
}

//var_dump($_SESSION['userdata']['userId']);

?>


<script>
var menu = document.getElementById('listadir');
menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/usuario/" class="linkMenuSup">Dados de usuário</a> ';
</script>

<div class="row">

    <div class="col-md-12">

        <!-- Titulo pagina -->
        <label class="page-header"><h3>Dados do usuário</h3></label><!-- Fim Titulo pagina -->


    </div>

</div>

<div class="row">

    <div class="col-md-12">

        <!-- formulario de cadastro -->
        <form method="post" id="edicao_usuario" enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-12">

                    <input type="hidden" id="txt_userId" name="txt_userId" value="<?php if (isset($dadosUsuario['id'])) echo $dadosUsuario['id']; ?>">
                    <input type="hidden" id="opc_local" name="opc_local" value="<?php if (isset($dadosUsuario['local_usu'])) echo $dadosUsuario['local_usu']; ?>">

                </div>

            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Imagem do usuário</label>
                        <input id="file_foto" name="file_foto" type="file" />
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>

            <div class="row">

                <!-- nome do usuario -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome do Usu&aacute;rio</label>
                        <input type="text" class="form-control" id="txt_nome" name="txt_nome" placeholder="Nome do Usu&aacute;rio" maxlength="50" required
                        value="<?php if (isset($dadosUsuario['nome'])) echo $dadosUsuario['nome']; ?>">
                    </div>
                </div><!-- fim nome do usuario -->

                <!-- sobrenome do usuario -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sobrenome do Usu&aacute;rio</label>
                        <input type="text" class="form-control" id="txt_sobrenome" name="txt_sobrenome" placeholder="Sobrenome do Usu&aacute;rio" maxlength="90" required
                        value="<?php if (isset($dadosUsuario['sobrenome'])) echo $dadosUsuario['sobrenome']; ?>">
                    </div>
                </div><!-- fim sobrenome do usuario -->

            </div>

            <div class="row">

                <!-- E-mail -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telefone</label>
                        <input type="tel" class="form-control" id="txt_telefone_usuario" name="txt_telefone_usuario" placeholder="Telefone" maxlength="50" required
                        value="<?php if(isset($dadosUsuario['telefone'])) echo $dadosUsuario['telefone']; ?>">
                    </div>
                </div><!-- fim E-mail -->

                <!-- E-mail -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Celular</label>
                        <input type="tel" class="form-control" id="txt_celular_usuario" name="txt_celular_usuario" placeholder="Celular" maxlength="50" required
                        value="<?php if(isset($dadosUsuario['celular'])) echo $dadosUsuario['celular']; ?>">
                    </div>
                </div><!-- fim E-mail -->


            </div>

            <div class="row">

                <!-- E-mail -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">E-mail</label>
                        <input type="email" class="form-control" id="txt_email" name="txt_email" placeholder="E-mail" maxlength="50" required
                        value="<?php if(isset($dadosUsuario['email'])) echo $dadosUsuario['email']; ?>">
                    </div>
                </div><!-- fim E-mail -->

            </div>

            <div class="row">

                <!-- senha -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Senha</label>
                        <input type="password" class="form-control" id="txt_senha" name="txt_senha" placeholder="Senha" maxlength="30" >
                        <span class="senhaPerm">Caracteres permitidos !,-,#,+,=,*</span>
                    </div>
                </div><!-- fim senha -->

                <!-- confirma senha -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirma senha</label>
                        <input type="password" class="form-control" id="txt_cfsenha" name="txt_cfsenha" placeholder="Confirma senha" maxlength="30" >
                    </div>
                </div><!-- fim confirma senha -->


            </div>

            <div class="row">

                <!-- nome da matiz -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="tiposDeCliente">Cliente</label><br>
                        <?php //$modeloCadastro->loadClienteFilial(); ?>
                    </div>
                </div><!-- fim do campo nome da matiz -->

                <!-- permissao -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoPermissao">Permiss&atilde;o</label><br>
                        <?php //$modeloCadastro->loadPerfilAcesso(); ?>
                    </div>
                </div><!-- fim permissao -->
            </div>

            <?php

                /*

                'id' => string '42' (length=2)
                  'id_perfil_acesso' => string '2' (length=1)
                  'nome' => string 'Golvea' (length=6)
                  'sobrenome' => string 'Gusm&atilde;o' (length=13)
                  'email' => string 'email@email.com' (length=15)
                  'telefone' => string '(342) 2342-3423' (length=15)
                  'celular' => string '(423) 4234-2342' (length=15)
                  'senha' => string '9091a762fd732c7d0f308540ee93ed94' (length=32)
                  'local_usu' => string '1' (length=1)
                  'id_cliente' => string '49' (length=2)
                  'tipo_inst' => string '0' (length=1)
                  'status_ativo' => string '1' (length=1)
                  'dt_criaco' => string '2017-01-10 15:25:08' (length=19)

                */

            ?>

            <!-- botao de enviar -->
            <div class="row">
                <div class="col-md-2 col-md-offset-5 txt-center">
                    <!-- <input type="submit" id="btn_salvar" name="btn_salvar" class="btn btn-info" value="Atualizar"> -->
                    <button type="button" class="btn btn-primary" id="atualizarUsuario">Atualizar</button>
                </div>
            </div><!-- fim do botao de envio -->

        </form>

    </div>

</div>
