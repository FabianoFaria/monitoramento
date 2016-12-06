<?php

class PesquisarModel extends MainModel
{
    public function __construct ($db = false, $controller = null)
    {
        // carrega conexao
        $this->db = $db;
        
        // carrega controller
        $this->controller = $controller;
        
        // carrega parametros
        $this->parametros = $this->controller->parametros;
    }
    
    
    /* pesquisa */
    public function pesquisaRelacao ($num = 0)
    {
        /* monta query */
        if ($num == 0)
            $query = "select id as codCliente, nome, status_ativo as situacao from tb_cliente";
        else if ($num == 1)
            $query = "select id as codCliente, nome, status_ativo as situacao from tb_filial";
        else if ($num == 2)
            $query = "select id as codCliente, nome, status_ativo as situacao from tb_fabricante";
        else if ($num == 3)
            $query = "select id as codCliente, tipo_equipamento as nome, status_ativo as situacao from tb_equipamento";
        
        /* monta a result */
        $result = $this->db->select($query);
        /* verifica se existe resposta */
        if ($result)
        {
            /* verifica se existe valor */
            if (@mysql_num_rows($result) > 0)
            {
                /* armazena na array */
                while ($row = @mysql_fetch_assoc ($result))
                {
                    $retorno[] = $row;
                }
                
                /* devolve retorno */
                return $retorno;
            }
        }
        else
            return false;
    }
}

?>