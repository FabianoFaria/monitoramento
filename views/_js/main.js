$(document).ready(function(){

    // efeito fade da caixa de confirmacao de envio do cadastro
    if ($(".mensagemSucesso").is(":visible"))
    {
        setInterval(function(){
            $(".mensagemSucesso").fadeOut();
        }, 3000);
    }

    // efeito fade da caixa de erro de cadastro
    if ($(".mensagemError").is(":visible"))
    {
        setInterval(function(){
            $(".mensagemError").fadeOut();
        }, 3000);
    }

    // mascara do ddd
    // $("#txt_ddd").mask("(999)");
    // mascara do telefone
    $("#txt_telefone").mask("9999-99999");
    // mascara do cep
    $("#txt_cep").mask("99999-999");

    // configuracao do botao de sair
    $("#btn_logout")
        .mouseenter(function(){
            $("#btn_sair").fadeIn(100);
        })
        .mouseleave(function () {
            $("#btn_sair").fadeOut(100);
        });

    // configuracao do botao de itens cadastrados
    $("#btn_showConf")
    .mouseenter(function(){
        $("#menuCadastro").fadeIn(100);
    })
    .mouseleave(function(){
        $("#menuCadastro").fadeOut(100);
    });


    // verificador de cep
    $("#txt_cep").change(function(){
        var cep_code = $(this).val();
        cep_code = cep_code.replace("-","");
        if( cep_code.length <= 0 ) return;

        $.get("http://apps.widenet.com.br/busca-cep/api/cep.json", { code: cep_code },
        function(result){
            console.log(result);
            if( result.status!=1 ){
                alert(result.message || "Houve um erro desconhecido");
                return;
            }
            //$("#txt_cep").val( result.code );
            $("#txt_cidade").val( result.city );
            $("#txt_bairro").val( result.district );
            $("#txt_endereco").val( result.address );
            //$("#opc_estado").val( result.state);
        });
    });


    /*
     *      Validacoes do formulario
     */

    /* bateria */

    /* valor alto */
    $("#txt_vlAlto").focusout(function()
    {
        if ($(this).val() > $("#txt_pico").val())
        {
            alert("Erro no valor da Bateria: Valor Alto maior que o Pico");
        }
        if ($(this).val() < $("#txt_vlCarregando").val())
        {
            alert("Erro no valor da Bateria: Valor Alto menor que o Valor Carregando");
        }
    });/* fim valor alto */

    /* valor baixo */
    $("#txt_vlBaixo").focusout(function()
    {
        if ($(this).val() > $("#txt_pico").val())
        {
            alert("Erro no valor da Bateria: Valor Baixo maior que o Pico");
        }
    });/* fim valor baixo */

    /* valor real */
    $("#txt_vlReal").focusout(function()
    {
        if ($("#txt_vlReal").val() < $("#txt_vlBaixo").val())
        {
            alert("Erro no valor da Bateria: Valor Real menor que o Valor Baixo");
        }
    });/* fim valor real */

    /* valor real */
    $("#txt_vlCarregando").focusout(function()
    {
        if ($("#txt_vlCarregando").val() < $("#txt_vlReal").val())
        {
            alert("Erro no valor da Bateria: Valor Carregando menor que o Valor Real");
        }
    });/* fim valor real */


    /* valor pico */
    $("#txt_pico").focusout(function()
    {
        if ($(this).val() < $("#txt_vlAlto").val())
        {
            alert("Erro no valor da Bateria: Valor Pico menor que o Valor Alto");
        }
    });/* fim valor pico */

    /* fim bateria */




    /* Entrada */

    /* pico */
    $("#txt_entPico").focusout(function () {
        if($(this).val() < $("#txt_entAlto").val())
            alert("Erro no valor da Entrada: Valor Pico menor que o Valor Alto");
    });

    /* baixo */
    $("#txt_entBaixo").focusout(function () {
        if($(this).val() > $("#txt_entPico").val())
            alert("Erro no valor da Entrada: Valor Baixo maior que o Valor Pico");
        if($(this).val() > $("#txt_entTol1").val())
            alert("Erro no valor da Entrada: Valor Baixo maior que o Valor Tolerancia 1");

    });

    /* tolerancia 1 */
    $("#txt_entTol1").focusout(function () {
        if($(this).val() < $("#txt_entBaixo").val())
            alert("Erro no valor da Entrada: Valor Tolerancia 1 menor que o Valor Baixo");
        if($(this).val() > $("#txt_entIdeal").val())
            alert("Erro no valor da Entrada: Valor Tolerancia 1 maior que o Valor Ideal");
    });

    /* ideal */
    $("#txt_entIdeal").focusout(function () {
        if($(this).val() < $("#txt_entTol1").val())
            alert("Erro no valor da Entrada: Valor Ideal menor que o Valor Tolerancia 1");
        if($(this).val() > $("#txt_entTol2").val())
            alert("Erro no valor da Entrada: Valor Ideal maior que o Valor Tolerancia 2");
    });


    /* tolerancia  2 */
    $("#txt_entTol2").focusout(function () {
        if($(this).val() < $("#txt_entIdeal").val())
            alert("Erro no valor da Entrada: Valor Tolerancia 2 menor que o Valor Ideal");
        if($(this).val() > $("#txt_entAlto").val())
            alert("Erro no valor da Entrada: Valor Tolerancia 2 maior que o Valor Alto");
    });

    /* Alto */
    $("#txt_entAlto").focusout(function () {
        if($(this).val() < $("#txt_entTol2").val())
            alert("Erro no valor da Entrada: Valor Alto menor que o Valor Tolerancia 2");
        if($(this).val() > $("#txt_entPico").val())
            alert("Erro no valor da Entrada: Valor Alto maior que o Valor Pico");
    });




    /* Saida */

    /* pico */
    $("#txt_saiPico").focusout(function () {
        if($(this).val() < $("#txt_saialto").val())
            alert("Erro no valor da Saida: Valor Pico menor que o Valor Alto");
    });

    /* baixo */
    $("#txt_saibaixo").focusout(function () {
        if($(this).val() > $("#txt_saiPico").val())
            alert("Erro no valor da Saida: Valor Baixo maior que o Valor Pico");
        if($(this).val() > $("#txt_saitolerancia1").val())
            alert("Erro no valor da Saida: Valor Baixo maior que o Valor Tolerancia 1");

    });

    /* tolerancia 1 */
    $("#txt_saitolerancia1").focusout(function () {
        if($(this).val() < $("#txt_saibaixo").val())
            alert("Erro no valor da Saida: Valor Tolerancia 1 menor que o Valor Baixo");
        if($(this).val() > $("#txt_saiideal").val())
            alert("Erro no valor da Saida: Valor Tolerancia 1 maior que o Valor Ideal");
    });

    /* ideal */
    $("#txt_saiideal").focusout(function () {
        if($(this).val() < $("#txt_saitolerancia1").val())
            alert("Erro no valor da Saida: Valor Ideal menor que o Valor Tolerancia 1");
        if($(this).val() > $("#txt_saitolerancia2").val())
            alert("Erro no valor da Saida: Valor Ideal maior que o Valor Tolerancia 2");
    });


    /* tolerancia  2 */
    $("#txt_saitolerancia2").focusout(function () {
        if($(this).val() < $("#txt_saiideal").val())
            alert("Erro no valor da Saida: Valor Tolerancia 2 menor que o Valor Ideal");
        if($(this).val() > $("#txt_saialto").val())
            alert("Erro no valor da Saida: Valor Tolerancia 2 maior que o Valor Alto");
    });

    /* Alto */
    $("#txt_saialto").focusout(function () {
        if($(this).val() < $("#txt_saitolerancia2").val())
            alert("Erro no valor da Saida: Valor Alto menor que o Valor Tolerancia 2");
        if($(this).val() > $("#txt_saiPico").val())
            alert("Erro no valor da Saida: Valor Alto maior que o Valor Pico");
    });




    // Valor alto
    $("#txt_entAlto").focusout(function()
    {
        if ($(this).val() > $("#txt_entPico").val())
        {
            alert("Erro no valor da bateria: Valor Alto maior que o Pico");
        }
        if ($(this).val() < $("#txt_entTol2").val())
        {
            alert("Erro no valor da bateria: Valor Alto menor que o Valor Carregando");
        }
    });

    /*
     *      fim Validacoes do formulario
     */




    // Mostra o menu de notificacao
    $("#btn_alertaNot")
        // Quando clicar no item de notificacao
        .click(function(){
            // Verifica se o menu esta ativo
            if ($("#div-notificacao").is(":visible") == false)
            {
                // Se estiver oculto
                // Apresenta ele
                $("#div-notificacao").show();
            }
        })
        // Quando retirar o mouse do campo de notificacao
        .mouseleave(function(){
            // Oculta o menu de notificacao
            $("#div-notificacao").hide();
        });


    /**
     * Formulario de cadastro de usuario
     */
    $("#txt_cfsenha").focusout(
        function(){
            if ($("#txt_senha").val() != $("#txt_cfsenha").val())
            {
                alert("Senha não corresponde");
                $("#btn_salvar").prop( "disabled", true );
                $("#txt_senha").addClass("border-red");
                $("#txt_cfsenha").addClass("border-red");
            }
            else
            {
                $("#btn_salvar").prop( "disabled", false );
                $("#txt_senha").removeClass("border-red");
                $("#txt_cfsenha").removeClass("border-red");
            }
        });
    /* Fim do formulario de cadastro */


});


/*
 *   funcao que permite inserir apenas numeros
 */
function onlyNumber(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla>47 && tecla<58))
        return true;
    else{
        if (tecla==8 || tecla==0)
            return true;
        else
            return false;
    }
}
function onlyNumber2(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla>47 && tecla<58 || tecla == 44))
        return true;
    else{
        if (tecla==8 || tecla==0)
            return true;
        else
            return false;
    }
}


function geraGrafico(link)
{
    // Coleta os dados do checkbox
    var entr1t = $("#chk_entrada_r1t").is(":checked");
    var ents1t = $("#chk_entrada_s1t").is(":checked");
    var entt1t = $("#chk_entrada_t1t").is(":checked");
    var entr1c = $("#chk_entrada_r1c").is(":checked");
    var ents1c = $("#chk_entrada_s1c").is(":checked");
    var entt1c = $("#chk_entrada_t1c").is(":checked");

    if (!entr1t) entr1t = 0; else entr1t = 1;
    if (!ents1t) ents1t = 0; else ents1t = 1;
    if (!entt1t) entt1t = 0; else entt1t = 1;
    if (!entr1c) entr1c = 0; else entr1c = 1;
    if (!ents1c) ents1c = 0; else ents1c = 1;
    if (!entt1c) entt1c = 0; else entt1c = 1;

    var url = entr1t + "," + ents1t + "," + entt1t + "," + entr1c + "," + ents1c + "," + entt1c;
    window.location.href = link + url;
}
