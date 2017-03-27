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
        $equipModelo    = $this->load_model('equipamento/equipamento-model');

        $dadosEquipamento   = $equipModelo->detalhesEquipamentoParaConfiguracao($_POST['idEquipamento']);

        $idSimEquipamento       = $dadosEquipamento[0]['id'];
        $numeroSimEquipamento   = $dadosEquipamento[0]['id_sim'];

        $removerEquip       = $equipModelo->removerEquipamentoViaJson($_POST['idEquipamento']);

        if($removerEquip){

            //REMOVE OS PARAMETROS CADASTRADOS PARA O EQUIPAMENTO
            $removerParamEquip = $equipModelo->removerParametrosEquipamentoViaJson($_POST['idEquipamento']);

            //REMOVE DA TABELA DE POSIÇÕES AS POSIÇÕES OCUPADAS NO EQUIPAMENTO PELO SIM
            $removePosicoesEquipamento  = $equipModelo->removerPosicoesTabelaEquipamentoViaJson($idSimEquipamento, $numeroSimEquipamento);

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

}

?>
