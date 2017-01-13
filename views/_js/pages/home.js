//Ajustes iniciais da página de cadastro
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

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

});
