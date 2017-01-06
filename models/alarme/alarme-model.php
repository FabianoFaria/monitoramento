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


    }

?>
