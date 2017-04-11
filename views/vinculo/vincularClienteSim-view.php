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
                        <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $this->parametros[0]; ?>" />
                        <label for="exampleInputEmail1">Matriz ou filial</label><br>
                        <select id="filialVincular" name="filialVincular" class="form-control">
                            <?php

                                if(isset($dadosFiliais)){
                                    ?>
                                        <option value="">Selecione uma filial </option>
                                        <option value="0">Vicular a Matriz </option>
                                    <?php

                                        foreach ($dadosFiliais as $filial) {
                                            echo "<option value='".$filial['id']."'>".$filial['nome']."</option>";
                                        }

                                }else{
                            ?>
                                <option value="0">Vicular a Matriz </option>
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
                        <select id="txt_numSim" name="txt_numSim" class="form-control">

                        </select>

                        <!-- <input type="text" class="form-control" id="txt_numSim" name="txt_numSim" placeholder="C&oacute;digo do SIM" maxlength="20" required> -->
                    </div>
                </div><!-- fim do Codigo SIM -->

                <!-- Ambiente / local -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ambiente / Local  (Opcional)</label>
                        <textarea id="ambienteSim" name="ambienteSim" class="form-control"></textarea>
                    </div>
                </div><!-- fim do Ambiente / local -->

            </div>

            <div class="row">
                <div class="col-md-2 col-md-offset-5 txt-center">
                    <!-- <input type="submit" class="btn btn-info" name="btn_vicular" value="Vicular SIM"> -->
                    <button type="button" id="salvarVinculo" class="btn btn-info">Vincular</button>
                </div>
            </div>

        </form>


    </div>
</div>
