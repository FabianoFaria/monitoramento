<?php

	/*
		SCRIPT COM O OBJETIVO DE VERIFICAR SE SISTEMA ESTÀ RECEBENDO DADOS DO EQUIPAMENTO, CASO CONTRARIO EMITE ALERTA
	*/


	 // Inclui a classe de conexa
    require_once "classes/class-EficazDB.php";
    require_once "classes/class-email.php";

    echo "Verificador de recebimento de dados <br>!";

	/*
		COLETA A DATA ATUAL DA VERIFICAÇÃO
	*/
	$dataAtual = date('Y-m-d H:i:s');

	var_dump($dataAtual);


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

			/*
			array (size=5)
			  'id' => string '22' (length=2)
			  'id_cliente' => string '50' (length=2)
			  'id_filial' => string '0' (length=1)
			  'nomeModeloEquipamento' => string 'Gh' (length=2)
			  'status_ativo' => string '1' (length=1)
			  'idSimEquip'
			*/

			$dadoRecebido = ultimoDadoRecebido($equipamento['id']);

			//var_dump($dadoRecebido);
			/*
				FAZ A VALIDAÇÃO DA DATA DO ÚLTIMO EMVIO DE DADOS
			*/
			if($dadoRecebido){

				/*
				array (size=1)
				0 =>
				array (size=3)
				  'id' => string '599856' (length=6)
				  'num_sim' => string '9999998888' (length=10)
				  'dt_criacao' => string '2017-02-14 11:44:16' (length=19)
				*/
				foreach ($dadoRecebido as $dados){

					$dataDado = $dados['dt_criacao'];

					/*
						CALCULA A DIFERENÇA ENTRE AS DATAS
					*/

					$totalMinutos = round((time() - strtotime($dataDado)) / 60);

					//$diferenca = date_diff(date_create($dataDado), date_create($dataAtual));

					// $diffMes   = $diferenca->m;
					// $diffDia   = $diferenca->d;
					// $diffHora  = $diferenca->h;
					// $diffMin   = $diferenca->i;
					// $totalMinutos = $diffMin + ($diffHora * 60) + ($diffDia * 1440) + ($diffMes * 43200);

					//var_dump($totalMinutos);
					// var_dump(time());
					// var_dump(strtotime($dataAtual));



					//var_dump($listaContatos);




					/*
						CASO A DIFERENÇA SEJA MAIOR QUE 10MIN
					*/
					if($totalMinutos > 10){

						/*
							VERIFICA SE NÃO HÁ NENHUM OUTRO ALARME JÁ ATIVO PARA O EQUIPAMENTO
						*/
						$alarmeExiste = verificarAlarmeEquipamento($equipamento['idSimEquip']);

						if(!$alarmeExiste){
							/*
								INICIA O PROCESSO DE GERAR ALARME DO EQUIPAMENTO
							*/
							gerarAlarmeEquipamento($equipamento['idSimEquip'], $dados['num_sim'],$dataAtual);

							/*
								INICIA PROCESSO DE GERAR EMAILS
							*/
							$listaContatos = carregarContatosEquiapemtno($equipamento['id_cliente'], $equipamento['id_filial']);

							if($listaContatos){

								foreach ($listaContatos as $contato){

									$mailer = new email;

									$nome = $contato['nome_contato'];
									$email = $contato['email'];

									//CHAMA A FUNÇÃO PARA EFETUAR O ENVIO DE EMAIL PARA CADA UM DOS CONTATOS

				                    $localEquip = (isset($equipamento['nomeFili'])) ? ' filial '.$equipamento['nomeFili'] : 'Matriz';

									$resultadoEnvio = $mailer->envioEmailAlertaEquipamentoNaoResponde($contato['email'], $contato['nome_contato'], $equipamento['tipo_equipamento'], $equipamento['nomeModeloEquipamento'], $equipamento['ambiente'], $equipamento['nomeClie']);

									//var_dump($resultadoEnvio);
								}
							}

						}else{
							/*
								REGISTRA NO BD OS DADOS ZERADOS PARA RELATÓRIOS POSTERIORES
							*/
							registraDadosZeradosEquipamento($dados['num_sim']);
						}

						//var_dump($alarmeExiste);
						//$id_sim_equip, $numSim, $data
					}

				}
			}

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


          $query = "SELECT equip.id,equip.id_cliente, equip.id_filial, equip.nomeModeloEquipamento, equip.status_ativo, simEquip.id as 'idSimEquip', simEquip.ambiente, clie.nome AS 'nomeClie', fili.nome AS 'nomeFili', tpEquip.tipo_equipamento
                        FROM tb_equipamento equip
						JOIN tb_tipo_equipamento tpEquip ON equip.tipo_equipamento = tpEquip.id
						JOIN tb_cliente clie ON equip.id_cliente = clie.id
						JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id
						LEFT JOIN tb_filial fili ON equip.id_filial = fili.id
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

        $query = "SELECT dados.id, dados.num_sim, dados.dt_criacao
					FROM tb_dados dados
					JOIN tb_sim_equipamento simEquip ON simEquip.id_sim = dados.num_sim
					JOIN tb_equipamento equip ON equip.id = simEquip.id_equipamento
					WHERE equip.id = '$idEquipamento'
					ORDER BY dados.id DESC LIMIT 1";

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
	* FUNÇÃO PARA RETORNAR A DIFERENÇA DE TEMPO
	*/
	function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
	{
		//////////////////////////////////////////////////////////////////////
		//PARA: Date Should In YYYY-MM-DD Format
		//RESULT FORMAT:
		// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
		// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
		// '%m Month %d Day'                                            =>  3 Month 14 Day
		// '%d Day %h Hours'                                            =>  14 Day 11 Hours
		// '%d Day'                                                        =>  14 Days
		// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
		// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
		// '%h Hours                                                    =>  11 Hours
		// '%a Days                                                        =>  468 Days
		//////////////////////////////////////////////////////////////////////

	    $datetime1 = date_create($date_1);
	    $datetime2 = date_create($date_2);

	    $interval = date_diff($datetime1, $datetime2);

	    return $interval->format($differenceFormat);

	}

	/*
	 * FUNÇÃO PARA GERAR ALARME DO EQUIPAMENTO
	*/
	function gerarAlarmeEquipamento($id_sim_equip, $numSim, $data){

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

		//REGISTRA A FALHA DO EQUIPAMENTO
		// Monta a query para salvar uma falta
		$query = "insert into tb_numero_falta (id_num_sim) values ('$numSim')";

		// Executa a query
		if (!$conn->query($query))
		{
			// Monta a query de log
			$query = "insert into tb_log (log)  values ('Erro ao grava o numero de faltas; numero do sim ".$numSim." ')";
			// Grava o log
			$conn->query($valor);
		}

		/*
			REGISTRA O EQUIPAMENTO COMO DESLIGADO NO BD ATÉ RECEBER NOVOS DADOS
		*/
	    $queryDadosVazios = "insert into tb_dados (num_sim,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u) values
	                  ('$numSim','0','0','0','0','0','0',
	                   '0','0','0','0','0','0','0',
	                   '0','0','0','0','0','0')";

		$result = $conn->query($queryDadosVazios);

		/*
			REGISTRA O ALARME NA TABELA DO BD
		*/
	    $queryAlarme = "INSERT INTO tb_alerta(id_sim_equipamento, id_msg_alerta, nivel_alerta, dt_criacao)
	                    VALUES ('$id_sim_equip', '8', '1', '$data')";

		$result = $conn->query($queryAlarme);

		$idGerada  = mysql_insert_id();

		//REGISTRA OS DETALHES DO ALARME PARA CONSULTA PELO MONITOR
		$queryDetalheAlarme = "INSERT INTO tb_tratamento_alerta(id_alerta, parametro, parametroMedido, parametroAtingido, pontoTabela)
					        VALUES ('$idGerada', 'Equipamento mestre', '0', '0', 'a')";

		$conn->query($queryDetalheAlarme);

		// Fecha a conexao
		$conn->close();

	}

	/*
	* FUNÇÃO PARA VERIFICAR SE AINDA EXISTE ALARMES ATIVOS NO EQUIPAMENTO
	*/
	function verificarAlarmeEquipamento($idSimEquip){

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

		$query = "SELECT alert.id, alert.id_sim_equipamento
					FROM tb_alerta alert
					WHERE alert.id_sim_equipamento = '$idSimEquip' AND alert.id_msg_alerta = '8' AND alert.status_ativo < 4";

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
	* REGISTRA NA TABELA DADOS, A FALHA DO EQUIPAMENTOS
	*/
	function registraDadosZeradosEquipamento($numSim){

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

		/*
			REGISTRA O EQUIPAMENTO COMO DESLIGADO NO BD ATÉ RECEBER NOVOS DADOS
		*/
	    $queryDadosVazios = "insert into tb_dados (num_sim,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u) values
	                  ('$numSim','0','0','0','0','0','0',
	                   '0','0','0','0','0','0','0',
	                   '0','0','0','0','0','0')";

		$result = $conn->query($queryDadosVazios);

		// Fecha a conexao
		$conn->close();

	}

	/*
    * CARREGA OS CONTATOS DE EMAIL DO EQUIPAMENTO
    */
    function carregarContatosEquiapemtno($idClie, $idFili){

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

        $query = "SELECT nome_contato, email FROM tb_contato_alerta WHERE id_cliente = '$idClie' AND id_filial = '$idFili'";

        /* monta result */
        $result =  $conn->select($query);

        /* VERIFICA SE EXISTE VALOR */
        if (@mysql_num_rows($result) > 0)
        {
            /* ARMAZENA NA ARRAY */
            while ($rowEquip = @mysql_fetch_assoc ($result))
            {
                $retornoEquip[] = $rowEquip;
            }

            $dados = $retornoEquip;

            // Fecha a conexao
            $conn->close();

        }else{
            $dados = false;
        }

        return $dados;
    }

?>
