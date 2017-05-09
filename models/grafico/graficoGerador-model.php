<?php

/**
 * GraficoGeradorModel
 *
 * Modelo que gerencia toda as regras da geracao do grafico
 */
 class GraficoGeradorModel extends MainModel
{

    /**
     * respData
     *
     * Armazena a resposta dos valores
     *
     * @access public
     */
    public $respData;

    /**
     * respDate
     *
     * Armazena a resposta das datas
     *
     * @access public
     */
    public $respDate;

    /**
     * Metodo construtor
     *
     * Fucao que configura todas os parametros
     *
     * @access public
     */

    public function __construct ($db = false, $controller = null)
    {
        /* carrega a conexao */
        $this->db = $db;

        /* carrega o controller */
        $this->controller = $controller;

        /* carrega os parametros */
        $this->parametros = $this->controller->parametros;

        // Chama a funcao que monta o grafico
        $this->montaGrafico();
    }

    /**
     * montaGrafico
     *
     * Funcao que constroi o grafico
     *
     * @access public
     */
    private function montaGrafico ()
    {

        // CRIA AS TABELAS
        $tabela = array("b","c","d","e","f","g","i", "j", "l", "m", "n", "o", "h", "q","r", "er", "es", "et", "cr", "cs", "ct");
        $tabela2 = array("Entrada R","Entrada S","Entrada T","Saida R","Saida S","Saida T", "Corrente R", "Corrente S", "Corrente T", "Corrente Saida R", "Corrente Saida S", "Corrente Saida T", "Bateria", "Temperatura Ambiente","Temperatura Banco bateria", "Pontência entrada R", "Pontência entrada S", "Pontência entrada T", "Pontência saída R", "Pontência saída S", "Pontência saída T");

        // CONVERTE DA BASE 64
        //$sim_num = base64_decode($this->parametros[0]);
        $equipId = $this->parametros[0];

        //RECUPERA O SIM ATRAVES DO NUMERO DO EQUIPAMENTO
        if(is_numeric($equipId)){

            $querySim = "SELECT id_sim FROM tb_sim_equipamento WHERE id_equipamento = '$equipId'";

            $resultadoSim = $this->verificaQuery($querySim);

            if(!empty($resultadoSim)){

                $sim_num = $resultadoSim[0]['id_sim'];

                // Coleta os itens ativados
                $opc = explode(",",$this->parametros[1]);

                //RECUPERA OS HORÁRIOS PASSADOS PELO USUÁRIO
                $horaIni  = $opc[23];
                $horaFim  = $opc[24];

                // Recupera as datas de inicio e fim de periodo

                $dataIni  = date( "Y-m-d ".$horaIni.":00", strtotime($opc[21]) );
                $dataFim  = date( "Y-m-d ".$horaFim.":59", strtotime($opc[22]) );

                $datetime1 = date_create($opc[21]);
                $datetime2 = date_create($opc[22]);
                $intervalInDays = ($datetime2->format("U") - $datetime1->format("U"))/(3600 * 24);

                $diasDiff   = $intervalInDays;

                /*
                * QUERY PARA CARREGAR AS VARIAVEIS DE CALIBRAÇÃO DO EQUIPAMENTO
                */

                // $variaveisCalib = array();

                // Monta a sequencia de opções de calibração para serem carregadas no gráfico
                // for ($a = 0; $a < sizeof($tabela) ; $a++)
                // {
                //
                //     if (($opc[$a] == 1) && (is_numeric($opc[$a]))){

                        // $queryCalibracao  = "SELECT cali.variavel_cal FROM tb_equipamento_calibracao cali JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = cali.id_equip WHERE simEquip.id_sim = '{$sim_num}' AND cali.posicao_tab = '$tabela[$a]' AND simEquip.status_ativo = '1'";

                        // BUSCA OS DADOS NO BANCO
                        // $resultCalib = $this->verificaQuery($queryCalibracao);

                        // if(!empty($resultCalib)){
                        //
                        //     // Adiciona o valor de calibração na array
                        //
                        //     foreach ($resultCalib as $cal){
                        //
                        //         //print_r($cal['variavel_cal']);
                        //
                        //         array_push($variaveisCalib, array($tabela[$a] => $cal['variavel_cal']));
                        //
                        //     }
                        //
                        // }

                //     }
                //
                // }

                //print_r($opc);
                //var_dump($variaveisCalib);
                //exit();

                /*
                * QUERY PARA TRAZER OS DADOS DA TABELA NORMAL
                */
                // Monta a query para buscar os resultados
                $query = "SELECT DATE(dad.dt_criacao) date, MINUTE(dad.dt_criacao) minut, DAY(dad.dt_criacao) day, HOUR(dad.dt_criacao) hour, MIN(dad.dt_criacao) min_date, UNIX_TIMESTAMP(dad.dt_criacao) AS 'dt_criacao', ";

                // Define os parametros
                for ($a = 0; $a < sizeof($tabela) ; $a++)
                {
                    if (($opc[$a] == 1) && (is_numeric($opc[$a]))){

                        // $query .= ' dad.'.$tabela[$a] . ",";
                        // Query para procurar a variavel de calibracao da posição da tabela.
                        $queryCalibracao  = "SELECT cali.variavel_cal FROM tb_equipamento_calibracao cali JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = cali.id_equip WHERE simEquip.id_sim = '{$sim_num}' AND cali.posicao_tab = '$tabela[$a]' AND simEquip.status_ativo = '1'";

                        // BUSCA OS DADOS NO BANCO
                        $resultCalib = $this->verificaQuery($queryCalibracao);

                        if(!empty($resultCalib)){

                            // Adiciona o valor de calibração na query

                            foreach ($resultCalib as $cal){

                                //print_r($cal['variavel_cal']);
                                $query .= ' ( dad.'.$tabela[$a].' * '.$cal['variavel_cal'].') AS "'.$tabela[$a].'",';
                            }

                        }else{

                            //Coreção para não misturar parametros desta query com as da outra tabela
                            if(($tabela[$a] != 'er') && ($tabela[$a] != 'es') && ($tabela[$a] != 'et') && ($tabela[$a] != 'ct') && ($tabela[$a] != 'cr') && ($tabela[$a] != 'cs')){

                                $query .= ' dad.'.$tabela[$a] . ",";

                            }
                        }


                        // if($tabela[$a] == 'h'){
                        //     //$query .= ''.$tabela[$a] . " + (800) AS 'h',";
                        //     $query .= ' IF(dad.h > 0, dad.h + 1700, dad.h) AS "h",';
                        // }else{
                        //     //Coreção para não misturar parametros desta query com as da outra tabela
                        //     if(($tabela[$a] != 'er') && ($tabela[$a] != 'es') && ($tabela[$a] != 'et') && ($tabela[$a] != 'ct') && ($tabela[$a] != 'cr') && ($tabela[$a] != 'cs')){
                        //
                        //         $query .= ' dad.'.$tabela[$a] . ",";
                        //
                        //     }
                        //
                        // }

                    }

                }

                // Trata a ultima posicao
                $query .= ".";
                $query = str_replace(",.","",$query);

                $query .= " FROM tb_dados dad";

                // $query .= " JOIN tb_sim_equipamento sim_equip ON sim_equip.id_sim = dad.num_sim";
                //
                // $query .= " JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento";

                //$query .= " JOIN tb_dados_potencia dadPot ON (dadPot.num_sim = '{$sim_num}' AND dad.num_sim = '{$sim_num}' AND dad.dt_criacao = dadPot.data_registro) ";

                $query .= " WHERE dad.dt_criacao BETWEEN '{$dataIni}' AND '{$dataFim}' AND dad.num_sim = '{$sim_num}' AND dad.status_ativo = '1'";

                if($diasDiff > 7){
                    $query .=" GROUP BY DATE(dad.dt_criacao)";
                }elseif($diasDiff > 2){
                    $query .=" GROUP BY DATE(dad.dt_criacao),HOUR(dad.dt_criacao)";
                }else{
                    $query .=" GROUP BY DATE(dad.dt_criacao),HOUR(dad.dt_criacao), MINUTE(dad.dt_criacao)";
                }

                // var_dump( $opc, $query, $diasDiff);
                // print_r($query);
                // exit();

                // BUSCA OS DADOS NO BANCO
                $result = $this->verificaQuery($query);

                /*
                * QUERY PARA TRAZER OS DADOS DE POTENCIA
                */
                $queryPot = "SELECT DATE(dadPot.data_registro) date, MINUTE(dadPot.data_registro) minut, DAY(dadPot.data_registro) day, HOUR(dadPot.data_registro) hour, MIN(dadPot.data_registro) min_date, UNIX_TIMESTAMP(dadPot.data_registro) AS 'dt_criacao', ";
                // Define os parametros
                for ($a = 0; $a < sizeof($tabela) ; $a++)
                {
                    if (($opc[$a] == 1) && (is_numeric($opc[$a]))){

                        if(($tabela[$a] == 'er') || ($tabela[$a] == 'es') || ($tabela[$a] == 'et') || ($tabela[$a] == 'ct') || ($tabela[$a] == 'cr') || ($tabela[$a] == 'cs')){

                            $queryPot .= ' dadPot.'.$tabela[$a] . ",";

                        }

                    }
                }

                // Trata a ultima posicao
                $queryPot .= ".";
                $queryPot = str_replace(",.","",$queryPot);

                $queryPot .= " FROM tb_dados_potencia dadPot";
                $queryPot .= " WHERE dadPot.data_registro BETWEEN '{$dataIni}' AND '{$dataFim}' AND dadPot.num_sim = '{$sim_num}'";

                if($diasDiff > 7){
                    $queryPot .=" GROUP BY DATE(dadPot.data_registro)";
                }elseif($diasDiff > 2){
                    $queryPot .=" GROUP BY DATE(dadPot.data_registro),HOUR(dadPot.data_registro)";
                }else{
                    $queryPot .=" GROUP BY DATE(dadPot.data_registro),HOUR(dadPot.data_registro), MINUTE(dadPot.data_registro)";
                }

                // BUSCA OS DADOS NO BANCO
                $resultPot = $this->verificaQuery($queryPot);

                // var_dump($resultPot);
                // print_r($queryPot);
                // exit();

                // Inicia a variavel da data
                $respDate       = "[";
                $respRawDate    = array();

                // JUNÇÃO DOS RESULTADOS DAS DUAS QUERYES

                if((!empty($result)) || (!empty($resultPot))){

                    // Realiza o loop na result
                    for ($a = 0; $a < sizeof($result); $a++)
                    {
                        // $respDate é responsavel por armazenar as séries das datas.
                        // $respDate .= "'".date('d-M-y H:i',strtotime($result[$a]['dt_criacao']))."',";
                        $respDate .= "'".$result[$a]['dt_criacao']."',";

                        //SALVA NA ARRAY A DATA PURA
                        array_push($respRawDate, $result[$a]['dt_criacao']);

                        for ($b = 0; $b < sizeof($tabela) ; $b++)
                        {
                            if ($opc[$b] == 1 && empty ($respData[$tabela[$b]][0]))
                            {
                                $respData[$tabela[$b]][0] = "{name:'{$tabela2[$b]}',data:[";

                            }

                            //VERIFICA SE O PARAMETRO ESTÁ ESCOLHIDO OU NÃO PARA ADICIONAR NA SÉRIE
                            if ($opc[$b] == 1){

                                //EFETUA A DISCRIMINAÇÃO DOS PARAMETROS ESCOLHIDOS
                                if(($tabela[$b] != "er") && ($tabela[$b] != "es") && ($tabela[$b] != "et") && ($tabela[$b] != "cr") && ($tabela[$b] != "cs") && ($tabela[$b] != "ct")){
                                    //CONVERTE AS POTÊNCIAS EM (Kw)
                                    $respData[$tabela[$b]][0] .= "".floatval($result[$a][$tabela[$b]]/100).",";
                                }else{
                                    //$respData[$tabela[$b]][0] .= "".intval(floatval($result[$a][$tabela[$b]]/100)).",";
                                    //$respData[$tabela[$b]][0] .= "".floatval($result[$a][$tabela[$b]]/100).",";
                                }

                            }

                        }
                    }

                    // Realiza o loop na resultPot
                    for ($a = 0; $a < sizeof($resultPot); $a++)
                    {

                        // TESTA SE $result RETORNOU RESULTADO, CASO NEGATIVO
                        if(empty($result)){

                            $respDate .= "'".$resultPot[$a]['dt_criacao']."',";

                            //SALVA NA ARRAY A DATA PURA
                            array_push($respRawDate, $resultPot[$a]['dt_criacao']);
                        }

                        for ($b = 0; $b < sizeof($tabela) ; $b++)
                        {
                            if ($opc[$b] == 1 && empty ($respData[$tabela[$b]][0]))
                            {
                                $respData[$tabela[$b]][0] = "{name:'{$tabela2[$b]}',data:[";

                            }

                            //VERIFICA SE O PARAMETRO ESTÁ ESCOLHIDO OU NÃO PARA ADICIONAR NA SÉRIE
                            if ($opc[$b] == 1){

                                //EFETUA A DISCRIMINAÇÃO DOS PARAMETROS ESCOLHIDOS
                                if(($tabela[$b] == "er") || ($tabela[$b] == "es") || ($tabela[$b] == "et") || ($tabela[$b] == "cr") || ($tabela[$b] == "cs") || ($tabela[$b] == "ct")){
                                    //CONVERTE AS POTÊNCIAS EM (Kw)
                                    $respData[$tabela[$b]][0] .= "".floatval($resultPot[$a][$tabela[$b]]/1000).",";
                                }else{
                                    //$respData[$tabela[$b]][0] .= "".intval(floatval($result[$a][$tabela[$b]]/100)).",";
                                    //$respData[$tabela[$b]][0] .= "".floatval($result[$a][$tabela[$b]]/100).",";
                                }

                            }
                        }

                    }


                    // Adiciona e remove os caracteres
                    $respDate .= "]";
                    $respDate = str_replace(",]","]",$respDate);

                    foreach ($respData as $campo => $valor)
                    {
                        $respData[$campo][0] = $valor[0] . ",}";
                        $respData[$campo][0] = str_replace(",,","]",$respData[$campo][0]);
                    }

                }else{
                    $respDate = "[]";
                    $respData = "{}";
                    $respRawDate = array();
                    $diff = 0;
                }

            }else{
                //CASO O EQUIPAMENTO NÃO POSSUA DADOS SALVOS NO BD AINDA
                $respDate = "[]";
                $respData = "{}";
                $respRawDate = array();
                $diasDiff = 0;
            }

        }else{
            $respDate = "[]";
            $respData = "{}";
            $respRawDate = array();
            $diasDiff = 0;
        }

        // Converte para json
        $this->respData = $respData;
        $this->respDate = $respDate;
        $this->respRawDate = $respRawDate;
        $this->respDiference = $diasDiff;

    }


    /**
     * Funcao que busca os dados do cliente como
     * nome e dados do equipamento
     *
     * @param string $sim - recebe a criptografia do sim
     *
     * @return array $resp - retorna todos os dados do cliente
     */
    public function buscaDadosClinte ($sim)
    {

        // Decodifica o sim
        $sim = base64_decode($sim);

        // Monta a query
        $query = "select
                    c.nome as nomeCli, e.tipo_equipamento as nomeEquip , e.modelo as modeloEquip, fa.nome as nomeFabri
                from tb_sim_equipamento sq
                inner join tb_sim s on s.num_sim = sq.id_sim
                inner join tb_cliente c on c.id = s.id_cliente
                inner join tb_equipamento e on e.id = sq.id_equipamento
                inner join tb_fabricante fa on fa.id = e.id_fabricante
                where sq.id_sim = {$sim}";

        // Busca valores
        $resultado = $this->realizaBusca($query);

        // Verifica se existe retorno
        if ($resultado)
            return $resultado;
        else{
            // Caso nao exista resultado
            // Realiza a busca para as filiais
            // Monta a query da filial
            $query = "select
                        f.nome as nomeCli, e.tipo_equipamento as nomeEquip , e.modelo as modeloEquip, fa.nome as nomeFabri
                    from tb_sim_equipamento sq
                    inner join tb_sim s on s.num_sim = sq.id_sim
                    inner join tb_filial f on f.id = s.id_filial
                    inner join tb_equipamento e on e.id = sq.id_equipamento
                    inner join tb_fabricante fa on fa.id = e.id_fabricante
                    where sq.id_sim = {$sim}";

            // Busca os valores
            $resultado = $this->realizaBusca($query);

            // Verifica se existe valor
            if ($resultado)
            {
                // Se existir valor
                // Devolve a resposta
                return $resultado;
            }
            else
            {
                // Caso nao exista, retorna false
                return $resultado;
            }

        }


    }


}







?>
