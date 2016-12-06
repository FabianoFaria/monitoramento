<?php

/**
 * GraficoListaEquipamentoModel
 * 
 * Modelo que gerencia as regras da listagem de equipamentos
 */
class GraficoListaEquipamentoModel extends MainModel
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