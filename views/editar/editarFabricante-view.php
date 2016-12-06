<?php

if (! defined('EFIPATH')) exit();


/* insere o modulo de busca de paises */
$retornoPais = $modelo->carregaPais();

/* insere o modulo de busca de estado */
$retornoEstado = $modelo->carregaEstado();

/* carrega dados do frabricante */
$retorno = $modelo->carregaFabricante (base64_decode($this->parametros[0]));

/* coleta os dados */
$nome     = isset ($retorno[0]['nome']) && ! empty ($retorno[0]['nome']) ? $modelo->converte($retorno[0]['nome'],1): '';
$endereco = isset ($retorno[0]['endereco']) && ! empty ($retorno[0]['endereco']) ? $modelo->converte($retorno[0]['endereco'],1): '' ;
$cidade   = isset ($retorno[0]['cidade']) && ! empty ($retorno[0]['cidade']) ? $modelo->converte($retorno[0]['cidade'],1): '';
$bairro   = isset ($retorno[0]['bairro']) && ! empty ($retorno[0]['bairro']) ? $modelo->converte($retorno[0]['bairro'],1): '';

$pais      = isset ($retorno[0]['pais'])      && ! empty ($retorno[0]['pais'])      ? $retorno[0]['pais']      : 0 ;
$estado    = isset ($retorno[0]['estado'])    && ! empty ($retorno[0]['estado'])    ? $retorno[0]['estado']    : 0 ;
$id_pais   = isset ($retorno[0]['id_pais'])   && ! empty ($retorno[0]['id_pais'])   ? $retorno[0]['id_pais']   : 0 ;
$id_estado = isset ($retorno[0]['id_estado']) && ! empty ($retorno[0]['id_estado']) ? $retorno[0]['id_estado'] : 0 ;
$numero    = isset ($retorno[0]['numero'])    && ! empty ($retorno[0]['numero'])    ? $retorno[0]['numero']    : '' ;
$ddd       = isset ($retorno[0]['ddd'])       && ! empty ($retorno[0]['ddd'])       ? $retorno[0]['ddd']       : '' ;
$telefone  = isset ($retorno[0]['telefone'])  && ! empty ($retorno[0]['telefone'])  ? $retorno[0]['telefone']  : '' ;
$cep       = isset ($retorno[0]['cep'])       && ! empty ($retorno[0]['cep'])       ? $retorno[0]['cep']       : '' ;

/* edita os dados do fabricante */
$modelo->editarFabricante(base64_decode($this->parametros[0]));
?>


<script>
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/pesquisar/fabricantecadastrado" class="linkMenuSup">Editar Fabricante</a> / <a href="" class="linkMenuSup">Fabricante</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">FABRICANTE CADASTRADO</label><!-- Fim Titulo pagina -->
    
    
    <!-- formulario de cadastro -->
    <form method="post">
        <div class="row">
            <!-- nome do fabricante -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome do Fabricante</label>
                    <input type="text" class="form-control" id="txt_fabricante" name="txt_fabricante" placeholder="Nome do Equipamento" maxlength="80" required value="<?php echo $nome; ?>">
                </div>
            </div><!-- fim nome do fabricante -->
            
            
            <!-- DDD -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                    <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="return onlyNumber(event);" value="<?php echo $ddd; ?>">
                </div>
            </div><!-- fim do ddd -->
            
            <!-- telefone -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="10" onkeypress="return onlyNumber(event);" value="<?php echo $telefone; ?>">
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
                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="9"  onkeypress="return onlyNumber(event);" value="<?php echo $numero; ?>">
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
                    <?php $modelo->listaPaises($id_pais);?>
                </div>
            </div><!-- fim do pais -->
            
            
            <!-- estado -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Estado</label><br>
                    <?php $modelo->listaEstado($id_estado);?>
                </div>
            </div><!-- fim do estado -->
        </div>
        
        
        
        <!-- botao de enviar -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" name="btn_salvar" class="btn btn-info" value="Salvar"></div>
        </div><!-- fim do botao de envio -->
        
    </form><!-- fim do formulario de cadastro -->
</div>