<?php

    /**
     * Classe de controle que gerencia
     * o model e a view da filial
     */

    class FilialController extends MainController
    {
        /**
         * Funcao que gerencia o index das Filiais
         */

         public function index ()
         {
             // Verifica se esta logado
             $this->check_login();

             // Define o titulo da pagina
             $this->title = "Filiais";

             // Define os parametro da funcao
             $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

             // CARREGA O MODELO DE USUÁRIO PARA CONTROLE DE LOGIN
             $modelo        = $this->load_model('usuario/usuario-model');
             // Carrega o modelo para este view
             $modeloFilial  = $this->load_model('filial/filial-model');

             // Carrega view
             require_once EFIPATH . "/views/_includes/header.php";
             require_once EFIPATH . "/views/_includes/menu.php";
             require_once EFIPATH . "/views/filial/filialLista-view.php";
             require_once EFIPATH . "/views/_includes/footer.php";
         }

         //TRATAMENTO DOS DADOS PARA CADASTRO VIA JSON

         public function registraFilial(){

            //CARREGA MODELO PARA ESTA FUNÇÃO
            $filialModelo    = $this->load_model('filial/filial-model');

            $registraFilial  = $filialModelo->registroFilial($_POST['nomeFilial'], $_POST['codigoArea'], $_POST['telefone'], $_POST['cepFilial'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['idEstado'], $_POST['idPais'], $_POST['idMatriz']);

            if($registraFilial){
                exit(json_encode(array('status' => $registraFilial['status'] )));
            }else{
                exit(json_encode(array('status' => $registraFilial['status'] )));
            }

         }


    }

?>
