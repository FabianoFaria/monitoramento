<?php

// Verifica se esta definido o path
if (! defined('EFIPATH')) exit();

if(is_numeric($this->parametros[0])){

    /*
    * TESTA SE USUÁRIO TEM PERMISSÃO PARA VISUALIZAR O EQUIPAMENTO ESPECIFICADO
    */
    switch ($_SESSION['userdata']['tipo_usu']) {
        case 'Administrador':

            $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

            if($dadosCliente['status']){
                $dadosCliente   = $dadosCliente['dados'][0];

                $idClienteForm  = $dadosCliente['id'];

                $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                $lista          = $lista['equipamento'];
                $nomeCliente    = $dadosCliente['nome'];
            }else{
                $lista          = false;
            }

        break;
        case 'Cliente':
            //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
            $usuarioAutorizado  = false;
            $idcliente = $_SESSION['userdata']['cliente'];
            $usuariosCliente  = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

            //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
            if($usuariosCliente['status']){

                foreach ($usuariosCliente['dados'] as $usuarioCliente){

                    if(intval($usuarioCliente['id']) == $idcliente){
                        $usuarioAutorizado  = true;
                    }
                }
            }

            if($usuarioAutorizado){
                $dadosCliente   = $modeloClie->carregarDadosCliente($idcliente);

                if($dadosCliente['status']){
                    $dadosCliente   = $dadosCliente['dados'][0];

                    $idClienteForm  = $idcliente;

                    $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                    $lista          = $lista['equipamento'];
                    $nomeCliente    = $dadosCliente['nome'];
                }else{
                    $lista          = false;
                }
            }else{
                $lista          = false;
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

            if($usuarioAutorizado){
                $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

                if($dadosCliente['status']){

                    $idClienteForm  = $idcliente;

                    $dadosCliente   = $dadosCliente['dados'][0];
                    $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                    $lista          = $lista['equipamento'];
                    $nomeCliente    = $dadosCliente['nome'];
                }else{
                    $lista          = false;
                }
            }else{
                $lista          = false;
            }

        break;
        case 'Tecnico':
            $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

            if($dadosCliente['status']){
                $dadosCliente   = $dadosCliente['dados'][0];
                $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                $lista          = $lista['equipamento'];
                $nomeCliente    = $dadosCliente['nome'];
                $idClienteForm  = $dadosCliente['id'];
            }else{
                $lista          = false;
            }
        break;
    }

    if($lista){

        //CONFIRMADO A PERMISSÃO DO USUÁRIO SOBRE O EQUIPAMENTO, PROSEGUE A VERIFICAÇÃO DO EQUIPAMENTO
        $dadosEquipamento   = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
        $dadosEquipamento   = $dadosEquipamento['equipamento'][0];
        // Aqui está sendo carregado os dados de Sim, id_sim_equipamento necessarios para está página
        $dadosVinculoEquip  = $modeloEquip->detalhesEquipamentoParaConfiguracao($this->parametros[0]);
        //Aqui são os dados do cliente para exibição na tela
        $dadosClie          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);

        if($dadosClie['status']){
            $dadosClie = $dadosClie['equipamento'][0];
            $idClie    = $dadosClie['idClie'];
            $nomeClie  = $dadosClie['cliente'];
        }

        if($dadosVinculoEquip['status']){
            $idEquip    = $dadosVinculoEquip['equipamento'][0]['id_equipamento'];
            $idSimEquip = $dadosVinculoEquip['equipamento'][0]['id'];
            $idSim      = $dadosVinculoEquip['equipamento'][0]['id_sim'];
        }else{
            $idEquip    = null;
            $idSimEquip = null;
            $idSim      = null;
        }

        $equipamentoMonitorado = $dadosEquipamento['tipoEquip']." ".$dadosEquipamento['nomeModeloEquipamento'];

        //var_dump($dadosEquipamento);

        switch ($dadosEquipamento['tipoEquip']) {
            case 'Medidor temperatura':
                require_once EFIPATH ."/views/monitoramento/graficoMonitorMedidorTemperatura.php";
            break;

            default:
                require_once EFIPATH ."/views/monitoramento/graficoMonitorNoBreak.php";
            break;
        }

    }else{
        echo "Favor verificar suas permisões de usuário!";
    }

}else{
    echo "Parametro inválido!";
}


?>
