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
    }
?>
