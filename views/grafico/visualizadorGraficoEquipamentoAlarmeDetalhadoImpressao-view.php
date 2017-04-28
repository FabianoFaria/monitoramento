<?php

    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();

    // Require composer autoload
    require_once EFIPATH.'/classes/mpdf/mpdf.php';

    /*
    * EFETUA O TRATAMENTO DOS PARAMETROS DE DATA_INICIO_REL
    */
    $dataInicio     = implode("-", array_reverse(explode(",",($this->parametros[2]))));
    $dataFim        = implode("-", array_reverse(explode(",",($this->parametros[3]))));

    /*
    * PREPARA OS DADOS PARA SEREM EXIBIDOS NO PDF
    */
    $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

    //EQUIPAMENTO ESPECIFICADO
    if($dadosCliente['status']){
        $dadosCliente   = $dadosCliente['dados'][0];
        $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[1]);
        $lista          = $lista['equipamento'];
        $nomeCliente    = $dadosCliente['nome'];
        $nomeUnidade    = (isset($lista[0]['filial'])) ? $lista[0]['filial'] :"Matriz";
    }else{
        $lista          = false;
    }

    //RECUPERA O TOTAL DE ALARMES REGISTRADOS DURANTE O PERIOODO, PARA O EQUIPAMENTO SELECIONADO
    //TOTAL DE ALARMES DO EQUIPAMENTO
    $totalAlarmes  = 0;
    $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($lista[0]['id'], $dataInicio, $dataFim);

    if($alarmesGeral['status']){

        $totalAlarmes = $alarmesGeral['alarmes'][0]['total'];
    }

    $alarmEquip    = $modeloAlarme->recuperaAlarmesEquipamento($lista[0]['id'], $dataInicio, $dataFim);


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
    $stylesheet = HOME_URI.'/views/_css/bootstrap.min.css';
    //$cert       = HOME_URI.'/views/certificado/wwwmonitoreficazsystemcombr.pem';

    function http_get_contents($url)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_TIMEOUT, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_getinfo($ch);
      /*
         curl_setopt($ch, CURLOPT_CAINFO, $cert);
        curl_setopt($ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $postResult = curl_exec($ch);

        if (curl_errno($ch)) {
         print curl_error($ch);
        }
        curl_close($ch);
      */

      if(FALSE === ($retval = curl_exec($ch))) {
        error_log(curl_error($ch));
      } else {
        return $retval;
      }
    }

    $htmlRealatorio .="<style>";
    $htmlRealatorio .= $style;
    $htmlRealatorio .="</style>";

    $htmlRealatorio .="<div class='row'>";
        $htmlRealatorio .="<div class='col-md-12'>";

            $htmlRealatorio .="<div class='panel panel-default'>";
                $htmlRealatorio .="<div class='panel-heading'>";
                $htmlRealatorio .="<h4 class='text-header'>Eficaz System - sistema de monitoramento InfraWeb.</h4>";
                $htmlRealatorio .="</div>";
                $htmlRealatorio .="<div class='panel-body'>";
                    $htmlRealatorio .="<h4><small>Relatório de alarmes detalhados gerados pelos equipamento selecionado.</small></h4>";
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
                    $htmlRealatorio .="<h6> Unidade : ".$nomeUnidade." </h6>";

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
                            $htmlRealatorio .="<p class='text-header'>Alarmes gerados pelo equipamento : $totalAlarmes</p>";

                        $htmlRealatorio .="</div>";

                    $htmlRealatorio .="</div>";

                $htmlRealatorio .="</div>";

            $htmlRealatorio .="</div>";

        $htmlRealatorio .="</div>";
    $htmlRealatorio .="</div>";

    $htmlRealatorio .="<div class='col-md-12'>";

        $htmlRealatorio .="<table id='stream_table' class='table table-striped table-bordered'>";
            $htmlRealatorio .="<tbody>";

                if($alarmEquip['status']){

                    foreach ($alarmEquip['equipAlarm'] as $alarm) {

                        $htmlRealatorio .="<tr>";

                            $htmlRealatorio .="<td>";
                                $htmlRealatorio .="<div class='row'>";

                                    $htmlRealatorio .="<div class='col-md-12'>";

                                        $htmlRealatorio .="<table class='table table-condensed'>";
                                            $htmlRealatorio .="<tbody>";

                                                $htmlRealatorio .="<tr>";

                                                    $htmlRealatorio .="<td>";
                                                        $dataAlarme = explode(" ", $alarm['dt_criacao']);

                                                        $msgAlarm   = $alarm['mensagem'];
                                                        $dataAlarm  = implode("/",array_reverse(explode("-", $dataAlarme[0])));

                                                        $htmlRealatorio .="<p><b>Data :</b> $dataAlarm</p>";
                                                        $htmlRealatorio .="<p><b>Horário :</b>  $dataAlarme[1]</p>";
                                                        $htmlRealatorio .="<p><b>Alerta :</b> $msgAlarm</p>";

                                                        $statusAlarm = "";
                                                        switch ($alarm['status_ativo']){
                                                            case '1':
                                                                $statusAlarm = " Novo";
                                                            break;
                                                            case '2':
                                                                $statusAlarm = " Visualizado";
                                                            break;
                                                            case '3':
                                                                $statusAlarm = " Em tratamento";
                                                            break;
                                                            case '4':
                                                                $statusAlarm = " Solucionado";
                                                            break;

                                                            default:
                                                                $statusAlarm = " Finalizado";
                                                            break;
                                                        }

                                                        $htmlRealatorio .="<p><b>Status :</b> $statusAlarm</p>";

                                                    $htmlRealatorio .="</td>";

                                                    $htmlRealatorio .="<td>";
                                                    $htmlRealatorio .="</td>";

                                                    $htmlRealatorio .="<td>";

                                                        $parametro  = $alarm['parametro'];

                                                        $htmlRealatorio .="<p><b>Parametro :</b> $parametro</p>";

                                                        $pontoAlarme  = $this->verificarPontoTabela($alarm['pontoTabela']);

                                                        $htmlRealatorio .="<p><b>Ponto :</b> $pontoAlarme </p>";

                                                            $medidaAlarm = "";
                                                            switch ($alarm['parametroMedido']){
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

                                                                    $medidaAlarm = "<span class='text-danger'>".$alarm['parametroMedido']." (V)</span> / <span class='text-primary'>".$alarm['parametroAtingido']." (V) </span>";
                                                                break;
                                                            }

                                                        $htmlRealatorio .="<p class='text-rigth'><b>Medida :</b> $medidaAlarm</p>";
                                                    $htmlRealatorio .="</td>";

                                                $htmlRealatorio .="</tr>";

                                            $htmlRealatorio .="</tbody>";
                                        $htmlRealatorio .="</table>";

                                    $htmlRealatorio .="</div>";

                                $htmlRealatorio .="</div>";

                                $htmlRealatorio .="<div class='row'>";

                                    $htmlRealatorio .="<div class='col-md-12'>";

                                        $htmlRealatorio .="<table class='table  table-bordered'>";

                                            $htmlRealatorio .="<thead>";
                                                $htmlRealatorio .="<tr>";
                                                    $htmlRealatorio .="<th>Data tratamento</th>";
                                                    $htmlRealatorio .="<th>Tratamento</th>";
                                                    $htmlRealatorio .="<th>Usuário</th>";
                                                $htmlRealatorio .="</tr>";
                                            $htmlRealatorio .="</thead>";

                                            $htmlRealatorio .="<tbody>";

                                                //CARREGA OS TRATAMENTOS REGISTRADOS PARA O ALARME
                                                $tratamentosAlarme = $modeloAlarme->carregaTratamentosAlarme($alarm['alertId']);

                                                if($tratamentosAlarme['status']){

                                                    foreach ($tratamentosAlarme['alarmTrat'] as $tratamento){

                                                        $htmlRealatorio .="<tr>";

                                                            $htmlRealatorio .="<td>";
                                                                $dataAlarmeTrat = explode(" ", $tratamento['data_tratamento']);

                                                                $dataTrat = implode("/",array_reverse(explode("-", $dataAlarmeTrat[0])))." <br />".$dataAlarmeTrat[1];

                                                                $htmlRealatorio .= $dataTrat;

                                                            $htmlRealatorio .="</td>";

                                                            $htmlRealatorio .="<td>";
                                                                $htmlRealatorio .= $tratamento['tratamento_aplicado'];
                                                            $htmlRealatorio .="</td>";

                                                            $htmlRealatorio .="<td>";

                                                                $usuarioTrat    = $tratamento['nome']." ".$tratamento['sobrenome'];
                                                                $htmlRealatorio .= $usuarioTrat;
                                                            $htmlRealatorio .="</td>";

                                                        $htmlRealatorio .="</tr>";
                                                    }
                                                }


                                                //CASO O ALARME TENHA SIDO FINALIZADO
                                                if(isset($alarm['tratamento_aplicado'])){
                                                    $htmlRealatorio .="<tr>";

                                                        $htmlRealatorio .="<td>";

                                                            if(isset($alarm['dt_fechamento'])){

                                                                $dataAlarmeTrat = explode(" ", $alarm['dt_fechamento']);

                                                                $dataTrat = implode("/",array_reverse(explode("-", $dataAlarmeTrat[0])))." <br />".$dataAlarmeTrat[1];

                                                                $htmlRealatorio .= $dataTrat;
                                                            }

                                                        $htmlRealatorio .="</td>";

                                                        $htmlRealatorio .="<td>";

                                                            $htmlRealatorio .=  $alarm['tratamento_aplicado'];

                                                        $htmlRealatorio .="</td>";

                                                        $htmlRealatorio .="<td>";

                                                            $htmlRealatorio .=  $alarm['usr_nome']." ".$alarm['sobrenome'];

                                                        $htmlRealatorio .="</td>";

                                                    $htmlRealatorio .="</tr>";
                                                }

                                            $htmlRealatorio .="</tbody>";

                                        $htmlRealatorio .="</table>";

                                    $htmlRealatorio .="</div>";

                                $htmlRealatorio .="</div>";

                            $htmlRealatorio .="</td>";

                        $htmlRealatorio .="</tr>";
                    }
                }

            $htmlRealatorio .="</tbody>";
        $htmlRealatorio .="</table>";


    $htmlRealatorio .="</div>";





    //FIM DO HTML
    $htmlRealatorio .= "</body>";
    $htmlRealatorio .= "</html>";


    //Create an instance of the class:
    $mpdf = new mPDF();

    $mpdf->SetTitle('Relatorio cliente ');

    $url = $stylesheet;

    $streamSSL = stream_context_create(array(
        "ssl"=>array(
            "cafile" => $cert,
            "verify_peer"=> true,
            "verify_peer_name"=> true
        )
    ));

    //var_dump(http_get_contents($stylesheet));
    //var_dump($stylesheet);

    // Write some HTML code:
    $mpdf->WriteHTML(http_get_contents($stylesheet),1);
    $mpdf->WriteHTML($htmlRealatorio,2);

    // Output a PDF file directly to the browser
    $mpdf->Output('relatorio_cliente.pdf', 'I');

?>
