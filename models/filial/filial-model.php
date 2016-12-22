<?php

    /**
    * Classe de modelo que gerencia as informacoes das filiais
    */
    class FilialModel extends MainModel
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

        /* FUNÇÃO RESPONSAVEL PELA LISTAGEM DE FILIAIS
        *   Provavelmente será necesario passar um parametro para trazer a penas a filial de um cliente especifico
        */
        public function listarFiliais()
        {

            $query = "SELECT fil.id, fil.nome, fil.endereco, fil.cidade, fil.ddd, fil.telefone, est.nome as 'estado', pais.nome as 'pais', clie.nome as 'matriz' FROM tb_filial fil
                        LEFT JOIN tb_estado est ON est.id = fil.id_estado
                        JOIN tb_pais pais ON pais.id = fil.id_pais
                        JOIN tb_cliente clie ON clie.id = fil.id_matriz";

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
         * Função responsavel por listar filiais de um determinado cliente
        */
        public function filiaisCliente($idMatriz){

            $query = "SELECT * FROM tb_filial WHERE id_matriz = '$idMatriz'";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            if($result){
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
            }else
                return false;
        }


        /*
        * Cadastrar filial através de AJAX
        */
        public function registroFilial($nomeFilial, $codigoArea, $telefone, $cepFilial, $endereco, $numero, $bairro, $cidade, $idEstado, $idPais, $idMatriz){

            // Verifica se os cambos obrigatorios nao sao nulos
            if ($nomeFilial != "" && $telefone != "" && $cepFilial != "" && $endereco != "" && $cidade != "")
            {
                $idUser = $_SESSION['userdata']['userId'];

                // Monta a query
                $query = "insert into tb_filial (nome, id_matriz, endereco, numero, cep, id_pais, id_estado, cidade, bairro, ddd,
                            telefone,id_users, foto)
                            values ('$nomeFilial','$idMatriz','$endereco','$numero','$cepFilial','$idPais','$idEstado', '$cidade','$bairro',
                            '$codigoArea','$telefone','$idUser','a881bd9c3f3b8446ef35ac350a06691a.jpg')";

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
