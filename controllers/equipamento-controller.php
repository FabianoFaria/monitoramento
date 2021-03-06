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
        if($_SESSION['userdata']['per_co'] != 1 ){
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
            $modeloEquipamento  = $this->load_model('equipamento/equipamento-model');
            $modeloCliente      = $this->load_model('cliente/cliente-model');

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

        $equipamentoRegistrado  = $equipModelo->registrarEquipamentoJson($_POST['idCliente'],$_POST['idFilial'],$_POST['equipamento'],$_POST['fabricante'],$_POST['nomeModelo'],$_POST['correnteBateria'],$_POST['potencia'],$_POST['tensaoBancoBat'],$_POST['correnteBanco'],$_POST['quantBat'],$_POST['quantBancoBat'],$_POST['quantBatPorBanc'],$_POST['tipoBateria'],$_POST['localBateria'], $_POST['tipoEntrada'], $_POST['tipoSaida'], $_POST['tensaoMinBarramento']);

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
            $_POST['tipoSaida'],
            $_POST['tensaoMinBarramento']
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
        $equipModelo        = $this->load_model('equipamento/equipamento-model');

        $dadosEquipamento   = $equipModelo->detalhesEquipamentoParaConfiguracao($_POST['idEquipamento']);

        $removerEquip       = $equipModelo->removerEquipamentoViaJson($_POST['idEquipamento']);

        //RECUPERA INFORMAÇÕES DE PLANTA BAIXA
        $plantaBaixa        = $equipModelo->dadosEquipamentoPlantaBaixa($_POST['idEquipamento']);

        if($plantaBaixa['status']){

            $removePlanta = $equipModelo->removerPLantaBaixa($plantaBaixa['dadosPlanta'][0]['id_planta']);

            //var_dump($removePlanta);
            if($removePlanta['status']){
                //REMOVE TODOS OS PONTOS QUE FORAM CADASTRADOS NESTA PLANTA BAIXA
                $removePonto        = $equipModelo->removerPontosPlanta($plantaBaixa['dadosPlanta'][0]['id_planta']);

                if($plantaBaixa['dadosPlanta'][0] != ''){
                        $this->removeOldAvatar($plantaBaixa['dadosPlanta'][0]['imagem_planta'], UP_BLUEPRINT_IMG_PATH);
                }
            }
        }

        //VERIFICA SE REMOÇÃO FOI CONCLUIDA PARA CONTINUAR COM EXCLUSÃO
        if($removerEquip){

            //var_dump($dadosEquipamento);

            if($dadosEquipamento['status']){

                $idSimEquipamento       = $dadosEquipamento['equipamento'][0]['id'];
                $numeroSimEquipamento   = $dadosEquipamento['equipamento'][0]['id_sim'];

                //REMOVE DA TABELA DE POSIÇÕES AS POSIÇÕES OCUPADAS NO EQUIPAMENTO PELO SIM
                $removePosicoesEquipamento  = $equipModelo->removerPosicoesTabelaEquipamentoViaJson($idSimEquipamento, $numeroSimEquipamento);

            }

            //REMOVE OS PARAMETROS CADASTRADOS PARA O EQUIPAMENTO
            $removerParamEquip = $equipModelo->removerParametrosEquipamentoViaJson($_POST['idEquipamento']);

            //REMOVE OS PONTOS DE PLANTA BAIXA E A PLANTA BAIXA CADASTRADA PARA O EQUIPAMENTO

            exit(json_encode(array('status' => $removerEquip['status'] )));
        }else{
            exit(json_encode(array('status' => $removerEquip['status'] )));
        }
     }

    /*
    * FUNÇÃO PARA FILTRAR EQUIPAMENTOS POR CLIENTE
    */
    public function filtrarEquipamentosPorCliente(){

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $equipModelo = $this->load_model('equipamento/equipamento-model');

        $equipamentosPorCliente = $equipModelo->listarEquipamentosCliente($_POST['idCliente']);

        if($equipamentosPorCliente['status']){

            $listaEquipamentos  = $equipamentosPorCliente['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Cliente</th>
                                <th>local</th>
                                <th class='txt-center'>Gerenciar contatos</th>
                                </tr></thead>";
            $tabela         .="<tbody>";

            foreach ($listaEquipamentos as $equipamento) {
                $tabela         .="<tr>";
                    $tabela         .="<td>";
                        $tabela     .=$equipamento['tipoEquip'];
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $tabela     .=$equipamento['nomeModeloEquipamento'];
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $tabela     .=$equipamento['cliente'];
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $tabela     .= (isset($equipamento['filial'])) ? $equipamento['filial'] : "Matriz";
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $link       = HOME_URI."/equipamento/gerenciarContatosEquipamentos/".$equipamento['id']."";
                        $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt fa-2x'></i></a>";
                    $tabela         .="</td>";
                $tabela         .="</tr>";
            }

            $tabela         .="</tbody>";

            exit(json_encode(array('status' => $equipamentosPorCliente['status'], 'equipamentos' => $tabela)));
        }else{
            exit(json_encode(array('status' => $equipamentosPorCliente['status'] )));
        }

    }

    /*
    * FUNÇÃO PARA FILTRAR EQUIPAMENTOS POR CLIENTE E FILIAL
    */
    public function carregarListaEquipamentoFilialRelatoriosJson(){

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $equipModelo = $this->load_model('equipamento/equipamento-model');

        $dadosFiliaisEquipamento = $equipModelo->listarEquipamentosFilialCliente($_POST['idCliente'], $_POST['idFilial']);

        $tabela         = "";
        $tabela         .="<thead><tr>
                            <th>Equipamento</th>
                            <th>Modelo</th>
                            <th>Cliente</th>
                            <th>local</th>
                            <th class='txt-center'>Gerenciar contatos</th>
                            </tr></thead>";

        if($dadosFiliaisEquipamento['status']){

            $listaEquipamentos  = $dadosFiliaisEquipamento['equipamentos'];

            $tabela         .="<tbody>";

            foreach ($listaEquipamentos as $equipamento) {
                $tabela         .="<tr>";
                    $tabela         .="<td>";
                        $tabela     .=$equipamento['tipoEquip'];
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $tabela     .=$equipamento['nomeModeloEquipamento'];
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $tabela     .=$equipamento['cliente'];
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $tabela     .= (isset($equipamento['filial'])) ? $equipamento['filial'] : "Matriz";
                    $tabela         .="</td>";
                    $tabela         .="<td>";
                        $link       = HOME_URI."/equipamento/gerenciarContatosEquipamentos/".$equipamento['id']."";
                        $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt fa-2x'></i></a>";
                    $tabela         .="</td>";
                $tabela         .="</tr>";
            }

            $tabela         .="</tbody>";

            exit(json_encode(array('status' => $dadosFiliaisEquipamento['status'], 'equipamentos' => $tabela )));

        }else{

            $tabela         .="<tbody>";
            $tabela         .="<tr>";
            $tabela         .="<td colspan='5'>";
            $tabela         .="Nenhum equipamento encontrado";
            $tabela         .="</td>";
            $tabela         .="<tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => $dadosFiliaisEquipamento['status'], 'equipamentos' => $tabela )));
        }

    }

    /*
    * CARREGA LISTA DE EQUIPAMENTOS POR CLIENTE, FILIAL, TIPO PARA RELATÔRIOS
    */
    public function carregarListaEquipamentoFilialTipoRelatorioJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        if($_POST['idCliente'] == ""){
            $idClie = 0;
        }else{
            $idClie = $_POST['idCliente'];
        }

        if($_POST['idCliente'] == ""){
            $idFili = 0;
        }else{
            $idFili = $_POST['idFilial'];
        }

        if($_POST['idTipo'] == ""){
            $idTipo = 0;
        }else{
            $idTipo = $_POST['idTipo'];
        }

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialClienteTipo($idClie, $idFili, $idTipo);

        $tabela         = "";
        $tabela         .="<thead><tr>
                            <th>Equipamento</th>
                            <th>Modelo</th>
                            <th>Cliente</th>
                            <th>local</th>
                            <th class='txt-center'>Monitorar</th>
                            </tr></thead>";

        if(!empty($dadosEquips['status'])){
            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            if($listaEquip){
                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {
                        $tabela         .="<tr>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['tipoEquip'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['nomeModeloEquipamento'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['cliente'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? $equip['filial'] : "Matriz";
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $link       = HOME_URI."/equipamento/gerenciarContatosEquipamentos/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt fa-2x'></i></a>";
                            $tabela         .="</td>";
                        $tabela         .="</tr>";
                    }

                $tabela         .="</tbody>";
            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='5'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }

            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));

        }else{
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }
    }

    /*
    * CARREGA A TELA DE GERENCIAMENTO DE EMAILS PARA O EQUIPAMENTO
    */
    public function gerenciarContatosEquipamentos(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{
            // Define o titulo da pagina
            $this->title = "equipamento";

            // Carrega o modelo para este view
            $modeloEquip   = $this->load_model('equipamento/equipamento-model');
            $modeloClie    = $this->load_model('cliente/cliente-model');

            // Carrega view
             require_once EFIPATH . "/views/_includes/header.php";
             require_once EFIPATH . "/views/_includes/menu.php";
             require_once EFIPATH . "/views/equipamento/equipamentoGerenciarContatos-view.php";
             require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /*
    * CADASTRO DE CONTATO DE EQUIPAMENTO
    */
    public function registrarContatoAlarmeJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo      = $this->load_model('alarme/alarme-model');

        $contatoCadastrado = $alarmeModelo->registraContatoEquipamentoAlarmeJson($_POST['idMatriz'], $_POST['idFilial'], $_POST['idEquipamento'], $_POST['sedeContato'],$_POST['nomeContato'], $_POST['funcaoContato'], $_POST['emailContato'], $_POST['celularContato'], $_POST['obsContato']);

        if($contatoCadastrado['status']){
            exit(json_encode(array('status' => $contatoCadastrado['status'])));
        }else{
            exit(json_encode(array('status' => $contatoCadastrado['status'])));
        }
    }

    /*
    * Função para carregar os dados de um determinado contato via JSON
    */
    public function carregarContatosAlarmesJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo      = $this->load_model('alarme/alarme-model');

        $contatoAlarmes    = $alarmeModelo->carregarContatoEquipamentosAlarmes($_POST['idContato']);

        if($contatoAlarmes['status']){
            exit(json_encode(array('status' => $contatoAlarmes['status'], 'contato' => $contatoAlarmes['contato'][0])));
        }else{
            exit(json_encode(array('status' => $contatoAlarmes['status'])));
        }

    }

    /*
    * Função para remover um contato da lista
    */
    public function removerContatosAlarmesJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo     = $this->load_model('alarme/alarme-model');

        $contatoRemovido  = $alarmeModelo->removerContatoEquipamentoLista($_POST['idContato']);

        if($contatoRemovido['status']){
            exit(json_encode(array('status' => $contatoRemovido['status'])));
        }else{
            exit(json_encode(array('status' => $contatoRemovido['status'])));
        }
    }

    /*
    * Função para efetuar o registro dos dados do contato
    */
    public function salvarEditContatoAlarmeJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $alarmeModelo       = $this->load_model('alarme/alarme-model');

        $contatoAtualizado  = $alarmeModelo->atualizarContatoEquipamento($_POST['idEdit'], $_POST['nomeEdit'], $_POST['funcaoEdit'], $_POST['emailEdit'], $_POST['celularEdit'], $_POST['obserEdit']);

        if($contatoAtualizado['status']){
            exit(json_encode(array('status' => $contatoAtualizado['status'])));
        }else{
            exit(json_encode(array('status' => $contatoAtualizado['status'])));
        }
    }


    /**
    * FUNÇÔES PARA GERENCIMENTO DE CHIPS
    */

    public function gerenciarChips(){

        //CARREGA MODELO PARA ESTA FUNÇÃO
        $equipModelo = $this->load_model('equipamento/equipamento-model');

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "equipamento";

            // Carrega o modelo para este view
            $modelo     = $this->load_model('equipamento/equipamento-model');
            $modeloClie = $this->load_model('cliente/cliente-model');

            // Carrega view
             require_once EFIPATH . "/views/_includes/header.php";
             require_once EFIPATH . "/views/_includes/menu.php";
             require_once EFIPATH . "/views/equipamento/equipamentoGerenciarSim-view.php";
             require_once EFIPATH . "/views/_includes/footer.php";

        }

    }

    /**
    * FUNÇÕES PARA FILTRAGEM DE STATUS DE CHIP SIM
    */
    public function filtroStatusChipJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $listasChip     = $equipeModelo->filtroChipSims($_POST['statusChip']);

        if($listasChip['status']){

            //var_dump( $listasChip['chipsSims']);

            $listaChip = "";

            foreach ($listasChip['chipsSims'] as $chipSim) {

                $cliente   = (isset($chipSim['cliente'])) ? $chipSim['cliente'] : 'Não alocado';

                if(isset($chipSim['cliente'])){
                    $filial = (isset($chipSim['filial'])) ? $chipSim['filial'] : 'Matriz';
                }else{
                    $filial = '';
                }

                $dataTemp1 = explode(" ", $chipSim['data_teste']);
                $data_teste = implode("/", array_reverse(explode('-', $dataTemp1[0])));

                $dataTemp2 = explode(" ", $chipSim['data_instalacao_clie']);
                $data_insta = implode("/", array_reverse(explode('-', $dataTemp2[0])));

                $dataTemp3 = explode(" ", $chipSim['data_desativacao']);
                $data_desa = implode("/", array_reverse(explode('-', $dataTemp3[0])));

                $dataTeste          = $data_teste." ".$dataTemp1[1];
                $dataInstalacao     = $data_insta." ".$dataTemp2[1];
                $dataDesativacao    = $data_desa." ".$dataTemp3[1];

                /*
                <td>
                    ".$chipSim['versao_projeto']."
                </td>
                <td>
                    ".$chipSim['versao_projeto']."
                </td>
                */

                $listaChip .= "<tr>
                                    <td>
                                        ".$chipSim['num_sim']."
                                    </td>
                                    <td>
                                        ".$cliente."
                                    </td>
                                    <td>
                                        ".$filial."
                                    </td>

                                    <td>
                                        ".$dataTeste."
                                    </td>
                                    <td>
                                        ".$dataInstalacao."
                                    </td>
                                    <td>
                                        ".$dataDesativacao."
                                    </td>
                                    <td>
                                        <button class='btn button' onclick='carregarDadosChipSim(".$chipSim['num_sim'].")'>
                                            <i class='fa fa-pencil fa-1x'></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button>
                                            <i class='fa fa-times fa-1x'></i>
                                        </button>
                                    </td>
                                </tr>
                                ";

            }

            exit(json_encode(array('status' => $listasChip['status'], 'chipSims' => $listaChip)));
        }else{
            exit(json_encode(array('status' => $listasChip['status'])));
        }

    }

    /*
    * FUNÇÕES PARA FILTRAGEM DE STATUS DE CHIP E CLIENTE
    */
    public function filtroStatusChipClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $listasChip     = $equipeModelo->filtroChipSimsCliente($_POST['statusChip'], $_POST['idCliente']);

        if($listasChip['status']){

            $listaChip = "";

            foreach ($listasChip['chipsSims'] as $chipSim){

                $cliente   = (isset($chipSim['cliente'])) ? $chipSim['cliente'] : 'Não alocado';

                if(isset($chipSim['cliente'])){
                    $filial = (isset($chipSim['filial'])) ? $chipSim['filial'] : 'Matriz';
                }else{
                    $filial = '';
                }

                $dataTemp1 = explode(" ", $chipSim['data_teste']);
                $data_teste = implode("/", array_reverse(explode('-', $dataTemp1[0])));

                $dataTemp2 = explode(" ", $chipSim['data_instalacao_clie']);
                $data_insta = implode("/", array_reverse(explode('-', $dataTemp2[0])));

                $dataTemp3 = explode(" ", $chipSim['data_desativacao']);
                $data_desa = implode("/", array_reverse(explode('-', $dataTemp3[0])));

                $dataTeste          = $data_teste." ".$dataTemp1[1];
                $dataInstalacao     = $data_insta." ".$dataTemp2[1];
                $dataDesativacao    = $data_desa." ".$dataTemp3[1];

                $listaChip .= "<tr>
                                    <td>
                                        ".$chipSim['num_sim']."
                                    </td>
                                    <td>
                                        ".$cliente."
                                    </td>
                                    <td>
                                        ".$filial."
                                    </td>

                                    <td>
                                        ".$dataTeste."
                                    </td>
                                    <td>
                                        ".$dataInstalacao."
                                    </td>
                                    <td>
                                        ".$dataDesativacao."
                                    </td>
                                    <td>
                                        <button class='btn button' onclick='carregarDadosChipSim(".$chipSim['num_sim'].")'>
                                            <i class='fa fa-pencil fa-1x'></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button>
                                            <i class='fa fa-times fa-1x'></i>
                                        </button>
                                    </td>
                                </tr>
                                ";

            }

            exit(json_encode(array('status' => $listasChip['status'], 'chipSims' => $listaChip)));
        }else{
            exit(json_encode(array('status' => $listasChip['status'])));
        }


    }

    /*
    * CADASTRO DE NOVO CHIP SIM
    */
    public function registrarNovoChipJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $novoSim        = $equipeModelo->cadastrarNovoChipSim($_POST['numeroChip'],$_POST['numeroTelefone'], $_POST['modeloChip'], $_POST['versaoProjeto']);

        if($novoSim['status']){
            exit(json_encode(array('status' => $novoSim['status'])));
        }else{
            exit(json_encode(array('status' => $novoSim['status'])));
        }
    }


    public function carregarDadosSIMJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosChipSim   = $equipeModelo->carregarDadosChipSim($_POST['idChipSim']);

        if($dadosChipSim['status']){

            //$dadosChipSim['informacoesChip'][0]

            $dataAtivacaoTemp       = explode(' ', $dadosChipSim['informacoesChip'][0]['data_instalacao_clie']);
            $dataDesativacaoTemp    = explode(' ', $dadosChipSim['informacoesChip'][0]['data_desativacao']);
            $dataTeste              = explode(' ', $dadosChipSim['informacoesChip'][0]['data_teste']);

            $dataAtivacao       = implode('/', array_reverse(explode('-', $dataAtivacaoTemp[0])))." ".$dataAtivacaoTemp[1];
            $dataDesativacao    = implode('/', array_reverse(explode('-', $dataDesativacaoTemp[0])))." ".$dataDesativacaoTemp[1];
            $dateTestes         = implode('/', array_reverse(explode('-', $dataTeste[0])))." ".$dataTeste[1];

            exit(json_encode(array('status' => $dadosChipSim['status'], 'chipInformacao' => $dadosChipSim['informacoesChip'][0], 'dataTestes' => $dateTestes, 'dataAtivacao' => $dataAtivacao, 'dataDesativacao' => $dataDesativacao)));

        }else{
            exit(json_encode(array('status' => $dadosChipSim['status'])));
        }

    }

    public function atualizarDadosChipJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dataTeste      = explode('/', $_POST['dataTeste']);
        $horaAtual      = date('H:m:s');
        $dataTesteFinal = implode('-', array_reverse($dataTeste))." ".$horaAtual;

        $telefone       = str_replace(" ", "", $_POST['telefoneChip']);

        $chipAtualizado = $equipeModelo->atualizarDadosSimChip($_POST['simChip'], $telefone, $_POST['modeloChip'], $_POST['versaoProjeto'], $dataTesteFinal);

        if($chipAtualizado['status']){

            exit(json_encode(array('status' => $chipAtualizado['status'])));
        }else{

            exit(json_encode(array('status' => $chipAtualizado['status'])));
        }
    }

    /*
    * CARREGA OS DADOS DO EQUIPAMENTO E O POSICIONAMENTO DO EQUIPAMENTO NA TABELA
    */
    public function carregarDadosEquipamentoCalibracao(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "equipamento";

            // Carrega o modelo para este view
            $modelo     = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/equipamento/equipamentoCalibracao-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }

    /*
    * CARREGA O ULTIMO DADO QUE FOI LIDO NA POSICAO DA TABELA INFORMADA
    */
    public function carregarDadosPosicaoTabelaJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $ultimoDado     = $equipeModelo->ultimoDadoenviadoPelaPosicao($_POST['idEquipamento'], $_POST['posicao']);

        //var_dump($ultimoDado);
        /*
        'ultimoDadoPosicao' <font color='#888a85'>=&gt;</font>
            <b>array</b> <i>(size=1)</i>
            'g' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'800'</font> <i>(length=3)</i>
        */

        if($ultimoDado['status']){
            exit(json_encode(array('status' => $ultimoDado['status'], 'ultimoDado' => $ultimoDado['ultimoDadoPosicao'][$_POST['posicao']])));
        }else{
            exit(json_encode(array('status' => $ultimoDado['status'])));
        }

    }

    /*
    * APÓS GERAR O VALOR DE VARIAVEL DE CALIBRAÇÃO, É EFETUADO O REGISTRO NO BANCO DE DADOS
    */
    public function salvarPosicaoTabelaJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo       = $this->load_model('equipamento/equipamento-model');

        $variavelSalva      = null;

        //VERIFICA SE JÁ NÃO EXISTE ALGUMA VARIAVEL DE CALIBRAÇÃO PARA A POSICAO ESPECIFICA DO EQUIPAMENTO

        $variavelExistente  = $equipeModelo->recuperaVariavelExistente($_POST['idEquipamento'], $_POST['posicao']);

        if($variavelExistente['status']){
            //VARIAVEL JÁ EXISTE NO SISTEMA, SERÁ ATUALIZADA

            $idVariavel     = $variavelExistente['idVariavel']['id'];

            $variavelSalva  = $equipeModelo->atualizarVariavelCalibri($idVariavel, $_POST['valorCalibracao']);

        }else{
            //VARIAVEL AINDA NÃO EXISTE NO SISTEMA, SERÀ CADASTRADA UMA NOVA

            $variavelSalva  = $equipeModelo->registraNovaVariavelCalibri($_POST['idEquipamento'], $_POST['posicao'], $_POST['valorCalibracao']);
        }

        //var_dump($variavelSalva);

        if($variavelSalva['status']){
            exit(json_encode(array('status' => $variavelSalva['status'], 'resultado' => $variavelSalva['operatio'])));
        }else{
            exit(json_encode(array('status' => $variavelSalva['status'])));
        }

    }

    /**
    *  FUNÇÃO PARA INICIAR CADASTRO E GERENCIAMENTO DE PLANTA BAIXA
    */
    public function gerenciarPlantaBaixa(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            // Carrega o modelo para este view
            $modeloEquipamento   = $this->load_model('equipamento/equipamento-model');
            $modeloCliente    = $this->load_model('cliente/cliente-model');

            //DEFINE O TITULO DA PAGINA
            $this->title = "equipamento";

            // Carrega o modelo para este view
            $modelo     = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/equipamento/equipamentoPlantaBaixa-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }

    /*
    * LISTA OS EQUIPAMENTOS FILTRADOS POR CLIENTE
    */
    public function listarEquipamentosClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo           = $this->load_model('equipamento/equipamento-model');

        $equipamentosCliente        = $equipeModelo->filtroListaEquipamentos($_POST['idCliente']);
        $estadosEquipamentosCliente = $equipeModelo->ufEquipamentosCliente($_POST['idCliente']);

        //var_dump($estadosEquipamentosCliente);

        if($estadosEquipamentosCliente['status']){

            $listaEstados   = "";
            $listaEstados .="<option value=' '>";
            $listaEstados .= " Selecione...";
            $listaEstados .="</option>";

            $listaArray     = array();

            foreach ($estadosEquipamentosCliente['estados'] as $estado) {

                if(isset($estado['id'])){

                    if(!in_array($estado['id'], $listaArray)){

                        array_push($listaArray, $estado['id']);

                        $listaEstados .="<option value='".$estado['id']."'>";
                            $listaEstados .= $estado['nome'];
                        $listaEstados .="</option>";

                    }

                }elseif(isset($estado['idMatriz'])){

                    if(!in_array($estado['idMatriz'], $listaArray)){

                        array_push($listaArray, $estado['idMatriz']);

                        $listaEstados .="<option value='".$estado['idMatriz']."'>";
                            $listaEstados .= $estado['estadoMatriz'];
                        $listaEstados .="</option>";
                    }

                }

            }

        }

        if($equipamentosCliente['status']){

            //var_dump($equipamentosCliente);
            $table = "";

            foreach ($equipamentosCliente['equipamentos'] as $equipamento) {

                $table .= "<tr>";

                    $table .= "<td>";
                        $table .= $equipamento['tipoEquip'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= "<b>".$equipamento['nomeModeloEquipamento']."</b> / ".$equipamento['fabricante'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= $equipamento['cliente'];
                    $table .= "</td>";

                    $table .= "<td>";
                        if(isset($equipamento['filial'])){
                            $table .= $equipamento['filial'];
                        }else{
                            $table .= 'Matriz';
                        }
                    $table .= "</td>";

                    $table .= "<td>";
                        if(isset($equipamento['id_sim'])){
                            $table .= "<a href='".HOME_URI."/vinculo/vincularEquipamentoSim/".$equipamento['id']."'> ".$equipamento['id_sim']."</a>";
                        }else{
                            $table .= "<a href='".HOME_URI."/vinculo/vincularEquipamentoSim/".$equipamento['id']."'> Vincular N° SIM </a>";
                        }
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/carregarDadosEquipamentoCalibracao/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-wrench '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/configurarEquipamentoCliente/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-gears '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/editarEquipamentoCliente/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-pencil-square-o fa-lg '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= "<button class='btn btnRemoveEquip' value='' onclick='excluirEquipamentoBtn(".$equipamento['id'].")'> <i class='fa fa-times fa-lg '></i> </button>";

                    $table .= "</td>";

                $table .= "</tr>";

            }

            exit(json_encode(array('status' => $equipamentosCliente['status'], 'listaEquipamentos' => $table, 'estados' => $listaEstados)));

        }else{
            exit(json_encode(array('status' => $equipamentosCliente['status'])));
        }

    }

    /*
    * LISTA DE EQUIPAMENTOS COM OU SEM PLANTA CADASTRADA
    */
    public function listarEquipamentosClientePlantaJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo           = $this->load_model('equipamento/equipamento-model');

        $equipamentosCliente        = $equipeModelo->filtroListaEquipamentos($_POST['idCliente']);
        $estadosEquipamentosCliente = $equipeModelo->ufEquipamentosCliente($_POST['idCliente']);

        if($estadosEquipamentosCliente['status']){

            $listaEstados   = "";
            $listaEstados .="<option value=' '>";
            $listaEstados .= " Selecione...";
            $listaEstados .="</option>";

            $listaArray     = array();

            foreach ($estadosEquipamentosCliente['estados'] as $estado) {

                if(isset($estado['id'])){

                    if(!in_array($estado['id'], $listaArray)){

                        array_push($listaArray, $estado['id']);

                        $listaEstados .="<option value='".$estado['id']."'>";
                            $listaEstados .= $estado['nome'];
                        $listaEstados .="</option>";

                    }

                }elseif(isset($estado['idMatriz'])){

                    if(!in_array($estado['idMatriz'], $listaArray)){

                        array_push($listaArray, $estado['idMatriz']);

                        $listaEstados .="<option value='".$estado['idMatriz']."'>";
                            $listaEstados .= $estado['estadoMatriz'];
                        $listaEstados .="</option>";
                    }

                }

            }

        }

        if($equipamentosCliente['status']){

            //var_dump($equipamentosCliente);
            $table = "";

            foreach ($equipamentosCliente['equipamentos'] as $equipamento) {

                $table .= "<tr>";

                    $table .= "<td>";
                        $table .= $equipamento['tipoEquip'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= "<b>".$equipamento['nomeModeloEquipamento']."</b> / ".$equipamento['fabricante'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= $equipamento['cliente'];
                    $table .= "</td>";

                    $table .= "<td>";
                        if(isset($equipamento['filial'])){
                            $table .= $equipamento['filial'];
                        }else{
                            $table .= 'Matriz';
                        }
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/carregarDadosEquipamentoCalibracao/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-map-marker '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/configurarEquipamentoCliente/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-picture-o '></i> </a>";
                    $table .= "</td>";

                $table .= "</tr>";

            }

            exit(json_encode(array('status' => $equipamentosCliente['status'], 'listaEquipamentos' => $table, 'estados' => $listaEstados)));

        }else{

            exit(json_encode(array('status' => $equipamentosCliente['status'])));

        }

    }

    /*
    * LISTA DE EQUIPAMENTOS POR CLIENTES E ESTADOS
    */
    public function listarEquipamentosEstadoClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo           = $this->load_model('equipamento/equipamento-model');

        $equipamentosCliente    = $equipeModelo->filtroListaEquipamentosPorEstado($_POST['idCliente'], $_POST['idEstado']);

        if($equipamentosCliente['status']){

            //var_dump($equipamentosCliente);
            $table = "";

            foreach ($equipamentosCliente['equipamentos'] as $equipamento) {

                $table .= "<tr>";

                    $table .= "<td>";
                        $table .= $equipamento['tipoEquip'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= "<b>".$equipamento['nomeModeloEquipamento']."</b> / ".$equipamento['fabricante'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= $equipamento['cliente'];
                    $table .= "</td>";

                    $table .= "<td>";
                        if(isset($equipamento['filial'])){
                            $table .= $equipamento['filial'];
                        }else{
                            $table .= 'Matriz';
                        }
                    $table .= "</td>";

                    $table .= "<td>";
                        if(isset($equipamento['id_sim'])){
                            $table .= "<a href='".HOME_URI."/vinculo/vincularEquipamentoSim/".$equipamento['id']."'> ".$equipamento['id_sim']."</a>";
                        }else{
                            $table .= "<a href='".HOME_URI."/vinculo/vincularEquipamentoSim/".$equipamento['id']."'> Vincular N° SIM </a>";
                        }
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/carregarDadosEquipamentoCalibracao/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-wrench '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/configurarEquipamentoCliente/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-gears '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/editarEquipamentoCliente/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-pencil-square-o fa-lg '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= "<button class='btn btnRemoveEquip' value='' onclick='excluirEquipamentoBtn(".$equipamento['id'].")'> <i class='fa fa-times fa-lg '></i> </button>";

                    $table .= "</td>";

                $table .= "</tr>";

            }

            exit(json_encode(array('status' => $equipamentosCliente['status'], 'listaEquipamentos' => $table)));

        }else{
            exit(json_encode(array('status' => $equipamentosCliente['status'])));
        }

    }

    /*
    * LISTA OS EQUIPAMENTOS POR CLIENTES E ESTADOS PARA PLANTA BAIXA
    */
    public function listarEquipamentosEstadoClientePlantaJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo           = $this->load_model('equipamento/equipamento-model');

        $equipamentosCliente    = $equipeModelo->filtroListaEquipamentosPorEstado($_POST['idCliente'], $_POST['idEstado']);

        if($equipamentosCliente['status']){

            //var_dump($equipamentosCliente);
            $table = "";

            foreach ($equipamentosCliente['equipamentos'] as $equipamento) {

                $table .= "<tr>";

                    $table .= "<td>";
                        $table .= $equipamento['tipoEquip'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= "<b>".$equipamento['nomeModeloEquipamento']."</b> / ".$equipamento['fabricante'];
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .= $equipamento['cliente'];
                    $table .= "</td>";

                    $table .= "<td>";
                        if(isset($equipamento['filial'])){
                            $table .= $equipamento['filial'];
                        }else{
                            $table .= 'Matriz';
                        }
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/carregarPontosPlantaBaixa/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-map-marker '></i> </a>";
                    $table .= "</td>";

                    $table .= "<td>";
                        $table .=  "<a href='".HOME_URI."/equipamento/configurarPlantaBaixa/".$equipamento['id']."' class='link-tabela-moni'> <i class='fa fa-picture-o '></i> </a>";
                    $table .= "</td>";

                $table .= "</tr>";

            }

            exit(json_encode(array('status' => $equipamentosCliente['status'], 'listaEquipamentos' => $table)));

        }else{

            exit(json_encode(array('status' => $equipamentosCliente['status'])));
        }

    }

    /*
    * CARREGAR DADOS DO TIPO DE EQUIPAMENTO
    */
    public function buscaTipoEquipamentoJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo           = $this->load_model('equipamento/equipamento-model');

        $tipoEquipamento        = $equipeModelo->carregarTipoEquipamento($_POST['idTipoEquipamento']);

        if($tipoEquipamento['status']){

            //var_dump($tipoEquipamento);
            foreach ($tipoEquipamento['tipoEquipamento'] as $tipo){
                $tipoEquip = $tipo['tipo_equipamento'];
            }

            //var_dump($tipoEquip);

            exit(json_encode(array('status' => $tipoEquipamento['status'], 'tipoEquipamento' => $tipoEquip)));

        }else{
            exit(json_encode(array('status' => $tipoEquipamento['status'])));
        }
    }

    /*
    * CARREGAR TELA DE CONFIGURAÇÃO DE PLANTA BAIXA
    */
    public function configurarPlantaBaixa(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            // Carrega o modelo para este view
            $modeloEquipamento   = $this->load_model('equipamento/equipamento-model');
            $modeloCliente    = $this->load_model('cliente/cliente-model');

            //DEFINE O TITULO DA PAGINA
            $this->title = "equipamento";

            // Carrega o modelo para este view
            $modelo     = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/equipamento/equipamentoConfigurarPlantaBaixa-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }


    /*
    * CADASTRAR DADOS DE PLANTA BAIXA
    */
    public function cadastroPlantaBaixa(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo           = $this->load_model('equipamento/equipamento-model');

        //TESTA SE FOI COLOCADO ALGUM ARQUIVO PARA SER SALVO

        if(file_exists($_FILES['file_planta']['tmp_name']) && is_uploaded_file($_FILES['file_planta']['tmp_name'])){

            //EFETUA O UPLOAD DA IMAGEM SELECIONADA
            $arquivoEnviado = $this->upload_plantaBaixa($_FILES, UP_BLUEPRINT_IMG_PATH);

            if($arquivoEnviado['status'] == 'erro'){

                exit(json_encode(array('status' => false, 'mensagem' => $arquivoEnviado['mensagem'])));
            }else{

                $arquivoEnviado = $arquivoEnviado['mensagem'];
            }

        }else{

            $arquivoEnviado = null;

        }

        $cadastrarPlantaJson   = $equipeModelo->cadastrarPlantaJson($_POST['txt_clie'], $_POST['txt_filial'], $_POST['txt_equip'], $_POST['txt_planta'], $arquivoEnviado);

        if($cadastrarPlantaJson['status']){

            exit(json_encode(array('status' => true, 'mensagem' => '')));
        }else{
            exit(json_encode(array('status' => false, 'mensagem' => 'Ocorreu um erro ao tentar atualizar os dados do usuário, favor verificar as informações fornecidas.')));
        }
    }

    /*
    * REMOVER DADOS DE PLANTA BAIXA
    */
    public function removerPlantaJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo           = $this->load_model('equipamento/equipamento-model');

        $removePlanta           = $equipeModelo->removerPLantaBaixa($_POST['idplanta']);

        if($removePlanta['status']){

            //REMOVE TODOS OS PONTOS QUE FORAM CADASTRADOS NESTA PLANTA BAIXA
            $removePonto        = $equipeModelo->removerPontosPlanta($_POST['idplanta']);

            if($_POST['nomeArquivo'] != ''){
                    $this->removeOldAvatar($_POST['nomeArquivo'], UP_BLUEPRINT_IMG_PATH);
            }

            exit(json_encode(array('status' => true, 'mensagem' => '')));
        }else{
            exit(json_encode(array('status' => false, 'mensagem' => 'Ocorreu um erro ao tentar remover planta baixa, favor verificar as informações fornecidas.')));
        }

    }

    /*
    * CARREGAR TELA DE CONFIGURAÇÃO DE PONTOS DO EQUIPAMENTO NA PLANTA BAIXA
    */
    public function carregarPontosPlantaBaixa(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_pe'] != 1 ){

            // Se nao possuir
            // Redireciona para index
            $this->moveHome();

        }else{

            // Carrega o modelo para este view
            $modeloEquipamento   = $this->load_model('equipamento/equipamento-model');
            $modeloCliente    = $this->load_model('cliente/cliente-model');

            //DEFINE O TITULO DA PAGINA
            $this->title = "equipamento";

            // Carrega o modelo para este view
            $modelo     = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/equipamento/equipamentoConfigurarPontosPlantaBaixa-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";


        }
    }

    /*
    * Função para atualizar o posicionamento dos pontos e do equipamento
    */
    public function salvarPontosTabelaJson(){

        // Carrega o modelo para este view
        $modeloEquipamento   = $this->load_model('equipamento/equipamento-model');

        $verificaPosicaoExistente = $modeloEquipamento->verificaPosicionamentoExistente($_POST['idEquip'], $_POST['idPlantaBaixa'], $_POST['idPosicao']);

        if($verificaPosicaoExistente['status']){

            //Apenas atualiza a posicao do ponto
            $pontoRegistrado = $modeloEquipamento->atualizarPosicionamento($_POST['idEquip'], $_POST['idPlantaBaixa'], $_POST['idPosicao'], $_POST['posx'], $_POST['posy']);

            if($pontoRegistrado['status']){
                $resultado = true;
            }else{
                $resultado = false;
            }

        }else{

            //Registra a posicao do ponto

            $pontoRegistrado = $modeloEquipamento->cadastrarPosicionamento($_POST['idEquip'], $_POST['idPlantaBaixa'], $_POST['idPosicao'], $_POST['posx'], $_POST['posy']);

            if($pontoRegistrado['status']){
                $resultado = true;
            }else{
                $resultado = false;
            }

        }

        if($resultado){
            exit(json_encode(array('status' => $resultado)));

        }else{

            exit(json_encode(array('status' => $resultado)));
        }
    }
}

?>
