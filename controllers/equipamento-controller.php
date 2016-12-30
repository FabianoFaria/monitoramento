<?php

/**
* Classe que gerencia o controle
* da view e model dos dados dos equipamentos
*/

class EquipamentoController extends MainController
{

    /**
     * index
     *
     * Funcao inicial que carrega
     *
     * @access public
     */

     public function index ()
     {
         // Verifica se esta logado
         $this->check_login();

         //Define o titulo da pagina
         $this->title = "Equipamento";

         // Define os parametro da funcao
         $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

         // Carrega o modelo para este view
         $modelo = $this->load_model('usuario/usuario-model');
         // Carrega o modelo de cadastro para este view
         $modeloEquipamento = $this->load_model('equipamento/equipamento-model');

         // Carrega view
         require_once EFIPATH . "/views/_includes/header.php";
         require_once EFIPATH . "/views/_includes/menu.php";
         require_once EFIPATH . "/views/equipamento/equipamentoLista-view.php";
         require_once EFIPATH . "/views/_includes/footer.php";

     }

     /*
     * Função para cadastro de equipamento
     */

     public function cadastrarEquipamento()
     {

        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "equipamento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo         = $this->load_model('equipamento/equipamento-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');

        // Carrega view
         require_once EFIPATH . "/views/_includes/header.php";
         require_once EFIPATH . "/views/_includes/menu.php";
         require_once EFIPATH . "/views/equipamento/equipamentoCadastro-view.php";
         require_once EFIPATH . "/views/_includes/footer.php";

     }


     /*
     *  Efetua o cadastro de equipamento via JSON
     */

     public function registrarEquipamentoClienteJson()
     {

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $equipModelo            = $this->load_model('equipamento/equipamento-model');

        $equipamentoRegistrado  = $equipModelo->registrarEquipamentoJson($_POST['idCliente'], $_POST['idFilial'], $_POST['equipamento'], $_POST['modEquip'], $_POST['fabricante'], $_POST['quantBateria'], $_POST['caracteristicas'], $_POST['amperagem'], $_POST['tipoBateria'], $_POST['potencia']);

        if($equipamentoRegistrado){
            exit(json_encode(array('status' => $equipamentoRegistrado['status'] )));
        }else{
            exit(json_encode(array('status' => $equipamentoRegistrado['status'] )));
        }

     }
}

?>
