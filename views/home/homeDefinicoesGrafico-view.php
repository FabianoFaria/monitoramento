<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

/* verifica se existe uma acao */
$modelo->gerarGrafico();

?>

<div class="container fontPadrao">
    
    <label class="tituloPagina">Defini&ccedil;&otilde;es</label>
    
    <!-- lista de caminho -->
    <ol class="breadcrumb fontBreadCrumb">
        <li><a href="<?php echo HOME_URI; ?>/home/">Home</a></li>
        <li class="active">Defini&ccedil;&otilde;es de Gr&aacute;fico</li>
    </ol><!-- fim lista de caminho -->
    
    <div class="row"><div class="col-md-12"><label>Defini&ccedil;&otilde;es</label><br></div></div>
    <div class="row">
        <form method="post">
            <!-- grafico bateria  -->
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Bateria</div>
                    <div class="panel-body txt-center">
                        <label class="checkbox-inline fontOpcDef"><input type="checkbox" name="chk_bat" value="1"> Exibir</label>
                    </div>
                </div>
            </div><!-- fim grafico bateria  -->


            <!-- grafico entrada  -->
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Tens&atilde;o de Entrada</div>
                    <div class="panel-body txt-center">
                        <label class="checkbox-inline fontOpcDef"><input type="checkbox" name="chk_ent" value="1"> Exibir</label>
                    </div>
                </div>
            </div><!-- fim grafico entrada  -->


            <!-- grafico saida  -->
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Tens&atilde;o de Sa&iacute;da</div>
                    <div class="panel-body txt-center">
                        <label class="checkbox-inline fontOpcDef"><input type="checkbox" name="chk_sai" value="1"> Exibir</label>
                    </div>
                </div>
            </div><!-- grafico saida  -->


            <!-- grafico onda  -->
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Gr&aacute;fico de onda</div>
                    <div class="panel-body txt-center">
                        <label class="checkbox-inline fontOpcDef"><input type="checkbox" name="chk_ond" value="1"> Exibir</label>
                    </div>
                </div>
            </div><!-- fim grafico onda  -->

            <div class="row">
                <div class="col-md-2 col-md-offset-5 txt-center">
                    <input type="submit" name="btn_gerar" class="btn btn-default" value="Gerar Gr&aacute;fico">
                </div>
            </div>
        </form>
    </div>
</div>