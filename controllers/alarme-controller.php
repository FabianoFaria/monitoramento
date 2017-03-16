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

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_pe'] != 1 ){
            // SE NAO POSSUIR
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else{

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
    }

    public function alarmePorEquipamento(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_pe'] != 1 ){
            // SE NAO POSSUIR
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "alarme";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            $modelo         = $this->load_model('usuario/usuario-model');
            $modeloCliete   = $this->load_model('cliente/cliente-model');
            // CARREGA O MODELO PARA ESTE VIEW
            $alarmeModelo  = $this->load_model('alarme/alarme-model');
            $modeloEdicao  = $this->load_model('editar/editar-model');
            $modeloEquip   = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/alarme/alarmeListaEquipamentos-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }

    }

    public function alarmeStatus(){
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_ca'] != 1 ){
            // SE NAO POSSUIR
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else{
            // Define o titulo da pagina
            $this->title = "alarme";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            $modelo        = $this->load_model('usuario/usuario-model');
            // CARREGA O MODELO PARA ESTE VIEW
            $alarmeModelo  = $this->load_model('alarme/alarme-model');
            $modeloEdicao  = $this->load_model('editar/editar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/alarme/alarmeLista-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    public function gerenciarAlertas(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessaris
        if ($_SESSION['userdata']['per_pe'] != 1 )
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
    * Função para remover um contato da lista
    */
    public function removerContatosAlarmesJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo     = $this->load_model('alarme/alarme-model');

        $contatoRemovido  = $alarmeModelo->removerContatoLista($_POST['idContato']);

        if($contatoRemovido['status']){
            exit(json_encode(array('status' => $contatoRemovido['status'])));
        }else{
            exit(json_encode(array('status' => $contatoRemovido['status'])));
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

            /*
            * DADOS DA DATA DO ALERTA
            */
            $dataCriacao    = explode(" ", $dadosAlarme['dt_criacao']);
            $horaCriacao    = $dataCriacao[1];
            $dataCriacaoTratada = implode("/", array_reverse(explode("-", $dataCriacao[0])));
            $dataVisualizacao   = date('d/m/Y h:i:s');

            /*
            * DADOS DO STATUS DE ALERTA E MENSAGENS
            */
            $statusAlarme    = '';
            switch ($dadosAlarme['status_ativo']) {
                case '1':
                    $statusAlarme = "<i class='fa fa-exclamation-triangle  fa-2x fa-blink' style='color:red'></i> <span>Alarme novo</span>";
                break;
                case '2':
                    $statusAlarme = "<i class='fa fa-exclamation-triangle  fa-2x' style='color:orange'></i> <span>Alarme visualizado</span>";
                break;
                case '3':
                    $statusAlarme = "<i class='fa fa-exclamation-triangle  fa-2x' style='color:yellow'></i> <span>Alarme em tratamento</span>";
                break;
                case '4':
                    $statusAlarme = "<i class='fa fa-exclamation-triangle  fa-2x' style='color:green'></i> <span>Alarme solucionado</span>";
                break;
                case '5':
                    $statusAlarme = "<i class='fa  fa-check  fa-2x' style='color:green'></i><span>Alarme Finalizado</span>";
                break;
            }

            $mensagemAlerta     = $alarmeModelo->recuperaMensagemAlarme($dadosAlarme['id_msg_alerta']);

            /*
            * DADOS DO EQUIPAMENTO
            */
            $tipoEquip              = $dadosAlarme['tipo_equipamento'];
            $nomeEquipamento        = $dadosAlarme['nomeModeloEquipamento'];
            $pontoTabela            = $this->verificarPontoTabela($dadosAlarme['pontoTabela']);
            $localEquip             = ($dadosAlarme['ambiente_local_sim'] == ' ') ? $dadosAlarme['ambiente_local_sim'] : "Não informado.";

            /*
            * ÚLTIMA LEITURA DO EQUIPAMENTO
            */
            $ultimaLeitura          = $alarmeModelo->recuperacaoUltimaLeituraEquip($dadosAlarme['simEquip'], $dadosAlarme['pontoTabela']);

            if($ultimaLeitura['status']){
                $leitura =  $this->configurarTipoPontoTabela($dadosAlarme['pontoTabela'], $ultimaLeitura['equipAlarm'][0]['medida']);
            }else{
                $leitura = "Não recebida.";
            }

            /*
            * DADO QUE GEROU ALARME
            */
            $dadoGeradorAlarme = $this->configurarTipoPontoTabela($dadosAlarme['pontoTabela'], ($dadosAlarme['parametroMedido'] * 100));

            /*
            * TRATAMENTOS REGISTRADOS PARA O ALARME
            */
            $tratamentosRegistrados = $alarmeModelo->recuperacaoTratamentosAlarme($_POST['idAlarme']);

            if($tratamentosRegistrados['status']){

                $tratamentos = "";
                foreach ($tratamentosRegistrados['tratamentos'] as $trat) {
                    $tratamentos .= "<tr>";
                        $tratamentos .= "<td>";
                            $tratamentos .= $trat['nome']." ".$trat['sobrenome'];
                        $tratamentos .= "</td>";
                        $tratamentos .= "<td>";
                            $tratamentos .= $trat['tratamento_aplicado'];
                        $tratamentos .= "</td>";
                        $tratamentos .= "<td>";

                            $dateRaw      = explode(" ", $trat['data_tratamento']);
                            $diaTrat      = $dateRaw[0];

                            $tratamentos .= implode("/", array_reverse(explode("-", $diaTrat))) ." ".$dateRaw[1];
                        $tratamentos .= "</td>";
                    $tratamentos .= "</tr>";
                }

            }else{
                $tratamentos = "<tr><td colspan='3'>Nenhum tratamento aplicado.</td></tr>";
            }

            exit(json_encode(
                            array(
                                'status' => true,
                                'cliente' => $dadosClie['dados'][0],
                                'filial' => $dadosFili,
                                'alarme' => $dadosAlarme,
                                'dadoGerouAlarme' => $dadoGeradorAlarme,
                                'statusAlarme' => $statusAlarme,
                                'horaAlarme' => $horaCriacao,
                                'dataAlarme' => $dataCriacaoTratada,
                                'dataVisualizada' => $dataVisualizacao,
                                'tipoEquip' => $tipoEquip,
                                'nomeEquip' => $nomeEquipamento,
                                'pontoTab' => $pontoTabela,
                                'ultimoDado' => $leitura,
                                'tratamentos' => $tratamentos,
                                'localizacaoEquip' => $localEquip
                                )
                            )
                );
        }else{
            exit(json_encode(array('status' => $dadosAlarme['status'])));
        }
    }


    /*
    * Função para registrar tratamento do alarme
    */
    public function salvarTratamentoAlarmeJson(){

        $alarmeModelo       = $this->load_model('alarme/alarme-model');

        //SE STATUS NÂO FOR '4', IRÁ REGISTRAR TRATAMENTO PROVISORIO DO ALARME
        if($_POST['statusAlm'] < 4){

            //REGISTRA TRATAMENTO PROVISORIO DO ALARME
            $registroTratamento = $alarmeModelo->registrarTratamentoProvisorioAlarme($_POST['idAlarme'], $_POST['msgTrat']);

        }else{
            // REGISTRO DO TRATAMENTO DEFINITIVO DO ALARME FOI ALTERADO PARA TERMINAR COM STATUS 'SOLUCIONADO'
            // POIS O STATUS FINALIZADO CAIU EM DESUSO
            //REGISTRA TRATAMENTO DEFINITIVO DO ALARME
            $registroTratamento = $alarmeModelo->registrarTratamentoAlarme($_POST['idAlarme'], $_POST['msgTrat']);

        }

        if($registroTratamento['status']){

            $alterarStatusAlarme = $alarmeModelo->atualizarStatusAlarme($_POST['idAlarme'], $_POST['statusAlm']);

            exit(json_encode(array('status' => $registroTratamento['status'])));
        }else{
            exit(json_encode(array('status' => $registroTratamento['status'])));
        }

    }


    /*
    * VERIFICA SE FOI REGISTRADO UM NOVO ALARME PARA ATUALIZAR O CONTADOR VIA JSON
    */
    public function verificaNovoAlarme(){

        $quantidadeAtual    = $_GET['total'];

        $alarmeModelo       = $this->load_model('alarme/alarme-model');

        $contagemAlarmes    = $alarmeModelo->contagemNovosAlarmes($_GET['clie']);

        if($contagemAlarmes['status']){

            //Compara com o número atual de alarmes

            if($quantidadeAtual < $contagemAlarmes['totalAlarmes'][0]['totalNovo']){

                //Carrega os alarmes que foram recem cadastrados
                $alarmesRegistrados = $alarmeModelo->recuperaNotificacoesAlarmesRecemCadastrados($_GET['clie']);

                //var_dump($alarmesRegistrados);
                if($alarmesRegistrados['status']){

                    $listaAlarme    = "";

                    //Monta a lista de alarmes que seram devolvidos ao JSON para serem exibidos no menu.
                    foreach ($alarmesRegistrados['alarmes'] as $alarmeLista) {
                        $listaAlarme    .= "<li>";
                        $listaAlarme    .= "<a href='".HOME_URI."/home/'>";
                        $listaAlarme    .= "<div>";
                        $listaAlarme    .= "<strong>".$alarmeLista['nome']."</strong>";
                        $listaAlarme    .= "</div>";
                        $listaAlarme    .= "<div>";
                        $listaAlarme    .= $alarmeLista['mensagem'];
                        $listaAlarme    .= "</div>";
                        $listaAlarme    .= "</a>";

                        $listaAlarme    .= "</li>";
                        $listaAlarme    .= "<li class='divider'></li>";

                    }
                    $statusContagem = true;
                    $totalAlarmes   = $contagemAlarmes['totalAlarmes'][0]['totalNovo'];
                    $alarmesNovos   = $listaAlarme;

                }else{
                    //Retorna falso caso não tenha sido retornado um npumero de alertas maior que o inicial
                    $statusContagem = false;
                    $totalAlarmes   = 0;
                    $alarmesNovos   = '';
                }

            }else{
                //Retorna falso caso não tenha sido retornado um npumero de alertas maior que o inicial
                $statusContagem = false;
                $totalAlarmes   = 0;
                $alarmesNovos   = '';
            }

        }else{
            //Devolve nenhum dado extra em caso a busca tenha falhado
            $statusContagem = false;
            $totalAlarmes   = $quantidadeAtual;
            $alarmesNovos   = '';
        }

        exit(json_encode(array('status' => $statusContagem, 'contagem' => $totalAlarmes, 'alarmes' => $alarmesNovos)));

    }

    /*
    * VERIFICA SE FOI REGISTRADO UM NOVO ALARME PARA ATUALIZAR O CONTADOR VIA JSON
    */
    public function verificaListaNovoAlarme(){

        $quantidadeAtual    = $_GET['total'];

        $alarmeModelo       = $this->load_model('alarme/alarme-model');

        $contagemAlarmes    = $alarmeModelo->recuperaNotificacoesAlarmesRecemCadastrados($_GET['clie'], $quantidadeAtual);

        $listaAlarme        = "";
        $totalNovo          = 0;

        if($contagemAlarmes['status']){


            //Monta a lista de alarmes que seram devolvidos ao JSON para serem exibidos no menu.
            foreach ($contagemAlarmes['alarmes'] as $alarmeLista) {
                $listaAlarme    .= "<tr>";
                    $listaAlarme    .= "<td>";
                        //$listaAlarme    .= "<i class='fa fa-exclamation-triangle  fa-2x fa-blink' style='color:red'></i> <p> Novo</p>";
                        $listaAlarme    .= "<i class='fa fa-exclamation-triangle  fa-2x fa-blink' style='color:red'></i>";
                    $listaAlarme    .= "</td>";
                    $listaAlarme    .= "<td>";
                        $data = explode(" ", $alarmeLista['dt_criacao']);
                        $listaAlarme    .= implode("/",array_reverse(explode("-", $data[0])));
                    $listaAlarme    .= "</td>";
                    $listaAlarme    .= "<td>";
                        $localEspecifico = (isset($alarmeLista['filial'])) ? $alarmeLista['filial']: "Matriz";
                        $listaAlarme    .= $alarmeLista['nome']." - ".$localEspecifico;
                    $listaAlarme    .= "</td>";
                    $listaAlarme    .= "<td>";
                        $listaAlarme    .= $alarmeLista['nomeModeloEquipamento'];
                    $listaAlarme    .= "</td>";
                    $listaAlarme    .= "<td>";
                        //$listaAlarme    .= $alarmeLista;
                    $listaAlarme    .= "</td>";
                    $listaAlarme    .= "<td>";
                        $listaAlarme    .= "<p><b>".$alarmeLista['mensagem']."</b></p>";
                    $listaAlarme    .= "</td>";
                    $listaAlarme    .= "<td>";
                        //NOVO TRECHO
                        $listaAlarme    .= "<p>";
                        switch ($alarmeLista['parametroMedido']){
                            case 'Bateria':
                                # code...
                            break;
                            case 'Temperatura':
                                # code...
                            break;
                            /*
                            TRATA CASOS DE CORRENTE E TENSÃO
                            */
                            default:

                                $listaAlarme    .= "<span class='text-danger'>";
                                    $listaAlarme    .=$alarmeLista['parametroMedido']." (V)";
                                $listaAlarme    .= "</span> onde o limite era";
                                $listaAlarme    .= "<span class='text-info'>";
                                    $listaAlarme    .=$alarmeLista['parametroAtingido']." (V)";
                                $listaAlarme    .= "</span>";

                            break;
                        }
                        $listaAlarme    .= "</p>";
                    $listaAlarme    .= "</td>";
                    $listaAlarme    .= "<td>";
                        $idAlarme       = $alarmeLista['id'];
                        $listaAlarme    .= "<button class='btn btn-primary' onclick='detalharAlarme(".$idAlarme.")'>";
                            $listaAlarme    .= "<i class='fa fa-search '></i> Detalhes";
                        $listaAlarme    .= "</button>";
                    $listaAlarme    .= "</td>";
                $listaAlarme    .= "</tr>";

                $totalNovo++;
            }

            $totalAlarmes   = $totalNovo;

            if($totalNovo > $quantidadeAtual){

                $statusContagem = true;

            }else{
                $statusContagem = false;
            }

        }else{
            //Devolve nenhum dado extra em caso a busca tenha falhado
            $statusContagem = false;
            $totalAlarmes   = $quantidadeAtual;
            $listaAlarme    = '';
        }

        exit(json_encode(array('statusLista' => $statusContagem, 'contagemLista' => $totalAlarmes, 'alarmesNovaLista' => $listaAlarme, 'contagemAntiga' => $quantidadeAtual)));
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
