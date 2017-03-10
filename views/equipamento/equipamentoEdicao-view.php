<!-- EDIÇÃO EQUIPAMENTO -->

<?php
    if (! defined('EFIPATH')) exit;

    $dadosEquipamento   = $modelo->dadosEquipamentoCliente($this->parametros[0]);
    $tiposEquip         = $modelo->listarTipoEquip();
    $fabricantes        = $modeloFabri->listarFabricantes();

    if($dadosEquipamento['status']){
    	$equipamentoCarregado = $dadosEquipamento['equipamento'][0];
    }else{
    	$equipamentoCarregado = null;
    }

    if($tiposEquip['status']){
        $tiposEncontrados = $tiposEquip['equipamento'];
    }else {
        $tiposEncontrados = 0;
    }

?>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento">Listar equipamentos</a> / <a href="<?php echo HOME_URI; ?>/equipamento/editarEquipamentoCliente/<?php echo $this->parametros[0]; ?>">Edição de equipamento : <?php echo (isset($equipamentoCarregado)) ? $equipamentoCarregado['tipoEquip']: ""; ?></a>';
</script>


<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Edição de equipamento : <?php echo (isset($equipamentoCarregado)) ? $equipamentoCarregado['tipoEquip']: ""; ?></label><!-- Fim Titulo pagina -->
    </div>
</div>

<?php

    //var_dump($equipamentoCarregado);

	/*

 		array(1) { [0]=> array(12) { ["id"]=> string(1) "4" ["id_cliente"]=> string(1) "2" ["id_filial"]=> string(1) "0" ["tipo_equipamento"]=> string(6) "tretre" ["modelo"]=> string(5) "erter" ["potencia"]=> string(4) "4453" ["qnt_bateria"]=> string(5) "23323" ["caracteristica_equip"]=> string(5) "23423" ["tipo_bateria"]=> string(13) "Estacionária" ["amperagem_bateria"]=> string(5) "23423" ["cliente"]=> string(4) "Jose" ["filial"]=> NULL } }
	*/

?>

<div class="row">
	<div class="col-lg-12">

        <!-- formulario de cadastro -->
        <form id="editarEquipamento" method="post">

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cliente com o equipamento : </label>
                        <input id="idEquip" name="idEquip" type='hidden' value="<?php echo $this->parametros[0]; ?>">
                        <input id="clienteEquipamento" name="clienteEquipamento" type='hidden' value="<?php echo $equipamentoCarregado['id_cliente']; ?>">
                        <input id="filialEquipamento" name="filialEquipamento" type='hidden' value="<?php echo $equipamentoCarregado['id_filial']; ?>">
                        <input id="nomeCliente" name="nomeCliente" type='text'  class="form-control" value="<?php echo $equipamentoCarregado['cliente']; ?>">
                    </div>
                </div><!-- fim cliente -->

        		<div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Filial com o equipamento : </label>
                        <input id="nomeFilial" name="nomeFilial" type='text'  class="form-control" value="<?php echo (isset($equipamentoCarregado['filial'])) ? $equipamentoCarregado['filial']: "Matriz"; ?>">
                    </div>
                </div><!-- fim filial -->

            </div>

            <div class="row">
                <!-- TIPO DE EQUIPAMENTO -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoEquipamento">Tipo de Equipamento</label>
                        <select class="form-control" id="txt_tipoEquip" name="txt_tipoEquip" >
                            <option value=""> Selecione tipo</option>
                            <?php

                                if($tiposEncontrados != 0){
                                    foreach ($tiposEncontrados as $tipo) {
                                        if($tipo['id'] == $equipamentoCarregado['tipo_equipamento']){
                                            echo "<option value='".$tipo['id']."' selected>".$tipo['tipo_equipamento']."</option>";
                                        }else{
                                            echo "<option value='".$tipo['id']."'>".$tipo['tipo_equipamento']."</option>";
                                        }
                                    }
                                }else{
                                    echo "Nennuption m tipo de equipamento cadastrado.";
                                }

                            ?>
                        </select>
                    </div>
                </div><!-- fim tipo do equipamento -->

                <!-- FABRICANTE -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nome do Fabricante</label>
                        <select id="fabricante_opt" name="fabricante_opt" class="form-control">

                            <option  value="" >Selecione...</option>
                            <?php //$modelo->listaFabricante();

                                if($fabricantes != false){

                                    foreach ($fabricantes as $fabri) {

                                        if($fabri['id'] == $equipamentoCarregado['id_fabricante']){
                                            echo "<option  value='".$fabri['id']."' selected>".$fabri['nome']."</option>";
                                        }else{
                                            echo "<option  value='".$fabri['id']."' >".$fabri['nome']."</option>";
                                        }

                                    }

                                }else{
                                    echo "<option  value='' >Nennum fabricante cadastrado!</option>";
                                }

                            ?>

                        </select>

                    </div>
                </div><!-- fim fabricante -->

                <!-- MODELO DE EQUIPAMENTO -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="modeloEquipamento">Modelo de Equipamento</label>
                        <input type="text" class="form-control" id="txt_nomeModeloEquip" name="txt_nomeModeloEquip" placeholder="Modelo de Equipamento" value="<?php echo  $equipamentoCarregado['nomeModeloEquipamento']; ?>">
                    </div>
                </div><!-- fim modelo do equipamento -->
            </div>

            <div class="row">
                <!-- Entrada de equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="modeloEquipamento">Tipo entrada do equipamento</label>
                        <select id="opc_tipoEntrada" name="opc_tipoEntrada" spellcheck="false" class="form-control">
                            <option value='1' <?php echo ($equipamentoCarregado['tipo_entrada'] == '1') ? 'selected' : ''; ?> >Monofásico</option>
                            <option value='2' <?php echo ($equipamentoCarregado['tipo_entrada'] == '2') ? 'selected' : ''; ?> >Bifásico</option>
                            <option value='3' <?php echo ($equipamentoCarregado['tipo_entrada'] == '3') ? 'selected' : ''; ?> >Trifásico</option>
                        </select>
                    </div>
                </div><!-- fim entrada do equipamento -->

                <!-- Saída de equipamento -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="modeloEquipamento">Tipo saída do equipamento</label>
                        <select id="opc_tipoSaida" name="opc_tipoSaida" spellcheck="false" class="form-control">
                            <option value='1' <?php echo ($equipamentoCarregado['tipo_saida'] == '1') ? 'selected' : ''; ?> >Monofásico</option>
                            <option value='2' <?php echo ($equipamentoCarregado['tipo_saida'] == '2') ? 'selected' : ''; ?> >Bifásico</option>
                            <option value='3' <?php echo ($equipamentoCarregado['tipo_saida'] == '3') ? 'selected' : ''; ?> >Trifásico</option>
                        </select>
                    </div>
                </div><!-- fim saída do equipamento -->
            </div>

            <div class="row">

                <h4 class="page-header">Bateria do equipamento</h4>

                <!-- Corrente da bateria -->
               <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Corrente da bateria (V)</label>
                       <input type="text" class="form-control" id="txt_correnteBat" name="txt_correnteBat" placeholder="Corrente da bateria" value="<?php echo $equipamentoCarregado['correnteBateria']; ?>">
                   </div>
               </div><!-- fim corrente da bateria -->

                <!-- POTENCIA -->
               <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Pot&ecirc;ncia (Kva)</label>
                       <input type="text" class="form-control" id="txt_potencia" name="txt_potencia" placeholder="Pot&ecirc;ncia" value="<?php echo $equipamentoCarregado['potencia']; ?>">
                   </div>
               </div><!-- fim potencia -->

            </div>

            <div class="row">

                <!-- TENSÃO BANCO DE BATERIA -->
                <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Tensão do banco de bateria (V)</label>
                       <input type="text" class="form-control" id="txt_tensao_bancoBat" name="txt_tensao_bancoBat" placeholder="Tesão banco de bateria" value="<?php echo $equipamentoCarregado['tensaoBancoBateria']; ?>">
                   </div>
                </div><!-- TENSÃO BANCO DE BATERIA -->

                <!-- CORRENTE BANCO DE BATERIA -->
                <div class="col-md-4">
                   <div class="form-group">
                       <label for="Potencia">Corrente do banco de bateria (A)</label>
                       <input type="text" class="form-control" id="txt_correnteBancoBat" name="txt_correnteBancoBat" placeholder="Corrente do banco de bateria" value="<?php echo $equipamentoCarregado['correnteBancoBateria']; ?>">
                   </div>
                </div><!-- CORRENTE BANCO DE BATERIA -->

            </div>

            <div class="row">

                <!-- Quantidade de bateria -->
                <div class="col-md-4">
                   <div class="form-group">
                       <label for="qntBateria">Quantidade de bateria (Opcional)</label>
                       <input type="text" class="form-control" id="txt_qntBateria" name="txt_qntBateria" placeholder="Quantidade de bateria" maxlength="5"
                       onkeypress="retun onlyNumber(event);" value="<?php echo $equipamentoCarregado['qnt_bateria']; ?>">
                   </div>
                </div><!-- fim quantidade de bateria -->

                <!-- Quantidade de banco de bateria -->
                <div class="col-md-4">
                  <div class="form-group">
                      <label for="qntBateria">Quantidade de banco de bateria (Opcional)</label>
                      <input type="text" class="form-control" id="txt_qntBancoBateria" name="txt_qntBancoBateria" placeholder="Quantidade de bateria" maxlength="5"
                      onkeypress="retun onlyNumber(event);" value="<?php echo $equipamentoCarregado['quantidade_banco_bateria']; ?>">
                  </div>
                </div><!-- fim quantidade de bateria -->

                <!-- Quantidade de banco de bateria -->
                <div class="col-md-4">
                     <div class="form-group">
                         <label for="qntBateria">Quantidade de bateria por banco (Opcional)</label>
                         <input type="text" class="form-control" id="txt_qntBateriaPorBanco" name="txt_qntBateriaPorBanco" placeholder="Quantidade de bateria por banco" maxlength="5"
                         onkeypress="retun onlyNumber(event);" value="<?php echo $equipamentoCarregado['quantidade_bateria_por_banco']; ?>">
                     </div>
                </div><!-- fim quantidade de bateria -->

            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoBateria">Tipo de bateria</label>
                        <select id="opc_tipoBateria" name="opc_tipoBateria" spellcheck="false" class="form-control">
                            <option value='' <?php echo ($equipamentoCarregado['tipo_bateria'] == '') ? 'selected' : ''; ?> >Selecione um tipo de bateria</option>
                            <option value='Selada' <?php echo ($equipamentoCarregado['tipo_bateria'] == 'Selada') ? 'selected' : ''; ?> >Selada</option>
                            <option value='Automotiva' <?php echo ($equipamentoCarregado['tipo_bateria'] == 'Automotiva') ? 'selected' : ''; ?> >Automotiva</option>
                            <option value='Estacion&aacute;ria' <?php echo ($equipamentoCarregado['tipo_bateria'] == 'Estacionária') ? 'selected' : ''; ?> >Estacion&aacute;ria</option>
                        </select>
                    </div>
                </div><!-- fim Tipo de bateria -->

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipoBateria">Banco de bateria externo/interno</label>
                        <select id="opc_localBat" name="opc_localBat" spellcheck="false" class="form-control">
                            <option value='' <?php echo ($equipamentoCarregado['localBateria'] == '') ? 'selected' : ''; ?> >Selecione um tipo de bateria</option>
                            <option value='Externa' <?php echo ($equipamentoCarregado['localBateria'] == 'Externa') ? 'selected' : ''; ?> >Externa</option>
                            <option value='Interna' <?php echo ($equipamentoCarregado['localBateria'] == 'Interna') ? 'selected' : ''; ?> >Interna</option>
                        </select>
                    </div>
                </div><!-- fim Tipo de bateria -->

            </div>

            <!-- botao de enviar -->
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <div class=" txt-center"><button id="validarEdicaoEquipamento" type="button" name="btn_salvar" class="btn btn-info btn-lg btn-block" value="Salvar">Salvar equipamento</button></div>
                </div>
            </div><!-- fim do botao de envio -->

        </form>

    </div>
</div>
