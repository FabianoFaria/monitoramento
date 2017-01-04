<?php

class ConfiguracaoModel extends MainModel
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


    /* busca todos os esquipamentos e ambientes vinculados a cliente e filial */
    public function buscaRelacao()
    {
        $query = " select s.num_sim, c.nome , s.dt_criacao , s.status_ativo
                   from tb_sim s
                   inner join tb_cliente c on c.id = s.id_cliente
                   where s.status_ativo = 1 and s.id_cliente is not null";

        $result = $this->db->select($query);

        /* verifica se existe retorno */
        if ($result)
        {
            /* verifica se existe resultado */
            if (@mysql_num_rows($result) > 0)
            {
                /* monta array com os resultados */
                while ($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;

                /* retorna o array */
                return $retorno;
            }
        }
    }


    /* busca todos os esquipamentos e ambientes vinculados a cliente e filial */
    public function buscaRelacaoFilial()
    {
        // Descriptografa o numero do sim
        $num_sim_cliente = base64_decode($this->parametros[0]);

        // Monta a query para busca o cliente
        $query = "select s.num_sim, c.nome , s.dt_criacao , s.status_ativo, 'c' as nivel , id_cliente
                  from tb_sim s
                  inner join tb_cliente c on c.id = s.id_cliente
                  where s.status_ativo = 1 and  s.num_sim = {$num_sim_cliente}";

        // Realiza o select
        $resp[] = $this->realizaBusca($query);



        // Monta a query para buscar as filiais
        $query = "select s.num_sim, f.nome, s.dt_criacao, s.status_ativo, 'f' as nivel
                  from tb_filial f
                  inner join tb_sim s on s.id_filial = f.id
                  where f.id_matriz = {$resp[0]['id_cliente']}";
        // Busca a result da filial
        $resp[] = $this->realizaBusca($query);

        return $resp;
    }


    /* busca todos os esquipamentos e ambientes vinculados a cliente e filial */
    public function buscaRelacaoEquipamento()
    {
        // Descriptografa o numero do sim
        $num_sim_cliente = base64_decode($this->parametros[0]);

        // Monta a query para buscar equipamentos
        $query = "select
            fa.nome as fabricante, e.tipo_equipamento as tipo, e.modelo, e.potencia, e.qnt_bateria, e.caracteristica_equip,
            sq.status_ativo, e.tipo_bateria, e.amperagem_bateria, sq.dt_criacao , sq.id as id_sq, e.id as id_equip
            from tb_sim_equipamento sq
            inner join tb_equipamento e on e.id = sq.id_equipamento
            inner join tb_fabricante fa on fa.id = e.id_fabricante
            where sq.id_sim = {$num_sim_cliente}";

        // Realiza o select
        $result = $this->db->select($query);

        /* verifica se existe retorno */
        if ($result)
        {
            /* verifica se existe resultado */
            if (@mysql_num_rows($result) > 0)
            {
                /* monta array com os resultados */
                while ($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;

                return $retorno;
            }
        }

        // Retorna o valor do select
        return false;
    }


    /**
     * buscaClienteFilial
     *
     * Busca todos os cliente e filiais
     *
     * @access public
     */
    public function buscaClienteFilial()
    {
        // Descriptografa o numero do sim
        $num_sim_cliente = base64_decode($this->parametros[0]);

        // Monta a query para buscar matriz
        $query = "select s.num_sim, c.nome
                from tb_sim s
                inner join  tb_cliente c on c.id = s.id_cliente
                where num_sim = {$num_sim_cliente}";

        // Realiza o select
        $respo = $this->realizaBusca($query);
        // Verifica se existe valor
        if ($respo != false && is_array($respo) && ! empty ($respo))
        {
            // Adiciona o valor
            $resp = $respo;
        }

        // Monta query para buscar filial
        $query = "select s.num_sim, f.nome
                from tb_sim s
                inner join tb_filial f on f.id = s.id_filial
                where s.num_sim = {$num_sim_cliente}";

        // Realiza o select
        $respo = $this->realizaBusca($query);
        // Verifica se existe valor
        if ($respo != false && is_array($respo) && ! empty ($respo))
        {
            // Adiciona o valor
            $resp = $respo;
        }

        // Finaliza
        return $resp;
    }

    /**
     * realizaBusca
     *
     * Funcao que realiza o select e monta a array de resposta
     */
    public function realizaBusca($query)
    {
        $result = $this->db->select($query);

        /* verifica se existe retorno */
        if ($result)
        {
            /* verifica se existe resultado */
            if (@mysql_num_rows($result) > 0)
            {
                /* monta array com os resultados */
                while ($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;

                /* retorna o array */
                return $retorno[0];
            }
        }
        return false;
    }

    /* configuracao dos parametros */
    public function carregaParametroForm()
    {
        /* realiza validacao */
        if (isset($this->parametros) && is_array($this->parametros) && !empty($this->parametros))
        {
            /* decodifica o parametro */
            $equip = base64_decode($this->parametros[2]);
            /* quebra em array */
            $equip = explode("-",$equip);

            /* monta a query */
            $query = "select * from tb_parametro where id_sim_equipamento = ". base64_decode($this->parametros[1])." and
                      num_sim = ". base64_decode($this->parametros[0])." and id_equipamento = {$equip[0]} and
                      status_ativo = 1 order by (dt_criacao) desc limit 1";

            /* busca os valores */
            $result = $this->db->select($query);
            /* verifica se existe retorno */
            if ($result)
            {
                /* verifica se existe valor */
                if (@mysql_num_rows ($result) > 0)
                {
                    /* associa o retorno do banco no array */
                    while ($row = @mysql_fetch_assoc($result))
                    {
                        /* armazena os valores no array */
                        $retorno[] = $row['parametro'];
                    }
                    /* retorna o array */
                    return $retorno;
                }
            }
        }
    }

    /**
     * Funcao que salva os valores do formulario no banco
     * Esta funcao eh ativada quando existe uma acao do botao de submit
     */
    public function chamaSalvaParametro()
    {
        // Verifica se existe uma acao no botao
        if (isset($_POST['btn_enviar']))
        {
            // Captura os valores
            $batbaixo = isset($_POST['txt_vlBaixo']) && !empty($_POST['txt_vlBaixo']) ? $this->trataV($_POST['txt_vlBaixo']) : 0;

            // Cria variavel que guarda os valores
            $concat = '';

            // Quebra o retorno do post e concatena na variavel
            foreach($_POST as $linha=>$valor)
            {
                // Trata resultado do formulario
                $tValor = isset($valor) && !empty($valor) ? $this->trataV($valor) : 0;
                // Concatena os valores
                $concat .= "{$linha}-{$tValor}|";
            }

            // Remove o campo que nao sera utilizado
            $concat = str_replace("|btn_enviar-Salvar|","",$concat);

            // Decripta os parametros
            $controle = base64_decode($this->parametros[0]);
            $controle2 = base64_decode($this->parametros[1]);
            $controle3 = base64_decode($this->parametros[2]);

            // Quebra em array
            $controle3 = explode ("-",$controle3);

            // Monta a query para salvar o parametro no banco
            $query = "insert into tb_parametro (num_sim, id_sim_equipamento, parametro, id_equipamento, id_users) values
                      ('{$controle}','{$controle2}','{$concat}','{$controle3[0]}','{$_SESSION['userdata']['userId']}')";

            // Vrifica se executou com sucesso
            if ($this->db->query($query))
            {
                // Apresenta mensagem de sucesso
                echo "<div class='mensagemSucesso'><span>Cadastro salvo com sucesso!</span></div>";
                $login_uri = HOME_URI . "/configuracao/";
                // Redireciona a pagina
                echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $login_uri . '"},1500);</script>';
            }
            else
            {
                // Apresenta mensagem de erro
                echo "<div class='mensagemError'><span>Erro ao salvar.</span></div>";
            }
        }
    }

    /*
    * Função para carregar as configurações do equipamento cadastrado, caso exista
    */
    public function carregarConfiguracaoEquip($idEquip)
    {
        if(is_numeric($idEquip)){

            $query = "SELECT param.id, param.id_equipamento, param.id_users, param.id_sim_equipamento, param.num_sim, param.parametro
                        FROM tb_parametro param
                        WHERE param.id_equipamento = '$idEquip'";

            /* monta a result */
            $result = $this->db->select($query);

            /* verifica se existe resposta */
            if ($result)
            {
                /* verifica se existe valor */
                if (@mysql_num_rows($result) > 0)
                {
                    /* armazena na array */
                    while ($row = @mysql_fetch_assoc ($result))
                    {
                        $retorno[] = $row;
                    }

                    /* devolve retorno */
                    $array = array('status' => false, 'param' => $retorno);

                }else{
                    $array = array('status' => false, 'param' => 0);
                }
            }else{
                $array = array('status' => false, 'param' => 0);
            }

        }else{
            $array = array('status' => false, 'param' => 0);
        }

        return $array;
    }

}

?>
