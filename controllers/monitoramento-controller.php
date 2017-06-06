<?php

/**
 * Classe de controle que gerencia o model
 * e a view do monitoramento
 */
class MonitoramentoController extends MainController
{
    /**
     * Funcao que gerencia a index do monitoramento
     */
    public function index ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo         = $this->load_model('monitoramento/monitoramento-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/monitoramento/monitoramento-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }


    /**
     * unidades
     *
     * Funcao que monta a lista da matriz e suas filiais
     *
     * @accss public
     */
    public function unidades ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo         = $this->load_model('monitoramento/monitoramento-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/monitoramento/monitoramentoListaFilial-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }


    /**
     * listaEquipamento
     *
     * Funcao que monta a lista de equipamento da unidade ou matriz
     *
     * @accss public
     */
    public function listaEquipamento ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo = $this->load_model('monitoramento/monitoramento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/monitoramento/monitoramentoListaEquipamento-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }



    /**
     * Funcao de Gerador de grafico
     * mostra o grafico de barra ou analogico
     */
    public function gerarGrafico ()
    {
        // Verifica se esta login
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo         = $this->load_model('monitoramento/monitoramento-model');
        // Carrega os dados do equipamento
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');
        // Carrega os dados do cliente
        $modeloClie     = $this->load_model('cliente/cliente-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";

        // Carrega a lista inicial de dados do grafico linha
        require_once EFIPATH . "/classes/sincronizacaoGrafico/listaInicial.php";

        // Inicia class da Lista inical
        //ESTE METODO TAMBEM PASSOU POR REFORMULAÇÕES
        // $limite     = 30;
        //$listaIni   = new ListaInicial($limite, $this->db, $this->parametros);

        // Carregando a view
        //require_once EFIPATH . "/views/monitoramento/monitoramentoGerarGrafico-view_back_up.php";
        require_once EFIPATH . "/views/monitoramento/monitoramentoGerarGrafico-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }


    /*
    * FUNÇÃO PARA CARREGAR LISTA DE EQUIPAMENTOS PARA EXIBIÇÃO DE PLANTA BAIXA
    */
    public function equipamentoPlantaBaixa(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_mo'] != 1 ){
            // SE NAO POSSUIR
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "monitoramento";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo
            $modelo         = $this->load_model('monitoramento/monitoramento-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/monitoramento/monitoramentoListaEquipamentoPlanta-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }

    public function monitorarPlantaBaixa(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_mo'] != 1 ){
            // SE NAO POSSUIR
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "monitoramento";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo
            $modelo         = $this->load_model('monitoramento/monitoramento-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/monitoramento/monitoramentoListaVisualizarEquipamentoPlantaBaixa-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }
    }

    /*
    * CARREGA A ÚLTIMA LEITURA DO EQUIPAMENTO NO PONTO ESPECIFICADO
    */
    public function carregarUltimoDadoPosicaoPlantaBaixaJson(){

        $equipModel     = $this->load_model('equipamento/equipamento-model');
        $alarmeModelo   = $this->load_model('alarme/alarme-model');
        $monitoraModelo = $this->load_model('monitoramento/monitoramento-model');

        $idEquip        = $_POST['idEquip'];
        $idSim          = $_POST['idSim'];
        $idSimEquip     = $_POST['idSimEquip'];
        $pontoRecebido  = $_POST['pontoEquip'];
        $tipoEquip      = $_POST['tipoEquip'];

        //$equipInfo      = $equipModel->;

        /*
        * VERIFICA SE FOI PASSADO UM PONTO VÁLIDO, OU O EQUIPAMENTO MESTRE
        */
        if($pontoRecebido != 'mestre'){

            //Verifica o tipo de equipamento
            switch ($tipoEquip) {
                case 'Medidor temperatura':
                    $pontoTabela = "Medidor de temperatura ".strtoupper($pontoRecebido);
                break;
                default:
                    $pontoTabela  = $this->verificarPontoTabela($pontoRecebido);
                break;
            }

            /*
            * CARREGA VARIAVEL DE CALIBRACAO DA POSICAO SOLICITADA
            */
            $variavelCalibracao     = $alarmeModelo->carregarVariavelCalibracao($idSimEquip, $pontoRecebido);

            //var_dump($idSim, $pontoRecebido);

            if(isset($variavelCalibracao[0])){

                $parametro    = $variavelCalibracao[0]['variavel_cal'];

            }else{
                $parametro    = 1;
            }

            /*
            * ÚLTIMA LEITURA DO EQUIPAMENTO
            */
            // O tratamento é efetuado com a variavel de calibracao
            $ultimaLeitura          = $alarmeModelo->recuperacaoUltimaLeituraEquip($idSim, $pontoRecebido);

            if($ultimaLeitura['status']){

                $ultimaLeituraValor     = $ultimaLeitura['equipAlarm'][0]['medida'] * $parametro;

                $protocoloPassado       = $this->verificaProtocoloPosicaoTebela($ultimaLeituraValor);

                if(!is_numeric($protocoloPassado)){
                    $ultimaLeituraValor = 0;
                }

                $f = sprintf ("%.2f", $ultimaLeituraValor);

                //Verifica o tipo de Equipamento
                switch ($tipoEquip) {
                    case 'Medidor temperatura':

                        /*
                            Carrega os parametros de alarme
                        */
                        $parametrosAlarmeEquip = $monitoraModelo->loadGraficoParamMedidorTemp($idEquip, $idSimEquip, $idSim);

                        if(!empty($parametrosAlarmeEquip)){

                            $leitura    = number_format(($ultimaLeituraValor / 100) ,2 ,'.','');

                            //var_dump($parametrosAlarmeEquip);
                            if($leitura < $parametrosAlarmeEquip[0]){

                                $leitura = "<div class='percent-current lead'> <p class='text-danger'>".$leitura." (C°)</p></div>";

                            }else if($leitura < $parametrosAlarmeEquip[1]){

                                $leitura = "<div class='percent-current lead'> <p class='text-warning'>".$leitura." (C°)</p></div>";

                            }else if($leitura > $parametrosAlarmeEquip[4]){

                                $leitura = "<div class='percent-current lead'> <p class='text-danger'>".$leitura." (C°)</p></div>";

                            }else if(($leitura > $parametrosAlarmeEquip[3]) && ($leitura < $parametrosAlarmeEquip[4]) ){

                                $leitura = "<div class='percent-current lead'> <p class='text-warning'>".$leitura." (C°)</p></div>";

                            }else{
                                $leitura = "<div class='percent-current lead'> <p class='text-success'>".$leitura." (C°)</p></div>";
                            }

                        }else{
                            $leitura = "<div class='percent-current lead'> <p class='text-success'>".number_format(($ultimaLeituraValor / 100) ,2 ,'.','')." (C°)</p></div>";
                        }

                        // $leitura = "<div class='tg-thermometer small' style='height: 120px'>";
                        //     $leitura .= " <div class='draw-a'></div>";
                        //     $leitura .= " <div class='draw-b'></div>";
                        //     $leitura .= "<div class='meter'>";
                        //         $leitura .= "<div class='statistics'>";
                        //             $leitura .= "<div class='percent percent-a'>100 c°</div>";
                        //             $leitura .= "<div class='percent percent-b'>75 c°</div>";
                        //             $leitura .= "<div class='percent percent-c'>50 c°</div>";
                        //             $leitura .= "<div class='percent percent-d'>25 c°</div>";
                        //             $leitura .= "<div class='percent percent-e'>0 c°</div>";
                        //         $leitura .= "</div>";
                        //     $leitura .= "</div>";

                            //$leitura .= "<div class='mercury' style='height: ".number_format(($ultimaLeituraValor / 100) ,2 ,'.','')."%'>";
                            //    $leitura = "<div class='percent-current'>".number_format(($ultimaLeituraValor / 100) ,2 ,'.','')." (C°)</div>";
                        //         $leitura .= "<div class='mask'>";
                        //             $leitura .= "<div class='bg-color'></div>";
                        //         $leitura .= "</div>";
                        //     $leitura .= "</div>";
                        //
                        // $leitura .= "</div>";

                    break;

                    default:
                        $leituraTemp =  $this->configurarTipoPontoTabela($pontoRecebido, number_format($ultimaLeituraValor ,2 ,'.',''));

                        $leitura = "<div class='percent-current lead'> <p class='text-primary'>".$leituraTemp." </p></div>";
                    break;
                }

                exit(json_encode(array('status' => true, 'dados' => $leitura)));

            }else{

                $leitura = "<div class='percent-current lead'> <p class='text-danger'>Não recebeu.</p></div>";

                exit(json_encode(array('status' => false, 'dados' => $leitura)));
            }

        }else{

            /*
            * EXIBE INFORMAÇÕES DO ULTIMO DADO DO MESTRE MESTRE
            */

        	$dataAtual = date('Y-m-d H:i:s');

            //$dadoRecebido = ultimoDadoRecebido($equipamento['id']);
            $dadoRecebido          = $alarmeModelo->recuperacaoUltimaLeituraEquip($idSim, 'num_sim');

            //var_dump($dadoRecebido);

            if($dadoRecebido['status']){

                foreach ($dadoRecebido['equipAlarm'] as $dados){

                    $dataDado = $dados['dt_criacao'];

                    $totalMinutos = round((time() - strtotime($dataDado)) / 60);

                    // if($totalMinutos > 10){
                    //     $leitura = "Não está recebendo.";
                    //
                    //     exit(json_encode(array('status' => false, 'dados' => $leitura)));
                    // }else{
                         $leitura = "Equipamento ok!";
                    //
                        exit(json_encode(array('status' => false, 'dados' => $leitura)));
                    // }
                }

            }else{
                $leitura = "Não recebeu.";

                exit(json_encode(array('status' => false, 'dados' => $leitura)));
            }
        }

    }

    /*
    * VERIFICA SE NÃO FOI PASSADO UM PROTOCOLO NO LUGAR DO VALOR
    */
    public function verificaProtocoloPosicaoTebela($valor){

        require_once EFIPATH."/protocolosDisponiveis.php";

        //Procura na array de protocolos o valor passado pela função, $protocolos já se encontra no arquivo do required
        if (array_key_exists($valor,$protocolos)){
            //Retorna o valor da array em caso o valor tenha sido retornado um dos protocolos
            return $protocolos[$valor];
        }else{
            return 1;
        }
    }

}

?>
