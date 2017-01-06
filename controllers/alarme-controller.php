<?php

/**
 * Classe de controle que registra, exibe, gera relatorio
 * e controla demais operações sobre alarmes
 */
 class AlarmeController extends MainController
 {
    /**
     * Funcao que gerencia o index dos alarmes
     */
    public function index()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "Alarmes";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        $modelo         = $this->load_model('usuario/usuario-model');
        $modeloCliete   = $this->load_model('cliente/cliente-model');
        // CARREGA O MODELO PARA ESTE VIEW
        $alarmeModelo  = $this->load_model('alarme/alarme-model');
        $modeloEdicao  = $this->load_model('editar/editar-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/alarme/alarmeLista-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

    public function alarmeStatus(){
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "alarme";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        $modelo         = $this->load_model('usuario/usuario-model');
        // CARREGA O MODELO PARA ESTE VIEW
        $alarmeModelo  = $this->load_model('alarme/alarme-model');
        $modeloEdicao  = $this->load_model('editar/editar-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/alarme/alarmeLista-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

    public function gerenciarAlertas(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessaris
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ed'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            //Define o titulo da pagina
            $this->title = "alarme";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('cliente/cliente-model');
            $modeloAlarm    = $this->load_model('alarme/alarme-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/alarme/gerenciarAlarmeCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }

    /*
    * Função para registrar os dados de contato para alarmes via JSON
    */
    public function registrarContatoAlarmeJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo      = $this->load_model('alarme/alarme-model');

        $contatoCadastrado = $alarmeModelo->registraContatoAlarmeJson($_POST['idMatriz'], $_POST['sedeContato'],$_POST['nomeContato'], $_POST['funcaoContato'], $_POST['emailContato'], $_POST['celularContato'], $_POST['obsContato']);

        if($contatoCadastrado['status']){
            exit(json_encode(array('status' => $contatoCadastrado['status'])));
        }else{
            exit(json_encode(array('status' => $contatoCadastrado['status'])));
        }
    }

    /*
    * Função para listar os contatos para alarmes via JSON
    */
    public function listarContatosAlarmesJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo       = $this->load_model('alarme/alarme-model');

        $contatosAlarmes    = $alarmeModelo->listarContatoAlarmes($_POST['idCliente'], $_POST['idFilial']);

        if($contatosAlarmes['status']){

            //var_dump($contatosAlarmes['status']);
            $listaContatos = "";
            foreach ($contatosAlarmes['contatos'] as $contato) {
                $listaContatos .= "<tr>";
                $listaContatos .= "<td>".$contato['nome_contato']."</td>";
                $listaContatos .= "<td>".$contato['funcao']."</td>";
                $listaContatos .= "<td>".$contato['email']."</td>";
                $listaContatos .= "<td>".$contato['celular']."</td>";
                $listaContatos .= "<td>".$contato['observacao']."</td>";
                $listaContatos .= "<td id='linkConta_".$contato['id']."'><a href='javascript:void(0);' onClick='atualizarContato(".$contato['id'].")'><i class='fa fa-eye '></i></a></td>";
                $listaContatos .= "<td><a href='#' class='excluirContato' value='".$contato['id']."'><i class='fa fa-times '></i></a></td>";
                $listaContatos .= "</tr>";
            }

            exit(json_encode(array('status' => $contatosAlarmes['status'], 'contatos' => $listaContatos)));
        }else{
            exit(json_encode(array('status' => $contatosAlarmes['status'])));
        }

    }

    /*
    * Função para carregar os dados de um determinado contato via JSON
    */
    public function carregarContatosAlarmesJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo       = $this->load_model('alarme/alarme-model');

        $contatoAlarmes    = $alarmeModelo->carregarContatoAlarmes($_POST['idContato']);

        if($contatoAlarmes['status']){
            exit(json_encode(array('status' => $contatoAlarmes['status'], 'contato' => $contatoAlarmes['contato'][0])));
        }else{
            exit(json_encode(array('status' => $contatoAlarmes['status'])));
        }

    }

    /*
    * Função para efetuar o registro dos dados do contato
    */
    public function salvarEditContatoAlarmeJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo       = $this->load_model('alarme/alarme-model');

        $contatoAtualizado  = $alarmeModelo->atualizarContato($_POST['idEdit'], $_POST['nomeEdit'], $_POST['funcaoEdit'], $_POST['emailEdit'], $_POST['celularEdit'], $_POST['obserEdit']);

        if($contatoAtualizado['status']){
            exit(json_encode(array('status' => $contatoAtualizado['status'])));
        }else{
            exit(json_encode(array('status' => $contatoAtualizado['status'])));
        }
    }

 }

 ?>
