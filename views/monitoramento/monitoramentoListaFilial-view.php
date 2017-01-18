<?php

if (!defined('EFIPATH')) exit();

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
//$retorno = $modelo->buscaRelacaoFilial();

//Retorna informacoes do cliente
$detalhesCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);
//Retorna a lista de equipamentos do cliente para listar, seja da matriz ou da filial
$listaEquipamentos = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);

if($detalhesCliente['status']){
    $nomeCliente = $detalhesCliente['dados'][0]['nome'];
}else{
    $nomeCliente = 'Não informado';
}

// $teste = base64_decode("MTM5NDkwMDczMjY5MDY");
// var_dump($teste);

?>

<script type="text/javascript">
    // var Movies0 = [
    //     <?php
    //         /* se for um array */
    //         if (is_array($retorno))
    //         {
    //             $guarda = "";
    //
    //             for ($a = 0 ; $a < sizeof($retorno) ; $a++)
    //             {
    //                 if (!empty($retorno[$a]))
    //                 {
    //                     $statusVer = "Desativado";
    //                     if ($retorno[$a]['status_ativo'] == 1)
    //                         $statusVer = "Ativado";
    //
    //                     if ($retorno[$a]['nivel'] == 'c')
    //                         $nivel = "Matriz";
    //                     else if ($retorno[$a]['nivel'] == 'f')
    //                         $nivel = "Filial";
    //                     else
    //                         $nivel = '';
    //
    //                     /* convert data para o padrao brasileiro */
    //                     $tempo = explode(" ",$retorno[$a]['dt_criacao']);
    //                     $tempo = $tempo[0];
    //                     $tempo = explode("-",$tempo);
    //                     $tempo = $tempo[2]."/".$tempo[1]."/".$tempo[0];
    //
    //                     /* criptografa sim */
    //                     $chaveSim = base64_encode($retorno[$a]['num_sim']);
    //
    //
    //                     $guarda .= "{modelsh: '{$chaveSim}',
    //                                  num_sim: {$retorno[$a]['num_sim']},
    //                                  dataCriado: '{$tempo}',
    //                                  nivel: '{$nivel}',
    //                                  cliente: '{$modelo->converte($retorno[$a]['nome'],1)}',
    //                                  status: '{$statusVer}' },";
    //                 }
    //             }
    //
    //             $guarda .= ".";
    //             $guarda = str_replace(",.","",$guarda);
    //             echo $guarda;
    //
    //         }
    //     ?>
    // ];
    // var Movies = [Movies0];


    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/" class="linkMenuSup">Monitoramento</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/unidades/<?php echo $this->parametros[0]; ?>"><?php echo $nomeCliente; ?></a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>


<div class="container-fluid">

    <!-- Titulo pagina -->
    <label class="titulo-pagina-cliente"><?php //echo $retorno[0]['nome']; ?></label>

    <label class="titulo-pagina">
        - BI-GRAFI
    </label><!-- Fim Titulo pagina --><!-- Fim Titulo pagina -->



    <div class='table-responsive'>
        <table id="" class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>Nome equipamento</th>
                    <th>Modelo</th>
                    <th>Característica</th>
                    <th>Cliente</th>
                    <th>Filial/Matriz</th>
                    <th>Monitorar</th>
                </tr>
            </thead>
            <tbody>
            <?php

                if($listaEquipamentos['status']){

                    foreach ($listaEquipamentos['equipamentos'] as $equipamento) {

                        /*
                        * Tratamento dos dados do equipamento para passagem de parametros
                        */



            ?>
                <tr>
                    <td>
                        <?php echo $equipamento['nomeEquipamento']; ?>
                    </td>
                    <td>
                        <?php echo $equipamento['modelo']; ?>
                    </td>
                    <td>
                        <?php echo $equipamento['caracteristica_equip']; ?>
                    </td>
                    <td>
                        <?php echo $equipamento['cliente']; ?>
                    </td>
                    <td>
                        <?php echo (isset($equipamento['filial'])) ? $equipamento['filial'] : "Matriz"; ?>
                    </td>
                    <td>
                        <a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/<?php echo $equipamento['id']; ?>"><i class="fa fa-picture-o fa-2x"></i></a>
                    </td>
                </tr>
            <?php

                        /*
                        'id' => string '25' (length=2)
  'equipamento' => string '1' (length=1)
  'fabricante' => string 'Eaton' (length=5)
  'modelo' => string '8090' (length=4)
  'potencia' => string '100' (length=3)
  'qnt_bateria' => string '2' (length=1)
  'caracteristica_equip' => string 'nENHUMA' (length=7)
  'tipo_bateria' => string 'Selada' (length=6)
  'amperagem_bateria' => string '100' (length=3)
  'cliente' => string 'Nacional Industrias' (length=19)
  'filial' => string 'Filial Tr&ecirc;s' (length=17)

                        */

                    }
                }else{
                    echo "<tr><td colspan='6'> Não há equipamentos configurados para monitoramento</td></tr>";
                }
            ?>
            </tbody>
        </table>
        <div id="summary"><div></div></div>
    </div>
</div>


<?php

    //var_dump($listaEquipamentos);

?>

<script id="template" type="text/html">
    <!-- <tr>
        <td class="tdprim">
            <a href="<?php echo HOME_URI; ?>/monitoramento/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.cliente}}
            </a>
        </td>


        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.nivel}}
            </a>
        </td>


        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.num_sim}}
            </a>
        </td>


        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.status}}
            </a>
        </td>
        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.dataCriado}}
            </a>
        </td>
    </tr> -->
</script>
