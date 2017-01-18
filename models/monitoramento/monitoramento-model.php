<?php

class MonitoramentoModel extends MainModel
{

    public function __construct ($db = false, $controller = null)
    {
        /* carrega a conexao */
        $this->db = $db;

        /* carrega o controller */
        $this->controller = $controller;

        /* carrega os parametros */
        $this->parametros = $this->controller->parametros;
    }



    /**
     * funcao que configura os parametros , redefine a nova url
     */
    public function confParamentroGrafico()
    {
        /* grava a primeira posicao da url */
        $nova_url[0] = $this->parametros[0];

        /* trata o segundo paramentro */
        $deco_url = explode("-",base64_decode($this->parametros[1]));

        /* insere os valores decodificados */
        for ($a=0;$a<sizeof($deco_url);$a++)
            $nova_url[$a+1] = $deco_url[$a];

        return $nova_url;
    }

    /**
     * funcao que carrega os parametros do grafico
     * MODIFICANDO ESTA FUNÇÃO DE FORMA QUE PASSE A RECEBER PARAMETROS
     */
    public function loadGraficoParam($idEquip, $idSimEquip, $numSim)
    {
        //COMENTANDO ESTE TRECHO PARA DESATIVAR
        // Tira criptografica
        // Sim
        //$sim  = base64_decode($this->parametros[0]);
        // Id equipamento
        //$ideq = base64_decode($this->parametros[1]);
        // Id sim equipamento
        //$idsq = base64_decode($this->parametros[2]);

        //$idse = base64_decode($this->parametros[3]);

        //VALIDANDO OS TRECHOS PASSADOS POR PARAMETROS
        if(isset($idEquip) && isset($idSimEquip) && isset($numSim)){
            $sim  = $numSim;
            $ideq = $idEquip;
            $idsq = $idSimEquip;

            // Monta a query
            $query = "SELECT parametro FROM tb_parametro WHERE id_sim_equipamento = '$idsq' AND num_sim = '$sim' AND id_equipamento = '$ideq' ORDER BY (dt_criacao) DESC LIMIT 1";

            /* monta a result */
            $busca = $this->db->select($query);

            /* verifica se a query executa */
            if ($busca)
            {
                /* verifica se existe valor */
                if (@mysql_num_rows($busca) > 0)
                {
                    /* monta o array com os valores */
                    while($row = @mysql_fetch_assoc($busca))
                        $retorno[] = $row;

                    /* quebra a resposta no array */
                    $retorno = explode("|inicio|",$retorno[0]['parametro']);

                    //var_dump($retorno);

                    // foreach($retorno as $row)
                    // {
                    //
                    //
                    //     $row2 = explode("-",$row);
                    //     // Coleta posicao
                    //     $posicao[] = $row2[0];
                    //     // colote valor
                    //     $valor[] = $row2[2];
                    // }

                    for($i = 1; $i <=5; $i++){
                        //var_dump($retorno[0]);

                        $row2 = explode("|", $retorno[$i]);

                        if($row2 != ''){

                            for($f=0; $f<=4; $f++){

                                //var_dump($row2[$f]);
                                $row3 = explode("-",$row2[$f]);
                                // Coleta posicao
                                $posicao[] = $row3[0];
                                // // colote valor
                                $valor[] = ($row3[1] != '') ? $row3[1] : 0;
                            }
                        }

                        //var_dump($valor);
                        //(isset($configuracaoSalva)) ? $this->trataValor($valoresEntrada[0]) : ""
                    }

                    //Destroi variavel auxiliar
                    unset($row2);
                    //Retorna os valores
                    return $valor;
                    //return $retorno;
                }
                else
                {
                    /* caso nao existir valor, retorna false */
                    return false;
                }
            }
            else
            {
                echo "nao";
                /* se a query apresentar erro, retorna false */
                return false;
            }

        }else{
            return false;
        }

    }

    /**
     * Funcao que captura acao do post
     * Coleta dos dados das datas e gera o grafico por periodo
     */
    public function gerarPeriodo()
    {
        // Verifica se existe acao no post
        if (isset($_POST['btn_gerar']))
        {
            // Verifica se existe campo em branco
            if ($_POST['dt_ini'] != '' && $_POST['dt_fim'] != '')
            {
                $dti = base64_encode($_POST['dt_ini']);
                $dtf = base64_encode($_POST['dt_fim']);

                // Monta url
                $link = HOME_URI . "/monitoramento/gerarGrafico/".$this->parametros[0]."/".$this->parametros[1]."/".$this->parametros[2]."/".$this->parametros[3]."/".$dti."/".$dtf;

                // Redireciona para o grafico
                echo "<script type='text/javascript'>window.location.href = '" . $link . "'</script>";
            }
            else
            {
                // Mostra a mensagem de campo em branco
                echo "<div class='mensagemError'><span>Existe campo em branco.</span></div>
                    <script>setTimeout(function(){ $('.mensagemError').fadeOut(); },1500);</script>
                ";
            }
        }
    }

    /**
     * Funcao que insere os dados do $data em um string de retorno
     * Para chamar os valores dos graficos linha
     */
    public function insereDadosGrafico($valTratar)
    {
        $resutadoGrafico = "";
        // quebra os dados do array e monta
        for ($a=0;$a<sizeof($valTratar);$a++)
        {
            // Verifica se coloca virgula entre os elementos
            if ($a == (sizeof($valTratar) - 1))
            {
                // Mostra o valor sem virgula
                // Caso o valor do elemento se igual o tamanho da array
                $resutadoGrafico .= $valTratar[$a];
            }
            else
            {
                // Insere virgula entre os elementos
                // Se o valor do $a seja diferente do valor da array
                $resutadoGrafico .= $valTratar[$a].",";
            }
        }

        return $resutadoGrafico;
    }


    /**
     * Funcao que busca o tempo de operacao do aparelho
     *
     * @return string $dataOperacao - retorno o tempo total de operacao do dispositivo
     */
    function verificaTempoOperacao($sim)
    {
        // Decodifica a url
        $sim = base64_decode($sim);

        // Monta a query para pegar os valores da entrada
        $query = "select dt_criacao from tb_numero_falta where id_num_sim = {$sim} order by (dt_criacao) desc limit 1";

        // Realiza a pesquisa no banco
        $result = $this->db->select($query);

        // Verifica se existe resultado
        if (@mysql_num_rows ($result) > 0)
        {
            // Coleta dos dados
            while ($row = @mysql_fetch_assoc($result))
                $resp[] = $row;

            // Coleta a data de retorno
            $resultado = strval($resp[0]['dt_criacao']);
        }
        else
        {
            // Se nao existir faltas
            // Monta a query para pegar os valores da entrada
            $query = "select dt_criacao from tb_dados where num_sim = {$sim} order by (dt_criacao) asc limit 1";

            // Realiza a pesquisa no banco
            $result = $this->db->select($query);
        if (@mysql_num_rows ($result) > 0)
        {
            // Coleta dos dados
            while ($row = @mysql_fetch_assoc($result))
                $resp[] = $row;

            // Coleta a data de retorno
            $resultado = strval($resp[0]['dt_criacao']);
        }
            else
            $resultado = 0;
        }

        // Retorna o resultado
        return $resultado;
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


    /**
     * carregaDadosGrafico
     *
     * Funcao que carrega os dados do grafico de entrada e saida
     *
     * @access public
     */
    public function carregaDadosGrafico($posicao, $parte, $id)
    {
        // Coleta as informacoes do grafico
        $querymon = "select {$posicao},dt_criacao from tb_dados where num_sim = {$id} order by (dt_criacao) desc limit 20";

        // Monta a result
        $resmon = $this->db->select($querymon);

        // Monta os valores
        if (@mysql_num_rows($resmon) > 0)
        {
            $tempomon = "[";
            $datamon = "[";



            // Coleta o resultado
            while($rowmon = @mysql_fetch_assoc($resmon))
            {
                $linhaArr[] = $rowmon;
            }

            // Coleta o total do vetor
            $vetTam = sizeof($linhaArr);

            // Monta a resposta de tras para frente
            for ($a=$vetTam-1;$a>=0;$a--)
            {
                $datamon .= floatval($linhaArr[$a][$posicao]/10).",";
                $tempomon .= "'".$linhaArr[$a]['dt_criacao']."',";
            }

            // Diciona o final
            $datamon .= "]";
            $tempomon .= "]";
            // Remove a virgula
            $datamon = str_replace(",]","]",$datamon);
            $tempomon = str_replace(",]","]",$tempomon);

            // Junta o tempo com os dados
            $datamon .= ";".$tempomon;

            // Retorna os dados
            return $datamon;
        }

        return false;
    }

    /*
    *  Trata as strings dos valores das configurações dos equipamento
    */
    public function trataValor($valor){

        //Formato da string esperado : 'et1-2-0'
        $temp = explode('-', $valor);
        return str_replace('.',',',$temp[1]);
    }
}

?>
