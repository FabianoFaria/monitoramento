<?php

class HomeModel extends MainModel
{
    public function __construct ($db = false , $controller = null)
    {
        /* carrega a conexao */
        $this->db = $db;

        /* carrega o controller */
        $this->controller = $controller;

        /* carrega os parametros */
        $this->parametros = $this->controller->parametros;
    }

    /*
     *      funcao responsavel por trazer todos
     *      os clientes que possuem um sim cadastrado e equipamento
     */
    public function tabelaDeCliente ($cliente,$tipo)
    {
        /* verifica se a query esta funcionando */
        if ($result = $this->db->select ("call proc_trazclinte ({$cliente},{$tipo})"))
        {
            /* verifica se existe retorno */
            if (@mysql_num_rows($result) > 0)
            {
                /* se existir retorno, associa a array */
                while ($row = @mysql_fetch_assoc($result))
                {
                    /* armazena os valores e no array */
                    $retornoTabCliente[] = $row;
                }
                /* devolve os valores */
                return $retornoTabCliente;
            }
            return false;
        }
        return false;
    }

    

    /* acao que gera o grafico */
    public function gerarGrafico()
    {
        /* se existir uma acoa do post */
        if (isset($_POST['btn_gerar']))
        {
            /* verificador */
            $cont = 0;

            /* verificar se existe valor */
            $vet['bateria'] = isset($_POST['chk_bat']) ? $_POST['chk_bat'] : 0 ;
            $vet['entrada'] = isset($_POST['chk_ent']) ? $_POST['chk_ent'] : 0 ;
            $vet['saida']   = isset($_POST['chk_sai']) ? $_POST['chk_sai'] : 0 ;
            $vet['onda']    = isset($_POST['chk_ond']) ? $_POST['chk_ond'] : 0 ;

            /* verifica se todas as opcoes estao zeradas */
            foreach ($vet as $row)
            {
                if ($row != 0)
                    $cont = 1;
            }

            /* verifica as opcoes */
            if ($cont == 0)
                $link = base64_encode("1;1;1;1");
            else
                $link = base64_encode("{$vet['bateria']};{$vet['entrada']};{$vet['saida']};{$vet['onda']}");

            /* organizador de parametros */
            $tdParam = $this->parametros[0] ."/".$this->parametros[1]."/".$this->parametros[2];

            /* armazena o link */
            $login_uri = HOME_URI . "/home/grafico/" . $tdParam ."/". $link;

            /* redireciona */
            echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';
        }
    }

    /* funcao que configura os parametros */
    public function confParamentroGrafico()
    {
        /* grava a primeira posicao da url */
        $nova_url[0] = $this->parametros[0];

        /* trata o segundo paramentro */
        $deco_url = explode("-",base64_decode($this->parametros[3]));

        /* insere os valores decodificados */
        for ($a=0;$a<sizeof($deco_url);$a++)
            $nova_url[$a+1] = $deco_url[$a];

        /* quebra o segundo parametro */
        $nova_url2 = explode (";",$nova_url[1]);

        /* apaga posicao do array */
        unset($nova_url[1]);

        /* inserindo novos valores organizados */
        foreach ($nova_url2 as $row)
            $nova_url[] = $row;

        /* reindexando array */
        $nova_url = array_values($nova_url);

        /* fim */
        return $nova_url;
    }

    /* funcao que carrega os parametros do grafico */
    public function loadGraficoParam()
    {
        /* decripta os parametros */
        $sim  = base64_decode($this->parametros[0]);
        $ideq = base64_decode($this->parametros[1]);
        $idsq = base64_decode($this->parametros[2]);

        /* quebra em vetor */
        $ideq = explode("-",$ideq);

        /* buscando parametros no banco */
        if($ideq[1] == 'e')
        {
            $query = "select parametro from tb_parametro where id_sim_equipamento = {$idsq} and num_sim = {$sim} and id_equipamento = {$ideq[0]} order by (dt_criacao) desc limit 1";
        }
        else if ($ideq[1] == 'a')
        {
            $query = "select parametro from tb_parametro where id_sim_equipamento = {$idsq} and num_sim = {$sim} and id_ambiente = {$ideq[0]} order by (dt_criacao) desc limit 1";
        }

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
                $retorno = explode("|",$retorno[0]['parametro']);
                foreach($retorno as $row)
                {
                    $row2 = explode("-",$row);
                    /* coleta posicao */
                    $posicao[] = $row2[0];
                    /* colote valor */
                    $valor[] = $row2[1];
                }

                /* retorna os valores */
                return $valor;
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
    }
}

?>
