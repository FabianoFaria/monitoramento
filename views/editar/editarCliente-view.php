<?php
/* valida a existencia do path */
if (! defined('EFIPATH')) exit();

/* carrega as informacoes do cliente */
$retorno = $modelo->carregaCliente(base64_decode($this->parametros[0]));

/* insere o modulo de gravacao */
$modelo->editarCliente(base64_decode($this->parametros[0]));


/* insere o modulo de busca de paises */
$retornoPais = $modelo->carregaPais();

/* insere o modulo de busca de estado */
$retornoEstado = $modelo->carregaEstado();


/* coleta e ajuste de informacao */
$nome     = $modelo->converte($retorno[0]['nome'],1);
$endereco = $modelo->converte($retorno[0]['endereco'],1);
$numero   = isset($retorno[0]['numero']) && ! empty($retorno[0]['numero']) ? $retorno[0]['numero'] : 0 ;
$cep      = $retorno[0]['cep'];
$cidade   = $modelo->converte($retorno[0]['cidade'],1);
$bairro   = $modelo->converte($retorno[0]['bairro'],1);
$ddd      = isset($retorno[0]['ddd']) && ! empty($retorno[0]['ddd']) ? $retorno[0]['ddd'] : 0 ;
$telefone = isset($retorno[0]['telefone']) && ! empty($retorno[0]['telefone']) ? $retorno[0]['telefone'] : 0 ;
$pais     = $retorno[0]['pais'];
$idpais   = $retorno[0]['idpais'];
$estado   = $retorno[0]['estado'];
$idestado = $retorno[0]['idestado'];



?>

<script>
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/pesquisar/clientecadastrado/" class="linkMenuSup">Editar Cliente</a> / <a href="" class="linkMenuSup">Cliente</a>';
</script>

<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">CLIENTE CADASTRADO</label><!-- Fim Titulo pagina -->


    <!-- formulario de cadastro -->
    <form method="post" autocomplete="off">

        <div class="row">
            <!-- nome do cliente -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome do cliente</label>
                    <input type="text" class="form-control" id="txt_cliente" name="txt_cliente" placeholder="Nome do cliente" maxlength="100" required value="<?php echo $nome; ?>">
                </div>
            </div><!-- fim do campo nome do cliente -->

            <!-- DDD -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                    <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (00)" maxlength="2" onkeypress="return onlyNumber(event);" value="<?php if ($ddd != 0) echo $ddd; ?>">
                </div>
            </div><!-- fim do ddd -->

            <!-- telefone -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="10" onkeypress="return onlyNumber(event);" value="<?php if ($telefone != 0) echo $telefone; ?>">
                </div>
            </div><!-- fim do telefone -->
        </div>



        <div class="row">
            <!-- cep -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">CEP</label>
                    <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" required onkeypress="return onlyNumber(event);" value="<?php echo $cep; ?>">
                </div>
            </div><!-- fim do cep -->


            <!-- endereco do cliente -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Endere&ccedil;o</label>
                    <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required value="<?php echo $endereco; ?>">
                </div>
            </div><!-- fim do endereco do cliente -->

            <!-- numero -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">N&uacute;mero</label>
                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="10"  onkeypress="return onlyNumber(event);" value="<?php if ($numero != 0) echo $numero; ?>">
                </div>
            </div><!-- fim do numero -->
        </div>


        <div class="row">
            <!-- Cidade -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cidade</label>
                    <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required value="<?php echo $cidade; ?>">
                </div>
            </div><!-- fim do campo Cidade -->

            <!-- Bairro -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Bairro</label>
                    <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" required value="<?php echo $bairro; ?>">
                </div>
            </div><!-- fim do campo Bairro -->


            <!-- pais -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Pais</label><br>
                    <?php $modelo->listaPaises($idpais); ?>
                </div>
            </div><!-- fim do pais -->


            <!-- estado -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Estado</label><br>
                    <?php $modelo->listaEstado($idestado); ?>
                </div>
            </div><!-- fim do estado -->
        </div>



        <!-- botao de enviar -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" name="btn_salvar" class="btn btn-info" value="Salvar Altera&ccedil;&atilde;o"></div>
        </div><!-- fim do botao de envio -->

    </form><!-- fim do formulario de cadastro -->
</div>
