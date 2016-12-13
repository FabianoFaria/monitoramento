<?php

/**
* Classe de modelo que gerencia as informacoes dos fabricantes
*/

class FabricanteModel extends MainModel
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

    /* FUNÇÃO RESPONSAVEL PELA LISTAGEM DE FABRICANTES
    *
    */
    public function listarFabricantes()
    {
        $query = "SELECT fabri.id, fabri.nome, fabri.telefone, fabri.ddd, fabri.endereco, fabri.cidade, est.nome as 'estado', pais.nome as 'pais' FROM tb_fabricante fabri
                    LEFT JOIN tb_estado est ON est.id = fabri.id_estado
                    JOIN tb_pais pais ON pais.id = fabri.id_pais
                    JOIN tb_users usr ON  usr.id = fabri.id_users";

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


}

?>
