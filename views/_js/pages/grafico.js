//AJUSTES INICIAIS DA PÁGINA DE CADASTRO
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

/*
* FUNÇÃO PARA VALIDAR SE PELO MENOS UM PARAMETRO FOI SELECIONADO
*/
function geraGrafico(link)
{
    // Coleta os dados do checkbox
    var entr1t = $("#chk_entrada_r1t").is(":checked");
    var ents1t = $("#chk_entrada_s1t").is(":checked");
    var entt1t = $("#chk_entrada_t1t").is(":checked");
    var entr1c = $("#chk_entrada_r1c").is(":checked");
    var ents1c = $("#chk_entrada_s1c").is(":checked");
    var entt1c = $("#chk_entrada_t1c").is(":checked");

    var entr1tc = $("#chk_entrada_r1tc").is(":checked");
    var ents1tc = $("#chk_entrada_s1tc").is(":checked");
    var entt1tc = $("#chk_entrada_t1tc").is(":checked");
    var entr1cc = $("#chk_entrada_r1cc").is(":checked");
    var ents1cc = $("#chk_entrada_s1cc").is(":checked");
    var entt1cc = $("#chk_entrada_t1cc").is(":checked");
    var batent = $("#bat_entrada_r1tc").is(":checked");

    //VARIAVEIS DE COLETA DE TEMPERATURA
    var tempAmb     = $("#temp_ambiente").is(":checked");
    var tempBanco   = $("#temp_banco_bat").is(":checked");


    /*
        COLETA AS DATAS INFORMADAS
    */
    var from    = $("#data_inicio_rel").val().split("/");
    var dataIni = from[2]+"-"+from[1]+"-"+from[0];

    var to    = $("#data_fim_rel").val().split("/");
    var dataFim = to[2]+"-"+to[1]+"-"+to[0];

    /*
        COLETA OS HORÁRIOS INFORMADOS
    */
    var horasDas    = $("#timepickerOne").val();
    var horasAte    = $("#timepickerTwo").val();

    if (!entr1t) entr1t = 0; else entr1t = 1;
    if (!ents1t) ents1t = 0; else ents1t = 1;
    if (!entt1t) entt1t = 0; else entt1t = 1;
    if (!entr1c) entr1c = 0; else entr1c = 1;
    if (!ents1c) ents1c = 0; else ents1c = 1;
    if (!entt1c) entt1c = 0; else entt1c = 1;

    if (!entr1tc) entr1tc = 0; else entr1tc = 1;
    if (!ents1tc) ents1tc = 0; else ents1tc = 1;
    if (!entt1tc) entt1tc = 0; else entt1tc = 1;
    if (!entr1cc) entr1cc = 0; else entr1cc = 1;
    if (!ents1cc) ents1cc = 0; else ents1cc = 1;
    if (!entt1cc) entt1cc = 0; else entt1cc = 1;
    if (!batent) batent = 0; else batent = 1;

    if (!tempAmb) tempAmb = 0; else tempAmb = 1;
    if (!tempBanco) tempBanco = 0; else tempBanco = 1;

    var url = entr1t + "," + ents1t + "," + entt1t + "," + entr1c + "," + ents1c + "," + entt1c+ "," + entr1tc + "," + ents1tc + "," + entt1tc + "," + entr1cc + "," + ents1cc + "," + entt1cc + "," + batent +","+tempAmb+","+tempBanco+ "," + dataIni + "," + dataFim + ","+ horasDas +","+horasAte;
    window.location.href = link + url;

}

function gerarGraficoFisico(){

}

/*
* Adiciona datapicker ao formulario de data
*/
var options = {
    dayNamesMin: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
    monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
    maxDate: "+0y +0m +0d",
    mindate: "-1y -6m",
    changeMonth: true,
    changeYear: true,
    yearRange: "c-1:c+1",
    monthRange: "c-6:c+0",
    dateFormat: "dd/mm/yy"
}

 $("#data_inicio_relatorio").datepicker(options);
 $("#data_fim_relatorio").datepicker(options);
 $("#data_inicio_rel").datepicker(options);
 $("#data_fim_rel").datepicker(options);

$().ready(function() {

    //TORNA OBRIGATORIO INFORMAR DATA AO FORMULARIO DE RELATORIO

    $('#data_inicio_relatorio').mask('99/99/9999');
    $('#data_fim_relatorio').mask('99/99/9999');

    $('#data_inicio_rel').mask('99/99/9999');
    $('#data_fim_rel').mask('99/99/9999');


    //OptionsPicker
    var optionsPicker = {
        twentyFour: true,
        upArrow: 'wickedpicker__controls__control-up',
        downArrow: 'wickedpicker__controls__control-down',
        title: 'Horário escolhido',
        now: "00:00"
    }
    var optionsPickerTwo = {
        twentyFour: true,
        upArrow: 'wickedpicker__controls__control-up',
        downArrow: 'wickedpicker__controls__control-down',
        title: 'Horário escolhido',
        now: "23:59"
    }

    // DATA PICKER
    $('#timepickerOne').wickedpicker(optionsPicker);
    $('#timepickerTwo').wickedpicker(optionsPickerTwo);


    //TRATA os daderar os dados para gerar o gráfico

    $('#btn_gerarGrafico').click(function(){

        	$("#formularioGeradorGrafico").validate({

                rules: {

                    data_fim_rel : {
                        required : true,
                        dateBR : true,
                        greaterThan : "#data_inicio_rel"
                    },
                    timepickerTwo : {
                        diferencaHorarios : "#timepickerOne"
                    },
                    data_inicio_rel : {
                        required : true,
                        dateBR : true
                    }
                },
                messages: {

                    data_fim_rel : {
                        required : "Campo obrigatôrio.",
                        dateBR : "Favor informar uma data válida!",
                        greaterThan : "Data final deve ser maior que a data inicial!"
                    },
                    timepickerTwo :{
                        diferencaHorarios : "Horário final deve ter pelo menos 10 minutos de diferença."
                    },
                    data_inicio_rel : {
                        required : "Campo obrigatôrio.",
                        dateBR : "Favor informar uma data válida!"
                    }
                }

        	});

            if($("#formularioGeradorGrafico").valid()){

                //Valida se pelo menos um parametro foi selecionado!
                var geraGraficoParam = $('#geraGrafico').val();
                var checkboxs=document.getElementsByName("parametrosGraficos");
                var okay=false;
                for(var i=0,l=checkboxs.length;i<l;i++)
                {
                    if(checkboxs[i].checked)
                    {
                        okay=true;
                        break;
                    }
                }
                if(okay)geraGrafico(geraGraficoParam);
                else $('#nadaSelecionado').modal();

            }

    });

    //TRATA as datas que servirão de parametros para relatorio

    $('#confirmParametros').click(function(){

        $("#periodoRelatorio").validate({

            rules: {

                data_fim_relatorio : {
                    required : true,
                    dateBR : true,
                    greaterThan : "#data_inicio_relatorio"
                },
                data_inicio_relatorio : {
                    required : true,
                    dateBR : true
                }
            },
            messages: {

                data_fim_relatorio : {
                    required : "Campo obrigatôrio.",
                    dateBR : "Favor informar uma data válida!",
                    greaterThan : "Data final deve ser maior que a data inicial!"
                },
                data_inicio_relatorio : {
                    required : "Campo obrigatôrio.",
                    dateBR : "Favor informar uma data válida!"
                }
            }

        });

        if($("#periodoRelatorio").valid()){

            var idClient    = $('#idcliente').val();

            var from    = $("#data_inicio_relatorio").val().split("/");
            var dataIni = from[2]+"-"+from[1]+"-"+from[0];

            var to    = $("#data_fim_relatorio").val().split("/");
            var dataFim = to[2]+"-"+to[1]+"-"+to[0];


            //Concatena os parametros em uma string e passa para o link
            var url     = idClient+"/"+from+"/"+to;
            var link    = urlP+"/eficazmonitor/grafico/gerarRelatorioCliente/"
            window.location.href = link + url;

        }
    });

    /*
    * FUNÇÃO PARA TRATAR OS PARAMETROS E GERAR ESTATISTICAS DO EQUIPAMENTO
    */

    $('#confirmParametrosRelatorioEquipamento').click(function(){
        $("#periodoRelatorio").validate({

            rules: {

                data_fim_relatorio : {
                    required : true,
                    dateBR : true,
                    greaterThan : "#data_inicio_relatorio"
                },
                data_inicio_relatorio : {
                    required : true,
                    dateBR : true
                }
            },
            messages: {

                data_fim_relatorio : {
                    required : "Campo obrigatôrio.",
                    dateBR : "Favor informar uma data válida!",
                    greaterThan : "Data final deve ser maior que a data inicial!"
                },
                data_inicio_relatorio : {
                    required : "Campo obrigatôrio.",
                    dateBR : "Favor informar uma data válida!"
                }
            }

        });

        if($("#periodoRelatorio").valid()){

            var idClient    = $('#idcliente').val();
            var idEquip     = $('#idEquip').val();

            var from    = $("#data_inicio_relatorio").val().split("/");
            var dataIni = from[2]+"-"+from[1]+"-"+from[0];

            var to    = $("#data_fim_relatorio").val().split("/");
            var dataFim = to[2]+"-"+to[1]+"-"+to[0];

            //Concatena os parametros em uma string e passa para o link
            var url     = idClient+"/"+idEquip+"/"+from+"/"+to;
            var link    = urlP+"/eficazmonitor/grafico/gerarRelatorioEquipamentoCliente/"
            window.location.href = link + url;

        }


    });

    /*
    * FUNÇÃO PARA TRATAR OS PARAMETROS E GERAR DETALHES DOS ALARMES DO EQUIPAMENTO
    */
    $('#confirmParametrosRelatorioDetalharAlarmeEquipamento').click(function(){
        $("#periodoRelatorio").validate({

            rules: {

                data_fim_relatorio : {
                    required : true,
                    dateBR : true,
                    greaterThan : "#data_inicio_relatorio"
                },
                data_inicio_relatorio : {
                    required : true,
                    dateBR : true
                }
            },
            messages: {

                data_fim_relatorio : {
                    required : "Campo obrigatôrio.",
                    dateBR : "Favor informar uma data válida!",
                    greaterThan : "Data final deve ser maior que a data inicial!"
                },
                data_inicio_relatorio : {
                    required : "Campo obrigatôrio.",
                    dateBR : "Favor informar uma data válida!"
                }
            }

        });

        if($("#periodoRelatorio").valid()){

            var idClient    = $('#idcliente').val();
            var idEquip     = $('#idEquip').val();

            var from    = $("#data_inicio_relatorio").val().split("/");
            var dataIni = from[2]+"-"+from[1]+"-"+from[0];

            var to    = $("#data_fim_relatorio").val().split("/");
            var dataFim = to[2]+"-"+to[1]+"-"+to[0];

            //Concatena os parametros em uma string e passa para o link
            var url     = idClient+"/"+idEquip+"/"+from+"/"+to;
            var link    = urlP+"/eficazmonitor/grafico/gerarRelatorioAlarmeDetalheEquipamentoCliente/"
            window.location.href = link + url;

        }

    });

    /*
    * FUNÇÃO PARA LIMPAR FILTROS
    */
    $('#limparFiltro').click(function(){
        window.location.href(urlP +"/grafico/");
    });

    /*
    * FUNÇÃO PARA FILTRAR POR CLIENTES
    */
    $('#filtroClienteLista').change(function() {

        var idCliente = $(this).val();

        if(idCliente != ''){

            $('#filtroLocalAutoComplete').val("");

            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaFilialClienteRelatoriosJson",
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
                        //$('#filtroLocalAutoComplete').html(datra.filiais);

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
                        //$('#filtroLocalAutoComplete').html(datra.filiais);
                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                        $('#listaMonitoria').html(datra.equipamentos);
                        $('#localId').val(0);
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
    * DEMANDA AS FUNÇÕES SPLIT E AUTOCOMPLETE
    */
    // $("#filtroLocalAutoComplete")
    //   // don't navigate away from the field on tab when selecting an item
    //   .on( "keydown", function( event ) {
    //
    //     var idClie = $('#filtroClienteLista').val();
    //
    //     /*
    //     * VERIFICA SE FOI SELECIONADO UM CLIENTE
    //     */
    //     if(idClie != ''){
    //         if ( event.keyCode === $.ui.keyCode.TAB &&
    //             $( this ).autocomplete( "instance" ).menu.active ) {
    //           event.preventDefault();
    //         }
    //     }else{
    //        swal('','Selecione um cliente antes!','info');
    //     }
    //     /*
    //     * RETORNA OS EQUIPAMENTOS DA MATRIZ
    //     */
    //    //  if(){
    //    //      console.log('Chamando a matriz');
    //    //  } IMPLEMENTAR
    //
    //   })
    //   .autocomplete({
    //     source: function( request, response ) {
    //       $.getJSON( urlP+"/eficazmonitor/cliente/carregarListaFilialAutoCompleteJson/?filtroClie="+ $("#filtroClienteLista").val(), {
    //         term: extractLast( request.term )
    //       }, response
    //   );
    //     },
    //     search: function() {
    //       // custom minLength
    //       var term = extractLast( this.value );
    //       if ( term.length < 2 ) {
    //         return false;
    //       }
    //     },
    //     focus: function() {
    //       // prevent value inserted on focus
    //       return false;
    //     },
    //     select: function( event, ui ) {
    //
    //        $('#localId').val(ui.item.id);
    //
    //        //GERA A TABELA DE EQUIPAMENTOS CONFORME O LOCAL ESCOLHIDO
    //        var idFilial    = ui.item.id;
    //        var idCliente   = $('#filtroClienteLista').val();
    //
    //        if(idFilial != ''){
    //            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
    //            $.ajax({
    //                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialRelatoriosJson",
    //                secureuri: false,
    //                type : "POST",
    //                dataType: 'json',
    //                data      : {
    //                    'idCliente' : idCliente,
    //                    'idFilial' : idFilial
    //                },
    //                success : function(datra)
    //                {
    //                    if(datra.status){
    //
    //                        /*
    //                        * PREENCHE TABELA COM EQUIPAMENTOS
    //                        */
    //                        $('#listaMonitoria').html(datra.equipamentos);
    //
    //                    }else{
    //
    //                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
    //                        $('#listaMonitoria').html(datra.equipamentos);
    //                    }
    //
    //                },
    //                error: function(jqXHR, textStatus, errorThrown)
    //                {
    //                    //Settar a mensagem de erro!
    //                    // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
    //                    swal("Oops...", "Ocorreu um erro ao carregar os equipamentos, favor verificar os dados informados!", "error");
    //                     // Handle errors here
    //                     console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
    //                     // STOP LOADING SPINNER
    //                }
    //            });
    //        }
    //    }
    // });

    /*
    * FILTRA OS EQUIPAMENTOS DE ACORDO COM A ESCOLHA DO LOCAL
    */
    $('#filtroLocalLista').change(function() {

        var idFilial    = $(this).val();
        var idCliente   = $('#filtroClienteLista').val();

        if(idFilial != ''){

            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialRelatoriosJson",
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
                        $('#localId').val(idFilial);

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

   /* FUNÇÕES ADICIONAIS DE AUTOCOMPLETE
   */
   function split(val) {
     return val.split( /,\s*/ );
   }
   function extractLast( term ) {
     return split( term ).pop();
   }

    /*
    * FILTRAR EQUIPAMENTOS DE ACORDO COM O CLIENTE, FILIAL E O TIPO DE EQUIPAMENTO PARA RELATORIO
    */
    $('#filtroEquipLista').change(function() {

        var idTipoEquip = $(this).val();
        var idCliente   = $('#filtroClienteLista').val();
        var idFilial    = $('#localId').val();

        if(idTipoEquip != ''){
            //EFETUA O CARREGAMENTO DOS DADOS DOS EQUIPAMENTOS POR TIPO
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialTipoRelatorioJson",
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

    /*
    * FILTRAR OS CLIENTES PARA O RELATÔRIO DE ESTATISTICA
    */
    $('#filtroClienteListaEstatistica').change(function(){

        var idCliente = $(this).val();

        if(idCliente != ''){

            $('#filtroLocalAutoCompleteEstatistica').val("");

            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaFilialClienteEstatisticaJson",
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
                        //$('#filtroLocalLista').html(datra.filiais);
                        $('#filtroLocalListaGerador').html(datra.filiais);

                        /*
                        * PREENCHE TABELA COM EQUIPAMENTOS
                        */
                        $('#listaMonitoria').html(datra.equipamentos);

                        /*
                        * RETIRA O VALOR DO ID DE FILIAL
                        */
                        $('#localId').val(0);

                    }else{
                        //$('#filtroLocalLista').html(datra.filiais);
                        $('#filtroLocalListaGerador').html(datra.filiais);
                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                        $('#listaMonitoria').html(datra.equipamentos);
                        $('#localId').val(0);
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
    $('#filtroLocalListaGerador').change(function() {

        var idFilial    = $(this).val();
        var idCliente   = $('#filtroClienteLista').val();

        if(idFilial != ''){

            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialEstatisticaJson",
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
                        $('#localId').val(idFilial);

                    }else{

                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                        $('#listaMonitoria').html(datra.equipamentos);
                        $('#localId').val(0);
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
    * FILTRA OS EQUIPAMENTOS DE ACORDO COM A ESCOLHA DO LOCAL PARA ESTATISTICA
    */

    $("#filtroLocalAutoCompleteEstatistica")
      // don't navigate away from the field on tab when selecting an item
      .on( "keydown", function( event ) {

        var idClie = $('#filtroClienteListaEstatistica').val();

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
          $.getJSON( urlP+"/eficazmonitor/cliente/carregarListaFilialAutoCompleteJson/?filtroClie="+ $("#filtroClienteListaEstatistica").val(), {
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
           var idCliente   = $('#filtroClienteListaEstatistica').val();

           if(idFilial != ''){
               //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
               $.ajax({
                   url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialEstatisticaJson",
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

    /*
    * FILTRAR EQUIPAMENTOS DE ACORDO COM O CLIENTE, FILIAL E O TIPO DE EQUIPAMENTO PARA ESTATISTICAS
    */
    $('#filtroEquipListaEstatistica').change(function() {

        var idTipoEquip = $(this).val();
        var idCliente   = $('#filtroClienteListaEstatistica').val();
        var idFilial    = $('#localId').val();

        if(idTipoEquip != ''){
            //EFETUA O CARREGAMENTO DOS DADOS DOS EQUIPAMENTOS POR TIPO
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialTipoEstatisticaJson",
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

    /*
    * FILTRAR CLIENTES PARA RELATÓRIO DETALHADO DE ALARMES
    */
    $("#filtroClienteAlarmeDetalhado").change(function(){

        var idCliente = $(this).val();

        if(idCliente != ''){

            $('#filtroLocalAutoCompleteAlarmeDetalhado').val("");

            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaFilialClienteAlarmesDetalhados",
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
                        //$('#filtroLocalLista').html(datra.filiais);
                        $('#filtroLocalListaGeradorDetalhado').html(datra.filiais);

                        /*
                        * PREENCHE TABELA COM EQUIPAMENTOS
                        */
                        $('#listaMonitoria').html(datra.equipamentos);

                        /*
                        * RETIRA O VALOR DO ID DE FILIAL
                        */
                        $('#localId').val(0);

                    }else{
                        //$('#filtroLocalLista').html(datra.filiais);
                        $('#filtroLocalListaGeradorDetalhado').html(datra.filiais);
                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                        $('#listaMonitoria').html(datra.equipamentos);
                        $('#localId').val(0);
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
            $('#filtroClienteAlarmeDetalhado').html("<option value=''> Selecione...</option>");
        }
    });

    /*
    * FILTRA OS EQUIPAMENTOS DE ACORDO COM A ESCOLHA DO LOCAL PARA DETALHAMENTO DE ALARMES
    */
    $('#filtroLocalListaGeradorDetalhado').change(function() {

        var idFilial    = $(this).val();
        var idCliente   = $('#filtroClienteAlarmeDetalhado').val();

        if(idFilial != ''){

            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialAlarmeDetalhadoJson",
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
                        $('#localId').val(idFilial);

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
    * FILTRA OS EQUIPAMENTOS DE ACORDO COM A ESCOLHA DO LOCAL PARA DETALHAMENTO DE ALARMES
    */

    // $("#filtroLocalAutoCompleteAlarmeDetalhado")
    //     // don't navigate away from the field on tab when selecting an item
    //     .on( "keydown", function( event ) {
    //
    //         var idClie = $('#filtroClienteAlarmeDetalhado').val();
    //
    //         /*
    //         * VERIFICA SE FOI SELECIONADO UM CLIENTE
    //         */
    //         if(idClie != ''){
    //             if ( event.keyCode === $.ui.keyCode.TAB &&
    //                 $( this ).autocomplete( "instance" ).menu.active ) {
    //               event.preventDefault();
    //             }
    //         }else{
    //            swal('','Selecione um cliente antes!','info');
    //         }
    //
    //     }).autocomplete({
    //     source: function( request, response ) {
    //         $.getJSON( urlP+"/eficazmonitor/cliente/carregarListaFilialAutoCompleteJson/?filtroClie="+ $("#filtroClienteAlarmeDetalhado").val(), {
    //           term: extractLast( request.term )
    //         }, response
    //     );
    //     },
    //     search: function() {
    //         // custom minLength
    //         var term = extractLast( this.value );
    //           if ( term.length < 2 ) {
    //             return false;
    //         }
    //     },
    //     focus: function() {
    //         // prevent value inserted on focus
    //         return false;
    //     },
    //     select: function( event, ui ) {
    //
    //         $('#localId').val(ui.item.id);
    //
    //         //GERA A TABELA DE EQUIPAMENTOS CONFORME O LOCAL ESCOLHIDO
    //         var idFilial    = ui.item.id;
    //         var idCliente   = $('#filtroClienteAlarmeDetalhado').val();
    //
    //         if(idFilial != ''){
    //             //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
    //             $.ajax({
    //                 url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialAlarmeDetalhadoJson",
    //                 secureuri: false,
    //                 type : "POST",
    //                 dataType: 'json',
    //                 data      : {
    //                     'idCliente' : idCliente,
    //                     'idFilial' : idFilial
    //                 },
    //                 success : function(datra)
    //                 {
    //                     if(datra.status){
    //
    //                         /*
    //                         * PREENCHE TABELA COM EQUIPAMENTOS
    //                         */
    //                         $('#listaMonitoria').html(datra.equipamentos);
    //
    //                         /*
    //                         * RETIRA O VALOR DO ID DE FILIAL
    //                         */
    //                         $('#localId').val(idFilial);
    //
    //                     }else{
    //
    //                         // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
    //                         $('#listaMonitoria').html(datra.equipamentos);
    //                     }
    //                 },
    //                 error: function(jqXHR, textStatus, errorThrown)
    //                 {
    //                     //Settar a mensagem de erro!
    //                     // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
    //                     swal("Oops...", "Ocorreu um erro ao carregar os equipamentos, favor verificar os dados informados!", "error");
    //                     // Handle errors here
    //                     console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
    //                     // STOP LOADING SPINNER
    //                 }
    //             });
    //         }
    //     }
    // });

    /*
    * FILTRAR EQUIPAMENTOS DE ACORDO COM O CLIENTE, FILIAL E O TIPO DE EQUIPAMENTO PARA DETALHAMENTO DE ALARMES
    */
    $('#filtroEquipAlarmeDetalhado').change(function(){

        var idTipoEquip = $(this).val();
        var idCliente   = $('#filtroClienteAlarmeDetalhado').val();
        var idFilial    = $('#localId').val();

        if(idTipoEquip != ''){
            //EFETUA O CARREGAMENTO DOS DADOS DOS EQUIPAMENTOS POR TIPO
            $.ajax({
                url: urlP+"/eficazmonitor/cliente/carregarListaEquipamentoFilialTipoAlarmeDetalheJson",
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
});
