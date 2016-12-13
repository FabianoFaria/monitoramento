<!-- LISTAR ALERTAS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/alerta">Listar alarmes</a>';
</script>


<?php



    if(isset($parametros)){
        //Busca por alarmes com um status especifico
    }else{
        //Exibe os alarmes conforme forem registrados
    }
 ?>

<div class="row">
    <div class="col-lg-12">
         <!-- TITULO PAGINA -->
         <label class="page-header">Listagem de alarmes registrados</label><!-- Fim Titulo pagina -->
    </div>
</div>

 <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4><i class="fa fa-search-plus "></i> Filtro de alarmes</h4>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="row">
                        <!-- Status do alarme -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Status do alarme</label>
                                <select class="form-control">
                                    <option value="">Selecione...</option>
                                    <option value="">Alarme gerado</option>
                                    <option value="">Alarme reconhecido</option>
                                    <option value="">Alarme solucionado</option>
                                    <option value="">Alarme finalizado</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nome do cliente -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome do cliente</label>
                                <select class="form-control">
                                    <option value="">Selecione...</option>
                                    <option value="">Todos</option>
                                </select>
                            </div>
                        </div>



                        <div class="col-md-4 ">
                            <div class="form-group">
                                <button class="btn btn-info pull-right" type="button">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
   <div class="col-lg-12">
       <div class="panel panel-yellow">
           <div class="panel-heading">
               <h4><i class="fa fa-exclamation-triangle "></i> Alarmes registrados</h4>
           </div>
           <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Mestre</th>
                            <th>Módulo</th>
                            <th>Ponto</th>
                            <th>Descrição</th>
                            <th>Medida gerada</th>
                            <th>Adicionar observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8">Nenhum alarme gerado até o momento!</td>
                        </tr>
                    </tbod>
                </table>
           </div>
       </div>
   </div>
</div>
