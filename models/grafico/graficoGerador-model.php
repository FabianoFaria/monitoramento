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
        $tabela = array("b","c","d","e","f","g","i", "j", "l", "m", "n", "o", "h");
        $tabela2 = array("Entrada R","Entrada S","Entrada T","Saida R","Saida S","Saida T", "corrente R", "Corrente S", "Corrente T", "Corrente Saida R", "Corrente Saida S", "Corrente Saida T", "Bateria");

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
                //$opc = explode(",",$this->parametros[4]);
                $opc = explode(",",$this->parametros[1]);

                // Monta a query para buscar os resultados
                $query = "SELECT UNIX_TIMESTAMP(dt_criacao) AS 'dt_criacao', ";

                // Define os parametros
                for ($a = 0; $a < sizeof($tabela) ; $a++)
                {
                    if (($opc[$a] == 1) && (is_numeric($opc[$a])))
                        $query .= $tabela[$a] . ",";
                }

                // Trata a ultima posicao
                $query .= ".";
                $query = str_replace(",.","",$query);

                // Recupera as datas de inicio e fim de periodo

                $dataIni  = date( "Y-m-d H:i:s", strtotime($opc[13]) );
                $dataFim  = date( "Y-m-d H:i:s", strtotime($opc[14]) );

                // Adiciona o final da query
                // $query .= " FROM tb_dados WHERE num_sim = {$sim_num} AND dt_criacao > '{$dataIni}' AND dt_criacao < '{$dataFim}' LIMIT 300";
                $query .= " FROM tb_dados WHERE num_sim = {$sim_num} AND dt_criacao BETWEEN '{$dataIni}' AND '{$dataFim} ' LIMIT 4360";
                //$query .="FROM ( SELECT @row := @row +1 AS rownum, dt_criacao FROM (SELECT @row :=0) r, tb_dados WHERE num_sim = {$sim_num} AND dt_criacao BETWEEN '{$dataIni}' AND '{$dataFim}') ) ranked WHERE rownum %30 =1";

                /*
                    Query para filtrar os dados para a cada meia horas
                    FROM (
                        SELECT
                            @row := @row +1 AS rownum, dt_criacao
                        FROM (
                            SELECT @row :=0) r, tb_dados WHERE num_sim = '1' AND dt_criacao BETWEEN '2017-02-01' AND '2017-02-09'
                        ) ranked
                    WHERE rownum %30 =1
                */


                //var_dump( $opc, $query);

                // Busca os dados no banco
                $result = $this->verificaQuery($query);

                // Inicia a variavel da data
                $respDate       = "[";
                $respRawDate    = array();

                if(!empty($result)){

                    // Realiza o loop na result
                    for ($a = 0; $a < sizeof($result); $a++)
                    {
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

                            if ($opc[$b] == 1)
                                $respData[$tabela[$b]][0] .= "".intval(floatval($result[$a][$tabela[$b]]/10)).",";
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
                }

            }

            //var_dump($resultadoSim);

        }else{
            $respDate = "[]";
            $respData = "{}";
            $respRawDate = array();
        }

        // Converte para json
        $this->respData = $respData;
        $this->respDate = $respDate;
        $this->respRawDate = $respRawDate;
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
        else
        {
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
