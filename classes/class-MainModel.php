<?php

/**
 * Classe que gerencia o model
 */
class MainModel
{
    /**
     * Funcao que faz o tratamento dos caracteres
     *
     * @param string  $palavra - Recebe a string com a palavra
     * @param numeric $opcao   - Recebe um numero que define a rota de tratamento
     */
    public function tratamento ($palavra = null, $opcao = 0)
    {
        // Verifica se existe a palavra
        if ($palavra != null)
        {
            // Se existir valor
            // Armazena a string
            $novaFrase = $palavra;

            // Verifica se o tratamento sera para e-mail
            if($opcao == 1)
            {
                // Se for e-mail
                // Cria um array com os caracteres que serao removidos
                $lista = array("-","'","(",")","[","]","{","}","+","=","$","#","&","/","*",'"',"´","^","°","ª","º",
                               "<",">","%","!","?",";",":","`","~",",");
            }
            // Verifica se o tratamento sera para senha
            else if ($opcao == 2)
            {
                // Se for senha
                // Cria um array com os caracteres que serao removidos
                $lista = array("'","(",")","&","[","]","{","}","+","/","_",'"',"´","^","°","ª","º","<",">","%","?",";",":","`","~",",","@","$");
            }
            // Verifica se o tratamento sera para telefone , cep e onde contem somente numeros
            else if ($opcao == 3)
            {
                // Se for para numeros
                // Criar um array com os caracteres que sera removidos
                $lista = array("(",")","[","]","{","}","+","=","$","#","&","/","*","_",'"',"´","^","°","ª","º",
                               "<",">","@","%","!","?",";",":","`","~",",","-","'");
            }
            else
            {
                // Por padrao
                // Para tratamento de texto
                $lista = array("(",")","[","]","{","}","+","=","$","#","&","/","*","_",'"',"´","^","°","ª","º",
                               "<",">","@","%","!","?",";",":","`","~",",");
            }

            // Realiza o loop para substituir os caracteres
            // Passando por todas as posicoes do array
            foreach($lista as $sub)
                // Substitui os caracteres por valor em branco
                $novaFrase = str_replace($sub, "", $novaFrase);

            // Chama a funcao que substitui os acentos
            $novaFrase = $this->converte($novaFrase);

            // Retorna a string tratada
            return $novaFrase;
        }
        // Caso a variavel palavra esteja em branco
        // Retorna nada
        return false;
    }

    /**
     * Funcao que converte os acentos
     *
     * @param string  $palavra - Recebe a string que sera tratada
     * @param numeric $volta   - Gerencia se sera convertido ou ser eh retorno
     */
    public function converte ($palavra = null, $volta = 0)
    {
        // Verifica se a palavra nao eh nula
        if ($palavra != null)
        {
            // Armazena em um variavel
            $novaFrase = $palavra;

            // Cria um array com os acentos
            $lista1 = array("á","é","í","ó","ú",
                            "à","è","ì","ò","ò",
                            "ã","õ",
                            "â","ê","î","ô","û",
                            "ç",
                            "Á","É","Í","Ó","Ú",
                            "À","È","Ì","Ò","Ù",
                            "Ã","Õ",
                            "Â","Ê","Î","Ô","Û",
                            "Ç");

            // Cria um array com a substituicao
            $lista2 = array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;",
                            "&agrave;","&egrave;","&igrave;","&ograve;","&ugrave;",
                            "&atilde;","&otilde;",
                            "&acirc;","&ecirc;","&icirc;","&ocirc;","&ucirc;",
                            "&ccedil;",
                            "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;",
                            "&Agrave;","&Egrave;","&Igrave;","&Ograve;","&Ugrave;",
                            "&Atilde;","&Otilde;",
                            "&Acirc;","&Ecirc;","&Icirc;","&Ocirc;","&Ucirc;",
                            "&Ccedil;");

            // Realiza um loop para substituir as posicoes
            for ($a = 0; $a < sizeof($lista1); $a++)
            {
                // Verifica se eh ida
                if ($volta == 0)
                {
                    // Se for ida
                    // Converte os acentos
                    $novaFrase = str_replace($lista1[$a],$lista2[$a],$novaFrase);
                }
                else if ($volta == 1)
                {
                    // Se for volta
                    // Converte para acento
                    $novaFrase = str_replace($lista2[$a],$lista1[$a],$novaFrase);
                }
            }
            // Retorna a string convertida
            return $novaFrase;
        }
        // Caso a palavra se nula
        // Retorna nada
        return false;
    }

    /**
     * Funcao que trata virgula
     *
     * Converte a virgula em ponto para armazenar no banco
     * com o padra internacional
     *
     * @param numeric $valor - Recebe o valor que contem a virgula
     * @param numeric $tipo  - Recebe a forma de tratamnto se sera ida ou volta
     */
    public function trataV ($valor, $tipo = 0)
    {
        // Verifica o tipo
        if ($tipo == 0)
        {
            // Se for ida
            // Substitui a virgula por ponto
            $valor = str_replace(",",".", $valor);
        }
        // Verifica se eh volta
        else if ($tipo == 1)
        {
            // Se for volta
            // Substitui ponto por virgula
            $valor = str_replace(".",",", $valor);
        }

        // Retorna o valor convertido
        return $valor;
    }

    /**
     * Funcao que gerencia as notificacoes
     */
    public function notificacao()
    {
        /**
         * Query de notificacao de equipamento e ambiente pendente de vinculo
         *
         * 1 - Equipamento por Cliente
         * 2 - Equipamento por Filial
         * 3 - Ambiente por Cliente
         * 4 - Ambiente por Filial
         */
        $query = [
            "select
            se.id, se.id_sim as sim, e.tipo_equipamento as nome_equip, 'vinculo' as modo , 'e' as tipo , concat(s.id_cliente, '-c') as cliente , c.nome
            from tb_sim_equipamento se
            inner join tb_equipamento e on e.id = se.id_equipamento
            inner join tb_sim s on s.num_sim = se.id_sim
            inner join tb_cliente c on c.id = s.id_cliente
            where
            id_equipamento is not null
            and s.id_cliente is not null
            and se.vinc_tabela = 0
            order by (se.dt_criacao) desc" ,

            "select
            se.id, se.id_sim as sim, e.tipo_equipamento as nome_equip, 'vinculo' as modo , 'e' as tipo , concat(s.id_filial, '-f') as cliente , f.nome
            from tb_sim_equipamento se
            inner join tb_equipamento e on e.id = se.id_equipamento
            inner join tb_sim s on s.num_sim = se.id_sim
            inner join tb_filial f on f.id = s.id_filial
            where
            id_equipamento is not null
            and s.id_filial is not null
            and se.vinc_tabela = 0
            order by (se.dt_criacao) desc"
        ];

        // Realiza o loop nas posicoes do array das querys
        // Salva os valores do select no array
        foreach ($query as $busca)
        {
            // Monta a result
            $result = $this->db->select($busca);

            // Verifica se existe retorno
            if ($result)
            {
                // Verifica se existe valor
                if (@mysql_num_rows($result) > 0)
                {
                    // Guarda os valores no array
                    while ($row = @mysql_fetch_assoc($result))
                        $valorNot[] = $row;
                }
            }
        }

        // Verifica se existe valor e eh um array
        if (! empty($valorNot) && is_array ($valorNot))
            // Retorna resultado
            return $valorNot;
        else
            // Fim
            return false;
    }

    /*
    * Função para buscar notificação de alarme
    */
    public function recuperaNotificacoesAlarmes(){

        $query = "SELECT alert.id, alert.dt_criacao, alert.status_ativo, alert.visto, msg_alert.mensagem, sim_equip.id_equipamento, equip.nomeEquipamento, equip.modelo, clie.nome, trat_alert.parametro , trat_alert.parametroMedido, trat_alert.parametroAtingido
                FROM tb_alerta alert
                JOIN tb_msg_alerta msg_alert ON alert.id_msg_alerta = msg_alert.id
                JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                JOIN tb_cliente clie ON clie.id = sim.id_cliente
                WHERE alert.status_ativo  = '1'
                ORDER BY alert.id DESC";

        // Monta a result
        $result = $this->db->select($query);

        /* verifica se existe resultado */
        if (@mysql_num_rows($result) > 0)
        {
            /* monta array com os resultados */
            while ($row = @mysql_fetch_assoc($result))
                $retorno[] = $row;

            /* retorna o array */
            $array = array('status' => true, 'alarmes' => $retorno);

        }else{
            $array = array('status' => false, 'alarmes' => '');
        }

        return $array;
    }

    /*
    *   Função para retornar os alarmes novos gerados pelo cliente.
    */
    public function recuperaNotificacoesAlarmesCliente($idCliente){

        if(is_numeric($idCliente)){

            $query = "SELECT alert.id, alert.dt_criacao, alert.status_ativo, alert.visto, msg_alert.mensagem, sim_equip.id_equipamento, equip.nomeEquipamento, equip.modelo, clie.nome, trat_alert.parametro , trat_alert.parametroMedido, trat_alert.parametroAtingido
                    FROM tb_alerta alert
                    JOIN tb_msg_alerta msg_alert ON alert.id_msg_alerta = msg_alert.id
                    JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                    JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                    JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                    JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                    JOIN tb_cliente clie ON clie.id = sim.id_cliente
                    WHERE clie.id = '$idCliente' AND alert.status_ativo  = '1'
                    ORDER BY alert.id DESC";

            // Monta a result
            $result = $this->db->select($query);

            /* verifica se existe resultado */
            if (@mysql_num_rows($result) > 0)
            {
                /* monta array com os resultados */
                while ($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;

                /* retorna o array */
                $array = array('status' => true, 'alarmes' => $retorno);

            }else{
                $array = array('status' => false, 'alarmes' => '');
            }

        }else{
            $array = array('status' => false, 'alarmes' => '');
        }

        return $array;
    }


    /**
     * Funcao de upload de arquivo
     *
     * @param array $file - Recebe o array com os parametros do arquivo
     */
    public function upload ($file)
    {
        // Pasta de upload
        $_UP['pasta'] = UP_EFIPATH;

        // Tamanho maximo do arquivo 1mb
        $_UP['tamanho'] = 1024 * 1024 * 1;

        // Extensoes de arquivo aceita
        $_UP['extensoes'] = array('jpg','png','gif');

        // Renomeia o arquivo
        $_UP['renomeia'] = true;

        // Tipos de erro
        $_UP['erro'][0] = "N&atilde;o houve erro";
        $_UP['erro'][1] = "Arquivo muito grande";
        $_UP['erro'][2] = "O arquivo ultrapassa o limite de tamanho espeficado";
        $_UP['erro'][3] = "Upload do arquivo feito parcialmento";
        $_UP['erro'][4] = "N&atilde;o foi feito o upload do arquivo";

        // Verifica se existe algum erro
        if ($_FILES['file_foto']['error'] != 0)
        {
            echo "N&atilde;o foi poss&iacute;vel fazer o upload do arquivo, erro: " . $_UP['erro'][$file['file_foto']['error']];
            exit;
        }

        // Verifica a extensao
        // Converte em minusculo
        $extensao = strtolower($file['file_foto']['name']);
        // Quebra em array
        $extensao = explode(".",$extensao);
        // Pega a ultima posicao
        $extensao = end($extensao);

        // Verifica a
        if (array_search($extensao, $_UP['extensoes']) === false)
        {
            echo "Extens&otilde;es suportadas: JPG, PNG e GIF";
            exit;
        }

        // Verifica o tamanho do arquivo
        if ($_UP['tamanho'] < $file['file_foto']['size'])
        {
            echo "Tamanho maximo do arquivo: 1mb";
            exit;
        }

        // Verifica se deve trocar o nome do arquivo
        if ($_UP['renomeia'] == true)
        {
            // Novo nome
            $nome_final = md5(time()) . "." . $extensao;
        }
        else
        {
            // Mantem o nome original
            $nome_final = $file['file_foto']['name'];
        }

        // Verifica se eh possivel mover o arquivo para a pasta
        if (move_uploaded_file($file['file_foto']['tmp_name'], $_UP['pasta'] ."/". $nome_final))
        {
            // Caso o arquivo seja enviado com sucesso
            if (defined('DEBUG') && DEBUG == true)
                echo "Upload efetuado com sucesso.";

            // Retorna o nome final
            return $nome_final;
        }
        else
        {
            // Caso nao seja possivel mover o arquivo
            if (defined('DEBUG') && DEBUG == true)
                echo "N&atilde;o foi possivel enviar o arquivo, tente mais tarde.";

            // Retorna falso caso de errado
            return false;
        }
    }

    /**
     *
     * listaEstado
     *
     * Funcao que gera a lista de todos os estados
     *
     * @access public
     */
    public function listaEstado($id = 0)
    {
        $pac2 = new C_PhpAutocomplete('estado');
        $pac2->display('SELECT');

        // Monta a query para buscar os estados
        $query = "select id,nome from tb_estado where status_ativo = 1";

        // Busca os valores do select
        $resultado = $this->verificaQuery($query);

        // Exibe os estado no option
        echo "<select id='estado' name='opc_estado' class='font-texto-01' required>";
                // Verifica se existe id
                if ($id == 0)
                {
                    // Oculta a opcao de selecionar
                    echo "<option>Selecione um estado</option>";
                }
                else
                {
                    // Monta a lista de estado com o mesmo id
                    foreach ($resultado as $rowestado)
                    {
                        // Exibe o estado cadastrado
                        if ($rowestado['id'] == $id)
                        {
                            echo "<option value='{$rowestado['id']}'>{$rowestado['nome']}</option>";
                        }
                    }
                }

                // Monta a lista de estado com id diferente
                foreach ($resultado as $rowestado)
                {
                    // Exibe os estados com id diferente
                    if ($rowestado['id'] != $id)
                    {
                        echo "<option value='{$rowestado['id']}'>{$rowestado['nome']}</option>";
                    }
                }
        echo "</select>";
    }



    /**
     * listaPaises
     *
     * Funcao que gera a lista de todos os paises
     *
     * @access public
     */
    public function listaPaises($id = 0)
    {
        $pac2 = new C_PhpAutocomplete('pais');
        $pac2->display('SELECT');

        // Monta a query para buscar os paises
        $query = "select id,nome from tb_pais where status_ativo = 1";

        // Busca os valores do select
        $resultado = $this->verificaQuery($query);

        // Exibe os estado no option
        echo "<select id='pais' name='opc_pais' class='font-texto-01' required>";
                // Verifica se existe id
                if ($id == 0)
                {
                    // Oculta a opcao de selecionar
                    echo "<option>Selecione um pais</option>";
                }
                else
                {
                    // Monta a lista de pais com o mesmo id
                    foreach ($resultado as $rowpais)
                    {
                        // Exibe o pais cadastrado
                        if ($rowpais['id'] == $id)
                        {
                            echo "<option value='{$rowpais['id']}'>{$rowpais['nome']}</option>";
                        }
                    }
                }

                // Monta a lista de paises com id diferente
                foreach ($resultado as $rowpais)
                {
                    // Exibe os paises com id diferente
                    if ($rowpais['id'] != $id)
                    {
                        echo "<option value='{$rowpais['id']}'>{$rowpais['nome']}</option>";
                    }
                }
        echo "</select>";
    }


    /*
    * Função para listagem simples de paises
    */
    public function listaPaisesSimples(){

        // Monta a query para buscar os paises
        $query = "select id,nome from tb_pais where status_ativo = 1";

        // Busca os valores do select
        $resultado = $this->verificaQuery($query);

        $lista = array();

        // Monta a lista de pais com o mesmo id
        foreach ($resultado as $rowestado)
        {
            array_push($lista, array('pais' => $rowestado['nome'], 'id' => $rowestado['id']));
        }

        return $lista;
    }

    /*
    * Função para listagem simples d estados
    */
    public function listaEstadosSimples(){

        // Monta a query para buscar os estados
        $query = "select id,nome from tb_estado where status_ativo = 1";

        // Busca os valores do select
        $resultado = $this->verificaQuery($query);

        $lista = array();

        // Monta a lista de pais com o mesmo id
        foreach ($resultado as $rowpais)
        {
            array_push($lista, array('nome' => $rowpais['nome'], 'id' => $rowpais['id']));
        }

        return $lista;
    }


    /**
     * listaMatriz
     *
     * Funcao que gera a lista de todos as matriz
     *
     * @access public
     */
    public function listaMatriz($id = 0)
    {
        $pac2 = new C_PhpAutocomplete('matriz');
        $pac2->display('SELECT');

        // Monta a query para buscar as matrizes
        $query = "select id, nome from tb_cliente where status_ativo = 1";

        // Busca os valores do select
        $resultado = $this->verificaQuery($query);

        // Exibe as matrizes no option
        echo "<select id='matriz' name='opc_matriz' class='font-texto-01' required>";
                // Verifica se existe id
                if ($id == 0)
                {
                    // Oculta a opcao de selecionar
                    echo "<option>Selecione uma matriz</option>";
                }
                else
                {
                    // Monta a lista de matriz com o mesmo id
                    foreach ($resultado as $rowmatriz)
                    {
                        // Exibe a matriz cadastrado
                        if ($rowmatriz['id'] == $id)
                        {
                            echo "<option value='{$rowmatriz['id']}'>{$rowmatriz['nome']}</option>";
                        }
                    }
                }

                // Monta a lista de matriz com id diferente
                foreach ($resultado as $rowmatriz)
                {
                    // Exibe as matrized com id diferente
                    if ($rowmatriz['id'] != $id)
                    {
                        echo "<option value='{$rowmatriz['id']}'>{$rowmatriz['nome']}</option>";
                    }
                }
        echo "</select>";
    }


    /**
     * listaFabricante
     *
     * Funcao que gera a lista de todos os fabricantes
     *
     * @access public
     */
    public function listaFabricante($id = 0)
    {
        $pac2 = new C_PhpAutocomplete('fabricante');
        $pac2->display('SELECT');

        // Monta a query para buscar os fabricantes
        $query = "select id, nome from tb_fabricante where status_ativo = 1";

        // Busca os valores do select
        $resultado = $this->verificaQuery($query);

        // Exibe os fabricantes no option
        echo "<select id='fabricante' name='opc_fabricante' class='font-texto-01' required>";
                // Verifica se existe o id
                if ($id == 0)
                {
                    echo "<option>Selecione uma fabricante</option>";
                }
                else
                {
                    // Monta a lista de fabricantes
                    foreach ($resultado as $rowfabricante)
                    {
                        // Busca o id do parametro
                        if ($rowfabricante['id'] == $id)
                        {
                            // Exibe as fabricantes
                            echo "<option value='{$rowfabricante['id']}'>{$rowfabricante['nome']}</option>";
                        }
                    }
                }
                // Monta a lista de fabricantes
                foreach ($resultado as $rowfabricante)
                {
                    // Busca o id diferente do parametro
                    if ($rowfabricante['id'] != $id)
                    {
                        // Exibe as fabricantes
                        echo "<option value='{$rowfabricante['id']}'>{$rowfabricante['nome']}</option>";
                    }
                }
        echo "</select>";
    }


    /**
     * loadCliente
     *
     * Funcao que gera uma lista de todos os cliente e filiais
     *
     * @access public
     */
    public function loadClienteFilial()
    {
        $pac2 = new C_PhpAutocomplete('clienteFilial');
        $pac2->display('SELECT');

        // Monta a query para buscar as cliente
        $query = "select concat(id,'-c') as id, nome from tb_cliente where status_ativo = 1";

        // Busca os valores do select
        $resultado[] = $this->verificaQuery($query);

        // Monta a query para buscar as filiais
        $query = "select concat(id,'-f') as id, nome from tb_filial where status_ativo = 1";

        // Busca os valores do select
        $resultado[] = $this->verificaQuery($query);

        // Exibe a lista de cliente e filiais no option
        echo "<select id='clienteFilial' name='opc_cliente' class='font-texto-01' required><option>Selecione uma cliente/filial</option>";
                // Monta a lista de cliente e filial
                for ($a = 0; $a < sizeof($resultado); $a++)
                {
                    foreach ($resultado[$a] as $row)
                    {
                        // Exibe as a lista
                        echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                    }
                }
        echo "</select>";
    }


    /**
     * buscaRelacao
     *
     * Funcao que busca todos os clientes
     *
     * @access public
     */
    public function buscaRelacao()
    {
        $query = " select s.num_sim, c.nome , s.dt_criacao , s.status_ativo
                   from tb_sim s
                   inner join tb_cliente c on c.id = s.id_cliente
                   where s.status_ativo = 1 and s.id_cliente is not null";

        $result = $this->db->select($query);

        // Verifica se existe retorno
        if ($result)
        {
            // Verifica se existe resultado
            if (@mysql_num_rows($result) > 0)
            {
                // Monta array com os resultados
                while ($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;

                // Retorna o array
                return $retorno;
            }
        }
    }

    /**
     * buscaRelacaoFilial
     *
     * Funcao que realiza a busca da matriz e de todoas a filiais
     *
     * @access public
     */
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


    /**
     * buscaRelacaoEquipamento
     *
     * busca todos os esquipamentos vinculados a cliente e filial
     *
     * @access public
     */
    public function buscaRelacaoEquipamento()
    {
        // Descriptografa o numero do sim
        $num_sim_cliente = base64_decode($this->parametros[0]);

        // Monta a query para buscar equipamentos
        $query = "select
                    s.num_sim, s.status_ativo, s.dt_criacao,
                    sq.id as tb_sim_id ,
                    e.id as equip_id , e.tipo_equipamento, e.modelo , e.potencia, e.qnt_bateria,
                    e.caracteristica_equip, e.tipo_bateria, e.amperagem_bateria,
                    f.nome
                from tb_sim s

                inner join tb_sim_equipamento sq on sq.id_sim = s.num_sim
                inner join tb_equipamento e on e.id = sq.id_equipamento
                inner join tb_fabricante f on f.id = e.id_fabricante
                where s.num_sim = {$num_sim_cliente}";

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
     * verificaQuery
     *
     * Funcao que realiza um select para buscar os valores
     *
     * @param string $query - Recebe um comando sql
     * @return array $resultado - Retorna um array
     *
     * @access public
     */
    public function verificaQuery($query)
    {
        // Monta a result
        $result = $this->db->select($query);

        // Criar o array de resposta
        $resultado = array();

        // Verifica se existe valor na result
        if (@mysql_num_rows($result) > 0)
        {
            // Monta o array de dados
            while ($row = @mysql_fetch_assoc($result))
                $resultado[] = $row;
        }

        // Retorna array
        return $resultado;
    }

    /**
     * realizaBusca
     *
     * Funcao que realiza o select e monta a array de resposta
     *
     * @param string $query - Recebe um comando sql
     *
     * @access public
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
}

?>
