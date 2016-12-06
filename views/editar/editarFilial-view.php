<?php
/* verfica link */
if (! defined('EFIPATH')) exit();

// busca todos os paises
$respPais = $modelo->carregaPais();

// busca todos os estados
$respEstado = $modelo->carregaEstado();

// carrega matriz
$respMatriz = $modelo->carregaMatriz();

// carrega a funcao de edicao
$modelo->editarFilial(base64_decode($this->parametros[0]));

/* carrega as informacoes da filial */
$retornoFilial = $modelo->carregaFilial(base64_decode($this->parametros[0]));

/* armazena e arruma os dados */
$id       = isset($retornoFilial[0]['id'])       && !empty($retornoFilial[0]['id'])       ? $retornoFilial[0]['id'] : 0;
$nome     = isset($retornoFilial[0]['nome'])     && !empty($retornoFilial[0]['nome'])     ? $modelo->converte($retornoFilial[0]['nome'],1) : '';
$matriz   = isset($retornoFilial[0]['matriz'])   && !empty($retornoFilial[0]['matriz'])   ? $modelo->converte($retornoFilial[0]['matriz'],1) : '';
$matrizid = isset($retornoFilial[0]['matrizid']) && !empty($retornoFilial[0]['matrizid']) ? $retornoFilial[0]['matrizid'] : 0;
$endereco = isset($retornoFilial[0]['endereco']) && !empty($retornoFilial[0]['endereco']) ? $modelo->converte($retornoFilial[0]['endereco'],1) : '';
$cidade   = isset($retornoFilial[0]['cidade'])   && !empty($retornoFilial[0]['cidade'])   ? $modelo->converte($retornoFilial[0]['cidade'],1) : '';
$bairro   = isset($retornoFilial[0]['bairro'])   && !empty($retornoFilial[0]['bairro'])   ? $modelo->converte($retornoFilial[0]['bairro'],1) : '';
$estado   = isset($retornoFilial[0]['estado'])   && !empty($retornoFilial[0]['estado'])   ? $modelo->converte($retornoFilial[0]['estado'],1) : '';
$pais     = isset($retornoFilial[0]['pais'])     && !empty($retornoFilial[0]['pais'])     ? $modelo->converte($retornoFilial[0]['pais'],1)   : '';
$idPais   = isset($retornoFilial[0]['idPais'])   && !empty($retornoFilial[0]['idPais'])   ? $retornoFilial[0]['idPais']   : 0;
$idEstado = isset($retornoFilial[0]['idEstado']) && !empty($retornoFilial[0]['idEstado']) ? $retornoFilial[0]['idEstado'] : 0;
$numero   = isset($retornoFilial[0]['numero'])   && !empty($retornoFilial[0]['numero'])   ? $retornoFilial[0]['numero']   : '';
$ddd      = isset($retornoFilial[0]['ddd'])      && !empty($retornoFilial[0]['ddd'])      ? $retornoFilial[0]['ddd']      : '';
$telefone = isset($retornoFilial[0]['telefone']) && !empty($retornoFilial[0]['telefone']) ? $retornoFilial[0]['telefone'] : '';
$cep      = isset($retornoFilial[0]['cep'])      && !empty($retornoFilial[0]['cep'])      ? $retornoFilial[0]['cep']      : 0;


?>

<script>
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/pesquisar/filialcadastrado/" class="linkMenuSup">Editar</a> / <a href="" class="linkMenuSup">Editar Filial</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">FILIAL CADASTRADO</label><!-- Fim Titulo pagina -->
    
    
    <!-- formulario de cadastro -->
    <form method="post">
        
        <div class="row">
            <!-- nome da filial -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome da Filial</label>
                    <input type="text" class="form-control" id="txt_filial" name="txt_filial" placeholder="Nome da Filial" maxlength="100" required value="<?php echo $nome; ?>">
                </div>
            </div><!-- fim do campo nome da filial -->
            
            
            <!-- nome da matiz -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Matriz</label><br>
                    <?php $modelo->listaMatriz($matrizid); ?>
                </div>
            </div><!-- fim do campo nome da matiz -->
        </div>
        
        
        <div class="row">
            <!-- DDD -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                    <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="return onlyNumber(event);" value="<?php echo $ddd; ?>">
                </div>
            </div><!-- fim do ddd -->
            
            <!-- telefone -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="9" onkeypress="return onlyNumber(event);" value="<?php echo $telefone; ?>">
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
                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="10" onkeypress="return onlyNumber(event);" value="<?php echo $numero; ?>">
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
                    <?php $modelo->listaPaises($idPais); ?>
                </div>
            </div><!-- fim do pais -->
            
            
            <!-- estado -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Estado</label><br>
                    <?php $modelo->listaEstado($idEstado); ?>
                </div>
            </div><!-- fim do estado -->
        </div>
        
        
        
        <!-- botao de envio -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" class="btn btn-info" name="btn_enviar" value="Salvar Altera&ccedil;&otilde;es"></div>
        </div><!-- fim botao de envio -->
        
    </form><!-- fim do formulario -->
</div>