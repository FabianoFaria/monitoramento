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
         $this->title = "fabricante";

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

     /**
     *
     */
     public function cadastrar ()
     {
        // Verifica se esta logado
         $this->check_login();

         // Define o titulo da pagina
         $this->title = "fabricante";

         // Define os parametro da funcao
         $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

         // Carrega o modelo
         $modelo = $this->load_model('fabricante/fabricante-model');

          // Carrega view
         require_once EFIPATH . "/views/_includes/header.php";
         require_once EFIPATH . "/views/_includes/menu.php";
         require_once EFIPATH . "/views/fabricante/fabricanteCadastrar-view.php";
         require_once EFIPATH . "/views/_includes/footer.php";
     }


    /*
    * REGISTRO DE FABRICANTE VIA JSON
    */
    public function registraFabricanteJSON(){

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $fabricanteModelo       = $this->load_model('fabricante/fabricante-model');

        $fabricanteRegistrado   = $fabricanteModelo->registrarFabricanteJson($_POST['novoFabricante'], $_POST['ddd'], $_POST['telefone'], $_POST['cep'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais']);

        if($fabricanteRegistrado){
            exit(json_encode(array('status' => $fabricanteRegistrado['status'] )));
        }else{
            exit(json_encode(array('status' => $fabricanteRegistrado['status'] )));
        }


    }

    /*
    * CARREGA OS DADOS DO FABRICANTE PARA EDIÇÂO
    */
    public function carregarFabricanteJson(){

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $fabricanteModelo       = $this->load_model('fabricante/fabricante-model');

        $fabricanteRegistrado   = $fabricanteModelo->carregarDadosFabricanteViaJson($_POST['idFabricante']);

        if($fabricanteRegistrado){
            exit(json_encode(array('status' => $fabricanteRegistrado['status'], 'fabricante' => $fabricanteRegistrado['dados'])));
        }else{
            exit(json_encode(array('status' => $fabricanteRegistrado['status'] )));
        }

    }
}






?>
