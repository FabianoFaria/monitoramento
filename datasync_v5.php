<?php

/*
* QUINTA VERSÃO DO DATASYNC.
* CARACTERISTICAS DESTA VERSÃO:
* ATUALIZAÇÃO DE CONEXÃO DE BD COM PDO E PREPARED STATEMENT
* RECEBER E GUARDAR OS DADOS RECEBIDO DO EQUIPAMENTO
* CONFORME OS TIPOS DE ENTRADA E SAÍDA DO EQUIPAMENTO EFETUAR OS TESTES DOS PARAMETROS E GERAR ALARME
* CONFORME AS ENTRADAS E SAÍDAS, CALCULAR A POTENCIA CONSUMIDA E SALVAR NO BANCO
* QUANDO DETECTADO QUEDA DE ENERGIA, INICIAR PPROCESSO DE CALCULO DE AUTONOMIA DA BATERIA
* ADIÇÃO DE TESTE DE FALSO POSITIVO PARA OS ALARMES DE CRÍTICO BAIXO ( EVITAR O PROBLEMA DE HARDWARE MANDAR ZERO E LOGO EM SEGUIDA MANDAR OS DADOS CORRETAMENTE )
*/

/*
* INCLUI A CLASSE DE CONEXA
*/

define('EFIPATH', dirname(__DIR__));
require_once EFIPATH ."/classes/class-EficazDB.php";
require_once EFIPATH ."/classes/class-email.php";

/*
* VALIDA OS CAMPOS DO POST
*/

if(isset($_POST['A']) && isset($_POST['B']) && isset($_POST['C']) && isset($_POST['D']) &&
   isset($_POST['E']) && isset($_POST['F']) && isset($_POST['G']) && isset($_POST['H']) &&
   isset($_POST['I']) && isset($_POST['J']) && isset($_POST['L']) && isset($_POST['M']) &&
   isset($_POST['N']) && isset($_POST['O']) && isset($_POST['P']) && isset($_POST['Q']) &&
   isset($_POST['R']) && isset($_POST['S']) && isset($_POST['T']) && isset($_POST['U'])){

    /*
    *  CRIA UM OBJETO DE DA CLASSE DE CONEXAO
    */
    $conn = new EficazDB;

    /*
    * VERIFICA SE EXISTE ERRO DE CONEXAO
    */
    if (!$conn)
    {
        // Retorno erro
        header('HTTP/1.1 404 Not Found');
        // Finaliza a execucao
        exit();
    }

    /*
    * LISTA DE PROTOCOLOS
    * EM FUTURAS VERSÕES, EFETUAR UM INCLUDE OU UMA QUERY DO BD
    */
    $protocolos    = array(
                        '65534' => 'Alerta Y',
                        '65533' => 'Alerta Z'
                    );

    /*
    * CADA UM DOS POSTS SERÁ VERIFICADO PARA PROCURAR ALGUM TIPO DE PROTOCOLO ENVIADO PELO EQUIPAMENTO
    * EM CASO DE PROTOCOLO ENCONTRADO, IRÁ SALVAR UM ZERO NO LUGAR DO CÓDIGO DO PROTOCOLO
    */

    $postB = verificaValorPosicaoQuery($_POST['B'],$protocolos);
    $postC = verificaValorPosicaoQuery($_POST['C'],$protocolos);
    $postD = verificaValorPosicaoQuery($_POST['D'],$protocolos);

    $postE = verificaValorPosicaoQuery($_POST['E'],$protocolos);
    $postF = verificaValorPosicaoQuery($_POST['F'],$protocolos);
    $postG = verificaValorPosicaoQuery($_POST['G'],$protocolos);

    $postH = verificaValorPosicaoQuery($_POST['H'],$protocolos);

    $postI = verificaValorPosicaoQuery($_POST['I'],$protocolos);
    $postJ = verificaValorPosicaoQuery($_POST['J'],$protocolos);
    $postL = verificaValorPosicaoQuery($_POST['L'],$protocolos);

    $postM = verificaValorPosicaoQuery($_POST['M'],$protocolos);
    $postN = verificaValorPosicaoQuery($_POST['N'],$protocolos);
    $postO = verificaValorPosicaoQuery($_POST['O'],$protocolos);

    $postP = verificaValorPosicaoQuery($_POST['P'],$protocolos);

    $postQ = verificaValorPosicaoQuery($_POST['Q'],$protocolos);
    $postR = verificaValorPosicaoQuery($_POST['R'],$protocolos);
    $postS = verificaValorPosicaoQuery($_POST['S'],$protocolos);
    $postT = verificaValorPosicaoQuery($_POST['T'],$protocolos);
    $postU = verificaValorPosicaoQuery($_POST['U'],$protocolos);


}else{
    /*
    * RETORNA ERRO
    */
    header('HTTP/1.1 404 Not Found');
}


?>
