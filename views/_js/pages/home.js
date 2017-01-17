//Ajustes iniciais da página de cadastro
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

function detalharAlarme(idAlarme){

    //Inicia a coleta de dados do alarme para preparação para exibição
    $.ajax({
        url: urlP+"/eficazmonitor/alarme/carregarDetalhesAlarmeJson",
        secureuri: false,
        type : "POST",
        dataType: 'json',
        data      : {
          'idAlarme' : idAlarme
      },
      success : function(datra)
       {
          //tempTest = JSON(datra);
          if(datra.status == true)
          {
              $('#statusAlarme').html(datra.statusAlarme);
              $('#dataGeracao').html(datra.dataAlarme+ ' '+datra.horaAlarme);
              $('#dataVizualizacao').html(datra.dataVisualizada);

              $('#nomeCliente').html(datra.cliente['nome']);

              if(datra.filial == ''){
                   $('#localAlarme').html('Matriz');
              }else{
                   $('#localAlarme').html(datra.filial[0]['nome']);
              }

            //   //DETALHES ALARME
            //  $('#limiteAlarme').html(datra.alarme['0']);
            //  $('#informacaoesAlarme').html(datra.alarme['1']);
            var statusAtual = datra.alarme['status_ativo'];

            $('#statusAlarmeModal').val(statusAtual);
            //$("#statusAlarmeModal > select > option[value=" + statusAtual + "]").prop("selected",true);

            $('#tratamentoAlarme').html(datra.alarme['tratamento_aplicado']);
            //MEDIDAS QUE GERARAM O ALAtmlRME
            $('#tipoMedida').html(datra.alarme['parametro']);
            $('#medidaOriginal').html(datra.alarme['parametroMedido']);
            $('#ultimaMedida').html('Não recebido ainda.');

            $('#idAlarme').val(idAlarme);

            $('#detalhesAlarme').modal({
                    backdrop: 'static',
                    keyboard: false
            });

          }
          else
          {
            swal("", "Ocorreu um erro ao tentar recuperar os dados do alarme. Favor tentar novamente.", "error");
          }
       },
      error: function(jqXHR, textStatus, errorThrown)
      {
        // Handle errors here
        console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
        // STOP LOADING SPINNER
      }

    });
}




$().ready(function() {

    /*
    * Efetua verificação a cada X segundos para verificar novos alarmes
    */
    // var interval = setInterval(function() {
    //     $.getJSON(urlP+"/eficazmonitor/alarme/listarNovosAlarmesJson",,function(response){
    //         $('.stat1').css({'color': response.status1});
    //         $('.stat2').css({'color': response.status2});
    //         ...
    //     });
    // }, 5000);

    /*
    * Salva o tratamento dado ao alarme, muda o status para vizualizado
    */

    $('#validarResponsavel').click(function(){

        var idAlarme    = $('#idAlarme').val();
        var tratAlarme  = $('#tratamentoAlarme').val();
        var statusAlarme = $('#statusAlarmeModal').val();

        //console.log('teste' + idAlarme);

        $('#solucaoAplicada').validate({
            rules: {
                tratamentoAlarme: {
                    required : true
                },
                statusAlarmeModal : {
                    required : true
                }
            },
            messages: {
                tratamentoAlarme: {
                    required : "Campo obrigatório"
                },
                statusAlarmeModal : {
                    required : "Campo obrigatório"
                }
            }
        });

        if($('#solucaoAplicada').valid()){

            $.ajax({
                url: urlP+"/eficazmonitor/alarme/salvarTratamentoAlarmeJson",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                  'idAlarme' : idAlarme,
                  'msgTrat'  : tratAlarme,
                  'statusAlm' : statusAlarme
              },
              success : function(datra)
               {
                   if(datra.status){
                       swal('','Tratamento registrado, verifica o estado do equipamento para confirmar a resolução do alarme', 'info');
                       $('#detalhesAlarme').modal('hide');

                       setTimeout(function(){
                           location.reload();
                       }, 2000);
                   }else{

                       swal('','Ocorreu um problema ao tentar registrar o tratamento, faveor verificar os dados informados','error');
                       $('#detalhesAlarme').modal('hide');
                   }

               },
              error: function(jqXHR, textStatus, errorThrown)
              {
                // Handle errors here
                console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                // STOP LOADING SPINNER
              }
            });

        }

    });

});
