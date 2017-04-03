<?php

class LogModel extends MainModel
{

    public function __construct ($db = false, $controller = null)
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
