<?php

if (!defined('EFIPATH')) exit();

?>

<script>
var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/configuracao/" class="linkMenuSup">Configura&ccedil;&atilde;o</a>';


</script>

<div class="container-fluid">

    <form id="formularioGeradorGrafico" method="">
        <div class="row">
            <div class="col-md-12">
                <label class="titulo-pagina">
                    OP&Ccedil;&Otilde;ES PARA GERAR O GR&Aacute;FICO
                </label><!-- Fim Titulo pagina --><!-- Fim Titulo pagina -->
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="panel panel-default">
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

            <div class="col-md-4">
                <div class="panel panel-default">
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

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Panel heading without title</div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>


        </div>

        <div class="row text-center">
            <a href="#" class="btn btn-default" id="btn_gerarGrafico" onclick="">Gerar grafico</a>
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


    <script>
        $( "#btn_gerarGrafico" ).click(function() {
            
            //Valida se pelo menos um parametro foi selecionado!
            var checkboxs=document.getElementsByName("parametrosGraficos");
            var okay=false;
            for(var i=0,l=checkboxs.length;i<l;i++)
            {
                if(checkboxs[i].checked)
                {
                    okay=true;
                    break;
                }
            }
            if(okay)geraGrafico('<?php echo $modelo->nUrl; ?>');
            else $('#nadaSelecionado').modal();;

        });
    </script>

</div>
