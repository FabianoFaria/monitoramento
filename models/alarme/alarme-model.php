<?php

    /**
    * Classe de modelo que gerencia as informacoes das filiais
    */
    class AlarmeModel extends MainModel
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


        /* FUNÇÃO RESPONSAVEL PELA LISTAGEM DE ALERTAS REGISTRADOS
        *
        */
        public function listarAlarmes()
        {
            //IMPLEMENTAR
        }

    }

?>
