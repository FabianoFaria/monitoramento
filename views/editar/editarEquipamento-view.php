<?php

if (! defined('EFIPATH')) exit();

// verifica se existe acao do post
$modelo->editarEquipamento(base64_decode($this->parametros[0]));

// insere a lista de fabricante
$respFab = $modelo->carregarFabricante();

/* carregar as informacoes do equipamento */
$retorno = $modelo->carregarEquipamento(base64_decode($this->parametros[0]));

/* coleta os dados do select */
$equip      = isset($retorno[0]['nome'])       ? $retorno[0]['nome'] : '';
$fabricante = isset($retorno[0]['fabricante']) ? $modelo->converte($retorno[0]['fabricante'],1) : '' ;
$idFabri    = isset($retorno[0]['idFabri'])    ? $modelo->converte($retorno[0]['idFabri']) : '' ;
?>

<script>
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/pesquisar/equipamentocadastrado/" class="linkMenuSup">Editar Equipamento</a> / <a href="" class="linkMenuSup">Equipamento</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">EQUIPAMENTO CADASTRADO</label><!-- Fim Titulo pagina -->
    
    <!-- formulario de cadastro -->
    <form method="post">
        <div class="row">
            <!-- nome do equipamento -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome do Equipamento</label>
                    <input type="text" class="form-control" id="txt_equipamento" name="txt_equipamento" placeholder="Nome do Equipamento" maxlength="80" required value="<?php echo $equip; ?>">
                </div>
            </div><!-- fim nome do equipamento -->
            
            
            <!-- fabricante -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome do Fabricante</label><br>
                    <?php $modelo->listaFabricante($idFabri); ?>
                </div>
            </div><!-- fim fabricante -->
        </div>
        
        
        
        
        <!-- botao de enviar -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" name="btn_salvar" class="btn btn-info" value="Salvar Altera&ccedil;&atilde;o"></div>
        </div><!-- fim do botao de envio -->
        
    </form><!-- fim do formulario de cadastro -->
</div>