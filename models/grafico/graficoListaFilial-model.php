<?php

/**
 * GraficoListaFilialModel
 * 
 * Modelo que gerencia toda a parte da listagem das filiais
 */
class GraficoListaFilialModel extends MainModel
{
    /**
     * Metodo construtor
     * 
     * Configura os parametros do modelo
     */
    public function __construct($db = false, $controller = null)
    {
        /* carrega a conexao */
        $this->db = $db;
        
        /* carrega o controller */
        $this->controller = $controller;
        
        /* carrega os parametros */
        $this->parametros = $this->controller->parametros;
    }
}

?>