<!-- LISTAR ALERTAS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    $clientes = $modeloCliete->listarContatoAlarmesCliente();

    //var_dump($clientes);

    if($clientes['status']){
        $alertasContatos = $clientes['dados'];
    }else{
        $alertasContatos = 0;
    }

    /*
    array (size=2)
'status' => boolean true
'dados' =>
array (size=11)
  0 =>

    */

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/alarme">Listar alarmes</a>';
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
        <label class="page-header">Selecione o cliente para efetuar a configuração de alarmes</label><!-- Fim Titulo pagina -->

        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Clientes cadastrados
            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cidade</th>
                                <th>Telefone</th>
                                <th class="txt-center">Gerenciar alarmes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                if(!is_numeric($alertasContatos)){
                                    foreach ($alertasContatos as $cliente){
                                    ?>
                                        <tr>
                                            <td>
                                                <?php  echo $cliente['nome']; ?>
                                            </td>
                                            <td>
                                                <?php  echo $cliente['cidade']; ?>
                                            </td>
                                            <td>
                                                <?php  echo $cliente['ddd']." ".$cliente['telefone']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo "<a href='".HOME_URI."/alarme/gerenciarAlertas/".$cliente['id']."'><i class='fa fa-bell-o fa-2x'></i></a>";
                                                ?>
                                            </td>

                                        </tr>

                                        <?php
                                    }

                                }else{
                            ?>
                                <tr>
                                    <td colspan="5">
                                        <p>
                                            Não há cliente cadastradoas!
                                        </p>
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

 <div class="row">
    <div class="col-lg-12">

    </div>
</div>
<div class="row">
   <div class="col-lg-12">

   </div>
</div>
