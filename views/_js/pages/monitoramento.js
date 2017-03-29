
//Ajustes iniciais da página de cadastro
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

$().ready(function() {


});

/*
* FUNÇÃO PARA LIMPAR FILTROS
*/
$('#limparFiltro').click(function(){
    window.location.replace(urlP +"/eficazmonitor/monitoramento/");
});

/*
* FUNÇÃO PARA APLICAR NOS FILTRO
* PRINCIPALMENTE NA TELA DE MONITORAMENTO, RELATÔRIO GRÁFICO E RELATÔRIO ESTATÍSTICO
*/

$('#filtroClienteLista').change(function() {

    var idCliente = $(this).val();

    if(idCliente != ''){

        $('#filtroLocalAutoComplete').val("");

        //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
        $.ajax({
            url: urlP+"/eficazmonitor/cliente/carregarListaFilialClienteJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
                'idCliente' : idCliente
            },
            success : function(datra)
            {
                if(datra.status){

                    /*
                    * PREENCHE O SELECT ALVO
                    */
                    $('#filtroLocalLista').html(datra.filiais);

                    /*
                    * PREENCHE TABELA COM EQUIPAMENTOS
                    */
                    $('#listaMonitoria').html(datra.equipamentos);

                    /*
                    * RETIRA O VALOR DO ID DE FILIAL
                    */
                    $('#localId').val(0);

                }else{
                    $('#filtroLocalLista').html(datra.filiais);
                    // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                    $('#listaMonitoria').html(datra.equipamentos);
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {

                //Settar a mensagem de erro!
                      // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                    swal("Oops...", "Ocorreu um erro ao carregar as filiais, favor verificar os dados informados!", "error");
             // Handle errors here
             console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
             // STOP LOADING SPINNER
            }
        });

    }else{
        $('#filtroLocalLista').html("<option value=''> Selecione...</option>");
    }


});

/*
* FILTRA OS EQUIPAMENTOS DE ACORDO COM A ESCOLHA DO LOCAL
*/
$('#filtroLocalLista').change(function() {

    var idFilial    = $(this).val();
    var idCliente   = $('#filtroClienteLista').val();

    if(idFilial != ''){

        //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
        $.ajax({
            url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
                'idCliente' : idCliente,
                'idFilial' : idFilial
            },
            success : function(datra)
            {
                if(datra.status){

                    /*
                    * PREENCHE TABELA COM EQUIPAMENTOS
                    */
                    $('#listaMonitoria').html(datra.equipamentos);
                    $('#localId').html(idFilial);

                }else{

                    // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                    $('#listaMonitoria').html(datra.equipamentos);
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {

                //Settar a mensagem de erro!
                    // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                    swal("Oops...", "Ocorreu um erro ao carregar os equipamentos, favor verificar os dados informados!", "error");
             // Handle errors here
             console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
             // STOP LOADING SPINNER
            }
        });

    }else{
        $('#filtroEquipLista').html("<option value=''> Selecione...</option>");
    }

});

/*
* FILTRA OS LOCAIS ATRAVES DE AUTO COMPLETE
*/
 $("#filtroLocalAutoComplete")
   // don't navigate away from the field on tab when selecting an item
   .on( "keydown", function( event ) {

     var idClie = $('#filtroClienteLista').val();

     /*
     * VERIFICA SE FOI SELECIONADO UM CLIENTE
     */
     if(idClie != ''){
         if ( event.keyCode === $.ui.keyCode.TAB &&
             $( this ).autocomplete( "instance" ).menu.active ) {
           event.preventDefault();
         }
     }else{
        swal('','Selecione um cliente antes!','info');
     }
     /*
     * RETORNA OS EQUIPAMENTOS DA MATRIZ
     */
    //  if(){
    //      console.log('Chamando a matriz');
    //  } IMPLEMENTAR

   })
   .autocomplete({
     source: function( request, response ) {
       $.getJSON( urlP+"/eficazmonitor/cliente/carregarListaFilialAutoCompleteJson/?filtroClie="+ $("#filtroClienteLista").val(), {
         term: extractLast( request.term )
       }, response
   );
     },
     search: function() {
       // custom minLength
       var term = extractLast( this.value );
       if ( term.length < 2 ) {
         return false;
       }
     },
     focus: function() {
       // prevent value inserted on focus
       return false;
     },
     select: function( event, ui ) {

        $('#localId').val(ui.item.id);

        //GERA A TABELA DE EQUIPAMENTOS CONFORME O LOCAL ESCOLHIDO
        var idFilial    = ui.item.id;
        var idCliente   = $('#filtroClienteLista').val();

        if(idFilial != ''){
            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialJson",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'idCliente' : idCliente,
                    'idFilial' : idFilial
                },
                success : function(datra)
                {
                    if(datra.status){

                        /*
                        * PREENCHE TABELA COM EQUIPAMENTOS
                        */
                        $('#listaMonitoria').html(datra.equipamentos);

                    }else{

                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                        $('#listaMonitoria').html(datra.equipamentos);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    //Settar a mensagem de erro!
                    // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                    swal("Oops...", "Ocorreu um erro ao carregar os equipamentos, favor verificar os dados informados!", "error");
                     // Handle errors here
                     console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                     // STOP LOADING SPINNER
                }
            });
        }
    }
 });

/* FUNÇÕES ADICIONAIS DE AUTOCOMPLETE
*/
function split( val ) {
  return val.split( /,\s*/ );
}
function extractLast( term ) {
  return split( term ).pop();
}

/*
* FILTRAR EQUIPAMENTOS DE ACORDO COM O CLIENTE, FILIAL E O TIPO DE EQUIPAMENTO
*/
$('#filtroEquipLista').change(function() {

    var idTipoEquip = $(this).val();
    var idCliente   = $('#filtroClienteLista').val();
    var idFilial    = $('#localId').val();

    if(idTipoEquip != ''){
        //EFETUA O CARREGAMENTO DOS DADOS DOS EQUIPAMENTOS POR TIPO
        $.ajax({
            url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialTipoJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
                'idCliente': idCliente,
                'idFilial' : idFilial,
                'idTipo'   : idTipoEquip
            },
            success : function(datra)
            {
                if(datra.status){

                    /*
                    * PREENCHE TABELA COM EQUIPAMENTOS
                    */
                    $('#listaMonitoria').html(datra.equipamentos);

                }else{

                    // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                    $('#listaMonitoria').html(datra.equipamentos);
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {

                //Settar a mensagem de erro!
                    // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                    swal("Oops...", "Ocorreu um erro ao carregar os equipamentos, favor verificar os dados informados!", "error");
             // Handle errors here
             console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
             // STOP LOADING SPINNER
            }
        });

    }

});
