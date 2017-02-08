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

        $fabricanteRegistrado   = $fabricanteModelo->registrarFabricanteJson($_POST['novoFabricante'], $_POST['ddd'], $_POST['telefone'], $_POST['cep'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais'], $_POST['email']);

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

        if($fabricanteRegistrado['status']){

            $dados['id']        = $fabricanteRegistrado['dados']['id'];
            $dados['id_estado'] = $fabricanteRegistrado['dados']['id_estado'];
            $dados['id_pais']   = $fabricanteRegistrado['dados']['id_pais'];
            $dados['nome']      = html_entity_decode($fabricanteRegistrado['dados']['nome'], ENT_COMPAT, 'UTF-8');
            $dados['ddd']       = html_entity_decode($fabricanteRegistrado['dados']['ddd'], ENT_COMPAT, 'UTF-8');
            $dados['telefone']  = html_entity_decode($fabricanteRegistrado['dados']['telefone'], ENT_COMPAT, 'UTF-8');
            $dados['cep']       = html_entity_decode($fabricanteRegistrado['dados']['cep'], ENT_COMPAT, 'UTF-8');
            $dados['endereco']  = html_entity_decode($fabricanteRegistrado['dados']['endereco'], ENT_COMPAT, 'UTF-8');
            $dados['numero']    = html_entity_decode($fabricanteRegistrado['dados']['numero'], ENT_COMPAT, 'UTF-8');
            $dados['cidade']    = html_entity_decode($fabricanteRegistrado['dados']['cidade'], ENT_COMPAT, 'UTF-8');
            $dados['bairro']    = html_entity_decode($fabricanteRegistrado['dados']['bairro'], ENT_COMPAT, 'UTF-8');
            $dados['email']     = html_entity_decode($fabricanteRegistrado['dados']['email_fabricante'], ENT_COMPAT, 'UTF-8');

            exit(json_encode(array('status' => $fabricanteRegistrado['status'], 'fabricante' => $dados)));
        }else{
            exit(json_encode(array('status' => $fabricanteRegistrado['status'] )));
        }

    }

    /*
    * ATUALIZAR OS DADOS DO FABRICANTES
    */
    public function atualizarFabricanteJSON(){

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $fabricanteModelo       = $this->load_model('fabricante/fabricante-model');

        $fabricanteAtualizado   = $fabricanteModelo->atualizarFabricanteViaJson($_POST['idFabricante'], $_POST['fabricante'], $_POST['ddd'], $_POST['telefone'], $_POST['cep'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais'], $_POST['email']);

        if($fabricanteAtualizado){
            exit(json_encode(array('status' => $fabricanteAtualizado['status'] )));
        }else{
            exit(json_encode(array('status' => $fabricanteAtualizado['status'] )));
        }

    }

    /*
    * REMOVER O FABRICANTE DE ATIVOS
    */
    public function removerFabricanteJSON(){

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $fabricanteModelo       = $this->load_model('fabricante/fabricante-model');

        $fabricanteAtualizado   = $fabricanteModelo->removerFabricanteViaJson($_POST['idFabricante']);

        if($fabricanteAtualizado){
            exit(json_encode(array('status' => $fabricanteAtualizado['status'] )));
        }else{
            exit(json_encode(array('status' => $fabricanteAtualizado['status'] )));
        }

    }
}






?>
