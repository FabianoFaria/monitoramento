<?php

/**
 * GraficoModel
 * 
 * Modelo que gerencia as regras do grafico, busca de empresa
 */
class GraficoModel extends MainModel
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