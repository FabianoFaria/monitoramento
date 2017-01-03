<!-- LISTAR FILIAIS DO CLIENTE VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* Carrega os dados do cliente */
    $dados    = $modeloClie->carregarDadosCliente($this->parametros[0]);
    $clientes = $modeloClie->listarCliente();

    if($clientes){
		$dadosCliente = $clientes;
    	//$dadosFiliais = $filiais['filiais'][0];
	}else{
	 	$dadosCliente = null;
    	//$dadosFiliais = null;
	}

	//var_dump($clientes);

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento">Listar equipamentos</a> / <a href="<?php echo HOME_URI; ?>/equipamento/cadastrarEquipamento">Cadastrar equipamentos</a>';
</script>

<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Registrar novo equipamento</label><!-- Fim Titulo pagina -->
    </div>
</div>

 <div class="row">
    <div class="col-lg-12">

        <!-- formulario de cadastro -->
        <form id="novoEquipamento" method="post">
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cliente com o equipamento : </label>
                        <select id="clienteEquipamento" name="clienteEquipamento" class="form-control">
                            <option value="" selected>Selecione cliente</option>
                            <?php
                                if(isset($dadosCliente)){

                                    foreach ($dadosCliente as $clienteEquip) {
                                        ?>
                                        <option value="<?php echo $clienteEquip['id']; ?>"><?php echo $clienteEquip['nome']; ?></option>
                                        <?php
                                    }

                                }
                            ?>
                        </select>
                    </div>
                </div><!-- fim fabricante -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Filial com o equipamento : </label>
                        <select id="filialEquipamento" name="filialEquipamento" class="form-control">
                            <option value="">Selecione filial</option>
                        </select>
                    </div>
                </div><!-- fim filial -->

            </div>

            <div class="row">
                <!-- fabricante -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome do Fabricante</label>
                        <?php $modelo->listaFabricante(); ?>
                    </div>
                </div><!-- fim fabricante -->

                <!-- Tipo de equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoEquipamento">Tipo de Equipamento</label>
                        <input type="text" class="form-control" id="txt_tipoEquip" name="txt_tipoEquip" placeholder="Tipo de Equipamento" maxlength="80"
                        value="">
                    </div>
                </div><!-- fim tipo do equipamento -->

                <!-- Modelo de equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="modeloEquipamento">Modelo de Equipamento</label>
                        <input type="text" class="form-control" id="txt_modeloEquip" name="txt_modeloEquip" placeholder="Modelo de Equipamento" maxlength="80"
                        required value="">
                    </div>
                </div><!-- fim modelo do equipamento -->



            </div>
            <div class="row">
                 <!-- Quantidade de bateria -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="qntBateria">Quantidade de bateria (Opcional)</label>
                        <input type="text" class="form-control" id="txt_qntBateria" name="txt_qntBateria" placeholder="Quantidade de bateria" maxlength="5"
                        onkeypress="retun onlyNumber(event);" value="">
                    </div>
                </div><!-- fim quantidade de bateria -->

                 <!-- Potencia -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Potencia">Pot&ecirc;ncia (Opcional)</label>
                        <input type="text" class="form-control" id="txt_potencia" name="txt_potencia" placeholder="Pot&ecirc;ncia" maxlength="15"
                        value="">
                    </div>
                </div><!-- fim potencia -->

                <!-- Caracteristica do equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="caracteristica">Caracter&iacute;sticas equipamento (Opcional)</label>
                        <input type="text" class="form-control" id="txt_caracteristica" name="txt_caracteristica" placeholder="Caracter&iacute;sticas equipamento"
                        maxlength="30" value="">
                    </div>
                </div><!-- fim Caracteristica do equipamento -->

            </div>
            <div class="row">
                <!-- Amperagem bateria -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Amperagem">Amperagem bateria (Opcional)</label>
                        <input type="text" class="form-control" id="txt_amperagem" name="txt_amperagem" placeholder="Amperagem bateria" maxlength="10"
                        value="">
                    </div>
                </div><!-- fim Amperagem bateria -->

                <!-- Tipo de bateria -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoBateria">Tipo de bateria (Opcional)</label>
                        <select id="opc_tipoBateria" name="opc_tipoBateria" spellcheck="false" class="form-control">
                            <option value=''>Selecione um tipo de bateria</option>
                            <option value='Selada'>Selada</option>
                            <option value='Automotiva'>Automotiva</option>
                            <option value='Estacion&aacute;ria'>Estacion&aacute;ria</option>
                        </select>
                    </div>
                </div><!-- fim Tipo de bateria -->

            </div>

            <!-- botao de enviar -->
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class=" txt-center"><button id="validarCadastroEquipamento" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar equipamento</button></div>
                </div>
            </div><!-- fim do botao de envio -->
        </form>
    </div>
</div>
