<?php

    // Verifica se esta definido o path
    if (! defined('EFIPATH')) exit();

    if(is_numeric($this->parametros[0])){

        // Aqui está sendo simplificado o processo de coleta de dados do equipamento para geração de gráficos
        $dadosEquipamento   = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
        $dadosEquipamento   = $dadosEquipamento['equipamento'][0];

        // Aqui está sendo carregado os dados de Sim, id_sim_equipamento necessarios para está página
        $dadosVinculoEquip  = $modeloEquip->detalhesEquipamentoParaConfiguracao($this->parametros[0]);

        var_dump($dadosVinculoEquip);
        var_dump($dadosEquipamento);
        exit();

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

        //INICIA CLASS DA LISTA INICAL
        $parametroListaIni  = array();
        array_push($parametroListaIni, $idSim);
        $limite             = 30;
        $listaIni           = new ListaInicial($limite, $this->db, $parametroListaIni);

        // CARREGA OS PARAMETROS CONFIGURADOS PARA O EQUIPAMENTO
        switch ($dadosEquipamento['tipoEquip']) {
            case 'Medidor temperatura':
                $retorno = "";
            break;

            default:
                // RETORNO DOS PARAMETROS PARA NOBREAK
                $retorno = $modelo->loadGraficoParam($idEquip, $idSimEquip, $idSim);
            break;
        }

        //var_dump($retorno);

        // // CARREGA OS VALORES DE CALIBRAÇÃO SALVOS PARA O EQUIPAMENTO
        // $valoresCalibracao = $modeloEquip->posicoesCalibradas($idEquip);
        //
        // if($valoresCalibracao['status']){
        //
        //     foreach ($valoresCalibracao['posicoesCalibradas'] as $calibracao) {
        //
        //         $posicoesCalibradas[] = array($calibracao['posicao_tab'] => $calibracao['variavel_cal']);
        //     }
        //
        // }else{
        //     $posicoesCalibradas = 0;
        // }

        // var_dump($posicoesCalibradas);
        //var_dump($dadosEquipamento);

    }else{

        $retorno = null;

    }


    /*
    * VERIFICA SE OS PARAMETROS ESTÃO CORRETOS
    * E SE HOUVE RETORNO DE DADOS DO EQUIPAMENTO
    */
    if (empty($retorno) && !isset($retorno)){

        // Caso nao exista valor
        // Apresenta mensagem e link informando que nao ha resultado
        echo "<div class='mensagem-semvalor'>
                <label class='mensagem-texto'>Verifique se os parametros est&atilde;o configurados.<br>
                    <a href='".HOME_URI."/configuracao/configurarEquipamentoCliente/".$this->parametros[0]."' class='link-mensagem'>Clique aqui para voltar</a>
                </label></div>";

    }else{



    }

?>
