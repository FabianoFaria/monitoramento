<?php

	/*
		SCRIPT COM O OBJETIVO DE VERIFICAR SE SISTEMA ESTÀ RECEBENDO DADOS DO EQUIPAMENTO, CASO CONTRARIO EMITE ALERTA
	*/
	

	 // Inclui a classe de conexa
    require_once "classes/class-EficazDB.php";
    require_once "classes/class-email.php";

    echo "Verificador de recebimento de dados <br>!";


    /*
		LISTA DE EQUIPAMENTOS ATIVOS
    */

	$equipamentosAtivos = listarEquipamentosAtivos();

	if($equipamentosAtivos){

		foreach ($equipamentosAtivos as $equipamento) {
			

			//var_dump($equipamento,"<br>");
			/*
				VERIFICA O ÚLTIMO DADO RECEBIDO
			*/


		}

	}



    /*
    * FUNÇÃO PARA LISTAR OS EQUIPAMENTOS ATIVOS
    */
    function listarEquipamentosAtivos(){

    	/*
        *  CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        */
        $conn = new EficazDB;

        // VERIFICA SE EXISTE ERRO DE CONEXAO
        if (!$conn)
        {
            // Retorno erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }


          $query = "SELECT equip.id,equip.id_cliente, equip.id_filial, equip.nomeModeloEquipamento, equip.status_ativo
                        FROM tb_equipamento equip
                        WHERE equip.status_ativo = '1'";

          /*
          * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
          */
          $paramEquip = $conn->select($query);

          /* VERIFICA SE EXISTE VALOR */
          if (@mysql_num_rows($paramEquip) > 0)
          {
               /* ARMAZENA NA ARRAY */
               while ($rowEquip = @mysql_fetch_assoc ($paramEquip))
               {
                   $retornoEquip[] = $rowEquip;
               }

               $parametros = $retornoEquip;

               // Fecha a conexao
               $conn->close();

           }else{
               $parametros = false;
           }

           return $parametros;

    }	


    /*
    * FUNÇÃO PARA RECUPERAR O ÚLTIMO DADO RECEBIDO
    */
    function ultimoDadoRecebido($idEquipamento){

    	/*
        *  CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        */
        $conn = new EficazDB;

        // VERIFICA SE EXISTE ERRO DE CONEXAO
        if (!$conn)
        {
            // Retorno erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }

        $query = "";



    }

?>