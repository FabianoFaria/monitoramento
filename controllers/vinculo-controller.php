<?php

/**
 * Classe de controle que gerencia
 * o model e a view do vinculo
 */
class VinculoController extends MainController
{
    /**
     * Funcao que gerencia o index do vinculo
     */
    public function index()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vinculo";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculo-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /*
    * Função para listar vinculos de um cliente
    */
    public function gerenciarVinculo(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "vinculo";

            // Carrega o modelo
            $modeloCliente  = $this->load_model('cliente/cliente-model');
            $modelo         = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }


    }


    /*
    * Função para registrar vinculo para cliente especifico
    */
    public function cadastrarVinculo()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }else{
            // Define o titulo da pagina
            $this->title = "vinculo";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo         = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vincularClienteSim-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }
    }

    /**
     * Funcao que gerencia o vinculo do
     * equipamento ou ambiente ao sim
     */
    public function vincular ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if($_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular Equipamento";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincular-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia o vinculo de sim ao cliente
     */
    public function vincularsim ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular SIM";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincularSim-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia o vinculo
     * do equipamento e sim a uma tabela
     */
    public function vincularposicao ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular Posi&ccedil;&atilde;o";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincularPosicao-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia todos os equipamentos
     * esperando vinculo na tabela
     */
    public function equipamentolista ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular Posi&ccedil;&atilde;o";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincularLista-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }


    /*
    * Função para carregar a tela de vinculo do equipamento com o SIM
    */
    public function vincularEquipamentoSim()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "vinculo";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo         = $this->load_model('equipamento/equipamento-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vincularSimEquipamento-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /*
    * Função para registrar vinculo entre SIM e cliente via JSON
    */

    public function registrarVinculoClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $vinculoModelo      = $this->load_model('vinculo/vinculo-model');

        $vinculoRegistrado  = $vinculoModelo->cadastrarVinculoCliente($_POST['idCliente'],$_POST['idFilial'],$_POST['num_sim'], $_POST['ambiente']);

        if($vinculoRegistrado['status']){
            exit(json_encode(array('status' => $vinculoRegistrado['status'])));
        }else{
            exit(json_encode(array('status' => $vinculoRegistrado['status'])));
        }

    }

    /*
    * Função para registrar o vinculo entre um equipamento e um SIM
    */
    public function registrarVinculoEquipamentoJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $vinculoModelo      = $this->load_model('vinculo/vinculo-model');
        $equipModel         = $this->load_model('equipamento/equipamento-model');

        //VERIFICAR SE HÁ POSIÇÕES DISPONIVEIS NA TABELA DE MONITORAMENTO DO NÚMERO SIM ESCOLHIDO

        $posicoesOcupadas                   = $vinculoModelo->posicoesOcupadas($_POST['simVinculado']);
        $posicoesEquipamentoParaVincular    = $vinculoModelo->posicoesEquipamentoVincular($_POST['idEquipamento']);
        $posicionamentoViavel               = null;

        //var_dump($posicoesOcupadas);

        if($posicoesOcupadas['status']){
            //foram encontradas posições ocupadas na tabela, efetuara verificação
            if($posicoesEquipamentoParaVincular['status']){
                $posParaOcupar  = explode(',',$posicoesEquipamentoParaVincular['posicoes'][0]['posicoes_tabela']);
                $posOcupada     = array();

                //Conparar as posições ocupadas com as posições para ocupar
                foreach ($posicoesOcupadas['posicoes_ocupadas'] as $posicao) {
                    //array_push($posOcupada, $posicao['posicao']);

                    /*
                    * CASO O POSICIONAMENTO NÃO SEJA VIAVEL, SERÁ RETORNADO FALSE, POIS NÃO HÁ ESPAÇO NA TABELA ALOCADO PARA O SIM
                    */

                    if(in_array($posicao['posicao'], $posParaOcupar)){
                        //var_dump ("Posicoes para vincular já estão ocupadas!".$posicao['posicao']);
                        $posicionamentoViavel   = false;
                    }else{
                        $posicionamentoViavel   = true;
                    }
                }

            }else{
                //Implementar condição de erro
                $posicionamentoViavel   = false;
            }


        }else{

            //Não foram encontradas posições na tabela seguir com a alocação de posições
            $posicionamentoViavel       = true;
        }

        // Testar se o SIM para vincular já não está com as posições necessarias ocupadas
        if($posicionamentoViavel){

            //INICIA O PROCESSO DE VINCULO COM A TABELA

            $vinculoEquipamento = $vinculoModelo->cadastrarVinculoEquipamento($_POST['idEquipamento'], $_POST['simVinculado'], $_POST['ambiente']);

            if($vinculoEquipamento['status']){

                // CARREGA O POSICIONAMENTO QUE O EQUIPAMENTO OCUPARA NA TABELA
                $posicionamentoTabela = $equipModel->carregarPosicaoTabela($_POST['tipoEquipamento']);

                if($posicionamentoTabela['status']){

                    //EFETUA O REGISTRO DE POSICIONAMENTO DO EQUIPAMENTO NA TABELA

                    $posicaoEquipamento = $posicionamentoTabela['equipamento'][0];

                    $posicoes   = explode(',',$posicaoEquipamento['posicoes_tabela']);

                    for($i=0; $i < count($posicoes); $i++){
                        //echo('<p>'.$posicoes[$i].'</p>');
                        $registraPosicao = $equipModel->registroPosicao($vinculoEquipamento['id_sim_equipamento'], $_POST['simVinculado'], $posicoes[$i]);

                    }

                    //VERIFICAR POSSIBILIDADE DE REGISTRAR NA TABELA SIM O VINCULO NA TABELA

                }

                exit(json_encode(array('status' => $vinculoEquipamento['status'], 'msg' => 'Vínculo registrado corretamente.')));

            }else{
                exit(json_encode(array('status' => $vinculoEquipamento['status'], 'msg' => 'Ocorreu um erro ao tentar vincular posição na tabela, verifique os dados enviados.')));
            }


        }else{
            exit(json_encode(array('status' => false, 'msg' => 'Não há posições na tabela para vincular este equipamento')));
        }

    }


    /*
    * Efetua a consulta das posições ocpadas na tabela pelo número SIM informado
    */
    public function  posicoesOcupadasTabela(){

        if(is_numeric($_POST['numeroSim'])){

            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $vinculoModelo      = $this->load_model('vinculo/vinculo-model');

            $posicoesOcupadas   = $vinculoModelo->posicoesOcupadas($_POST['numeroSim']);

            if($posicoesOcupadas['status']){

                //Montagem de parte da tabela
                $html = "";
                foreach ($posicoesOcupadas['posicoes_ocupadas'] as $posicao) {
                $html .= "<button class='btn btn-default'><span>".$posicao['posicao']." </span></button>";
                }
                $html .= "";

                exit(json_encode(array('status' => true, 'html' => $html)));

            }else{
                exit(json_encode(array('status' => false, 'html' => "<tr><td colspan='2'>SIM informado não possui posições ocupadas na tabela! </td></tr>")));
            }

        }else{
            exit(json_encode(array('status' => false, 'html' => "<tr><td colspan='2'>Sim informado não está correto!</td></tr>")));
        }

    }

    /*
    * RECUPERA A LISTA DE SIMS QUE FORAM CADASTRADOS PARA DETERMINADA FILIAL
    */
    public function  carregarListaSimFilialJson(){

        if(is_numeric($_POST['idCliente'])){

            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $vinculoModelo  = $this->load_model('vinculo/vinculo-model');

            $dadosSims      = $vinculoModelo->listarSimsFilialClienteTipo($_POST['idCliente'], $_POST['idFilial']);

            if($dadosSims['status']){

                //MONTA A TABELA DE EQUIPAMENTOS
                $listaSim         = $dadosSims['sims'];

                $tabela         = "";
                $tabela         .="<thead><tr>
                                    <th>Cliente</th>
                                    <th>Local</th>
                                    <th>Sim</th>
                                    <th>Ocupação do Sim</th>
                                    <th class='txt-center'>Excluir</th>
                                    </tr></thead>";
                if($dadosSims['status']){
                    $tabela         .="<tbody>";
                        foreach ($listaSim as $sim) {

                            $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=$sim['cliente'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$sim['filial'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$sim['num_sim'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                //$link       = HOME_URI."/vinculo/graficoFisicoParametrosEquipamentoCliente/".$sim['num_sim']."";
                                $tabela     .= "<a href='javascript:void(0)' onClick='detalhesPosicao(".$sim['num_sim'].")'><i class='fa fa-list-alt fa-2x'></i></a>";
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                //$link       = HOME_URI."/vinculo/graficoFisicoParametrosEquipamentoCliente/".$sim['num_sim']."";
                                $tabela     .= "<a href='javascript:void(0)' onClick='removerSim(".$sim['num_sim'].")'><i class='fa fa-times fa-lg'></i></a>";
                            $tabela         .="</td>";

                            $tabela         .="</tr>";
                        }
                    $tabela         .="</tbody>";

                }else{
                    $tabela         .="<tbody>";
                        $tabela         .="<tr>";
                            $tabela         .="<td colspan='4'>Nenhum SIM cadastrado até o momento</td>";
                        $tabela         .="</tr>";
                    $tabela         .="</tbody>";


                }

                exit(json_encode(array('status' => true, 'html' => $tabela)));

            }else{
                //GERA TABELA VAZIA
                $tabela         ="<thead><tr>
                                    <th>Cliente</th>
                                    <th>Local</th>
                                    <th>Sim</th>
                                    <th>Ocupação do Sim</th>
                                    <th class='txt-center'>Excluir</th>
                                    </tr></thead>";
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum SIM cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";

                exit(json_encode(array('status' => false, 'html' => $tabela)));
            }


        }
    }

    /*
    * REMOVE SIM DA LISTA DE ATIVOS
    */
    public function removerVinculoSim(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $vinculoModelo      = $this->load_model('vinculo/vinculo-model');

        $vinculoRemovido  = $vinculoModelo->removerVinculoCliente($_POST['numeroSim']);

        if($vinculoRemovido['status']){
            exit(json_encode(array('status' => $vinculoRemovido['status'])));
        }else{
            exit(json_encode(array('status' => $vinculoRemovido['status'])));
        }
    }

    /*
    * VERIFICA SE SIM EXISTE E ESTÁ ATIVO NO SISTEMA
    */
    public function verificarSimExistente(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $vinculoModelo      = $this->load_model('vinculo/vinculo-model');

        $vinculoExistente   = $vinculoModelo->verificarSimExistente($_POST['num_sim']);

        if($vinculoExistente['status']){
            // false DE EXISTENTE, LOGO IMPROPIO PARA SEGUIR
            echo json_encode(false);
        }else{
            //TRUE DE NÚMERO SIM NÃO EXISTENTE, CADASTRO PODE SEGUIR
            echo json_encode(true);
        }


    }
}


?>
