<?php

if (!defined('EFIPATH')) exit();

// Carregaas configurações do equipamento, se existirem
$configuracaoEquip  = $modelo->carregarConfiguracaoEquip($this->parametros[0]);
$detalhesEquip      = $modeloEquip->detalhesEquipamentoParaConfiguracao($this->parametros[0]);



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

//var_dump($configuracaoSalva);

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

                <!-- Form reformulado conforme alterações na forma de cofigurar os parametros -->
                <form id="formConfigDiferenciado" method="post">
                    <div class="row">

                        <?php

                                $valoresEntrada = explode('|', $configuracaoSalva[1]);

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
                                                <input type="text" class="form-control" id="ecb" name="ecb" placeholder="000,00" maxlength="7" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[0]) : ""; ?>">
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
                                                <input type="text" class="form-control" id="ei" name="ei" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[2]) : ""; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group has-warning">
                                                <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                <input type="text" class="form-control" id="ea" name="ea" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[3]) : ""; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group has-error">
                                                <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                <input type="text" class="form-control " id="eca" name="eca" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[4]) : ""; ?>">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <?php

                                $valoresSaida = explode('|', $configuracaoSalva[2]);

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

                            $valoresBateria = explode('|', $configuracaoSalva[3]);

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

                            $valoresCorrente = explode('|', $configuracaoSalva[4]);

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

                          $valoresCorrenteSaida = explode('|', $configuracaoSalva[5]);

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

                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <button id="salvarConfiguracaoParametros" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar parametros</button>
                            </div>
                         </div>
                    </div>

                </form>

                <!-- form contendo os dados do cliente -->
                <!-- <form id="formConfiguracaoParametros" method="post"> -->

                        <!-- <div class="row">
                            <div class="col-lg-12">
                               <div class="panel panel-default">
                                   <div class="panel-heading">
                                      ENTRADA
                                   </div>
                                   <div class="panel-body"> -->

                                       <?php

                                        //    for ($a=1; $a<4; $a++)
                                        //    {
                                           //
                                        //        //Caso seja uma edição de configuração
                                        //        if(!is_numeric($parametrosEquip)){
                                        //            // AMOSTRA STRING ESPERADA : 'eb-1-0|et1-1-0|ei-1-0|et2-1-0|ea-1-0|'
                                        //            $valoresEntrada = explode('|', $configuracaoSalva[$a]);
                                           //
                                        //        }

                                        ?>
                                            <!-- <div class="row">

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="page-header" for="exampleInputEmail1">Entrada <?php echo $a?> </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group has-error">
                                                        <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                        <input type="text" class="form-control" id="eb-<?php echo $a;?>" name="eb-<?php echo $a;?>" placeholder="000,00" maxlength="7" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[0]) : ""; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group has-warning">
                                                        <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                        <input type="text" class="form-control" id="et-<?php echo $a;?>" name="et-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[1]) : ""; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group has-success">
                                                        <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                        <input type="text" class="form-control" id="ei-<?php echo $a;?>" name="ei-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[2]) : ""; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group has-warning">
                                                        <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                        <input type="text" class="form-control" id="et2-<?php echo $a;?>" name="et2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[3]) : ""; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group has-error">
                                                        <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                        <input type="text" class="form-control " id="ea-<?php echo $a;?>" name="ea-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[4]) : ""; ?>">
                                                    </div>
                                                </div>

                                            </div> -->
                                        <?php
                                           //
                                        //    }

                                       ?>

                                   <!-- </div>
                                   <div class="panel-footer">

                                   </div>
                               </div>
                           </div>
                       </div> -->

                       <!-- <div class="row">
                           <div class="col-lg-12">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      SAÍDA
                                  </div>
                                  <div class="panel-body"> -->

                                    <?php

                                        // for ($a=1; $a<4; $a++)
                                        // {
                                        //     //Caso seja uma edição de configuração
                                        //     if(!is_numeric($parametrosEquip)){
                                        //         // AMOSTRA STRING ESPERADA : 'eb-1-0|et1-1-0|ei-1-0|et2-1-0|ea-1-0|'
                                        //         $valoresEntrada = explode('|', $configuracaoSalva[$a + 3]);
                                        //
                                        //     }
                                    ?>
                                        <!-- <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="page-header" for="exampleInputEmail1">Saída <?php echo $a?> </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="sb-<?php echo $a;?>" name="sb-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[0]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="st1-<?php echo $a;?>" name="st1-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[1]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="si-<?php echo $a;?>" name="si-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[2]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="st2-<?php echo $a;?>" name="st2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[3]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control" id="sa-<?php echo $a;?>" name="sa-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[4]) : ""; ?>">
                                                </div>
                                            </div>
                                        </div> -->
                                    <?php

                                        // }

                                    ?>

                                  <!-- </div>
                                  <div class="panel-footer">

                                  </div>
                              </div>
                          </div>
                       </div> -->

                       <!-- <div class="row">
                           <div class="col-lg-12">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      TENSÃO BATERIA(S)
                                  </div>
                                  <div class="panel-body"> -->

                                    <?php

                                        // for ($a=1; $a<3; $a++)
                                        // {
                                        //
                                        //     //Caso seja uma edição de configuração
                                        //     if(!is_numeric($parametrosEquip)){
                                        //         // AMOSTRA STRING ESPERADA : 'eb-1-0|et1-1-0|ei-1-0|et2-1-0|ea-1-0|'
                                        //         $valoresEntrada = explode('|', $configuracaoSalva[$a + 6]);
                                        //
                                        //     }
                                    ?>
                                        <!-- <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                    <label class="page-header" for="exampleInputEmail1">Tensão <?php echo $a?> </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico baixo</label>
                                                    <input type="text" class="form-control" id="tb-<?php echo $a;?>" name="tb-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[0]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor baixo</label>
                                                    <input type="text" class="form-control" id="tt1-<?php echo $a;?>" name="tt1-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[1]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-success">
                                                    <label for="exampleInputEmail1" class="control-label">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="ti-<?php echo $a;?>" name="ti-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[2]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-warning">
                                                    <label for="exampleInputEmail1" class="control-label">Valor alto</label>
                                                    <input type="text" class="form-control" id="tt2-<?php echo $a;?>" name="tt2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[3]) : ""; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group has-error">
                                                    <label for="exampleInputEmail1" class="control-label">Valor crítico alto</label>
                                                    <input type="text" class="form-control" id="ta-<?php echo $a;?>" name="ta-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="" value="<?php echo  (!is_numeric($parametrosEquip)) ? $this->trataValor($valoresEntrada[4]) : ""; ?>">
                                                </div>
                                            </div>
                                        </div> -->

                                    <?php

                                        // }

                                    ?>
<!--
                                  </div>
                                  <div class="panel-footer">

                                  </div>
                              </div>
                          </div>
                       </div> -->
                       <!-- <div class="row">
                           <div class="col-md-4">
                           </div>
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <button id="salvarConfiguracaoParam" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar parametros</button>
                               </div>
                            </div>
                        </div>
                </form> -->

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
