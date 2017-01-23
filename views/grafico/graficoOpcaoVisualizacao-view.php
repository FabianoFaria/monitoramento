<?php

if (!defined('EFIPATH')) exit();

    $equipamento = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
    $equipamento = $equipamento['equipamento'][0];
    //var_dump($equipamento);

?>

<script>
var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Relatôrios</a> / <a href="<?php echo HOME_URI; ?>/grafico/listaFilial/<?php echo $equipamento['id_cliente']; ?>"> Cliente :<?php echo $equipamento['cliente']; ?></a> / <a href="<?php echo HOME_URI; ?>/grafico/opcaoVisualizacao/<?php echo $this->parametros[0]; ?>">Equipamento <?php echo $equipamento['nomeEquipamento']; ?></a>';


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
                    <div class="panel-heading">Entrada</div>
                    <div class="panel-body">


                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Entrada</label>
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
                                <label class="font-texto-02">Tens&atilde;o</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="panel panel-red">
                    <div class="panel-heading">Sa&iacute;da</div>
                    <div class="panel-body">



                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Sa&iacute;da</label>
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
                                <label class="font-texto-02">Tens&atilde;o</label>
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

                <div class="panel panel-green">
                    <div class="panel-heading">Entrada</div>
                    <div class="panel-body">
                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Entrada</label>
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
                                <label class="font-texto-02">Corrente</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <div class="panel panel-red">
                    <div class="panel-heading">Saída</div>

                    <div class="panel-body">

                        <div class="row borda-01">
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Saída</label>
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
                                <label class="font-texto-02">Corrente</label>
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
                                <label class="font-texto-02">Bateria</label>
                            </div>
                        </div>
                        <div class="row borda-01">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">B</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 txt-center">
                                <label class="font-texto-02">
                                    <input type="checkbox" id="bat_entrada_r1tc" name="parametrosGraficos">
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label class="font-texto-02">Bateria</label>
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
                            <div class="col-md-12 txt-center">
                                <label class="font-texto-02">Período</label>
                            </div>
                        </div>

                        <div class="row borda-01">
                            <div class="col-md-6 txt-center">
                                <label class="font-texto-02">
                                    <input class="form-control" type="text" id="data_inicio_rel" name="data_inicio_rel" val="">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Data inicio</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 txt-center">
                                <label class="font-texto-02">
                                    <input class="form-control" type="text" id="data_fim_rel" name="data_fim_rel" val="">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="font-texto-02">Data fim</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-2">
            </div>

        </div>

        <div class="row text-center">
            <!-- <a href="#" class="btn btn-default" id="btn_gerarGrafico" onclick="">Gerar grafico</a> -->
            <button type="button" class="btn btn-primary" id="btn_gerarGrafico">Gerar gráfico</button>
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
