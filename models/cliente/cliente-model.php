<?php

    /**
    * Classe de modelo que gerencia as informacoes do cliente
    */
    class ClienteModel extends MainModel
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

         /* FUNÇÃO RESPONSAVEL PELA LISTAGEM DE CLIENTES
         *
         */
         public function listarCliente()
         {
             $query = "SELECT id, nome, cidade, ddd, telefone FROM tb_cliente";

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
                     return $retorno;
                 }
             }
             else
                 return false;
         }

         /**
          * Funcao que cadastra o cliente
          * Sempre que ocorrer uma acao no botao submit
          * Esta funcao eh acionada
          */
          public function cadastrarCliente()
          {
              // Se ocorrer uma acao
              if (isset($_POST['btn_salvar']))
              {
                  // Armazena o retorno do post
                  $cliente  = $this->tratamento($_POST['txt_cliente']);
                  $endereco = $this->tratamento($_POST['txt_endereco']);
                  $numero   = !empty ($_POST['txt_numero']) ? $this->tratamento($_POST['txt_numero'],3) : 0;
                  $ddd      = !empty($_POST['txt_ddd']) ? $this->tratamento($_POST['txt_ddd'],3) : 0;
                  $telefone = !empty ($_POST['txt_telefone']) ? $this->tratamento($_POST['txt_telefone'],3) : 0;
                  $cep      = $this->tratamento($_POST['txt_cep'],3);
                  $pais     = $this->tratamento($_POST['opc_pais']);
                  $estado   = $this->tratamento($_POST['opc_estado']);
                  $cidade   = $this->tratamento($_POST['txt_cidade']);
                  $bairro   = $this->tratamento($_POST['txt_bairro']);

                  // Verifica se os cambos obrigatorios nao sao nulos
                  if ($cliente != "" && $endereco != "" && $cep != "" && $cidade != "" && $bairro != "")
                  {
                      // Realiza o upload da imagem
                      $up_resp = $this->validaUpload($_FILES);
                      // Grava no banco os valores
                      $query = "insert into tb_cliente (nome, endereco, numero, cep, id_pais, id_estado, ddd, telefone , cidade, bairro, id_users ,
                                                        foto)
                                values ('{$cliente}', '{$endereco}', '{$numero}', '{$cep}', '{$pais}', '{$estado}', '{$ddd}', '{$telefone}',
                                '{$cidade}', '{$bairro}', '{$_SESSION['userdata']['userId']}', '{$up_resp}')";

                      // Realiza a chamada para gravar e verficar se gravou com sucesso
                      $this->validaInsercaoBanco ($query, "Cadastro salvo com sucesso!", "Erro durante o salvamento.");
                  }
                  else
                  {
                      // Se os dados estiveren vaizos
                      // Apresenta uma mensagem informa que existe campo em branco
                      echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
                  }
              }
          }

        //OPERAÇÔES DE CRUD ATRAVÉS DE JSON
        public function cadastrarClienteJson($nomeCliente, $ddd, $telefone, $cep, $endereco, $numero, $bairro, $cidade, $estado, $pais)
        {
            // Verifica se os cambos obrigatorios nao sao nulos
            if ($nomeCliente != "" && $endereco != "" && $cep != "" && $cidade != "" && $bairro != "")
            {

                // Realiza o upload da imagem
                //$up_resp = $this->validaUpload($_FILES);

                // Grava no banco os valores
                $query = "insert into tb_cliente (nome, endereco, numero, cep, id_pais, id_estado, ddd, telefone , cidade, bairro, id_users ,
                                                  foto)
                          values ('{$nomeCliente}', '{$endereco}', '{$numero}', '{$cep}', '{$pais}', '{$estado}', '{$ddd}', '{$telefone}',
                          '{$cidade}', '{$bairro}', '{$_SESSION['userdata']['userId']}', 'a881bd9c3f3b8446ef35ac350a06691a.jpg')";


                // Realiza a chamada para gravar e verficar se gravou com sucesso
                //$result = $this->validaInsercaoBanco ($query, "Cadastro salvo com sucesso!", "Erro durante o salvamento.");

                $result   = $this->db->select($query);

                $idGerada  = mysql_insert_id();
                //$queryId = mysql_insert_id();

                $array = array('status' => $result, 'idCliente' => $idGerada);

            }else{

                $array = array('status' => false, 'idCliente' => 0);

            }

            return $array;
        }

        /**
         * Funcao que valida a gravacao da query no banco
         *
         * @param string $query - recebe uma string contendo a query
         * @param string $msgSuc - recebe uma string contendo a mensagem de sucesso
         * @param string $msgErr - recebe uma string contendo a mensagem de erro
         */
        private function validaInsercaoBanco($query, $msgSuc, $msgErr)
        {
            // Verifica se gravou com sucesso
            if ($this->db->query($query))
            {
                // Se gravou
                // Apresenta a mensagem de sucesso
                //echo "<div class='mensagemSucesso'><span>{$msgSuc}</span></div>";
                return true;
            }
            else
            {
                // Se ocorreu um erro
                // Grava o erro no log
                // Monta a query do log
                $queryLog = "insert into tb_log (log) values ('Erro ao gravar o cadastro : [".str_replace("'","" , $query)."]')";

                // Executa a query
                $this->db->query($queryLog);

                // Apresenta a mensagem de erro
                //echo "<div class='mensagemError'><span>{$msgErr}</span></div>";
                return false;
            }
        }

    }

?>
