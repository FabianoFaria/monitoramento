<!-- LISTAR FILIAIS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    $retornoUsuario = $modelo->dadosUsuario($parametros[0]);

    /* insere o modulo de busca de paises */
    $retornoPais    = $modeloEdicao->carregaPais();

    /* insere o modulo de busca de estado */
    $retornoEstado  = $modeloEdicao->carregaEstado();

    //TERMINAR O PROCESSOS DE ATUALIZAR O USUÁRIO
    //var_dump($retornoUsuario);

?>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/usuario/Listar">Listar usuários </a> / <a href="#">Editar usuário </a>';
</script>

<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Editar o usuário <i><?php echo $retornoUsuario['nome']." ".$retornoUsuario['sobrenome']; ?></i></label><!-- Fim Titulo pagina -->

        <!-- formulario de cadastro -->
        <form method="post">
            <div class="row">

                <!-- nome do usuario -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome do Usu&aacute;rio</label>
                        <input type="text" class="form-control" id="txt_nome" name="txt_nome" placeholder="Nome do Usu&aacute;rio" maxlength="50" required
                        value="<?php echo $retornoUsuario['nome']; ?>">
                    </div>
                </div><!-- fim nome do usuario -->

                <!-- sobrenome do usuario -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sobrenome do Usu&aacute;rio</label>
                        <input type="text" class="form-control" id="txt_sobrenome" name="txt_sobrenome" placeholder="Sobrenome do Usu&aacute;rio" maxlength="90" required
                        value="<?php echo $retornoUsuario['sobrenome']; ?>">
                    </div>
                </div><!-- fim sobrenome do usuario -->

                <!-- E-mail -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">E-mail</label>
                        <input type="email" class="form-control" id="txt_email" name="txt_email" placeholder="E-mail" maxlength="50" required
                        value="<?php echo $retornoUsuario['email']; ?>">
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

                <!-- Usuario interno ou externo -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Usu&aacute;rio interno ou externo</label>
                        <select id="opc_local" name="opc_local" required class="form-control">
                                <option value=3 <?php if(isset($dadosUsuario['local_usu']) && ($dadosUsuario['local_usu'] == 3)){ echo "selected"; } ?>>Selecione</option>
                                <option value=1 <?php if(isset($dadosUsuario['local_usu']) && ($dadosUsuario['local_usu'] == 1)){ echo "selected"; } ?>>Interno</option>
                                <option value=0 <?php if(isset($dadosUsuario['local_usu']) && ($dadosUsuario['local_usu'] == 0)){ echo "selected"; } ?>>Externo</option>
                        </select>
                    </div>
                </div><!-- fim Usuario interno ou externo -->
            </div>


            <div class="row">
                <!-- nome da matiz -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tiposDeCliente">Cliente</label><br>
                        <?php $modeloEdicao->loadClienteFilial(); ?>
                    </div>
                </div><!-- fim do campo nome da matiz -->

                <!-- permissao -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoPermissao">Permiss&atilde;o</label><br>
                        <?php $modeloCadastro->loadPerfilAcesso(); ?>
                    </div>
                </div><!-- fim permissao -->
            </div>

            <!-- botao de enviar -->
            <div class="row">
                <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" id="btn_salvar" name="btn_salvar" class="btn btn-info" value="Atualizar"></div>
            </div><!-- fim do botao de envio -->
        </form>

    </div>
</div>
