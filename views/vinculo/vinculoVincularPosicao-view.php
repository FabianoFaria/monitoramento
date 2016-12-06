<?php

if (! defined('EFIPATH')) exit();

if (isset($parametros))
{
    // Coleta os parametros
    $parametro = base64_decode($parametros[0]);
    // Transforma em array
    $parametro = explode("/",$parametro);

    // Captura os valores da pesquisa de equipamento e cliente
    $retornoPesq = $modelo->busca_cliente_vinc($parametro[0]);
    // Transforma em array
    $retornoPesq = explode ("/",$retornoPesq);
    // Concatena o numero do sim no nome do cliente 
    $retornoPesq[0] .= ' - ' . $parametro[1];
    // Desabilita a edicao do input
    $estado = "disabled";
    $btn_op_send= "";
    
    // Chamada se acao do botao post
    $modelo->vinc_equip_sim_tabela($parametro);
}
else
{
    // Apaga os valores do array
    $retornoPesq[0] = "";
    $retornoPesq[1] = "";
    // habilita a edica do input
    $estado = "disabled";
    $btn_op_send = "disabled";
}

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/vinculo/" class="linkMenuSup">Vinculo</a> / <a href="#" class="linkMenuSup">Vinculo Posi&ccedil;&atilde;o</a>';
</script>
<link href="<?php echo HOME_URI; ?>/views/_css/multiple/multiple-select.css" rel="stylesheet"/>



<div class="container-fluid">
    <form method="post">
        <!-- Titulo pagina -->
        <label class="titulo-pagina">VINCULO POSI&Ccedil;&Atilde;O</label><!-- Fim Titulo pagina -->

        <div class="row">
            <!-- Nome cliente -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cliente</label>
                    <input type="text" class="form-control" name="txt_cliente" placeholder="Nome do cliente" maxlength="100" value="<?php echo $retornoPesq[0]; ?>" <?php echo $estado; ?>>
                </div>
            </div><!-- Fim Nome cliente -->
            
            <!-- Equipamento -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Equipamento</label>
                    <input type="text" class="form-control" name="txt_equipamento" placeholder="Nome do Equipamento" maxlength="100" value="<?php echo $retornoPesq[1]; ?>" <?php echo $estado; ?>>
                </div>
            </div><!-- Fim Equipamento -->
            
            <!-- posicoes da tabela -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Posi&ccedil;&atilde;o na tabela</label>

                    <select id="opc_posicao" name="opc_posicao[]" required class="form-control posicao-tabela" multiple="multiple" <?php echo $btn_op_send; ?>>
                        <option value="b">b</option>
                        <option value="c">c</option>
                        <option value="d">d</option>
                        <option value="e">e</option>
                        <option value="f">f</option>
                        <option value="g">g</option>
                        <option value="h">h</option>
                        <option value="i">i</option>
                        <option value="j">j</option>
                        <option value="l">l</option>
                        <option value="m">m</option>
                        <option value="n">n</option>
                        <option value="o">o</option>
                        <option value="p">p</option>
                        <option value="q">q</option>
                        <option value="r">r</option>
                        <option value="s">s</option>
                        <option value="t">t</option>
                        <option value="u">u</option>
                    </select>
                </div>
            </div><!-- fim das posicoes da tabela -->
        </div>
        
        <!-- botao de enviar -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" name="btn_salvar" class="btn btn-info" value="Salvar" <?php echo $btn_op_send; ?>></div>
        </div><!-- fim do botao de envio -->
    </form>
</div>

<script src="<?php echo HOME_URI; ?>/views/_js/multiple/jquery.multiple.select.js"></script>
<script>
$('#opc_posicao').multipleSelect();
</script>