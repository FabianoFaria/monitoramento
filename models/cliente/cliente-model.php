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
             $query = "SELECT clie.id, clie.nome, clie.cidade, clie.ddd, clie.telefone, clie.status_ativo, clie.dt_criacao
                        FROM tb_cliente clie WHERE clie.status_ativo = '1'";
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

         /*
         * FUNÇÃO PARA FILTRAR OS CLIENTES DE ACORDO COM O USUÁRIO LOGADO
         */
        public function listarClienteUsuario($idCLiente)
        {
            $query = "SELECT clie.id, clie.nome, clie.cidade, clie.ddd, clie.telefone, clie.status_ativo, clie.dt_criacao
                       FROM tb_cliente clie WHERE clie.id = '$idCLiente' AND clie.status_ativo = '1'";
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

         /*
         * Função responsavel por listar as filiais de um cliente
         */

         public function carregarFiliaisCliente($idCliente)
         {
            if(is_numeric($idCliente)){

              $query = "SELECT fil.id, fil.nome, fil.endereco, fil.cidade, fil.ddd, fil.telefone, est.nome as 'estado', pais.nome as 'pais', clie.nome as 'matriz' FROM tb_filial fil
                        LEFT JOIN tb_estado est ON est.id = fil.id_estado
                        JOIN tb_pais pais ON pais.id = fil.id_pais
                        JOIN tb_cliente clie ON clie.id = fil.id_matriz
                        WHERE fil.id_matriz = '$idCliente'";

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
                    $array = array('status' => true, 'filiais' => $retorno);
                }else{
                    $array = array('status' => false, 'filiais' => '');
                }
              }else{
                $array = array('status' => false, 'filiais' => '');
              }


            }else{

              $array = array('status' => false, 'filiais' => '');

            }

            return $array;
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

              // Armazena o retorno do post
              $cliente  = $this->tratamento($nomeCliente);
              $endereco = $this->tratamento($endereco);
              $numero   = !empty ($numero) ? $this->tratamento($numero,3) : 0;
              $ddd      = !empty($ddd) ? $this->tratamento($ddd,3) : 0;
              $telefone = !empty ($telefone) ? $this->tratamento($telefone,3) : 0;
              $cep      = $this->tratamento($cep,3);
              $pais     = $this->tratamento($pais);
              $estado   = $this->tratamento($estado);
              $cidade   = $this->tratamento($cidade);
              $bairro   = $this->tratamento($bairro);

                // Realiza o upload da imagem
                $up_resp = $this->validaUpload($_FILES);

                // Grava no banco os valores
                $query = "INSERT INTO tb_cliente (nome, endereco, numero, cep, id_pais, id_estado, ddd, telefone , cidade, bairro, id_users ,
                                                  foto)
                          VALUES ('{$nomeCliente}', '{$endereco}', '{$numero}', '{$cep}', '{$pais}', '{$estado}', '{$ddd}', '{$telefone}',
                          '{$cidade}', '{$bairro}', '{$_SESSION['userdata']['userId']}', '$up_resp')";


                // Realiza a chamada para gravar e verficar se gravou com sucesso
                //$result = $this->validaInsercaoBanco ($query, "Cadastro salvo com sucesso!", "Erro durante o salvamento.");

                $result   = $this->db->query($query);

                //var_dump($query);

                $idGerada  = mysql_insert_id();
                //$queryId = mysql_insert_id();

                $array = array('status' => $result, 'idCliente' => $idGerada);

            }else{

                $array = array('status' => false, 'idCliente' => 0);

            }

            return $array;
        }

        /*
        * Função para atualizar o cliente
        */
        public function atualizarClienteJson($idCliente, $nome_cliente, $ddd, $telefone, $cep, $endereco, $numero, $bairro, $cidade, $estado, $pais)
        {

          // Armazena o retorno do post
          $cliente  = $this->tratamento($nome_cliente);
          $endereco = $this->tratamento($endereco);
          $numero   = !empty ($numero) ? $this->tratamento($numero,3) : 0;
          $ddd      = !empty($ddd) ? $this->tratamento($ddd,3) : 0;
          $telefone = !empty ($telefone) ? $this->tratamento($telefone,3) : 0;
          $cep      = $this->tratamento($cep,3);
          $pais     = (is_numeric($pais)) ?   $this->tratamento($pais) : null;
          $estado   = (is_numeric($estado)) ? $this->tratamento($estado) : null;
          $cidade   = $cidade;
          $bairro   = $this->tratamento($bairro);

          $query = "UPDATE tb_cliente SET ";
          if(isset($cliente)){  $query .= "nome = '$cliente' ";}
          if(isset($endereco)){ $query .= ", endereco = '$endereco'";}
          if(isset($numero)){   $query .= ", numero = '$numero'";}
          if(isset($ddd)){      $query .= ", ddd = '$ddd'";}
          if(isset($telefone)){ $query .= ", telefone = '$telefone'";}
          if(isset($cep)){      $query .= ", cep = '$cep'";}
          if(isset($pais)){     $query .= ", id_pais = '$pais'";}
          if(isset($estado)){   $query .= ", id_estado = '$estado'";}
          if(isset($cidade)){   $query .= ", cidade = '$cidade'";}
          if(isset($bairro)){   $query .= ", bairro = '$bairro'";}
          $query .= " WHERE id = '$idCliente'";

          /* monta result */
          $result = $this->db->query($query);

          if ($result){
            $array = array('status' => true);
          }else{
            $array = array('status' => false);
          }

          return $array;
        }


        /*
        *   Função para carregar dados do cliente
        */
        public function carregarDadosCliente($idCliente){

          if(is_numeric($idCliente)){


            $query = "SELECT
                      c.nome , c.endereco, c.numero, c.cep, c.cidade, c.bairro, c.ddd, c.telefone , p.nome as pais ,
                      e.nome as estado , p.id as idpais, e.id as idestado
                      FROM tb_cliente c
                      INNER JOIN tb_pais p on p.id = c.id_pais
                      INNER JOIN tb_estado e on e.id = c.id_estado
                      WHERE c.id = $idCliente";

             /* monta result */
             $result = $this->db->select($query);

            if ($result){
              /* verifica se existe valor */
              if (@mysql_num_rows($result)>0)
              {
                  /* pega os valores e monta um array */
                  while ($row = @mysql_fetch_assoc($result))
                      $retorno[] = $row;

                  /* retorna o select */
                  $cliente  = $retorno;
                //   $status   = true;
                   $array = array('status' => true, 'dados' => $cliente) ;
              }
              else
                /* fim */
                 $array = array('status' => false, 'dados' => '') ;

            }else{
              /* fim */
              //$status = false;
              $array = array('status' => false, 'dados' => '') ;
            }

          }else{

            $array = array('status' => false);

          }

          return $array;

        }

        /*
        * FUNÇÃO QUE RECUPERA OS DADOS DO CONTATOS DO CLIENTE
        */
        public function carregaDadosContato($idCliente)
        {

          if(is_numeric($idCliente) && isset($idCliente)){

            $query = "SELECT id, nome, sobrenome, email, telefone, celular, id_cliente
                      FROM tb_users
                      WHERE id_cliente = '$idCliente'";

            /* monta result */
            $result = $this->db->select($query);

            if ($result){
              /* verifica se existe valor */
              if (@mysql_num_rows($result)>0)
              {
                  /* pega os valores e monta um array */
                  while ($row = @mysql_fetch_assoc($result))
                      $retorno[] = $row;

                  /* retorna o select */
                  $cliente  = $retorno;
                  $status   = true;

                  $array = array('status' => true, 'dados' => $cliente) ;
              }
              else
                /* fim */
                // $status = false;

                $array = array('status' => false, 'dados' => '') ;

            }else{
              /* fim */
              $status = false;

              $array = array('status' => true, 'dados' => '') ;
            }

          }else{
            $array = array('status' => false);
          }

          return $array;
        }

        /*
        * Função para carregar os números de SIM vinculados a filial do cliente
        */
        public function listarSimCliente($idCliente, $idFilial)
        {
            if(is_numeric($idCliente)){

                $query = "SELECT clie.nome as 'cliente', fili.nome as 'filial', sim.num_sim
                            FROM  tb_cliente clie
                            LEFT JOIN tb_filial fili ON clie.id = fili.id_matriz
                            LEFT JOIN tb_sim sim ON fili.id = sim.id_filial
                            WHERE fili.id_matriz = $idCliente AND fili.id = $idFilial";

                /* monta result */
                $result = $this->db->select($query);

                if ($result){
                  /* verifica se existe valor */
                  if (@mysql_num_rows($result)>0)
                  {
                      /* pega os valores e monta um array */
                      while ($row = @mysql_fetch_assoc($result))
                          $retorno[] = $row;

                      /* retorna o select */
                      $cliente  = $retorno;
                      $status   = true;

                      $array = array('status' => true, 'dados' => $cliente) ;
                  }
                  else
                    /* fim */
                    // $status = false;
                    $array = array('status' => false, 'dados' => '') ;

                }else{
                  /* fim */
                  $status = false;

                  $array = array('status' => true, 'dados' => '') ;
                }

            }else{
                $array = array('status' => false);
            }

            return $array;

        }

        /*
        * FUnção para carregar o num_sim da matriz do cliente com base no equipamento alocado
        */

        public function listarSimClienteMatriz($idEquip){

            if(is_numeric($idEquip)){
                $query = "SELECT clie.nome as 'cliente', sim.num_sim
                            FROM  tb_cliente clie
                            JOIN tb_equipamento equip ON clie.id = equip.id_cliente
                            LEFT JOIN tb_sim sim ON clie.id = sim.id_cliente
                            WHERE equip.id = $idEquip";

                /* monta result */
                $result = $this->db->select($query);

                if($result){

                    /* verifica se existe valor */
                    if (@mysql_num_rows($result)>0)
                    {
                        /* pega os valores e monta um array */
                        while ($row = @mysql_fetch_assoc($result))
                            $retorno[] = $row;

                        /* retorna o select */
                        $cliente  = $retorno;
                        $status   = true;

                        $array = array('status' => true, 'dados' => $cliente) ;
                    }
                    else
                      /* fim */
                      // $status = false;
                      $array = array('status' => false, 'dados' => '');
                }else{
                     $array = array('status' => false, 'dados' => '');
                }

            }else{
                $array = array('status' => false);
            }

            return $array;
        }

        /**
         * Funcao que valida a gravacao da query no banco
         *
         * @param string $query     - recebe uma string contendo a query
         * @param string $msgSuc    - recebe uma string contendo a mensagem de sucesso
         * @param string $msgErr    - recebe uma string contendo a mensagem de erro
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

        /**
         * Funcao que realiza o upload da foto
         *
         * @param array $files - Recebe um array com os dados da foto
         *
         * @return string $up_resp - Devolve o nome da foto
         */
        private function validaUpload($files)
        {
            // Verifica se existe arquivo no upload
            if (!empty($files['file_foto']['name']) && !empty($files['file_foto']['tmp_name']) && !empty($files['file_foto']['type']))
            {
                // Se existir arquivo para upload
                // Envia o array e aguarda a resposta
                $up_resp = $this->upload($files);
            }
            else
            {
                // Se nao existir arquivo para realizar upload
                $up_resp = '';
            }
            // Devolve o nome do arquivo
            return $up_resp;
        }

        /*
        * FUNÇÃO PARA LISTAR CLIENTES COM OU SEM CONTATOS PARA RECEBER ALERTAS
        */

        public function listarContatoAlarmesCliente(){

            $query = "SELECT clie.id, clie.nome, clie.cidade, clie.ddd, clie.telefone
                       FROM tb_cliente clie";

            /* monta result */
            $result = $this->db->select($query);

            if($result){

                /* verifica se existe valor */
                if (@mysql_num_rows($result)>0)
                {
                    /* pega os valores e monta um array */
                    while ($row = @mysql_fetch_assoc($result))
                        $retorno[] = $row;

                    /* retorna o select */
                    $cliente  = $retorno;
                    $status   = true;

                    $array = array('status' => true, 'dados' => $cliente) ;
                }
                else
                  /* fim */
                  // $status = false;
                  $array = array('status' => false, 'dados' => '');
            }else{
                 $array = array('status' => false, 'dados' => '');
            }

            return $array;
        }

        public function excluirClienteViaJson($idCliente){
            // Coletar os dados do post
            $id_clie   = $idCliente;

            if(is_numeric($id_clie)){

                $query = "UPDATE tb_cliente SET  status_ativo = '0' WHERE id = '$id_clie'";

                /* monta result */
                $result = $this->db->query($query);

                if ($result){
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
