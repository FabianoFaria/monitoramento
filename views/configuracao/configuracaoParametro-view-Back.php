<?php

if (!defined('EFIPATH')) exit();

// Carregaas configurações do equipamento, se existirem
$configuracaoEquip  = $modelo->carregarConfiguracaoEquip($this->parametros[0]);

var_dump($configuracaoEquip);

if($configuracaoEquip['status']){
    $parametrosEquip    = $configuracaoEquip['param'];
}else{
    $parametrosEquip    = 0;
}

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

            <!-- form contendo os dados do cliente -->
            <form id="formConfiguracaoParametros" method="post">

                    <div class="row">
                        <div class="col-lg-12">
                           <div class="panel panel-default">
                               <div class="panel-heading">
                                  ENTRADA
                               </div>
                               <div class="panel-body">

                                   <?php

                                       for ($a=1; $a<4; $a++)
                                       {

                                    ?>
                                        <div class="row">

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="page-header" for="exampleInputEmail1">Entrada <?php echo $a?> </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fontsub">Valor Baixo</label>
                                                    <input type="text" class="form-control" id="eb-<?php echo $a;?>" name="eb-<?php echo $a;?>" placeholder="000,00" maxlength="7" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fontsub">Valor tolerância 1</label>
                                                    <input type="text" class="form-control" id="et-<?php echo $a;?>" name="et-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fontsub">Valor Ideal</label>
                                                    <input type="text" class="form-control" id="ei-<?php echo $a;?>" name="ei-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fontsub">Valor tolerância 2</label>
                                                    <input type="text" class="form-control" id="et2-<?php echo $a;?>" name="et2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="fontsub">Valor Alto</label>
                                                    <input type="text" class="form-control" id="ea-<?php echo $a;?>" name="ea-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                                </div>
                                            </div>

                                        </div>
                                    <?php

                                       }

                                   ?>

                               </div>
                               <div class="panel-footer">

                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="row">
                       <div class="col-lg-12">
                          <div class="panel panel-default">
                              <div class="panel-heading">
                                  SAÍDA
                              </div>
                              <div class="panel-body">

                                <?php

                                    for ($a=1; $a<4; $a++)
                                    {

                                ?>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="page-header" for="exampleInputEmail1">Saída <?php echo $a?> </label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="fontsub">Valor Baixo</label>
                                                <input type="text" class="form-control" id="eb-<?php echo $a;?>" name="eb-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="fontsub">Valor toler&acirc;ncia 1</label>
                                                <input type="text" class="form-control" id="st1-<?php echo $a;?>" name="st1-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="fontsub">Valor Ideal</label>
                                                <input type="text" class="form-control" id="ei-<?php echo $a;?>" name="ei-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="fontsub">Valor tolerância 2</label>
                                                <input type="text" class="form-control" id="et2-<?php echo $a;?>" name="et2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="fontsub">Valor Alto</label>
                                                <input type="text" class="form-control" id="ea-<?php echo $a;?>" name="ea-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="">
                                            </div>
                                        </div>
                                    </div>
                                <?php

                                    }

                                ?>

                              </div>
                              <div class="panel-footer">

                              </div>
                          </div>
                      </div>
                   </div>

                   <div class="row">
                       <div class="col-lg-12">
                          <div class="panel panel-default">
                              <div class="panel-heading">
                                  TENSÃO
                              </div>
                              <div class="panel-body">

                                <?php

                                    for ($a=1; $a<3; $a++)
                                    {
                                ?>
                                    <div>




                                <?php

                                    }


                                ?>

                              </div>
                              <div class="panel-footer">

                              </div>
                          </div>
                      </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4">
                       </div>
                       <div class="col-md-4 ">
                         <div class="form-group">
                           <button id="salvarConfiguracaoParam" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar parametros</button</div>
                           <input id="idParametros" name="idParametros" type="hidden" value="">
                         </div>
                       </div>
                   </div>
                </form>
        </div>
    </div>



    <div class="container fontPadrao">
        <form method="post">

            <?php
                $mult = 0;
                for ($a=1; $a<4; $a++)
                {
                    // Variavel de controle
            ?>

            <!-- Entrada -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Entrada <?php echo $a?> </label>
                    </div>
                </div>
            </div>

            <div class="row">


                <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor tolerância 1</label>
                    <input type="text" class="form-control" id="et-<?php echo $a;?>" name="et-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>

            <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Ideal</label>
                    <input type="text" class="form-control" id="ei-<?php echo $a;?>" name="ei-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>

            <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor tolerância 2</label>
                    <input type="text" class="form-control" id="et2-<?php echo $a;?>" name="et2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>

            <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Alto</label>
                    <input type="text" class="form-control" id="ea-<?php echo $a;?>" name="ea-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
        </div><!-- Fim entrada -->


        <?php
                $mult++;
            } for ($a=1; $a<4; $a++) {
        ?>


        <!-- saida -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Sa&iacute;da <?php echo $a;?> </label>
                </div>
            </div>

            <?php ;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Baixo</label>
                    <input type="text" class="form-control" id="sb-<?php echo $a;?>" name="sb-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>

            <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor toler&acirc;ncia 1</label>
                    <input type="text" class="form-control" id="st1-<?php echo $a;?>" name="st1-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>

            <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Ideal</label>
                    <input type="text" class="form-control" id="si-<?php echo $a;?>" name="si-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>

            <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Toler&acirc;ncia 2</label>
                    <input type="text" class="form-control" id="st2-<?php echo $a;?>" name="st2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>

            <?php $mult++;?>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Alto</label>
                    <input type="text" class="form-control" id="sa-<?php echo $a;?>" name="sa-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
        </div><!-- Fim saida -->

        <?php
            $mult++;
            }
        ?>

        <!-- botao de envio -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center">
                <input type="submit" class="btn btn-info" id="btn_enviarConf" name="btn_enviar" value="Salvar">
            </div>
        </div><!-- fim botao de envio -->
    </form>
</div>



<!--

    Trecho para back up

-->


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
