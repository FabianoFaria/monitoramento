<?php 

if (!defined('EFIPATH')) exit();

?>

<script>
var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/configuracao/" class="linkMenuSup">Configura&ccedil;&atilde;o</a>';
</script>

<div class="container-fluid">
    
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
                                <input type="checkbox" id="chk_entrada_r1t">
                            </label>
                        </div>
                        <div class="col-md-2 txt-center">
                            <label class="font-texto-02">
                                <input type="checkbox" id="chk_entrada_s1t">
                            </label>
                        </div>
                        <div class="col-md-2 txt-center">
                            <label class="font-texto-02">
                                <input type="checkbox" id="chk_entrada_t1t">
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
                                <input type="checkbox" id="chk_entrada_r1c">
                            </label>
                        </div>
                        <div class="col-md-2 txt-center">
                            <label class="font-texto-02">
                                <input type="checkbox" id="chk_entrada_s1c">
                            </label>
                        </div>
                        <div class="col-md-2 txt-center">
                            <label class="font-texto-02">
                                <input type="checkbox" id="chk_entrada_t1c">
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
        <a href="#" class="btn btn-default" id="btn_gerarGrafico" onclick="geraGrafico('<?php echo $modelo->nUrl; ?>')">Gerar grafico</a>
    </div>

</div>