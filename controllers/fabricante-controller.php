<?php

/**
 * Classe de controle que gerencia
 * o model e a view das fabricantes
 */

 class FabricanteController extends MainController
{
    /**
     * Funcao que gerencia o index das fabricantes
     */
     public function index ()
     {
         // Verifica se esta logado
         $this->check_login();

         // Define o titulo da pagina
         $this->title = "Fabricantes";

         // Define os parametro da funcao
         $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

         // Carrega o modelo
         $modelo = $this->load_model('fabricante/fabricante-model');

         // Carrega view
         require_once EFIPATH . "/views/_includes/header.php";
         require_once EFIPATH . "/views/_includes/menu.php";
         require_once EFIPATH . "/views/fabricante/fabricanteLista-view.php";
         require_once EFIPATH . "/views/_includes/footer.php";

     }


}






?>
