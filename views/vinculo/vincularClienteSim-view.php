<!-- VINCULAR CLIENTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* Carrega os dados do cliente */
    $dados = $modelo->carregarDadosCliente($this->parametros[0]);
    $filiais  = $modelo->carregarFiliaisCliente($this->parametros[0]);

    if($dados['status']){
		$dadosCliente = $dados['dados'][0];

	}else{
	 	$dadosCliente = null;
	}

    if($filiais['status']){
    	$dadosFiliais = $filiais['filiais'];
	}else{
    	$dadosFiliais = null;
	}

    //var_dump($dadosFiliais);

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cliente/" class="linkMenuSup">Lista de clientes</a> / <a href="<?php echo HOME_URI; ?>/vinculo/gerenciarVinculo/<?php echo $this->parametros[0]; ?>"> Vinculos do cliente</a> / <a href="<?php echo HOME_URI; ?>/vinculo/cadastrarVinculo/<?php echo $this->parametros[0]; ?>">Vincular SIM ao cliente</a>';
</script>

<!-- Jquery file -->
<script src="<?php echo HOME_URI; ?>/views/_js/pages/jquery.js"></script>

<div class="row">
    <div class="col-md-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Vincular SIM para o cliente : <?php echo $dadosCliente['nome']; ?></label><!-- Fim Titulo pagina -->

        <form id="vincularSimCliente" method="post">

            <div class="row">
                <!-- nome da filial -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Filial (Opcional)</label><br>
                        <select id="filialVincular">
                            <?php

                                if(isset($dadosFiliais)){
                                    ?>
                                        <option value="">Selecione Uma filial </option>
                                    <?php

                                        foreach ($dadosFiliais as $filial) {
                                            echo "<option value='".$filial['id']."'>".$filial['nome']."</option>";
                                        }

                                }else{
                            ?>
                                <option value="">Não há filiais disponíveis </option>
                            <?php
                                }

                             ?>
                        </select>
                    </div>
                </div><!-- fim do campo nome da filial -->

                <!-- Codigo SIM -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">C&oacute;digo do SIM</label>
                        <input type="text" class="form-control" id="txt_numSim" name="txt_numSim" placeholder="C&oacute;digo do SIM" maxlength="14" onkeypress="return onlyNumber(event);" required>
                    </div>
                </div><!-- fim do Codigo SIM -->

            </div>

            <div class="row">
                <div class="col-md-2 col-md-offset-5 txt-center">
                    <input type="submit" class="btn btn-info" name="btn_vicular" value="Vicular SIM">
                </div>
            </div>

        </form>


    </div>
</div>
