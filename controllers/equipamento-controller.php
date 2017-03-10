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

        // VERIFICA AS PERMISSOES NECESSARIAS
        if ($_SESSION['userdata']['per_co'] != 1 ){
            // SE NAO POSSUIR
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "equipamento";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // CARREGA O MODELO PARA ESTE VIEW
            $modelo = $this->load_model('usuario/usuario-model');
            // CARREGA O MODELO DE CADASTRO PARA ESTE VIEW
            $modeloEquipamento = $this->load_model('equipamento/equipamento-model');

            // CARREGA VIEW
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/equipamento/equipamentoLista-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }


     }

     /*
     * FUNÇÃO PARA CADASTRO DE EQUIPAMENTO
     */

     public function cadastrarEquipamento()
     {

        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "equipamento";

        // VERIFICA AS PERMISSOES NECESSARIAS
        if ($_SESSION['userdata']['per_co'] != 1 ){
            // SE NAO POSSUIR
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else{
            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('equipamento/equipamento-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloFabri    = $this->load_model('fabricante/fabricante-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/equipamento/equipamentoCadastro-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

     }


     /*
     * Carregar dados do equipamento cadastrado
     */

     public function editarEquipamentoCliente(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_co'] != 1  )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "equipamento";

            // Carrega os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo     = $this->load_model('equipamento/equipamento-model');
            $modeloFabri    = $this->load_model('fabricante/fabricante-model');

            // Carrega view
             require_once EFIPATH . "/views/_includes/header.php";
             require_once EFIPATH . "/views/_includes/menu.php";
             require_once EFIPATH . "/views/equipamento/equipamentoEdicao-view.php";
             require_once EFIPATH . "/views/_includes/footer.php";

        }

     }

     /*
     * Carrega a tela de vinculaçao do equipamento com o SIM
     */
     public function vincularEquipamentoSim()
     {
         // Verifica o login
         $this->check_login();

         // Verifica as permissoes necessarias
         if ($_SESSION['userdata']['per_ca'] != 1 )
         {
             // Se nao possuir
             // Redireciona para index
             $this->moveHome();
         }else{

             // Carrega o modelo para este view
             $modelo     = $this->load_model('equipamento/equipamento-model');

             // Carrega view
              require_once EFIPATH . "/views/_includes/header.php";
              require_once EFIPATH . "/views/_includes/menu.php";
              require_once EFIPATH . "/views/equipamento/equipamentoVincularSim-view.php";
              require_once EFIPATH . "/views/_includes/footer.php";
        }
     }

     /*
     *  EFETUA O CADASTRO DE EQUIPAMENTO VIA JSON
     */
     public function registrarEquipamentoClienteJson()
     {

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $equipModelo            = $this->load_model('equipamento/equipamento-model');

        $equipamentoRegistrado  = $equipModelo->registrarEquipamentoJson($_POST['idCliente'],$_POST['idFilial'],$_POST['equipamento'],$_POST['fabricante'],$_POST['nomeModelo'],$_POST['correnteBateria'],$_POST['potencia'],$_POST['tensaoBancoBat'],$_POST['correnteBanco'],$_POST['quantBat'],$_POST['quantBancoBat'],$_POST['quantBatPorBanc'],$_POST['tipoBateria'],$_POST['localBateria'], $_POST['tipoEntrada'], $_POST['tipoSaida']);

        if($equipamentoRegistrado){
            exit(json_encode(array('status' => $equipamentoRegistrado['status'] )));
        }else{
            exit(json_encode(array('status' => $equipamentoRegistrado['status'] )));
        }

     }

     /*
     *  FUNÇÃO PARA EDITAR O EQUIPAMENTO VIA JSON
     */
     public function editarEquipamentoClienteJson()
     {
        //CARREGA MODELO PARA ESTA FUNÇÃO

        $equipModelo    = $this->load_model('equipamento/equipamento-model');

        /*
        'idEquip'         : idEquip,
        'idCliente' 		: idCliente,
        'idFilial'  		: idFilial,
        'equipamento'  	: equipamento,
        'fabricante'  	: fabricante,
        'nomeModelo'      : nomeModelo,
        'correnteBateria' : correnteBat,
        'potencia'        : potencia,
        'tensaoBancoBat'  : tensaoBanco,
        'correnteBanco'   : correnteBanco,
        'quantBat'        : quantBat,
        'quantBancoBat'   : quantBancoBat,
        'quantBatPorBanc' : quantBatPorBanc,
        'tipoBateria'     : tipoBat,
        'localBateria'    : localBat
        */

        $editarEquip    = $equipModelo->editarEquipamentoJson(
            $_POST['idEquip'],
            $_POST['idCliente'],
            $_POST['idFilial'],
            $_POST['equipamento'],
            $_POST['fabricante'],
            $_POST['nomeModelo'],
            $_POST['correnteBateria'],
            $_POST['potencia'],
            $_POST['tensaoBancoBat'],
            $_POST['correnteBanco'],
            $_POST['quantBat'],
            $_POST['quantBancoBat'],
            $_POST['quantBatPorBanc'],
            $_POST['tipoBateria'],
            $_POST['localBateria'],
            $_POST['tipoEntrada'],
            $_POST['tipoSaida']
            );

        if($editarEquip){
            exit(json_encode(array('status' => $editarEquip['status'] )));
        }else{
            exit(json_encode(array('status' => $editarEquip['status'] )));
        }
     }

     /*
     * FUNÇÃO PARA EXCLUIR EQUIPAMENTO
     */
     public function removerEquipamentoJson(){
        //CARREGA MODELO PARA ESTA FUNÇÃO
        $equipModelo    = $this->load_model('equipamento/equipamento-model');

        $removerEquip   = $equipModelo->removerEquipamentoViaJson($_POST['idEquipamento']);

        if($removerEquip){
            exit(json_encode(array('status' => $removerEquip['status'] )));
        }else{
            exit(json_encode(array('status' => $removerEquip['status'] )));
        }
     }
}

?>
