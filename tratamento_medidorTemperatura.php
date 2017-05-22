<?php

    /*
    * COM OS PARAMETROS CARREGADOS, INICIA A COMPARAÇÃO COM OS DADOS RECEBIDOS
    */

    $parametros = $dados[0]['parametro'];
    $idSimEquip = $dados[0]['id_sim_equipamento'];


    $configuracaoSalva = explode('|inicio|',$parametros);

    /*
    * CONFIGURAÇÃO DE TEMPERATURA QUE FOI REGULADA PARA TODOS OS MEDIDORES DO EQUIPAMENTO
    * OBS : PODE SER ALTERADO CONFORME AS NECESSIDADES DO PROJETO
    */

    $equipamentoAnalizado = carregarDadosEquip($equipamentosSim[0]['simIdEquip']);

    //var_dump($equipamentoAnalizado);
    $equipamentoAnalizado = $equipamentoAnalizado[0];

    /*
        PREPARA A ARRAY DE ENTRADAS PARA INICIAR A VERIFICAÇÃO DOS DADOS ENVIADOS
    */

    //ARRAY DE ENTRADAS
    $entradasDisponiveis = array("B","C","D","E","F","G","H","I","J","L","M","N","O","P","Q","R","S","T","U");

    //ENTRADAS CONFIGURADAS PELO EQUIPAMENTO
    $entradasEquipamento = $equipamentoAnalizado['tipo_entrada'];

    /*
    * PREPARA OS VALORES PARA COMPARAÇÃO
    */
    $valoresEntrada    = explode('|', $configuracaoSalva[1]);

    //var_dump($valoresEntrada);

    //CICLO DE VERIFICAÇÃO DAS ENTRADAS CONFIGURADAS NO EQUIPAMENTO
    for($i = 0; $i < $entradasEquipamento; $i++ ){

        $valorValido   =  verificaProtocoloPosicaoTebela($_POST[$entradasDisponiveis[$i]], $protocolos);

        //VERIFICA SE O VALOR É UM PROTOCOLO OU É UM VALOR VÁLIDO
        if($valorValido > 0){
            echo "Teste de entrada :".$entradasDisponiveis[$i]." <br />";

            $status    = comparaParametrosEquipamento(($_POST[$entradasDisponiveis[$i]]/100), $valoresEntrada, $idSimEquip, 'Medidor de temperatura', strtolower($entradasDisponiveis[$i]));

        }else{
            echo "Valor passado foi um protocolo ! <br />";

            //GERA ALARME DE PROTOCOLO
            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Medidor de temperatura', 9, 1, strtolower($entradasDisponiveis[$i]));
        }

    }


    /*
        'id' => string '59' (length=2)
         'nomeModeloEquipamento' => string 'Eficaz - Infraweb' (length=17)
         'tipo_equipamento' => string 'Medidor temperatura' (length=19)
         'ambiente' => string '' (length=0)
         'cliente' => string 'Eficaz System' (length=13)
         'filial' => null
         'tipo_entrada' => string '17' (length=2)
         'tipo_saida' => string '1' (length=1)
         'quantidade_bateria_por_banco' => string '0' (length=1)
         'tensaoMinBarramento' => string '10.5' (length=4)
         'correnteBancoBateria' => string '' (length=0)
         'potencia' => string '' (length=0)
    */



?>
