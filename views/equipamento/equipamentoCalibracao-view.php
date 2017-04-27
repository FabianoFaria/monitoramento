<!-- LISTAR EQUIPAMENTOS VIEW -->
<?php

    if (! defined('EFIPATH')) exit;

    $dadosEquipamento   = $modelo->dadosEquipamentoCliente($this->parametros[0]);

    //var_dump($dadosEquipamento);

    /*

    'id' => string '20' (length=2)
         'id_fabricante' => string '4' (length=1)
         'id_cliente' => string '48' (length=2)
         'id_filial' => string '0' (length=1)
         'tipo_equipamento' => string '1' (length=1)
         'nomeModeloEquipamento' => string 'C130' (length=4)
         'correnteBateria' => string '120' (length=3)
         'potencia' => string '50' (length=2)
         'tensaoBancoBateria' => string '3' (length=1)
         'correnteBancoBateria' => string '55' (length=2)
         'tensaoMinBarramento' => string '10.6' (length=4)
         'qnt_bateria' => string '25' (length=2)
         'quantidade_banco_bateria' => string '1' (length=1)
         'quantidade_bateria_por_banco' => string '25' (length=2)
         'tipo_bateria' => string 'Automotiva' (length=10)
         'localBateria' => string 'Interna' (length=7)
         'tipo_entrada' => string '3' (length=1)
         'tipo_saida' => string '3' (length=1)
         'idClie' => string '48' (length=2)
         'cliente' => string 'Correntes Andromeda' (length=19)
         'filial' => null
         'tipoEquip' => string 'No-break' (length=8)

    */

    /*
    'status' => boolean true
    'posicoesTipoEquip' =>
    array (size=1)
      0 =>
        array (size=1)
          'posicoes_tabela' => string 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,q,r,s,t,u' (length=39)
    */

    /*
    array (size=1)
        'status' => boolean false

    */
?>
<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento">Listar equipamentos</a> / <a href="<?php echo HOME_URI; ?>/equipamento/carregarDadosEquipamentoCalibracao/<?php echo $this->parametros[0]; ?>"> Calibração de equipamento :</a>';
</script>



<?php

    //CASO O EQUIPAMENTO SEJA ENCONTRADO
    if($dadosEquipamento['status']){

        $equipamentoCarregado   = $dadosEquipamento['equipamento'][0];

        //APÓS CARREGAR OS DADOS DO EQUIPAMENTO, CARREGA AS POSIÇÕES QUE SERÃO CALIBRADAS, OU FORAM CALIBRADAS
        $posicoesCalibra        = $modelo->posicoesCalibradas($this->parametros[0]);

        //CARREGA AS POSIÇÕES DE ACORDO COM O TIPO DE EQUIPAMENTO

        $posicoesEquipamento    = $modelo->posicoesTipoEquipamento($equipamentoCarregado['tipo_equipamento']);

        if($posicoesEquipamento['status']){

            $posicoesEquipamento = explode(',', $posicoesEquipamento['posicoesTipoEquip'][0]['posicoes_tabela']);

        }else{
            $posicoesEquipamento = "";
        }

        //var_dump($posicoesEquipamento);

?>
        <div class="row">
            <div class="col-lg-12">
                <!-- TITULO PAGINA -->
                <label class="page-header">Local do equipamento :
                    <?php echo (isset($equipamentoCarregado['filial'])) ? $equipamentoCarregado['filial'] : $equipamentoCarregado['cliente']." - Matriz"; ?>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- TABELA CONTENDO TODOS OS CLIENTES -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12">

                                <label class="page-header">Calibração de equipamento : <?php echo (isset($dadosEquipamento['status'])) ? $equipamentoCarregado['tipoEquip']." ".$equipamentoCarregado['nomeModeloEquipamento']  : ""; ?></label><!-- Fim Titulo pagina -->
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <form id="cadastroDadosCalibracao" class="">

                            <input type="hidden" id="idEquipamento" name="idEquipamento" value="<?php echo $this->parametros[0]; ?>" />

                            <div class="row">
                                <div class="col-md-12 form-group">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>

                                            </thead>
                                            <tbody>

                                                <?php

                                                    $f = 0;

                                                    ?>
                                                    <tr>

                                                        <?php
                                                            foreach ($posicoesEquipamento as $posicao) {
                                                                if($posicao != 'a'){

                                                                    ?>
                                                                        <td>
                                                                            <p class="text-center">
                                                                                <label for="entrada<?php echo $posicao; ?>"> <?php echo strtoupper($posicao); ?> </label>
                                                                                <!-- <input type="text" id="entrada<?php echo $posicao; ?>" name="entrada<?php //echo $posicao; ?>" class="form-control calibracaoInput" /> -->
                                                                                <a href="javascript:void(0)" onclick="calibrarequipamento(<?php echo $this->parametros[0] ?>, '<?php echo $posicao; ?>')" class="btn btn-primary">
                                                                                    <i class="fa fa-wrench "></i>
                                                                                </a>
                                                                            </p>
                                                                        </td>

                                                                    <?php

                                                                    $f++;
                                                                    if($f == 5){

                                                                        echo "</tr><tr>";

                                                                        $f = 0;
                                                                    }
                                                                }

                                                            }
                                                        ?>

                                                    </tr>
                                                    <?php
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
<?php
    }else{
?>

    <div class="row">
        <div class="col-lg-12">
            <label class="page-header">Equipamento não encontrado</label>
        </div>
    </div>

<?php
    }

?>
