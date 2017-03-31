<?php

if (!defined('EFIPATH')) exit();

    $equipamento = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
    $equipamento = $equipamento['equipamento'][0];
    //var_dump($equipamento);

?>

<script>

    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Relatôrios</a> / <a href="<?php echo HOME_URI; ?>/grafico/listaFilial/<?php echo $equipamento['id_cliente']; ?>"> Unidade : <?php echo (isset($equipamento['filial'])) ? $equipamento['filial'] :"Matriz"; ?> </a> / <a href="<?php echo HOME_URI; ?>/grafico/opcaoVisualizacao/<?php echo $this->parametros[0]; ?>">Equipamento <?php echo $equipamento['nomeModeloEquipamento']; ?></a>';


</script>

<div class="container-fluid">

    <form id="formularioGeradorGrafico" method="">
        <input type="hidden" id="geraGrafico" value="<?php echo $modelo->nUrl; ?>" />
        <div class="row">
            <div class="col-md-12">
                <label class="titulo-pagina">
                    OP&Ccedil;&Otilde;ES PARA GERAR O GR&Aacute;FICO
                </label><!-- Fim Titulo pagina --><!-- Fim Titulo pagina -->
            </div>
        </div>

        <div class="row">

            <div class="col-md-5">
                <div class="panel panel-green">
                    <div class="panel-heading">Tensão</div>
                    <div class="panel-body">


                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Opções</label>
                            </div>
                        </div>

                        <div class="row borda-01">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">R</label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">S</label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">T</label>
                            </div>
                            <div class="col-md-6 txt-center">
                                <label class="font-texto-02">FASES</label>
                            </div>
                        </div>

                        <!-- Entrada -->
                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_r1t" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_s1t" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_t1t" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Entrada</label>
                            </div>
                        </div>

                        <!-- Saída -->

                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_r1c" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_s1c" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_t1c" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Saída</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="panel panel-red">
                    <div class="panel-heading">Corrente</div>
                    <div class="panel-body">

                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Opções</label>
                            </div>
                        </div>

                        <div class="row borda-01">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">R</label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">S</label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">T</label>
                            </div>
                            <div class="col-md-6 txt-center">
                                <label class="font-texto-02">FASES</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_r1tc" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_s1tc" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_t1tc" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Entrada</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_r1cc" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_s1cc" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_t1cc" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Saída</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <!-- <div class="panel panel-default">
                    <div class="panel-heading">Panel heading without title</div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div> -->
            </div>

        </div>

        <div class="row">

            <div class="col-md-5">

                <div class="panel panel-yellow">
                    <div class="panel-heading">Potências</div>

                    <div class="panel-body">
                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Opções</label>
                            </div>
                        </div>

                        <div class="row borda-01">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">R</label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">S</label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">T</label>
                            </div>
                            <div class="col-md-6 txt-center">
                                <label class="font-texto-02">FASES</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_poter" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_potes" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_potet" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Entrada</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_potsr" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_potss" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="chk_entrada_potst" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Saída</label>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-5">
                <div class="panel panel-info">
                    <div class="panel-heading">Temperatura</div>

                    <div class="panel-body">

                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Locais</label>
                            </div>
                        </div>

                        <div class="row borda-01">

                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="temp_ambiente" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02"></label>
                            </div>
                            <div class="col-md-6 txt-center">
                                <label class="font-texto-02">Ambiente</label>
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="temp_banco_bat" name="parametrosGraficos">
                                </label>
                            </div>
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02"></label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Banco Bateria</label>
                            </div>
                        </div>

                        <div class="row borda-01">

                            <div class="col-md-2 txt-center">
                                <span><br /></span>
                            </div>
                        </div>

                    </div>

                </div>


            </div>

            <div class="col-md-2">
            </div>

        </div>

        <div class="row">

            <div class="col-md-5">

                <div class="panel panel-primary">
                    <div class="panel-heading">Bateria</div>
                    <div class="panel-body">
                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Tensão</label>
                            </div>
                        </div>
                        <div class="row borda-01">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="bat_entrada_r1tc" name="parametrosGraficos">
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label class="font-texto-02">Banco de bateria</label>
                            </div>
                        </div>

                        <div class="row borda-01">

                            <div class="col-md-2 txt-center">
                                <span><br /></span>
                            </div>
                        </div>

                        <div class="row borda-01">

                            <div class="col-md-2 txt-center">
                                <span><br /></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-5">

                <div class="panel panel-primary">
                    <div class="panel-heading">Período relatôrio</div>
                    <div class="panel-body">

                        <div class="row borda-01">
                            <div class="col-md-9 txt-center">
                                <label class="font-texto-02">Período</label>
                            </div>
                            <div class="col-md-3 txt-left">
                                <label class="font-texto-02">Horário</label>
                            </div>
                        </div>

                        <div class="row borda-01">
                            <div class="col-md-3">
                                <label class="font-texto-02">Desde : </label>
                            </div>

                            <div class="col-md-4 txt-center">
                                <label class="font-texto-02">
                                    <input class="form-control" type="text" id="data_inicio_rel" name="data_inicio_rel" val="">
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="font-texto-02">Das: </label>
                            </div>
                            <div class="col-md-3">
                                <label class="font-texto-02">
                                    <!-- <select id="horaInicio" name="horaInicio" class="form-control">
                                        <?php

                                            // for($i = 0; $i < 24; $i++){
                                            //     if($i < 10){
                                            //         $hora = "0".$i;
                                            //         echo "<option value='$hora'>".$hora."h</option>";
                                            //     }else{
                                            //         echo "<option value='$i'>".$i."h</option>";
                                            //     }
                                            // }

                                        ?>
                                    </select> -->
                                    <input type="text" id="timepickerOne" name="timepickerOne" class="timepicker form-control"/>
                                </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label class="font-texto-02">Até :</label>
                            </div>

                            <div class="col-md-4 txt-center">
                                <label class="font-texto-02">
                                    <input class="form-control" type="text" id="data_fim_rel" name="data_fim_rel" val="">
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="font-texto-02">Até: </label>
                            </div>
                            <div class="col-md-3">
                                <label class="font-texto-02">
                                    <!-- <select id="horaFim" name="horaFim" class="form-control">
                                        <?php

                                            // for($i = 0; $i < 24; $i++){
                                            //     if($i < 10){
                                            //         $hora = "0".$i;
                                            //         echo "<option value='$hora'>".$hora."h</option>";
                                            //     }else{
                                            //         if($i == 23){
                                            //             echo "<option value='23' selected>23h</option>";
                                            //         }else{
                                            //             echo "<option value='$i'>".$i."h</option>";
                                            //         }
                                            //
                                            //     }
                                            // }

                                        ?>
                                    </select> -->
                                    <input type="text" id="timepickerTwo" name="timepickerTwo" class="timepicker form-control"/>
                                </label>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-2">
            </div>

        </div>

        <div class="row text-center">

            <div class="col-md-3">

            </div>
            <div class="col-md-4">
                <!-- <a href="#" class="btn btn-default" id="btn_gerarGrafico" onclick="">Gerar grafico</a> -->
                <button type="button" class="btn btn-primary btn-lg btn-block" id="btn_gerarGrafico">Gerar gráfico</button>
            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-2">

            </div>
        </div>

    </form>

    <div id="nadaSelecionado" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="gridSystemModalLabel">Aviso!</h4>
            </div>
            <div class="modal-body" style="background-color:#cccccc;">
                <div class="campoForm">
                    <p  class="txt_form">
                        Pelo menos um parametro deve ser selecionado para efetivamente gerar o gráfico!
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
      </div>
    </div>


</div>
