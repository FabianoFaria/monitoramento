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

    }

?>
