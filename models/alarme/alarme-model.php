<?php

    /**
    * Classe de modelo que gerencia as informacoes das filiais
    */
    class AlarmeModel extends MainModel
    {
        public function __construct ($db = false , $controller = null)
        {
            // Conexao com o banco
            $this->db = $db;

            // Configuracao do controller
            $this->controller = $controller;

            // Configura os parâmetros
           $this->parametros = $this->controller->parametros;
        }


        /* FUNÇÃO RESPONSAVEL PELA LISTAGEM DE CONTATOS PARA RECEBER O ALARME
        *
        */
        public function listarContatoAlarmes($idCliente, $idFilial = 0, $todos = 0)
        {
            if(is_numeric($idCliente)){

                //Verifica se foi selecionado alguma filial
                if($todos == 1){

                    //Procura por contatos apenas do cliente
                    $query = "SELECT contAlert.id, contAlert.id_cliente, contAlert.id_filial, contAlert.nome_contato, contAlert.funcao, contAlert.email, contAlert.celular, contAlert.observacao
                            FROM tb_contato_alerta contAlert
                            WHERE contAlert.id_cliente  = $idCliente";

                }else{
                    //Procura por contatos da filial selecionada
                    $query = "SELECT contAlert.id, contAlert.id_cliente, contAlert.id_filial, contAlert.nome_contato, contAlert.funcao, contAlert.email, contAlert.celular, contAlert.observacao
                            FROM tb_contato_alerta contAlert
                            WHERE contAlert.id_cliente  = '$idCliente' AND contAlert.id_filial = '$idFilial'";
                }

                /* MONTA A RESULT */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if ($result)
                {
                  /* VERIFICA SE EXISTE VALOR */
                  if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'contatos' => $retorno);
                  }else{
                      $array = array('status' => false, 'contatos' => '');
                  }
                }else{
                  $array = array('status' => false, 'contatos' => '');
                }

            }else{

                $array = array('status' => false, 'contatos' => '');
            }

            return $array;
        }


        /*
        * Função para efetuar cdastro do contato de alarme via JSON
        */

        public function registraContatoAlarmeJson($idMatriz, $sedeContato, $nomeContato, $funcaoContato, $emailContato, $celularContato, $obsContato)
        {
            if(is_numeric($idMatriz)){

                $query = "INSERT INTO  tb_contato_alerta (id_cliente, id_filial , nome_contato, funcao, email, celular, observacao )
                            VALUES ('$idMatriz','$sedeContato', '$nomeContato', '$funcaoContato', '$emailContato', '$celularContato', '$obsContato')";

                //var_dump($query);
                // Verifica se gravou com sucesso
                if ($this->db->query($query))
                {
                    $array = array('status' => true);
                }else{
                    $array = array('status' => false);
                }
            }
            else{
                $array = array('status' => false);
            }

            return $array;
        }


        /*
        * Função para carregar os dados dos contatos para edição
        */
        public function carregarContatoAlarmes($idContato){

            if(is_numeric($idContato)){

                $query = "SELECT contact.id, contact.nome_contato, contact.funcao, contact.email, contact.celular, contact.observacao FROM tb_contato_alerta contact WHERE contact.id = $idContato";

                /* MONTA A RESULT */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if($result)
                {
                  /* VERIFICA SE EXISTE VALOR */
                  if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'contato' => $retorno);
                  }else{
                      $array = array('status' => false, 'contato' => '');
                  }
              }

            }else{

                $array = array('status' => false);

            }

            return $array;

        }

        public function removerContatoLista($idContato){

            if(is_numeric($idContato)){

                $query = "DELETE FROM tb_contato_alerta WHERE id = $idContato";

                if ($this->db->query($query))
                {
                    $array = array('status' => true);
                }else{
                    $array = array('status' => false);
                }

            }else{
                $array = array('status' => false);
            }

            return $array;
        }

        /*
        * Função para salvar as alterações do contato
        */
        public function atualizarContato($idEdit, $nomeEdit, $funcaoEdit, $emailEdit, $celularEdit, $obserEdit)
        {
            if(is_numeric($idEdit)){

                $query = "UPDATE tb_contato_alerta SET nome_contato = '$nomeEdit', funcao = '$funcaoEdit', email = '$emailEdit', celular = '$celularEdit', observacao = '$obserEdit'
                            WHERE id = '$idEdit'";

                //var_dump($query);
                // Verifica se gravou com sucesso
                if ($this->db->query($query))
                {
                    $array = array('status' => true);
                }else{
                    $array = array('status' => false);
                }

            }else{
                $array = array('status' => false);
            }

            return $array;
        }


        /*
        * Recupera lista de alarmes que foram registrados
        */
        public function alarmesGerados(){

            $query = "SELECT alert.id, alert.dt_criacao, alert.status_ativo, alert.visto, msg_alert.mensagem, sim_equip.id_equipamento, equip.nomeModeloEquipamento, clie.nome, fili.nome AS 'filial', trat_alert.parametro , trat_alert.parametroMedido, trat_alert.parametroAtingido, trat_alert.pontoTabela
                    FROM tb_alerta alert
                    JOIN tb_msg_alerta msg_alert ON alert.id_msg_alerta = msg_alert.id
                    JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                    JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                    JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                    JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                    JOIN tb_cliente clie ON clie.id = sim.id_cliente
                    LEFT JOIN tb_filial fili ON equip.id_filial = fili.id
                    WHERE alert.status_ativo < 5
                    ORDER BY alert.id DESC";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if ($result)
            {
              /* VERIFICA SE EXISTE VALOR */
              if (@mysql_num_rows($result) > 0)
                {
                  /* ARMAZENA NA ARRAY */
                  while ($row = @mysql_fetch_assoc ($result))
                  {
                    $retorno[] = $row;
                  }

                  /* DEVOLVE RETORNO */
                  $array = array('status' => true, 'alerta' => $retorno);
              }else{
                  $array = array('status' => false, 'alerta' => '');

                    //$retorno[] = $row;
              }

            }else{
              $array = array('status' => false, 'alerta' => '');
            }

            return $array;
        }

        /*
        * RECUPERA LISTA DE ALARMES QUE FORAM REGISTRADOS POR DETERMINADO CLIENTE
        */
        public function alarmesGeradosCliente($idCliente){

            $query = "SELECT alert.id, alert.dt_criacao, alert.status_ativo, alert.visto, msg_alert.mensagem, sim_equip.id_equipamento, equip.nomeModeloEquipamento, clie.nome, fili.nome AS 'filial', trat_alert.parametro , trat_alert.parametroMedido, trat_alert.parametroAtingido, trat_alert.pontoTabela
                    FROM tb_alerta alert
                    JOIN tb_msg_alerta msg_alert ON alert.id_msg_alerta = msg_alert.id
                    JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                    JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                    JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                    JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                    JOIN tb_cliente clie ON clie.id = sim.id_cliente
                    LEFT JOIN tb_filial fili ON equip.id_filial = fili.id
                    WHERE clie.id = '$idCliente' AND alert.status_ativo < 5
                    ORDER BY alert.id DESC";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if ($result)
            {
              /* VERIFICA SE EXISTE VALOR */
              if (@mysql_num_rows($result) > 0)
                {
                  /* ARMAZENA NA ARRAY */
                  while ($row = @mysql_fetch_assoc ($result))
                  {
                    $retorno[] = $row;
                  }

                  /* DEVOLVE RETORNO */
                  $array = array('status' => true, 'alerta' => $retorno);
              }else{
                  $array = array('status' => false, 'alerta' => '');

                    $retorno[] = "";
                  }

            }

            return $array;
        }

        /*
        * RECUPERA OS DADOS DO ALARME PARA SEREM EXIBIDOS PARA O USUÁRIO
        */
        public function recuperaDadosAlarme($idAlarme){

            $query = "SELECT alert.id, alert.id_sim_equipamento, alert.id_msg_alerta, alert.status_ativo, alert.visto, alert.dt_criacao, trat_alert.id AS 'tratamento_id', trat_alert.parametro, trat_alert.parametroMedido, trat_alert.parametroAtingido, trat_alert.tratamento_aplicado, trat_alert.pontoTabela,
                    equip.nomeModeloEquipamento, equip.id_cliente, equip.id_filial, equip.id AS 'idEquipAlert', tpEquip.tipo_equipamento, sim_equip.id_sim AS 'simEquip', sim.ambiente_local_sim
                    FROM tb_alerta alert
                    JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                    JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                    JOIN tb_sim sim ON sim_equip.id_sim = sim.num_sim
                    JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                    JOIN tb_tipo_equipamento tpEquip ON equip.tipo_equipamento = tpEquip.id
                    WHERE alert.id = '$idAlarme'";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if ($result)
            {
              /* VERIFICA SE EXISTE VALOR */
              if (@mysql_num_rows($result) > 0)
                {
                  /* ARMAZENA NA ARRAY */
                  while ($row = @mysql_fetch_assoc ($result))
                  {
                    $retorno[] = $row;
                  }

                  /* DEVOLVE RETORNO */
                  $array = array('status' => true, 'alerta' => $retorno);
              }else{
                  $array = array('status' => false, 'alerta' => '');
              }
            }

            return $array;
        }

        /*
        *
        */
        public function recuperacaoTratamentosAlarme($idAlarme){

            if(is_numeric($idAlarme)){

                $query = "SELECT trat.id, trat.id_user, trat.tratamento_aplicado, trat.data_tratamento, user.nome, user.sobrenome
                        FROM tb_tratamento_provisorio trat
                        LEFT JOIN tb_users user ON user.id = trat.id_user
                        WHERE trat.id_alerta = '$idAlarme'";

                /* MONTA A RESULT */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if ($result)
                {
                  /* VERIFICA SE EXISTE VALOR */
                  if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'tratamentos' => $retorno);
                  }else{
                      $array = array('status' => false, 'tratamentos' => '');
                  }
                }

            }else{
                $array = array('status' => false, 'tratamentos' => '');
            }


            return $array;
        }

        /*
        * Efetua a contagem de alarmes para atualização de contagem.
        */
        public function contagemNovosAlarmes($idClie){

            if(is_numeric($idClie)){

                //Caso um administrador esteja logado
                if($idClie == 0){
                    $query = "SELECT COUNT(alert.id) AS 'totalNovo' FROM tb_alerta alert WHERE status_ativo = '1' ";
                }else{
                    $query = "SELECT COUNT(alert.id) AS 'totalNovo'
                            FROM tb_alerta alert
                           JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                          JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                            JOIN tb_cliente clie ON clie.id = sim.id_cliente
                            WHERE alert.status_ativo  = '1' AND clie.id = '$idClie'";
                }

                /* MONTA A RESULT */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if ($result)
                {
                  /* VERIFICA SE EXISTE VALOR */
                  if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'totalAlarmes' => $retorno);
                  }else{
                      $array = array('status' => true, 'totalAlarmes' => 0);
                  }
              }else{
                $array = array('status' => false, 'totalAlarmes' => 0);
              }

            }else{

                $array = array('status' => false, 'totalAlarmes' => 0);

            }

            return $array;
        }

        /*
        * RECUPERA OS ALERTAS PARA SEREM EXIBIDOS NO MENU
        */
        public function recuperaNotificacoesAlarmesRecemCadastrados($idCliente, $limite = 0){

            if(is_numeric($idCliente)){

                if($idCliente == 0){
                    $query = "SELECT alert.id, alert.dt_criacao, alert.status_ativo, alert.visto, msg_alert.mensagem, sim_equip.id_equipamento, equip.nomeModeloEquipamento, clie.nome, fili.nome AS 'filial', trat_alert.parametro , trat_alert.parametroMedido, trat_alert.parametroAtingido
                            FROM tb_alerta alert
                            JOIN tb_msg_alerta msg_alert ON alert.id_msg_alerta = msg_alert.id
                            JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                            JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                            JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                            JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                            JOIN tb_cliente clie ON clie.id = sim.id_cliente
                            LEFT JOIN tb_filial fili ON equip.id_filial = fili.id
                            WHERE alert.status_ativo  = '1'
                            ORDER BY alert.id DESC LIMIT $limite, 99";
                }else{
                    $query = "SELECT alert.id, alert.dt_criacao, alert.status_ativo, alert.visto, msg_alert.mensagem, sim_equip.id_equipamento, equip.nomeModeloEquipamento, clie.nome, fili.nome AS 'filial', trat_alert.parametro , trat_alert.parametroMedido, trat_alert.parametroAtingido
                            FROM tb_alerta alert
                            JOIN tb_msg_alerta msg_alert ON alert.id_msg_alerta = msg_alert.id
                            JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                            JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                            JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                            JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                            JOIN tb_cliente clie ON clie.id = sim.id_cliente
                            LEFT JOIN tb_filial fili ON equip.id_filial = fili.id
                            WHERE clie.id = '$idCliente' AND alert.status_ativo  = '1'
                            ORDER BY alert.id DESC LIMIT $limite, 99";
                }

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
                $array = array('status' => false, 'totalAlarmes' => 0);
            }

            return $array;
        }

        /*
        * Retorna a mensagem de alarme que foi gerada
        */
        public function recuperaMensagemAlarme($idMsg){

            $query = "SELECT msg.mensagem, msg.descricao_alarme
                        FROM tb_msg_alerta msg
                        WHERE msg.id = '$idMsg'";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if ($result)
            {
              /* VERIFICA SE EXISTE VALOR */
              if (@mysql_num_rows($result) > 0)
                {
                  /* ARMAZENA NA ARRAY */
                  while ($row = @mysql_fetch_assoc ($result))
                  {
                    $retorno[] = $row;
                  }

                  /* DEVOLVE RETORNO */
                  $array = array('status' => true, 'mensagem' => $retorno);
              }else{
                  $array = array('status' => false, 'mensagem' => '');
              }
            }

            return $array;
        }

        /*
        * Registra o tratamento dado ao alarme
        */

        public function registrarTratamentoAlarme($idAlarme, $tratamento){

            if(is_numeric($idAlarme)){

                $id_usuer   = $_SESSION['userdata']['userId'];

                $query      = "UPDATE tb_tratamento_alerta SET id_user = $id_usuer, tratamento_aplicado = '$tratamento'
                            WHERE id_alerta = '$idAlarme'";

                //var_dump($query);

                if ($this->db->query($query))
                {
                    $array = array('status' => true);
                }else{
                    $array = array('status' => false);
                }
            }else{
                $array = array('status' => false);
            }

            return $array;
        }

        /*
        * REGISTRA O TRATAMENTO PROVISORIO DO ALARME
        */
        public function registrarTratamentoProvisorioAlarme($idAlarme, $tratamento){

            if(is_numeric($idAlarme)){

                $id_usuer   = $_SESSION['userdata']['userId'];

                $query = "INSERT INTO tb_tratamento_provisorio (id_alerta, id_user, tratamento_aplicado) VALUES ('$idAlarme','$id_usuer','$tratamento')";

                if ($this->db->query($query))
                {
                    $array = array('status' => true);
                }else{
                    $array = array('status' => false);
                }


            }else{
                $array = array('status' => false);
            }

            return $array;
        }


        /*
        * ATUALIZA O STATUS DO ALARME
        */
        public function atualizarStatusAlarme($idAlarme, $statusAlarme){

            if(is_numeric($statusAlarme) && is_numeric($idAlarme)){

                $query      = "UPDATE tb_alerta SET status_ativo = '$statusAlarme'
                            WHERE id = '$idAlarme'";

                if ($this->db->query($query))
                {
                    $array = array('status' => true);
                }else{
                    $array = array('status' => false);
                }

            }else{
                $array = array('status' => false);
            }

            return $array;
        }


        /*
        * Recupera os dados do(s) equipamento(s) que o cliente possui
        */
        public function totalEquipamentosClientes($idCliente){

            if(is_numeric($idCliente)){

                $query = "SELECT clie.id, sim.num_sim, sim_equip.id_equipamento, sim_equip.num_serie, tp_equip.tipo_equipamento, equip.nomeModeloEquipamento
                            FROM tb_cliente clie
                            JOIN tb_sim sim ON sim.id_cliente = clie.id
                            LEFT JOIN tb_sim_equipamento sim_equip ON sim_equip.id_sim = sim.num_sim
                            LEFT JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                            LEFT JOIN tb_tipo_equipamento tp_equip ON tp_equip.id = equip.tipo_equipamento
                            WHERE clie.id = '$idCliente'";

                /* EXECUTA A QUERY ESPECIFICADA */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if($result)
                {
                    /* VERIFICA SE EXISTE VALOR */
                    if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'equipamentos' => $retorno);
                    }else{
                      $array = array('status' => false, 'equipamentos' => '');
                    }
                }else{
                    $array = array('status' => false, 'equipamentos' => '');
                }
            }else{
                $array = array('status' => false);
            }

            return $array;

        }

        /*
        * RECUPERA O TOTAL DE ALARMES REGISTRADOS DURANTE UM PERIODO, DE ACORDO COM UM DETERMINADO CLIENTE
        */
        public function totalAlarmesGeradoEquipamento($idequipamento, $dataInicio, $dataFim){

            if(is_numeric($idequipamento)){

                $query = "SELECT COUNT(alert.id) AS 'total' FROM tb_alerta alert
                        JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                        JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                        WHERE equip.id = '$idequipamento' AND alert.dt_criacao BETWEEN '$dataInicio 00:00:00' AND '$dataFim 23:59:59'";

                /* EXECUTA A QUERY ESPECIFICADA */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if($result)
                {
                    /* VERIFICA SE EXISTE VALOR */
                    if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'alarmes' => $retorno);
                    }else{
                      $array = array('status' => false, 'alarmes' => '');
                    }
                }else{
                    $array = array('status' => false, 'alarmes' => '');
                }

            }else{
                $array = array('status' => false);
            }

            return $array;
        }

        /*
        * RECUPERA OS ALARMES QUE FORAM DISPARADOS POR DETERMINADO EQUIPAMENTO
        */
        public function recuperaAlarmesEquipamento($idequipamento, $dataInicio, $dataFim)
        {
            if(is_numeric($idequipamento)){

                $query = "SELECT sim_equip.id, sim_equip.id_equipamento, sim_equip.id_sim, sim_equip.num_serie, alert.id as 'alertId', alert.status_ativo, alert.dt_criacao, trat_alert.parametro, trat_alert.parametroMedido, trat_alert.parametroAtingido, trat_alert.tratamento_aplicado, msg_alert.mensagem
                            FROM tb_sim_equipamento sim_equip
                            JOIN tb_alerta alert ON alert.id_sim_equipamento = sim_equip.id
                            JOIN tb_msg_alerta msg_alert ON msg_alert.id = alert.id_msg_alerta
                            JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                            WHERE sim_equip.id_equipamento = '$idequipamento' AND alert.dt_criacao BETWEEN '$dataInicio 00:00:00' AND '$dataFim 23:59:59'
                            ORDER BY alert.id DESC";

                /* EXECUTA A QUERY ESPECIFICADA */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if($result)
                {
                    /* VERIFICA SE EXISTE VALOR */
                    if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'equipAlarm' => $retorno);
                    }else{
                      $array = array('status' => false, 'equipAlarm' => '');
                    }
                }else{
                    $array = array('status' => false, 'equipAlarm' => '');
                }

            }else{
                $array = array('status' => false);
            }

            return $array;
        }

        /*
        * COM O ID DO EQUIPAMENTO, PROCURA PELA ÚLTIMO DADO REGISTRADO PELO EQUIPAMENTO
        */
        public function recuperacaoUltimaLeituraEquip($idSim, $param){

            if(is_numeric($idSim)){

                $query = "SELECT id, ".$param." AS 'medida'";

                // $query .= " num_sim, b, c, d, e, f, g, h, i, j, l, m, n, o, p, q, r, s, t, u, dt_criacao ";

                $query .= " FROM tb_dados WHERE num_sim = '$idSim' ORDER BY id DESC LIMIT 1";

                /* EXECUTA A QUERY ESPECIFICADA */
                $result = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if($result)
                {
                    /* VERIFICA SE EXISTE VALOR */
                    if (@mysql_num_rows($result) > 0)
                    {
                      /* ARMAZENA NA ARRAY */
                      while ($row = @mysql_fetch_assoc ($result))
                      {
                        $retorno[] = $row;
                      }

                      /* DEVOLVE RETORNO */
                      $array = array('status' => true, 'equipAlarm' => $retorno);
                    }else{
                      $array = array('status' => false, 'equipAlarm' => '');
                    }
                }else{
                    $array = array('status' => false, 'equipAlarm' => '');
                }

            }else{
                $array = array('status' => false);
            }

            return $array;
        }
    }

?>
