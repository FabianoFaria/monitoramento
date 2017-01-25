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
        public function listarContatoAlarmes($idCliente, $idFilial = 0)
        {
            if(is_numeric($idCliente)){

                //Verifica se foi selecionado alguma filial
                if($idFilial == 0){

                    //Procura por contatos apenas do cliente
                    $query = "SELECT contAlert.id, contAlert.id_cliente, contAlert.id_filial, contAlert.nome_contato, contAlert.funcao, contAlert.email, contAlert.celular, contAlert.observacao
                            FROM tb_contato_alerta contAlert
                            WHERE contAlert.id_cliente  = $idCliente";

                }else{
                    //Procura por contatos da filial selecionada
                    $query = "SELECT contAlert.id, contAlert.id_cliente, contAlert.id_filial, contAlert.nome_contato, contAlert.funcao, contAlert.email, contAlert.celular, contAlert.observacao
                            FROM tb_contato_alerta contAlert
                            WHERE contAlert.id_cliente  = $idCliente AND contAlert.id_filial = $idFilial";
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

            $query = "SELECT alert.id, alert.dt_criacao, alert.status_ativo, alert.visto, msg_alert.mensagem, sim_equip.id_equipamento, equip.nomeEquipamento, equip.modelo, clie.nome, trat_alert.parametro , trat_alert.parametroMedido, trat_alert.parametroAtingido
                    FROM tb_alerta alert
                    JOIN tb_msg_alerta msg_alert ON alert.id_msg_alerta = msg_alert.id
                    JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                    JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                    JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                    JOIN tb_sim sim ON sim.num_sim = sim_equip.id_sim
                    JOIN tb_cliente clie ON clie.id = sim.id_cliente
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
              }
            }

            return $array;
        }


        /*
        * RECUPERA OS DADOS DO ALARME PARA SEREM EXIBIDOS PARA O USUÁRIO
        */
        public function recuperaDadosAlarme($idAlarme){

            $query = "SELECT alert.id, alert.id_sim_equipamento, alert.id_msg_alerta, alert.status_ativo, alert.visto, alert.dt_criacao, trat_alert.id AS 'tratamento_id', trat_alert.parametro, trat_alert.parametroMedido, trat_alert.parametroAtingido, trat_alert.tratamento_aplicado,
                    equip.nomeEquipamento, equip.modelo, equip.id_cliente, equip.id_filial
                    FROM tb_alerta alert
                    JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                    JOIN tb_sim_equipamento sim_equip ON sim_equip.id = alert.id_sim_equipamento
                    JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
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

                $query = "SELECT clie.id, sim.num_sim, sim_equip.id_equipamento, sim_equip.num_serie, tp_equip.tipo_equipamento, equip.nomeEquipamento, equip.modelo FROM tb_cliente clie
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
                        WHERE equip.id = '$idequipamento' AND alert.dt_criacao BETWEEN '$dataInicio 00:00:00' AND '$dataFim 00:00:00'";

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

                $query = "SELECT sim_equip.id, sim_equip.id_equipamento, sim_equip.id_sim, sim_equip.num_serie, alert.id as 'alertId', alert.status_ativo, trat_alert.parametro, trat_alert.parametroMedido, trat_alert.parametroAtingido, trat_alert.tratamento_aplicado
                            FROM tb_sim_equipamento sim_equip
                            JOIN tb_alerta alert ON alert.id_sim_equipamento = sim_equip.id
                            JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                            WHERE sim_equip.id_equipamento = '$idequipamento' AND alert.dt_criacao BETWEEN '$dataInicio 00:00:00' AND '$dataFim 00:00:00'";

            }else{
                $array = array('status' => false);
            }

            return $array;
        }

    }

?>
