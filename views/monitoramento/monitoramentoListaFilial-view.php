<?php

if (!defined('EFIPATH')) exit();

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php

// CHAMANDO LISTA DE VALORES
//$retorno = $modelo->buscaRelacaoFilial();


/*
* VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
*/
switch ($_SESSION['userdata']['tipo_usu']) {
    case 'Administrador':
        //var_dump($_SESSION);

        //Retorna informacoes do cliente
        $detalhesCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);
        //Retorna a lista de equipamentos do cliente para listar, seja da matriz ou da filial
        $listaEquipamentos = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);

        if($detalhesCliente['status']){
            $nomeCliente = $detalhesCliente['dados'][0]['nome'];
        }else{
            $nomeCliente = 'Não informado';
        }


    break;

    case 'Cliente':

        //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
        $usuarioAutorizado  = false;
        $idcliente = $_SESSION['userdata']['cliente'];
        $usuariosCliente  = $modeloClie->carregaDadosContato($this->parametros[0]);

        //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
        if($usuariosCliente['status']){
            foreach ($usuariosCliente['dados'] as $usuarioCliente){
                if($usuarioCliente['id_cliente'] == $idcliente){
                    $usuarioAutorizado  = true;
                }
            }
        }

        if($usuarioAutorizado){

            //Retorna informacoes do cliente
            $detalhesCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);
            //Retorna a lista de equipamentos do cliente para listar, seja da matriz ou da filial
            $listaEquipamentos = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);

            if($detalhesCliente['status']){
                $nomeCliente = $detalhesCliente['dados'][0]['nome'];
            }else{
                $nomeCliente = 'Não informado';
            }

        }else{
            $listaEquipamentos['status']  = false;
            $detalhesCliente['status']    = false;
            $nomeCliente        = 'Não informado';
        }


    break;

    case 'Visitante':

        //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
        $usuarioAutorizado  = false;
        $idcliente = $_SESSION['userdata']['cliente'];
        $usuariosCliente  = $modeloClie->carregaDadosContato($this->parametros[0]);

        //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
        if($usuariosCliente['status']){
            foreach ($usuariosCliente['dados'] as $usuarioCliente){
                if($usuarioCliente['id_cliente'] == $idcliente){
                    $usuarioAutorizado  = true;
                }
            }
        }




    break;

    case 'Tecnico':

        //Retorna informacoes do cliente
        $detalhesCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);
        //Retorna a lista de equipamentos do cliente para listar, seja da matriz ou da filial
        $listaEquipamentos = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);

        if($detalhesCliente['status']){
            $nomeCliente = $detalhesCliente['dados'][0]['nome'];
        }else{
            $nomeCliente = 'Não informado';
        }

    break;
}


?>

<script type="text/javascript">

    // GERENCIADOR DE LINK
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/" class="linkMenuSup">Monitoramento</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/unidades/<?php echo $this->parametros[0]; ?>"><?php echo $nomeCliente; ?></a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>


<div class="container-fluid">

    <!-- Titulo pagina -->
    <label class="titulo-pagina-cliente"><?php //echo $retorno[0]['nome']; ?></label>

    <label class="titulo-pagina">
        Equipamentos para monitorar
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
