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

    /*
    * Função para carregar os dados do Alarme via JSON
    */
    public function carregarDetalhesAlarmeJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo       = $this->load_model('alarme/alarme-model');
        $clieModelo         = $this->load_model('cliente/cliente-model');
        $filiModelo         = $this->load_model('filial/filial-model');

        $dadosAlarme        = $alarmeModelo->recuperaDadosAlarme($_POST['idAlarme']);

        if($dadosAlarme['status']){

            $dadosAlarme = $dadosAlarme['alerta'][0];

            $dadosClie   = $clieModelo->carregarDadosCliente($dadosAlarme['id_cliente']);
            //Caso o equipamento esteja em uma filial, será carregado os dados em outra função
            if($dadosAlarme['id_filial'] != 0){
                $dadosFili   = $filiModelo->filialEspecificaCliente($dadosAlarme['id_filial']);
            }else{
                $dadosFili   = '';
            }

            $dataCriacao    = explode(" ", $dadosAlarme['dt_criacao']);
            $horaCriacao    = $dataCriacao[1];
            $dataCriacaoTratada = implode("/", array_reverse(explode("-", $dataCriacao[0])));
            $dataVisualizacao   = date('d/m/Y h:i:s');

            $statusAlarme    = '';
            switch ($dadosAlarme['status_ativo']) {
                case '1':
                    $statusAlarme = 'Alarme Reconhecido';
                break;
                case '2':
                    $statusAlarme = 'Alarme em acompanhamento';
                break;
                case '3':
                    $statusAlarme = 'Alarme em tratamento';
                break;
                case '4':
                    $statusAlarme = 'Alarme solucionado';
                break;
                case '5':
                    $statusAlarme = 'Alarme finalizado';
                break;
            }

            //var_dump($dadosAlarme);

            exit(json_encode(array('status' => true, 'cliente' => $dadosClie['dados'][0], 'filial' => $dadosFili, 'alarme' => $dadosAlarme, 'statusAlarme' => $statusAlarme, 'horaAlarme' => $horaCriacao, 'dataAlarme' => $dataCriacaoTratada, 'dataVisualizada' => $dataVisualizacao)));
        }else{
            exit(json_encode(array('status' => $dadosAlarme['status'])));
        }
    }

 }

 /*

ALARME

 'status' <font color='#888a85'>=&gt;</font> <small>boolean</small> <font color='#75507b'>true</font>
'alerta' <font color='#888a85'>=&gt;</font>
 <b>array</b> <i>(size=1)</i>
   0 <font color='#888a85'>=&gt;</font>
     <b>array</b> <i>(size=12)</i>
       'id' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'71'</font> <i>(length=2)</i>
       'id_sim_equipamento' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'13'</font> <i>(length=2)</i>
       'id_msg_alerta' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'2'</font> <i>(length=1)</i>
       'status_ativo' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'1'</font> <i>(length=1)</i>
       'visto' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'0'</font> <i>(length=1)</i>
       'tratamento_id' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'66'</font> <i>(length=2)</i>
       'parametro' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Tensão'</font> <i>(length=7)</i>
       'parametroMedido' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'0'</font> <i>(length=1)</i>
       'parametroAtingido' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'110'</font> <i>(length=3)</i>
       'tratamento_aplicado' <font color='#888a85'>=&gt;</font> <font color='#3465a4'>null</font>
       'nomeEquipamento' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Hju'</font> <i>(length=3)</i>
       'modelo' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'8090'</font

 */

/*
filial


0 <font color='#888a85'>=&gt;</font>
   <b>array</b> <i>(size=16)</i>
     'id' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'15'</font> <i>(length=2)</i>
     'id_matriz' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'50'</font> <i>(length=2)</i>
     'id_estado' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'9'</font> <i>(length=1)</i>
     'id_pais' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'36'</font> <i>(length=2)</i>
     'id_users' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'5'</font> <i>(length=1)</i>
     'nome' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Filial Tr&amp;ecirc;s'</font> <i>(length=17)</i>
     'endereco' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Avenida Lagoa'</font> <i>(length=13)</i>
     'numero' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'0'</font> <i>(length=1)</i>
     'cep' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'73814505'</font> <i>(length=8)</i>
     'cidade' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Formosa'</font> <i>(length=7)</i>
     'bairro' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Village'</font> <i>(length=7)</i>
     'ddd' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'89'</font> <i>(length=2)</i>
     'telefone' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'234324234'</font> <i>(length=9)</i>
     'foto' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'a881bd9c3f3b8446ef35ac350a06691a.jpg'</font> <i>(length=36)</i>
     'status_ativo' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'1'</font> <i>(length=1)</i>
     'dt_criacao' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'2017-01-10 15:28:49'</font> <i>(length=19)</i>



*/

/*
cliente

<b>array</b> <i>(size=12)</i>
       'nome' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Nacional Industrias'</font> <i>(length=19)</i>
       'endereco' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Rua do Luar'</font> <i>(length=11)</i>
       'numero' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'0'</font> <i>(length=1)</i>
       'cep' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'53402395'</font> <i>(length=8)</i>
       'cidade' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Paulista'</font> <i>(length=8)</i>
       'bairro' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Fragoso'</font> <i>(length=7)</i>
       'ddd' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'23'</font> <i>(length=2)</i>
       'telefone' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'23234234'</font> <i>(length=8)</i>
       'pais' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Brasil'</font> <i>(length=6)</i>
       'estado' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Pernambuco'</font> <i>(length=10)</i>
       'idpais' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'36'</font> <i>(length=2)</i>
       'idestado' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'17'</font> <i>(length=2)</i>


*/

 ?>
