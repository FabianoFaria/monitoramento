<!-- VINCULAR EQUIPAMENTO DO CLIENTE COM O SIM VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* Carrega os dados do cliente */
    //$dados       = $modeloClie->listarCliente();
    $equipamento = $modelo->dadosEquipamentoCliente($this->parametros[0]);

    if($equipamento['status']){
        $dadosEquipamentos = $equipamento['equipamento'][0];
    }else{
        $dadosEquipamentos = NULL;
    }

    //Carrega os SIMs que foram vinculados a este cliente e filial
    if(isset($dadosEquipamentos['filial']) && ($dadosEquipamentos['id_filial'] != 0)){
        $dadosCliente   =  $modeloClie->listarSimCliente($dadosEquipamentos['id_cliente'], $dadosEquipamentos['id_filial']);
    }else{
        $dadosCliente   = $modeloClie->listarSimClienteMatriz($dadosEquipamentos['id']);
    }

	//var_dump($dadosEquipamentos);
    //var_dump($dadosCliente);


?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento">Listar equipamentos</a> / <a href="<?php echo HOME_URI; ?>/vinculo/vincularEquipamentoSim/<?php echo $this->parametros[0]; ?>">Vincular equipamento</a>';
</script>

<!-- Jquery file -->
<script src="<?php echo HOME_URI; ?>/views/_js/pages/jquery.js"></script>

<div class="row">
    <div class="col-md-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Vincular SIM para o equipamento : <?php echo ""; ?></label><!-- Fim Titulo pagina -->


        <!-- formulario de cadastro -->
        <form id="novoEquipamento" method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="numeroSerie">Equipamento para vincular</label>
                        <input type="hidden" id="idEquipamento" name="idEquipamento" value="<?php echo $dadosEquipamentos['id'];?>" />
                        <input type="hidden" id="idTipoEquipamento" name="idTipoEquipamento" value="<?php echo $dadosEquipamentos['tipo_equipamento'];?>" />
                        <input type="text" id="equipamentoVincular" class="form-control" value="<?php echo $dadosEquipamentos['tipoEquip']." ".$dadosEquipamentos['nomeModeloEquipamento']; ?>" disabled="">
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <!-- SELECT PARA VINCULAR O SIM AO CLIENTE OU FILIAL -->

                        <label for="numeroSerie">Selecione o número de série para vincular</label>
                        <?php
                            $count = 0;
                            $opcoes = "<option value=''>Selecione um SIM</option>";

                            if($dadosCliente['status']){
                                foreach ($dadosCliente['dados'] as $clienteSim) {
                                    if(isset($clienteSim['num_sim'])){
                                        $opcoes .= "<option value='".$clienteSim['num_sim']."'>".$clienteSim['num_sim']."</option>";
                                        $count++;
                                    }
                                }
                            }

                        ?>
                        <select id="simVinculadoCliente" class="form-control" name="simVinculadoCliente">
                            <?php
                                if($count >0){
                                    echo $opcoes;
                                }else{
                                    echo "<option value=''>Favor vincular um SIM a um cliente antes</option>";
                                }

                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Numero de serie -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="numeroSerie">N&uacute;mero de s&eacute;rie (Opcional)</label>
                        <input type="text" class="form-control" id="txt_numeroSerie" name="txt_numeroSerie" placeholder="N&uacute;mero de s&eacute;rie"
                        maxlength="30" onkeypress="return onlyNumber(event);" value="">
                    </div>
                </div>-->
                <!-- fim Numero de serie -->

                <!-- Ambiente -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ambiente">Observações do equipamento (Opcional)</label>
                        <textarea class="form-control" id="txt_ambiente" name="txt_ambiente"></textarea>
                    </div>
                </div><!-- fim Ambiente -->

            </div>
            <!-- botao de envio -->
            <div class="row">
                <div class="col-md-2 col-md-offset-5 txt-center">
                    <button type="button" id="btnVincularEquipamento" class="btn btn-info">Vincular</button>
                </div>
            </div><!-- fim botao de envio -->

        </form>


    </div>
</div>
<div class="row">
    <div class="col-md-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Gerenciar sims do cliente : <?php echo ($dadosCliente['dados'] != '' ) ?  $dadosCliente['dados'][0]['cliente'] : ""; ?></label><!-- Fim Titulo pagina -->
        <p>
            <a href="<?php echo HOME_URI; ?>/vinculo/gerenciarVinculo/<?php echo $dadosEquipamentos['id_cliente']; ?>">Gerenciar sims</a>
        </p>
        <?php
            //var_dump($dadosCliente);

            /*
            C:\wamp64\www\eficazmonitor\views\vinculo\vincularSimEquipamento-view.php:128:
            array (size=2)
            'status' => boolean true
            'dados' =>
            array (size=1)
              0 =>
                array (size=3)
                  'cliente' => string 'Correntes Andromeda' (length=19)
                  'filial' => string 'Filial Eater' (length=12)
                  'num_sim' => null
            */
        ?>

    </div>
</div>
