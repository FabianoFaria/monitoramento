<?php

if (!defined('EFIPATH')) exit();

// Carregaas configurações do equipamento, se existirem
$configuracaoEquip  = $modelo->carregarConfiguracaoEquip($this->parametros[0]);
$detalhesEquip      = $modeloEquip->detalhesEquipamentoParaConfiguracao($this->parametros[0]);
$dadosEquipamento   = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);

//CARREGAR CONTATOS QUE RECEBERÃO OS EMAILS DE ALERTA
if($dadosEquipamento['status']){

    $idFilial   = $dadosEquipamento['equipamento'][0]['id_filial'];
    $idCliente  = $dadosEquipamento['equipamento'][0]['id_cliente'];
    /*
        'id_cliente' => string '48' (length=2)
        'id_filial' => string '0' (length=1)
    */

    $listaContatos = $modeloAlarm->listarContatoAlarmes($idCliente, $idFilial);

}


if($configuracaoEquip['status']){
    $parametrosEquip    = $configuracaoEquip['param'][0];
    /*
    * Efetua o tratamento dos dados de configuração para exibição
    */
    $configuracaoSalva = explode('|inicio|',$parametrosEquip['parametro']);

}else{
    $parametrosEquip    = 0;
}

if($detalhesEquip['status']){
    $equipDetalhe = $detalhesEquip['equipamento'][0];
}else{
    $equipDetalhe = 0;
}

//var_dump($dadosEquipamento);

//var_dump($configuracaoSalva);

//var_dump($detalhesEquip);

// Carrega os clientes
//$retorno = $modelo->carregaParametroForm();

// Salva as configuracoes do cliente
//$modelo->chamaSalvaParametro();

// Verifica se a respota nao esta vazia e existe
// if (isset($retorno) && ! empty ($retorno) && is_array($retorno))
// {
//     // Separa os elementos da string em array
//     $retorno = explode("|",$retorno[0]);
//
//     // Quebra o retorno da tabela em uma array
//     foreach($retorno as $row)
//     {
//         // Array auxiliar para separar os valores da tabela
//         $row2 = explode("-",$row);
//         // Armazena os dados na array
//         $ret[] = $row2[2];
//     }
//     // Destroi a array auxiliar
//     unset($row2);
// }
?>

<script type="text/javascript">
    // Gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento/" class="linkMenuSup">Equipamentos</a> / <a href="<?php echo HOME_URI; ?>/configuracao/configurarEquipamentoCliente/<?php echo $this->parametros[0]; ?>" class="linkMenuSup">Configura parametros do equipamento</a>';
</script>

<!-- Jquery file -->
<script src="<?php echo HOME_URI; ?>/views/_js/pages/jquery.js"></script>


<div class="row">
    <div class="col-md-12">

        <!-- TITULO PAGINA -->
       <label class="page-header">Configurar parametros do equipamento :</label><!-- Fim Titulo pagina -->

            <?php
                //Caso o equipamento possua informações de vinculo com o SIM
                if(!is_numeric($equipDetalhe)){

                    //var_dump($configuracaoSalva);
            ?>

                <!-- Informações necessarias para o cadastro/atualização das configurações -->
                <input id="id_sim_equip" name="id_sim_equip" type="hidden" value="<?php echo $equipDetalhe['id']; ?>" />
                <input id="id_equip" name="id_equip" type="hidden" value="<?php echo $equipDetalhe['id_equipamento']; ?>" />
                <input id="num_sim" name="num_sim" type="hidden" value="<?php echo $equipDetalhe['id_sim']; ?>" />
                <input id="idParametros" name="idParametros" type="hidden" value="<?php echo ($parametrosEquip != 0) ? $parametrosEquip['id']: ""; ?>">

            <?php
                //Testa o tipo de equipamento a ser configurado

                switch ($dadosEquipamento['equipamento'][0]['tipoEquip']) {
                    case 'Medidor temperatura':

                    //Processamento de configuração de Medidor de temperatura
                    ?>
                    <form id="formConfigDiferenciado" method="post">
                        <div class="row">

                            <?php

                                if(isset($configuracaoSalva)){
                                    $valoresEntrada = explode('|', $configuracaoSalva[1]);
                                }

                            ?>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                       Medida de temperatura
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="page-header" for="exampleInputEmail1">Medidas (°C) </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="ecb" name="ecb" placeholder="000,00" maxlength="7" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[0]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="eb" name="eb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[1]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="ei" name="ei" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[2]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="ea" name="ea" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[3]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control " id="eca" name="eca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[4]) : ""; ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group">
                                                    <button id="salvarConfiguracaoParametros" type="button" name="btn_salvar" class="btn btn-info btn-group btn-group-justified" value="Salvar">Salvar parametros</button>
                                                </div>
                                             </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <?php

                    break;

                    default:

                    //Processamento normal de configuração de no break
                    ?>
                    <!-- Form reformulado conforme alterações na forma de cofigurar os parametros -->
                    <form id="formConfigDiferenciado" method="post">
                        <div class="row">

                            <?php

                                if(isset($configuracaoSalva)){
                                    $valoresEntrada = explode('|', $configuracaoSalva[1]);
                                }

                            ?>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                       Tensão de entrada
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="page-header" for="exampleInputEmail1">Entrada </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="ecb" name="ecb" placeholder="000,00" maxlength="7" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[0]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="eb" name="eb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[1]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="ei" name="ei" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[2]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="ea" name="ea" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[3]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control " id="eca" name="eca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[4]) : ""; ?>">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <?php

                                    //$valoresSaida = explode('|', $configuracaoSalva[2]);
                                    if(isset($configuracaoSalva)){
                                        $valoresSaida = explode('|', $configuracaoSalva[2]);
                                    }
                            ?>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Tensão saída
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="page-header" for="exampleInputEmail1">Saída</label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="scb" name="scb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresSaida[0]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="sb" name="sb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresSaida[1]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="si" name="si" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresSaida[2]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="sa" name="sa" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresSaida[3]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control" id="sca" name="sca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresSaida[4]) : ""; ?>">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <?php

                                //$valoresBateria = explode('|', $configuracaoSalva[3]);
                                if(isset($configuracaoSalva)){
                                    $valoresBateria = explode('|', $configuracaoSalva[3]);
                                }
                            ?>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Tensão bateria
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label class="page-header" for="exampleInputEmail1">Bateria</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="tbcb" name="tbcb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresBateria[0]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="tbb" name="tbb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresBateria[1]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="tbi" name="tbi" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresBateria[2]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="tba" name="tba" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresBateria[3]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control" id="tbca" name="tbca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresBateria[4]) : ""; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <?php

                                //$valoresCorrente = explode('|', $configuracaoSalva[4]);
                                if(isset($configuracaoSalva)){
                                    $valoresCorrente = explode('|', $configuracaoSalva[4]);
                                }
                            ?>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Corrente entrada
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label class="page-header" for="exampleInputEmail1">Entrada</label>
                                                </div>
                                            </div>
                                                <div class="col-md-2">
                                                    <div class="form-group has-error">
                                                        <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                        <input type="text" class="form-control" id="ccb" name="ccb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrente[0]) : ""; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group has-warning">
                                                        <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                        <input type="text" class="form-control" id="cb" name="cb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrente[1]) : ""; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group has-success">
                                                        <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                        <input type="text" class="form-control" id="ci" name="ci" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrente[2]) : ""; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group has-warning">
                                                        <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                        <input type="text" class="form-control" id="ca" name="ca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrente[3]) : ""; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group has-error">
                                                        <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                        <input type="text" class="form-control" id="cca" name="cca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrente[4]) : ""; ?>">
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php

                              //$valoresCorrenteSaida = explode('|', $configuracaoSalva[5]);
                              if(isset($configuracaoSalva)){
                                  $valoresCorrenteSaida = explode('|', $configuracaoSalva[5]);
                              }
                            ?>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Corrente saída
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label class="page-header" for="exampleInputEmail1">Saída</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="cscb" name="cscb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrenteSaida[0]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="csb" name="csb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrenteSaida[1]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="csi" name="csi" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrenteSaida[2]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="csa" name="csa" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrenteSaida[3]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control" id="csca" name="csca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresCorrenteSaida[4]) : ""; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                          //$valoresCorrenteSaida = explode('|', $configuracaoSalva[5]);
                          if(isset($configuracaoSalva)){
                              $valoresTemperaturaAmbiente = explode('|', $configuracaoSalva[6]);
                          }
                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Temperatura ambiente
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label class="page-header" for="exampleInputEmail1">Medidas (°C)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputTemp" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="tacb" name="tacb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaAmbiente[0]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputTemp" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="tasb" name="tasb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaAmbiente[1]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputTemp" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="tasi" name="tasi" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaAmbiente[2]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputTemp" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="tasa" name="tasa" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaAmbiente[3]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control" id="tasca" name="tasca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaAmbiente[4]) : ""; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                          //$valoresCorrenteSaida = explode('|', $configuracaoSalva[5]);
                          if(isset($configuracaoSalva)){
                              $valoresTemperaturaBancoBat = explode('|', $configuracaoSalva[7]);
                          }
                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Temperatura banco de bateria
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label class="page-header" for="exampleInputEmail1">Medidas (°C)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputTemp" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="tbbcb" name="tbbcb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaBancoBat[0]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputTemp" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="tbbb" name="tbbb" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaBancoBat[1]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputTemp" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="tbbsi" name="tbbsi" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaBancoBat[2]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputTemp" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="tbbsa" name="tbbsa" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaBancoBat[3]) : ""; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control" id="tbbsca" name="tbbsca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresTemperaturaBancoBat[4]) : ""; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <button id="salvarConfiguracaoParametros" type="button" name="btn_salvar" class="btn btn-info btn-group btn-group-justified" value="Salvar">Salvar parametros</button>
                                </div>
                             </div>
                        </div>

                        <!-- CARREGA AS CONFIGURAÇÔES DE CARREGARDOR DE BATERIA -->
                        <script>

                            /*
                            * PARAMETROS PARA ALARME DE CARREGADOR DE BATERIA, CARREGANDO A QUANTIDADE DE BATERIAS POR BANCOS
                            */
                            var parametrosBateriasPorBanco          = "";
                            var id_equipamento_carregar_parametro   = $('#id_equip').val();

                            $.ajax({
                                url: "<?php echo HOME_URI; ?>/configuracao/cadastrarConfiguracaoCarregadorBateriaJson",
                                secureuri: false,
                                type : "POST",
                                dataType: 'json',
                                data      : {
                                    'id_equipamento' : id_equipamento_carregar_parametro
                                },
                                success : function(datra)
                                {
                                    if(datra.status){
                                        //FOI CARREGADO A QUANTIDADE DE BATERIAS POR BANCO, GERANDO AS MEDIDAS PARA CONFIGURAÇÂO DO CARREGADOR
                                        //parametrosBateriasPorBanco = datra.parametros;
                                        $('#valorCarregadorBateriaTemp').html(datra.parametros);
                                        //CONCATENA OS VALORES CARREGADOS COM OS PARAMETROS DA QUANTIDADE DE BATERIA POR BANCO
                                        //paramConcatenados = paramConcatenados.concat(datra.parametros);
                                    }else{
                                        //AO OCORRER ERRO DE CARREGAMENTO DA QUANTIDADE DE BATERIA POR BANCO, DEIXA AS MEDIDA COM UM VALOR ZERADO
                                        //parametrosBateriasPorBanco = datra.parametros;
                                        $('#valorCarregadorBateriaTemp').html(datra.parametros);
                                        //CONCATENA OS VALORES CARREGADOS COM OS PARAMETROS DA QUANTIDADE DE BATERIA POR BANCO
                                        // paramConcatenados = paramConcatenados.concat(datra.parametros);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown)
                                {
                                 // Handle errors here
                                 console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                                 // STOP LOADING SPINNER
                                }
                            });
                        </script>

                        <span id="valorCarregadorBateriaTemp" style="display:none"></span>

                    </form>

                    <?php

                    break;
                }


            ?>

            <?php
                }else{

                //Caso o equipamento não esteja vinculado a um SIM
            ?>
                <div class="row">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            Equipamento sem vinculo com o SIM
                        </div>
                        <div class="panel-body">
                            <p>Favor verificar o vínculo do equipamento com um número SIM antes de registrar as configurações!</p>
                            <p>
                                <a href="<?php echo HOME_URI ?>/vinculo/vincularEquipamentoSim/<?php echo $this->parametros[0]; ?>"><b>Vincular equipamento a um SIM!</b></a>
                            </p>
                        </div>
                        <div class="panel-footer">

                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
    </div>
</div>

<!-- formulario de contatos -->
<div class="row">
    <div id="painelCadastro" class="col-lg-12">

        <label class="page-header">Gerenciar recebimento de alarmes</label>

        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <a role="button" data-toggle="collapse" data-parent="#painelCadastro" href="#collapseCadastro" aria-expanded="true" aria-controls="collapseOne">
                  <i class="fa fa-user-md "></i> Cadastrar novo contato para alarme
                </a>
            </div>
            <div id="collapseCadastro" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <!-- formulario de cadastro -->
                    <form id="novoContatoAlarme" method="post">
                        <div class="row">

                            <input id="idMatriz" name="idMatriz" type="hidden" value="<?php echo $idCliente; ?>" />
                            <input id="sedeContato" name="sedeContato" type="hidden" value="<?php echo $idFilial; ?>" />

                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Selecione o local do contato : </label>
                                    <select class="form-control" id="sedeContato">
                                        <option value=""> Selecione a matriz ou filial</option> -->
                                        <?php
                                            // if($filiais !=0){
                                            //     echo "<option value='0'> Matriz </option>";
                                            //     foreach ($filiais as $filial) {
                                            //         echo "<option value='".$filial['id']."'> ".$filial['nome']." </option>";
                                            //     }
                                            // }else{
                                            //     echo "<option value='0'> Contato matriz </option>";
                                            // }
                                        ?>
                                    <!-- </select>
                                </div>
                            </div> -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome do contato : </label>
                                    <input type="text" class="form-control" id="txt_nomeContato" name="txt_nomeContato" placeholder="Nome para contato" maxlength="80" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Função : </label>
                                    <input type="text" class="form-control" id="txt_funcao" name="txt_funcao" placeholder="Função do contato" maxlength="80" value="">
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email : </label>
                                    <input type="text" class="form-control" id="txt_email" name="txt_email" placeholder="Email do contato" maxlength="80" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Celular : </label>
                                    <input type="text" class="form-control" id="txt_celular" name="txt_celular" placeholder="Celular do contato" maxlength="80" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Observações : </label>
                                    <textarea id="txt_obs" name="txt_obs" class="form-control" ></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <button type="button" id="registrarContato" class="btn btn-info">Registrar contato para alarme</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="md-col-12">

        <!-- Contatos de alarme já cadastrados -->
        <div class="row">
            <div class="col-lg-12">
                <!-- TABELA CONTENDO TODOS OS CLIENTES -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>
                                    Contatos para receber alerta deste equipamento
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <!-- <select class="form-control" id="listarSedes">
                                    <option value=""> Selecione a matriz ou filial</option> -->
                                    <?php

                                        // var_dump($listaContatos);
                                        // if($filiais !=0){
                                        //     echo "<option value='0'> Matriz </option>";
                                        //     foreach ($filiais as $filial) {
                                        //         echo "<option value='".$filial['id']."'> ".$filial['nome']." </option>";
                                        //     }
                                        // }else{
                                        //     echo "<option value='0'> Contato matriz </option>";
                                        // }
                                    ?>
                                <!-- </select> -->
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class='table-responsive'>
                                <table id="stream_table_contatos" class='table table-striped table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Função</th>
                                            <th>Email</th>
                                            <th>Celular</th>
                                            <th>Observação</th>
                                            <th class="txt-center">Editar</th>
                                            <th class="txt-center">Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            if($listaContatos['status']){

                                                foreach ($listaContatos['contatos'] as $contato) {

                                                ?>
                                                    <tr>
                                                    <td> <?php echo  $contato['nome_contato']; ?></td>
                                                    <td> <?php echo  $contato['funcao']; ?> </td>
                                                    <td> <?php echo  $contato['email']; ?></td>
                                                    <td> <?php echo  $contato['celular']; ?></td>
                                                    <td> <?php echo  $contato['observacao']; ?></td>
                                                    <td id='linkConta_<?php echo $contato['id']; ?>'><a href='javascript:void(0);' onClick='atualizarContato("<?php echo $contato['id']; ?>")'><i class='fa fa-eye '></i></a></td>
                                                    <td><a href='javascript:void(0);' onClick='removerContato(<?php echo $contato['id']; ?>)'><i class='fa fa-times '></i></a></td>
                                                    </tr>
                                                <?php
                                                }

                                            }else{
                                                ?>
                                                    <tr>
                                                        <td colspan="7">
                                                            Nenhum contato cadastrado ainda.
                                                        </td>
                                                    </tr>
                                                <?php
                                            }



                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL PARA A EDIÇÃO DE CONTATO PARA RECEBER ALERTA -->

<div  id="editContato" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar contato</h4>
      </div>
      <div class="modal-body">
          <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-user-md "></i> Dados do contato para alarme
              </div>
              <div class="panel-body">
                  <form id="edicaoContatoAlarme" method="post">
                      <div class="row">
                          <input id="idContatoEditar" name="idContatoEditar" type="hidden" value="" />

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Nome do contato : </label>
                                  <input type="text" class="form-control" id="txt_nomeContato_edit" name="txt_nomeContato_edit" placeholder="Nome para contato" maxlength="80" value="">
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Função : </label>
                                  <input type="text" class="form-control" id="txt_funcao_edit" name="txt_funcao_edit" placeholder="Função do contato" maxlength="80" value="">
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Email : </label>
                                  <input type="text" class="form-control" id="txt_email_edit" name="txt_email_edit" placeholder="Email do contato" maxlength="80" value="">
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Celular : </label>
                                  <input type="text" class="form-control" id="txt_celular_edit" name="txt_celular_edit" placeholder="Celular do contato" maxlength="80" value="">
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Observações : </label>
                                  <textarea id="txt_obs_edit" name="txt_obs_edit" class="form-control" ></textarea>
                              </div>
                          </div>

                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="registraAlteracao" type="button" class="btn btn-primary">Salvar alterações</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
