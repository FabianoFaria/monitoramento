<!-- LISTAR FILIAIS DO EQUIPAMENTO VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* Carrega os dados do cliente */
    $dados      = $modeloClie->carregarDadosCliente($this->parametros[0]);
    $clientes   = $modeloClie->listarCliente();
    $tiposEquip = $modelo->listarTipoEquip();
    $fabricantes= $modeloFabri->listarFabricantes();

    if($clientes){
		$dadosCliente = $clientes;
    	//$dadosFiliais = $filiais['filiais'][0];
	}else{
	 	$dadosCliente = null;
    	//$dadosFiliais = null;
	}

    if($tiposEquip['status']){
        $tiposEncontrados = $tiposEquip['equipamento'];
    }else {
        $tiposEncontrados = 0;
    }

	//var_dump($tiposEquip);

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento">Listar equipamentos</a> / <a href="<?php echo HOME_URI; ?>/equipamento/cadastrarEquipamento">Cadastrar equipamentos</a>';
</script>

<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <h3 class="page-header">Registrar novo equipamento</h3><!-- Fim Titulo pagina -->
    </div>
</div>

 <div class="row">
    <div class="col-lg-12">

        <!-- FORMULARIO DE CADASTRO -->
        <form id="novoEquipamento" method="post">
            <div class="row">

                <h4 class="page-header">Tipo de equipamento</h4>

                <!-- TIPO DE EQUIPAMENTO -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoEquipamento">Tipo de Equipamento</label>
                        <select class="form-control" id="txt_tipoEquip" name="txt_tipoEquip" >
                            <option value=""> Selecione tipo</option>
                            <?php

                                if($tiposEncontrados != 0){
                                    foreach ($tiposEncontrados as $tipo) {
                                        echo "<option value='".$tipo['id']."'>".$tipo['tipo_equipamento']."</option>";
                                    }
                                }else{
                                    echo "Nennuption m tipo de equipamento cadastrado.";
                                }

                            ?>
                        </select>
                    </div>
                </div><!-- fim tipo do equipamento -->

            </div>
            <div class="row">

                <h4 class="page-header">Cliente e local do equipamento</h4>

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
                </div><!-- fim cliente -->

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

                <!-- Modelo de equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="modeloEquipamento">Modelo de Equipamento</label>
                        <input type="text" class="form-control" id="txt_nomeModeloEquip" name="txt_nomeModeloEquip" placeholder="Modelo de Equipamento" maxlength="80"
                        required value="">
                    </div>
                </div><!-- fim modelo do equipamento -->

            </div>

            <div class="row entradasMedidor">

                <!-- Quantidade de pontos do equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Pontos do equipamento</label>
                        <select id="opc_tipoEntrada" name="opc_tipoEntrada" class="form-control">
                            <?php
                                for($i = 1; $i <= 20; $i++){
                                    echo "<option value='".$i."'>".$i."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row fabricante">

                <!-- FABRICANTE -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome do Fabricante</label>
                        <select id="fabricante_opt" name="fabricante_opt" class="form-control">

                            <option  value="" >Selecione...</option>
                            <?php //$modelo->listaFabricante();

                                if($fabricantes != false){

                                    foreach ($fabricantes as $fabri) {
                                        echo "<option  value='".$fabri['id']."' >".$fabri['nome']."</option>";
                                    }

                                }else{
                                    echo "<option  value='' >Nennum fabricante cadastrado!</option>";
                                }

                            ?>

                        </select>

                    </div>
                </div><!-- fim fabricante -->

            </div>

            <div class="row entradaSaidaEquipamento">
                <!-- Entrada de equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="modeloEquipamento">Tipo entrada do equipamento</label>
                        <select id="opc_tipoEntrada" name="opc_tipoEntrada" spellcheck="false" class="form-control">
                            <option value=''>Selecione...</option>
                            <option value='1'>Monofásico</option>
                            <option value='2'>Bifásico</option>
                            <option value='3'>Trifásico</option>
                        </select>
                    </div>
                </div><!-- fim entrada do equipamento -->
                <!-- Saída de equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="modeloEquipamento">Tipo saída do equipamento</label>
                        <select id="opc_tipoSaida" name="opc_tipoSaida" spellcheck="false" class="form-control">
                            <option value=''>Selecione...</option>
                            <option value='1'>Monofásico</option>
                            <option value='2'>Bifásico</option>
                            <option value='3'>Trifásico</option>
                        </select>
                    </div>
                </div><!-- fim saída do equipamento -->
            </div>

            <div class="row bateriaEquipamento">

                <h4 class="page-header">Bateria do equipamento</h4>

                <!-- Corrente da bateria -->
               <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Corrente da bateria (A)</label>
                       <input type="text" class="form-control" id="txt_correnteBat" name="txt_correnteBat" placeholder="Corrente da bateria" maxlength="15"
                       value="">
                   </div>
               </div><!-- fim corrente da bateria -->

                <!-- POTENCIA -->
               <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Pot&ecirc;ncia (Kva)</label>
                       <input type="text" class="form-control" id="txt_potencia" name="txt_potencia" placeholder="Pot&ecirc;ncia" maxlength="15"
                       value="">
                   </div>
               </div><!-- fim potencia -->

            </div>

            <div class="row bateriaTensao">

                <!-- TENSÃO BANCO DE BATERIA -->
                <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Tensão do banco de bateria (V)</label>
                       <input type="text" class="form-control" id="txt_tensao_bancoBat" name="txt_tensao_bancoBat" placeholder="Tesão banco de bateria" maxlength="15"
                       value="">
                   </div>
                </div><!-- TENSÃO BANCO DE BATERIA -->

                <!-- CORRENTE BANCO DE BATERIA -->
                <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Corrente nominal das baterias(A)</label>
                       <input type="text" class="form-control" id="txt_correnteBancoBat" name="txt_correnteBancoBat" placeholder="Corrente do banco de bateria" maxlength="15"
                       value="">
                   </div>
                </div><!-- CORRENTE BANCO DE BATERIA -->

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Potencia">Tensão minima do barramento (Vdc)</label>
                        <input type="text" class="form-control" id="txt_tensaoMinBarramentoBat" name="txt_tensaoMinBarramentoBat" placeholder="Tensão minima do barramento" maxlength="15"
                        value="">
                    </div>
                </div>
            </div>

            <div class="row quantidadesBateria">

                <!-- Quantidade de bateria -->
                <div class="col-md-4">
                   <div class="form-group">
                       <label for="qntBateria">Quantidade de bateria </label>
                       <input type="text" class="form-control" id="txt_qntBateria" name="txt_qntBateria" placeholder="Quantidade de bateria" maxlength="5"
                       onkeypress="retun onlyNumber(event);" value="">
                   </div>
                </div><!-- fim quantidade de bateria -->

                <!-- Quantidade de banco de bateria -->
                <div class="col-md-4">
                  <div class="form-group">
                      <label for="qntBateria">Quantidade de banco de bateria </label>
                      <input type="text" class="form-control" id="txt_qntBancoBateria" name="txt_qntBancoBateria" placeholder="Quantidade de bateria" maxlength="5"
                      onkeypress="retun onlyNumber(event);" value="">
                  </div>
                </div><!-- fim quantidade de bateria -->

                <!-- Quantidade de banco de bateria -->
                <div class="col-md-4">
                     <div class="form-group">
                         <label for="qntBateria">Quantidade de bateria por banco</label>
                         <input type="text" class="form-control" id="txt_qntBateriaPorBanco" name="txt_qntBateriaPorBanco" placeholder="Quantidade de bateria por banco" maxlength="5"
                         onkeypress="retun onlyNumber(event);" value="">
                     </div>
                </div><!-- fim quantidade de bateria -->

            </div>

            <div class="row bateriaTipo">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoBateria">Tipo de bateria</label>
                        <select id="opc_tipoBateria" name="opc_tipoBateria" spellcheck="false" class="form-control">
                            <option value=''>Selecione um tipo de bateria</option>
                            <option value='Selada'>Selada</option>
                            <option value='Automotiva'>Automotiva</option>
                            <option value='Estacion&aacute;ria'>Estacion&aacute;ria</option>
                        </select>
                    </div>
                </div><!-- fim Tipo de bateria -->

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoBateria">Banco de bateria externo/interno</label>
                        <select id="opc_localBat" name="opc_localBat" spellcheck="false" class="form-control">
                            <option value=''>Selecione um tipo de bateria</option>
                            <option value='Interna'>Interna</option>
                            <option value='Externa'>Externa</option>
                        </select>
                    </div>
                </div><!-- fim Tipo de bateria -->

            </div>

            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class=" txt-center"><button id="validarCadastroEquipamento" type="button" name="btn_salvar" class="btn btn-info btn-lg btn-block" value="Salvar">Salvar equipamento</button></div>
                </div>
            </div>
        </form>

    </div>
</div>
