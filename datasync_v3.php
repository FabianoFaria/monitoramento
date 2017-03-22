<?php

    /*
    * TERCEIRA VERSÃO DO DATASYNC.
    * CARACTERISTICAS DESTA VERSÃO:
    * RECEBER E GUARDAR OS DADOS RECEBIDO DO EQUIPAMENTO
    * CONFORME OS TIPOS DE ENTRADA E SAÍDA DO EQUIPAMENTO EFETUAR OS TESTES DOS PARAMETROS E GERAR ALARME
    * CONFORME AS ENTRADAS E SAÍDAS, CALCULAR A POTENCIA CONSUMIDA E SALVAR NO BANCO
    * QUANDO DETECTADO QUEDA DE ENERGIA, INICIAR PPROCESSO DE CALCULO DE AUTONOMIA DA BATERIA
    */

    /*
    * INCLUI A CLASSE DE CONEXA
    */
    require_once "classes/class-EficazDB.php";
    require_once "classes/class-email.php";


    /*
    * VALIDA OS CAMPOS DO POST
    */

    if(isset($_POST['A']) && isset($_POST['B']) && isset($_POST['C']) && isset($_POST['D']) &&
       isset($_POST['E']) && isset($_POST['F']) && isset($_POST['G']) && isset($_POST['H']) &&
       isset($_POST['I']) && isset($_POST['J']) && isset($_POST['L']) && isset($_POST['M']) &&
       isset($_POST['N']) && isset($_POST['O']) && isset($_POST['P']) && isset($_POST['Q']) &&
       isset($_POST['R']) && isset($_POST['S']) && isset($_POST['T']) && isset($_POST['U']))
    {
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
        * MONTA A QUERY
        */
        $valor = "insert into tb_dados (num_sim,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u) values
                      ('{$_POST['A']}','{$_POST['B']}','{$_POST['C']}','{$_POST['D']}','{$_POST['E']}','{$_POST['F']}','{$_POST['G']}',
                       '{$_POST['H']}','{$_POST['I']}','{$_POST['J']}','{$_POST['L']}','{$_POST['M']}','{$_POST['N']}','{$_POST['O']}',
                       '{$_POST['P']}','{$_POST['Q']}','{$_POST['R']}','{$_POST['S']}','{$_POST['T']}','{$_POST['U']}')";

        /*
        * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
        */
        if (!$conn->query($valor))
        {
            // Monta a query de log
            $query = "insert into tb_log (log)  values ('Erro ao gravar os valores da tabela respota; SIM [{$_POST['A']}]')";

            // Grava o log
            $conn->query($valor);

            // Retona o erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }


        /*
        * CALCULA A POTENCIA DE SAÍDA CONSUMIDA
        */

        


        /*
        * FECHA A CONEXAO
        */
        $conn->close();


    }else{
        /*
        * RETORNA ERRO
        */
        header('HTTP/1.1 404 Not Found');
    }



    /*
    *
    * FUNÇÕES QUE SERÃO UTILIZADAS NESTA ROTINA
    *
    */




?>
