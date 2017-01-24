<?php

/**
 * GraficoOpcaoVisualizacaoModel
 *
 * Modelo que gerencia as regras da selecao das opceos
 * para gerar o grafico
 */
class GraficoOpcaoVisualizacaoModel extends MainModel
{
    public $nUrl;
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
        
        $param = "/";
        foreach ($this->parametros as $row)
        {
            $param .= $row . "/";
        }

        // Define o link
        $this->nUrl = HOME_URI ."/grafico/graficoGerador". $param;
    }
}
