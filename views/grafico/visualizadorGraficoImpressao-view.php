<?php
    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();


    // Require composer autoload
    require_once EFIPATH.'/classes/mpdf/mpdf.php';


    /*
    * Prepara os dados para serem exibidos no PDF
    */
    $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

    if($dadosCliente['status']){
        $dadosCliente   = $dadosCliente['dados'][0];
        $lista          = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);
        $lista          = $lista['equipamentos'];
        $nomeCliente    = $dadosCliente['nome'];
    }else{
        $lista          = false;
    }

    /*
    * EFETUA O TRATAMENTO DOS PARAMETROS DE DATA_INICIO_REL
    */
    $dataInicio     = implode("-", array_reverse(explode(",",($this->parametros[1]))));
    $dataFim        = implode("-", array_reverse(explode(",",($this->parametros[2]))));

    //RECUPERA O TOTAL DE ALARMES REGISTRADOS DURANTE O PERIOODO
    $totalAlertas       = 0;
    $totalEquipamentos  = $modeloAlarme->totalEquipamentosClientes($this->parametros[0]);

    if($totalEquipamentos['status']){

        $equipamentos = $totalEquipamentos['equipamentos'];

        //var_dump(count($equipamentos));
        foreach ($equipamentos as $equipamento){

            $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($equipamento['id_equipamento'], $dataInicio, $dataFim);

            if($alarmesGeral['status']){
                //EFETUA A SOMA DE ALERTAS GERADOS
                $totalAlertas = $totalAlertas + $alarmesGeral['alarmes'][0]['total'];


            }
            //EXIBE MEDIDADS MINIMAS E MAXIMAS REGISTRADAS PELO(S) EQUIPAMENTO(S).

        }

    }

    /*
    * INICIO DA CONSTRUÇÂO DO HTML
    */
    $htmlRealatorio = "<html>";
    $htmlRealatorio .= "<head>";
    $htmlRealatorio .= "<title>";
    $htmlRealatorio .= "";
    $htmlRealatorio .= "</title>";
    $htmlRealatorio .= "</head>";
    $htmlRealatorio .= "<body>";

    //CSS DA(S) PÁGINA HTML
    $stylesheet = file_get_contents(HOME_URI.'/views/_css/bootstrap.css');

    $htmlRealatorio .="<div class='row'>";
        $htmlRealatorio .="<div class='col-md-12'>";

            $htmlRealatorio .="<div class='panel panel-default'>";
                $htmlRealatorio .="<div class='panel-heading'>";
                $htmlRealatorio .="<h4 class='text-header'>Eficaz System - sistema de monitoramento.</h4>";
                $htmlRealatorio .="</div>";
                $htmlRealatorio .="<div class='panel-body'>";
                    $htmlRealatorio .="<h4><small>Relatôrio de alarmes gerados pelos equipamentos do cliente.</small></h4>";
                $htmlRealatorio .="</div>";
            $htmlRealatorio .="</div>";


        $htmlRealatorio .="</div>";
    $htmlRealatorio .="</div>";

    //Inicio da página, contem informações do sistema
    $htmlRealatorio .="<div class='row'>";
        $htmlRealatorio .="<div class='col-md-12'>";

            $htmlRealatorio .="<div class='panel panel-default'>";

                $htmlRealatorio .="<div class='panel-heading'>";
                    $htmlRealatorio .="<h5> Cliente : ".$nomeCliente." </h5>";

                    $htmlRealatorio .="<div class='col-md-4 pull-right'>";
                        $htmlRealatorio .="<h4><small> Periodo :".implode("/", array_reverse(explode("-",($dataInicio))))." até ".implode("/", array_reverse(explode("-",($dataFim))))."</small></h4>";
                    $htmlRealatorio .="</div>";

                $htmlRealatorio .="</div>";

                $htmlRealatorio .="<div class='panel-body'>";

                    $htmlRealatorio .="<div class='panel panel-default'>";

                        $htmlRealatorio .="<div class='panel-heading'>";
                            $htmlRealatorio .="Totais de alarmes";
                        $htmlRealatorio .="</div>";

                        $htmlRealatorio .="<div class='panel-body'>";
                            $htmlRealatorio .=$totalAlertas;;
                        $htmlRealatorio .="</div>";

                    $htmlRealatorio .="</div>";

                $htmlRealatorio .="</div>";

            $htmlRealatorio .="</div>";

        $htmlRealatorio .="</div>";
    $htmlRealatorio .="</div>";

    //VERIFICAÇÃO SE EXISTEM EQUIPAMENTOS PARA EXIBIR
    if($totalEquipamentos['status']){

        $htmlRealatorio .="<div class='row'>";
            $htmlRealatorio .="<div class='col-md-12'>";
                $htmlRealatorio .="<h4 class='text-header'>Lista de equipamentos </h4>";
            $htmlRealatorio .="</div>";
        $htmlRealatorio .="</div>";

        //INICIO DAS ESTATISTICAS DOS EQUIPAMENTOS

        $htmlRealatorio .="<div class='row'>";
            $htmlRealatorio .="<div class='col-md-12'>";


                //FOREACH PARA EXIBIÇÃO DOS EQUIPAMENTOS
                foreach ($equipamentos as $equipamento){

                    if(isset($equipamento['nomeEquipamento'])){

                        $htmlRealatorio .="<div class='panel panel-default'>";

                            $htmlRealatorio .="<div class='panel-heading'>";
                                $htmlRealatorio .= $equipamento['tipo_equipamento']." ".$equipamento['nomeEquipamento']." ".$equipamento['modelo'];
                            $htmlRealatorio .="</div>";

                            $htmlRealatorio .="<div class='panel-body'>";

                            //MONTA A TABELA COM OS ALARMES GERADOS PELO EQUIPAMENTO
                            $htmlRealatorio .="<div class='row'>";

                            //TOTAL DE ALARMES DO EQUIPAMENTO
                            $totalAlarmes  = 0;
                            $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($equipamento['id_equipamento'], $dataInicio, $dataFim);

                            if($alarmesGeral['status']){

                                $totalAlarmes = $alarmesGeral['alarmes'][0]['total'];
                            }

                            $alarmEquip    = $modeloAlarme->recuperaAlarmesEquipamento($equipamento['id_equipamento'], $dataInicio, $dataFim);

                            //INICIO DA TABELA
                            $htmlRealatorio .="<div class='col-md-12'>";

                                $htmlRealatorio .="<p class='text-header'>Alarmes gerados pelo equipamento :".$totalAlarmes."</p>";

                                $htmlRealatorio .="<table id='stream_table' class='table table-striped table-bordered'>";

                                $htmlRealatorio .="<thead>
                                                <tr>
                                                    <th>Data Origem</th>
                                                    <th>Status</th>
                                                    <th>Mensagem</th>
                                                    <th>Parametro</th>
                                                    <th>Medida</th>
                                                    <th>Tratamento</th>
                                                </tr>
                                            </thead>";

                                $htmlRealatorio .= "<tbody>";

                                    if($alarmEquip['status']){
                                        foreach ($alarmEquip['equipAlarm'] as $alarm) {

                                            //var_dump($alarm);
                                            $htmlRealatorio .= "<tr>";
                                                $htmlRealatorio .= "<td>";

                                                    $dataAlarme = explode(" ", $alarm['dt_criacao']);

                                                    $htmlRealatorio .= implode("/",array_reverse(explode("-", $dataAlarme[0])))." ".$dataAlarme[1];

                                                $htmlRealatorio .= "</td>";
                                                $htmlRealatorio .= "<td>";

                                                    switch ($alarm['status_ativo']){
                                                        case '1':
                                                            $htmlRealatorio .= "<p> Novo</p>";
                                                        break;
                                                        case '2':
                                                            $htmlRealatorio .= "<p> Visualizado</p>";
                                                        break;
                                                        case '3':
                                                            $htmlRealatorio .= "<p> Em tratamento</p>";
                                                        break;
                                                        case '4':
                                                            $htmlRealatorio .= "<p> Solucionado</p>";
                                                        break;

                                                        default:
                                                            $htmlRealatorio .= "<p> Finalizado</p>";
                                                        break;
                                                    }

                                                $htmlRealatorio .= "</td>";
                                                $htmlRealatorio .= "<td>";
                                                    $htmlRealatorio .= $alarm['mensagem'];
                                                $htmlRealatorio .= "</td>";
                                                $htmlRealatorio .= "<td>";
                                                    $htmlRealatorio .= $alarm['parametro'];
                                                $htmlRealatorio .= "</td>";
                                                $htmlRealatorio .= "<td>";
                                                    $htmlRealatorio .= "<span class='text-danger'>".$alarm['parametroMedido']."</span> / <span class='text-primary'> ".$alarm['parametroAtingido']."</span>";
                                                $htmlRealatorio .= "</td>";
                                                $htmlRealatorio .= "<td>";
                                                    $htmlRealatorio .= (isset($alarm['tratamento_aplicado'])) ? $alarm['tratamento_aplicado'] : "";
                                                $htmlRealatorio .= "</td>";
                                            $htmlRealatorio .= "<tr>";


                                        }
                                    }

                                    $htmlRealatorio .= "</tbody>";

                                $htmlRealatorio .="</table>";


                            $htmlRealatorio .="</div>";


                            $htmlRealatorio .="</div>";

                        $htmlRealatorio .="</div>";

                        $htmlRealatorio .="</div>";
                    }
                }

            $htmlRealatorio .="</div>";
        $htmlRealatorio .="</div>";

    }else{


        $htmlRealatorio .="<div class='row'>";
            $htmlRealatorio .="<div class='col-md-12'>";
                $htmlRealatorio .="<h4 class='text-header'>Nenhum equipamento para listar no momento. </h4>";
            $htmlRealatorio .="</div>";
        $htmlRealatorio .="</div>";

    }


    //FIM DO HTML
    $htmlRealatorio .= "</body>";
    $htmlRealatorio .= "</html>";


    //Create an instance of the class:

    $mpdf = new mPDF();

    $mpdf->SetTitle('Relatorio cliente ');

    // Write some HTML code:
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($htmlRealatorio,2);

    // Output a PDF file directly to the browser
    $mpdf->Output('relatorio_cliente.pdf', 'I');

?>
