
//Ajustes iniciais da página de cadastro
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

$().ready(function() {


});


/*
* FUNÇÃO PARA APLICAR NOS FILTRO
* PRINCIPALMENTE NA TELA DE MONITORAMENTO, RELATÔRIO GRÁFICO E RELATÔRIO ESTATÍSTICO
*/

$('#filtroClienteLista').change(function() {

    var idCliente = $(this).val();

    if(idCliente != ''){
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
* FILTRAR EQUIPAMENTOS DE ACORDO COM O CLIENTE, FILIAL E O TIPO DE EQUIPAMENTO
*/
$('#filtroEquipLista').change(function() {

    var idTipoEquip = $(this).val();
    var idCliente   = $('#filtroClienteLista').val();
    var idFilial    = $('#filtroLocalLista').val();

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
