<?php

/**
* Classe de modelo que gerencia as informacoes dos fabricantes
*/

class EquipamentoModel extends MainModel
{

    public function __construct ($db = false , $controller = null)
    {
        // Conexao com o banco
        $this->db = $db;

        // Configuracao do controller
        $this->controller = $controller;

        // Configura os parâmetros
       $this->parametros = $this->controller->parametros;
    }

    /* FUNÇÃO RESPONSAVEL PELA LISTAGEM DE EQUIPAMENTOS
    *
    */
    public function listarEquipamentos()
    {
        /*
            id_users,
            id_fabricante,
            id_cliente,
            id_filial,
            tipo_equipamento,
            nomeModeloEquipamento,
            correnteBateria,
            potencia,
            tensaoBancoBateria,
            correnteBancoBateria,
            qnt_bateria,
            quantidade_banco_bateria,
            quantidade_bateria_por_banco,
            tipo_bateria,
            localBateria
        */

        $query = "SELECT
        equip.id,
        equip.nomeModeloEquipamento,
         equip.tipo_equipamento as 'equipamento',
          tipo_equip.tipo_equipamento, fabri.nome as 'fabricante',
          equip.potencia,
          equip.qnt_bateria,
          equip.tipo_bateria,
           equip.localBateria,
          clie.nome as 'cliente', fili.nome as 'filial',  simEquip.id_sim as 'sim_clie'
                    FROM tb_equipamento equip
                    LEFT JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                    LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                    LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                    LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                    LEFT JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id AND simEquip.status_ativo > 0
                    WHERE equip.status_ativo = '1'";

        /* MONTA A RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if(!empty($result))
        {
            /* VERIFICA SE EXISTE VALOR */
            // if (@mysql_num_rows($result) > 0)
            // {
            //     /* ARMAZENA NA ARRAY */
            //     while ($row = @mysql_fetch_assoc ($result))
            //     {
            //         $retorno[] = $row;
            //     }
            //
            //     /* DEVOLVE RETORNO */
            //     return $retorno;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }
                /* DEVOLVE RETORNO */
                return $retorno;
        }
        else
            return false;
    }

    /*
    * FUNÇÃO PARA CARREGAR LISTA DE EQUIPAMENTOS DE CLIENTE ESPECIFICO
    */
    public function listarEquipamentosCliente($idCliente)
    {
        if(is_numeric($idCliente)){

            $query = "SELECT
                        equip.id, equip.nomeModeloEquipamento,
                        equip.tipo_equipamento as 'equipamento',
                        fabri.nome as 'fabricante',
                        equip.potencia,
                        equip.qnt_bateria,
                        equip.tipo_bateria,
                        clie.nome as 'cliente',
                        fili.nome as 'filial',
                        tipo_equip.tipo_equipamento as 'tipoEquip'
                        FROM tb_equipamento equip
                        LEFT JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                        LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                        LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                        LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                        WHERE equip.id_cliente = '$idCliente' AND equip.status_ativo = '1'
                        GROUP BY equip.id";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'equipamentos' => $retorno);
                // }else{
                //     $array = array('status' => false, 'equipamentos' => '');
                // }
                foreach ($result as $row) {
                    $retorno[] = $row;
                }
                    /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamentos' => $retorno);

            }else{
                $array = array('status' => false, 'equipamentos' => '');
            }

        }else{
            $array = array('status' => false, 'equipamentos' => '');
        }

        return $array;
    }

    /*
    * FILTRAR EQUIPAMENTOS DE ACORDO COM O LOCAL ESCOLHIDO
    */
    public function listarEquipamentosFilialCliente($idCliente, $idFili)
    {
        if(is_numeric($idCliente)){

            $query = "SELECT equip.id, equip.nomeModeloEquipamento, equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante', equip.potencia, equip.qnt_bateria, equip.tipo_bateria , clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip'
                        FROM tb_equipamento equip
                        LEFT JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                        LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                        LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                        LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                        WHERE equip.id_cliente = '$idCliente' AND equip.id_filial = '$idFili' AND equip.status_ativo = '1'
                        GROUP BY equip.id";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'equipamentos' => $retorno);
                // }else{
                //     $array = array('status' => false, 'equipamentos' => '');
                // }
                foreach ($result as $row) {
                    $retorno[] = $row;
                }
                    /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamentos' => $retorno);
            }else{
                $array = array('status' => false, 'equipamentos' => '');
            }

        }else{
            $array = array('status' => false, 'equipamentos' => '');
        }

        return $array;
    }

    /*
    * FILTRAR EQUIPAMENTOS DE ACORDO COM O LOCAL E O TIPO DE EQUIPAMENTO ESCOLHIDO
    */
    public function listarEquipamentosFilialClienteTipo($idCliente, $idFili, $idTipo){

        //Trata questões de filial não selecionada
        if(is_numeric($idFili)){
            $idFilial = $idFili;
        }else{
            $idFilial = 0;
        }

        if(($idCliente != "") && is_numeric($idCliente) && is_numeric($idTipo)){
            $query = "SELECT equip.id,
             equip.nomeModeloEquipamento,
             equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante',
             equip.potencia,
             equip.qnt_bateria,
             equip.tipo_bateria,
             equip.localBateria,
             clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip',
             estado.nome as 'estado', estadofili.nome as 'estadofili'";

            $query .= "";

            $query .= " FROM tb_equipamento equip";
            $query .= " JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante";
            $query .= " LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id";
            $query .= " LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id";
            $query .= " LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0";
            $query .= " LEFT JOIN tb_estado estado ON (estado.id = clie.id_estado AND equip.id_filial = 0)";
            $query .= " LEFT JOIN tb_estado estadofili ON (estadofili.id = fili.id_estado AND equip.id_filial > 0)";
            $query .= " WHERE equip.status_ativo = '1' ";
            if($idCliente != 0 ){
                $query .= "AND equip.id_cliente = '$idCliente'";
            }
            if($idFilial != 0  && $idCliente != 0 ){

                $query .= " AND equip.id_filial = '$idFili'";
            }
            if($idTipo != 0 ){
                if($idCliente != 0 ){
                    $query .= " AND equip.tipo_equipamento = '$idTipo'";
                }else{
                    $query .= "AND equip.tipo_equipamento = '$idTipo'";
                }
            }

            $query .= " GROUP BY equip.id";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'equipamentos' => $retorno);
                // }else{
                //     $array = array('status' => false, 'equipamentos' => '');
                // }
                foreach ($result as $row) {
                    $retorno[] = $row;
                }
                    /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamentos' => $retorno);
            }else{
                $array = array('status' => false, 'equipamentos' => '');
            }

        }else{
            $array = array('status' => false, 'equipamentos' => '');
        }

        return $array;
    }

    /*
    * FILTRAR EQUIPAMENTOS DA LISTA PRINCIPAL POR CLIENTE
    */
    public function filtroListaEquipamentos($idCliente){

        if(($idCliente != "") && is_numeric($idCliente)){

            $query = "SELECT equip.id,
                        equip.nomeModeloEquipamento,
                        equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante',
                        equip.potencia,
                        equip.qnt_bateria,
                        equip.tipo_bateria,
                        equip.localBateria,
                        simEquip.id_sim,
                        clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip',
                        estado.nome as 'estado', estadofili.nome as 'estadofili'
                      FROM tb_equipamento equip
                      LEFT JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                      LEFT JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id AND simEquip.status_ativo = 1
                      LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                      LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                      LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                      LEFT JOIN tb_estado estado ON (estado.id = clie.id_estado AND equip.id_filial = 0)
                      LEFT JOIN tb_estado estadofili ON (estadofili.id = fili.id_estado AND equip.id_filial > 0)
                      WHERE equip.status_ativo = '1' AND equip.id_cliente = '$idCliente'";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {

                foreach ($result as $row) {
                    $retorno[] = $row;
                }

                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamentos' => $retorno);

            }else{

                $array = array('status' => false, 'equipamentos' => '');

            }
        }else{
            $array = array('status' => false, 'equipamentos' => '');
        }

        return $array;
    }

    /*
    * FILTRAR EQUIPAMENTOS DA LISTA PRINCIPAL POR CLIENTE E ESTADO
    */
    public function filtroListaEquipamentosPorEstado($idCliente, $idEstado){

        if(($idCliente != "") && is_numeric($idCliente)){

            $query = "SELECT equip.id,
                        equip.nomeModeloEquipamento,
                        equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante',
                        equip.potencia,
                        equip.qnt_bateria,
                        equip.tipo_bateria,
                        equip.localBateria,
                        simEquip.id_sim,
                        clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip',
                        estado.nome as 'estado', estadofili.nome as 'estadofili'
                      FROM tb_equipamento equip
                      LEFT JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                      LEFT JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id AND simEquip.status_ativo = 1
                      LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                      LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                      LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                      LEFT JOIN tb_estado estado ON (estado.id = clie.id_estado AND equip.id_filial = 0)
                      LEFT JOIN tb_estado estadofili ON (estadofili.id = fili.id_estado AND equip.id_filial > 0)
                      WHERE equip.status_ativo = '1' AND equip.id_cliente = '$idCliente' AND (estado.id ='$idEstado' OR estadofili.id ='$idEstado')";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {

                foreach ($result as $row) {
                    $retorno[] = $row;
                }

                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamentos' => $retorno);

            }else{

                $array = array('status' => false, 'equipamentos' => '');

            }

        }else{
            $array = array('status' => false, 'equipamentos' => '');
        }

        return $array;
    }


    /*
    *   CARREGAR DADOS EQUIPAMENTO
    */

    public function dadosEquipamentoCliente($idEquipamento)
    {

        if(is_numeric($idEquipamento)){

            /*
                id_users,
                id_fabricante,
                id_cliente,
                id_filial,
                tipo_equipamento,
                nomeModeloEquipamento,
                correnteBateria,
                potencia,
                tensaoBancoBateria,
                correnteBancoBateria,
                qnt_bateria,
                quantidade_banco_bateria,
                quantidade_bateria_por_banco,
                tipo_bateria,
                localBateria
            */


            $query = "SELECT
                    equip.id,
                    equip.id_fabricante,
                    equip.id_cliente,
                    equip.id_filial,
                    equip.tipo_equipamento,
                    equip.nomeModeloEquipamento,
                    equip.correnteBateria,
                    equip.potencia,
                    equip.tensaoBancoBateria,
                    equip.correnteBancoBateria,
                    equip.tensaoMinBarramento,
                    equip.qnt_bateria,
                    equip.quantidade_banco_bateria,
                    equip.quantidade_bateria_por_banco,
                    equip.tipo_bateria,
                    equip.localBateria,
                    equip.tipo_entrada,
                    equip.tipo_saida,
                    equip_sim.id_sim,
                    equip_sim.id as 'id_sim_equip',
                    equip_sim.status_ativo as 'vinculo_ativo',
                    sim.ativo_cliente,
                    clie.id as 'idClie', clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip'
                      FROM tb_equipamento equip
                      LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                      LEFT JOIN tb_sim_equipamento equip_sim ON equip_sim.id_equipamento = equip.id AND equip_sim.status_ativo = '1'
                      LEFT JOIN tb_sim sim ON equip_sim.id_sim = sim.num_sim
                      LEFT JOIN tb_cliente clie ON clie.id = equip.id_cliente
                      LEFT JOIN tb_filial fili ON fili.id = equip.id_filial
                      WHERE  equip.id = '$idEquipamento'";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if($result)
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'equipamento' => $retorno);
                // }else{
                //     $array = array('status' => false, 'equipamento' => '');
                // }
                foreach ($result as $row) {
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamento' => $retorno);
            }else{
                $array = array('status' => false, 'equipamento' => '');
            }
        }else{
            $array = array('status' => false, 'equipamento' => '');
        }

        return $array;

    }


    /*
    * Registra vis JSON os dados do equipamento
    */

    public function registrarEquipamentoJson($idCliente, $idFilial, $equipamento, $fabricante, $nomeModelo, $correnteBateria, $potencia, $tensaoBancoBat, $correnteBanco, $quantBat, $quantBancoBat, $quantBatPorBanc, $tipoBateria, $localBateria, $equipamentoEntrada, $equipamentoSaida, $tensaoMinBarramento){

        // Verifica se os cambos obrigatorios nao sao nulos
        if ($idCliente != "" && $equipamento != "" )
        {

            /*
                id_users,
                id_fabricante,
                id_cliente,
                id_filial,
                tipo_equipamento,
                nomeModeloEquipamento,
                correnteBateria,potencia,
                tensaoBancoBateria,
                correnteBancoBateria,
                qnt_bateria,
                quantidade_banco_bateria,
                quantidade_bateria_por_banco,
                tipo_bateria,
                localBateria
            */


            // Trata os valores
            $idUser         = $_SESSION['userdata']['userId'];
            $idCliente      = $idCliente;
            $idFilial       = ($idFilial == '') ? 0 : $idFilial;
            $idFabri        = $fabricante;
            $tipoEquip      = $equipamento;
            $nomeEquipamento = isset($nomeModelo) && !empty ($nomeModelo) ? $this->converte($this->tratamento($nomeModelo)) : '';

            $potencia       = isset($potencia) && !empty ($potencia) ? $this->converte($this->tratamento($potencia)) : '';
            $tensaoBancoBat = isset($tensaoBancoBat) && !empty ($tensaoBancoBat) ? $this->converte($this->tratamento($tensaoBancoBat)) : '';
            $correnteBanco  = isset($correnteBanco) && !empty ($correnteBanco) ? $this->converte($this->tratamento($correnteBanco)) : '';
            $correnteBateria = isset($correnteBateria) && !empty ($correnteBateria) ? $this->converte($this->tratamento($correnteBateria)) : '';

            $qntBateria     = isset($quantBat) && !empty ($quantBat) ? $this->converte($this->tratamento($quantBat)) : 0;
            $quantBancoBat  = isset($quantBancoBat) && !empty ($quantBancoBat) ? $this->converte($this->tratamento($quantBancoBat)) : 0;
            $quantBatPorBanc = isset($quantBatPorBanc) && !empty ($quantBatPorBanc) ? $this->converte($this->tratamento($quantBatPorBanc)) : 0;

            $tipoBateria    = isset($tipoBateria) ? $tipoBateria : '';
            $localBateria   = isset($localBateria) ? $localBateria : '';

            // TRATAMENTO DOS DADOS DE ENTRADA E SAÍDA DO EQUIPAMENTO
            $entradaEquipamento = isset($equipamentoEntrada) && !empty ($equipamentoEntrada) ? $this->converte($this->tratamento($equipamentoEntrada)) : 0;
            $saidaEquipamento   = isset($equipamentoSaida) && !empty ($equipamentoSaida) ? $this->converte($this->tratamento($equipamentoSaida)) : 0;

            // TRATAMENTO DA TENSÃO MINIMA DO BARRAMENTO, CASO NÃO TENHA SIDO INFORMADA SERÁ SALVO O PADRÃO 10.5
            $tensaoMinBarramento = isset($tensaoMinBarramento) && !empty($tensaoMinBarramento) ? $this->converte($this->tratamento($tensaoMinBarramento)) : 10.5;

            // Se nao estiver em branco
            // Realiza a insercao no banco
            $query          = "INSERT INTO tb_equipamento (id_users,id_fabricante,id_cliente,id_filial,tipo_equipamento,nomeModeloEquipamento,correnteBateria,potencia,tensaoBancoBateria,correnteBancoBateria,qnt_bateria,quantidade_banco_bateria,quantidade_bateria_por_banco,tipo_bateria,localBateria,tipo_entrada,tipo_saida,tensaoMinBarramento)
                VALUES ('$idUser','$idFabri','$idCliente','$idFilial','$tipoEquip','$nomeEquipamento','$correnteBateria','$potencia','$tensaoBancoBat','$correnteBanco','$qntBateria','$quantBancoBat','$quantBatPorBanc','$tipoBateria','$localBateria', '$entradaEquipamento','$saidaEquipamento', '$tensaoMinBarramento')";

            //var_dump($query);

            $result         = $this->db->select($query);

            //$idEquip        = mysql_insert_id();
            //$idEquip        = $this->db->lastInsertIdPDO();
            if(is_numeric($result)){
                $idEquip = $result;
            }else{
                $idEquip = null;
            }

            $array = array('status' => $result, 'idequipamento' => $idEquip);

        }else{

            $array = array('status' => false, 'idequipamento' => 0);

        }

        return $array;

    }

    /*
    *   Editar equipamento via JSON
    */

    public function editarEquipamentoJson(
        $idEquip,
        $idCliente,
        $idFilial,
        $equipamento,
        $idFabricante,
        $nomeModelo,
        $correnteBateria,
        $potencia,
        $tensaoBancoBat,
        $correnteBanco,
        $quantBat,
        $quantBancoBat,
        $quantBatPorBanc,
        $tipoBateria,
        $localBateria,
        $tipoEntrada,
        $tipoSaida,
        $tensaoMinBarramento)
    {

        // Armazena o retorno do post

        $idEquip            = $this->tratamento($idEquip);

        $cliente            = $this->tratamento($idCliente);
        $filial             = $this->tratamento($idFilial);
        $equipamento        = $this->tratamento($equipamento);
        $idFabricante       = $this->tratamento($idFabricante);
        $nomeModelo         = $this->tratamento($nomeModelo);

        $correnteBateria    = $this->tratamento($correnteBateria);
        $potencia           = $this->tratamento($potencia);
        $tensaoBancoBat     = $this->tratamento($tensaoBancoBat);
        $correnteBanco      = $this->tratamento($correnteBanco);

        $quantBat           = $this->tratamento($quantBat);
        $quantBancoBat      = $this->tratamento($quantBancoBat);
        $quantBatPorBanc    = $this->tratamento($quantBatPorBanc);

        $tipoBateria        = $this->tratamento($tipoBateria);
        $localBateria       = $this->tratamento($localBateria);

        $tipoEntrada        = $this->tratamento($tipoEntrada);
        $tipoSaida          = $this->tratamento($tipoSaida);

        $tensaoMinBarramento = $this->tratamento($tensaoMinBarramento);

        $query = "UPDATE tb_equipamento SET ";
          if(isset($cliente)){  $query .= "id_cliente = '$cliente' ,";}
          if(isset($filial)){  $query .= "id_filial = '$filial' ,";}
          if(isset($equipamento)){  $query .= "tipo_equipamento = '$equipamento' ,";}
          if(isset($idFabricante)){  $query .= "id_fabricante = '$idFabricante' ,";}

          if(isset($nomeModelo)){  $query .= "nomeModeloEquipamento  = '$nomeModelo' ,";}

          if(isset($correnteBateria)){  $query .= "correnteBateria  = '$correnteBateria' ,";}
          if(isset($potencia)){  $query .= "potencia = '$potencia' ,";}
          if(isset($tensaoBancoBat)){  $query .= "tensaoBancoBateria  = '$tensaoBancoBat' ,";}
          if(isset($correnteBanco)){  $query .= "correnteBancoBateria  = '$correnteBanco' ,";}

          if(isset($quantBat)){  $query .= "qnt_bateria = '$quantBat' ,";}
          if(isset($quantBancoBat)){  $query .= "quantidade_banco_bateria  = '$quantBancoBat' ,";}
          if(isset($quantBatPorBanc)){  $query .= "quantidade_bateria_por_banco = '$quantBatPorBanc' ,";}

          if(isset($tipoBateria)){  $query .= "tipo_bateria = '$tipoBateria' ,";}
          if(isset($localBateria)){  $query .= "localBateria  = '$localBateria', ";}

          if(isset($tensaoMinBarramento)){  $query .= "tensaoMinBarramento  = '$tensaoMinBarramento', ";}

          if(isset($tipoEntrada)){  $query .= "tipo_entrada = '$tipoEntrada' ,";}
          if(isset($tipoSaida)){  $query .= "tipo_saida  = '$tipoSaida' ";}

        $query .= " WHERE id = '$idEquip'";

        // var_dump($query);

        /* monta result */
          $result = $this->db->query($query);

            //var_dump($query);

          if ($result){
            $array = array('status' => true);
          }else{
            $array = array('status' => false);
          }

          return $array;
    }

    /*
    * Função para retornar os dados de vinculo do equipamento antes de configura-lo
    */

    public function detalhesEquipamentoParaConfiguracao($idEquip){

        if(is_numeric($idEquip)){

            $query = "SELECT simEquip.id, simEquip.id_equipamento, simEquip.id_sim
                        FROM tb_sim_equipamento simEquip
                        WHERE simEquip.id_equipamento = '$idEquip' AND simEquip.status_ativo = '1'";

            $result         = $this->db->select($query);
            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'equipamento' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }
                foreach ($result as $row) {
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamento' => $retorno);
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }


    /*
    * Função para carregar os tipos de equipamentos
    */
    public function listarTipoEquip(){

        $query = "SELECT id, tipo_equipamento
                FROM tb_tipo_equipamento
                WHERE status = '1'";

                $result         = $this->db->select($query);

                /* VERIFICA SE EXISTE RESPOSTA */
                if(!empty($result))
                {
                    // /* VERIFICA SE EXISTE VALOR */
                    // if (@mysql_num_rows($result) > 0)
                    // {
                    //     /* ARMAZENA NA ARRAY */
                    //     while ($row = @mysql_fetch_assoc ($result))
                    //     {
                    //         $retorno[] = $row;
                    //     }
                    //
                    //     /* DEVOLVE RETORNO */
                    //     $array = array('status' => true, 'equipamento' => $retorno);
                    // }else{
                    //     $array = array('status' => false);
                    // }

                    foreach ($result as $row) {
                        $retorno[] = $row;
                    }
                    /* DEVOLVE RETORNO */
                    $array = array('status' => true, 'equipamento' => $retorno);

                }else{
                    $array = array('status' => false);
                }

        return $array;
    }

    /*
    *   Função para carregar o tipo de equipamento e o posicionamento na tabela
    */
    public function carregarPosicaoTabela($idTipo)
    {
        if(is_numeric($idTipo)){

            $query = "SELECT tipoEquip.id, tipoEquip.descricao_equipamento, tipoEquip.posicoes_tabela
                     FROM tb_tipo_equipamento tipoEquip
                     WHERE tipoEquip.id = '$idTipo'";

            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'equipamento' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }
                foreach ($result as $row) {
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'equipamento' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * FUNÇÃO PARA REGISTRAR POSICIONAMENTO DO EQUIPAMENTO NA TABELA
    */
    public function registroPosicao($idSimEquipamento, $idNumSim, $posicao){

        if(is_numeric($idSimEquipamento)){

            $query = "INSERT INTO tb_posicao (id_sim_equipamento, id_num_sim, posicao, status_ativo) VALUES ('$idSimEquipamento', '$idNumSim', '$posicao', '1')";

            /* MONTA RESULT */
            $result = $this->db->query($query);
            //var_dump($query);
            if ($result){
                $array = array('status' => true);
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * RETORNA A QUANTIDADE DE BATERIAS POR BANCO
    */
    public function quantidadeBateriaPorBanco($idEquip){

        if(is_numeric($idEquip)){

            $query = "SELECT quantidade_bateria_por_banco FROM tb_equipamento WHERE id = '$idEquip' AND status_ativo = '1'";
            //var_dump($query);


            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'quantidade' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }
                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'quantidade' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * REMOVER O EQUIPAMENTO SOLICITADO VIA JSON
    */
    public function removerEquipamentoViaJson($idEquipamento){
        // Coletar os dados do post
        $idEquip   = $idEquipamento;

        if(is_numeric($idEquip)){

            $query = "UPDATE tb_equipamento SET  status_ativo = '0' WHERE id = '$idEquip'";

            /* monta result */
            $result = $this->db->query($query);

            if ($result){
              $array = array('status' => true);
            }else{
              $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * REMOVER OS PARAMETROS DO EQUIPAMENTO SOLICITADO VIA JSON
    */
    public function removerParametrosEquipamentoViaJson($idEquipamento){

        // Coletar os dados do post
        $idEquip   = $idEquipamento;

        if(is_numeric($idEquip)){

            $query = "UPDATE tb_parametro SET  status_ativo = '0' WHERE id_equipamento = '$idEquip'";

            /* monta result */
            $result = $this->db->query($query);

            if ($result){
              $array = array('status' => true);
            }else{
              $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * REMOVER AS POSIÇÕES DO EQUIPAMENTO NO SIM
    */
    public function removerPosicoesTabelaEquipamentoViaJson($idSimEquip, $numEquipSim){

        if(is_numeric($idSimEquip)){

            $query = "UPDATE tb_posicao
                        SET status_ativo = '0'
                        WHERE id_sim_equipamento = '$idSimEquip' AND id_num_sim = '$numEquipSim'";

            /* monta result */
            $result = $this->db->query($query);

            if ($result){
              $array = array('status' => true);
            }else{
              $array = array('status' => false);
            }

        }else{

            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CARREGA OS DADOS DE CONTATO DO EQUIPAMENTO
    */
    public function dadosContatosEquipamentos($idEquipamento){

        if(is_numeric($idEquipamento)){

            $query = "SELECT contEquip.id, contEquip.id_cliente, contEquip.id_filial, contEquip.id_equipamento, clie.nome AS 'clieNome', contEquip.nome_contato, contEquip.funcao, contEquip.email, contEquip.celular, contEquip.observacao
                        FROM tb_contato_alerta_equip contEquip
                        JOIN tb_cliente clie ON clie.id = contEquip.id_cliente
                        WHERE id_equipamento = '$idEquipamento'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'contatos' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'contatos' => $retorno);

            }else{
                $array = array('status' => false);
            }


        }
        return $array;
    }

    /*
    * CARREGA A LISTA DE CHIPS ATIVOS
    */
    public function listaChipsSimAtivos(){

        $query = "SELECT num_sim, id_cliente, id_filial
                  FROM tb_sim
                  WHERE status_ativo = '1'";

        /* MONTA RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if(!empty($result))
        {
            // /* VERIFICA SE EXISTE VALOR */
            // if (@mysql_num_rows($result) > 0)
            // {
            //     /* ARMAZENA NA ARRAY */
            //     while ($row = @mysql_fetch_assoc ($result))
            //     {
            //         $retorno[] = $row;
            //     }
            //
            //     /* DEVOLVE RETORNO */
            //     $array = array('status' => true, 'chipsSims' => $retorno);
            // }else{
            //     $array = array('status' => false);
            // }
            foreach ($result as $row){
                $retorno[] = $row;
            }
            /* DEVOLVE RETORNO */
            $array = array('status' => true, 'chipsSims' => $retorno);

        }else{
            $array = array('status' => false);
        }

    }

    /*
    * FILTRA OS CHIPS QUE NÃO ESTÃO VINCULADOS
    */
    public function carregarSinsDisponiveis(){

        $query = "SELECT num_sim
                  FROM tb_sim
                  WHERE status_ativo = '1' AND id_cliente = '0' AND id_filial ='0'";

        /* MONTA RESULT */
       $result = $this->db->select($query);

       /* VERIFICA SE EXISTE RESPOSTA */
       if(!empty($result))
       {
        //    /* VERIFICA SE EXISTE VALOR */
        //    if (@mysql_num_rows($result) > 0)
        //    {
        //        /* ARMAZENA NA ARRAY */
        //        while ($row = @mysql_fetch_assoc ($result))
        //        {
        //            $retorno[] = $row;
        //        }
           //
        //        /* DEVOLVE RETORNO */
        //        $array = array('status' => true, 'chipsSims' => $retorno);
        //    }else{
        //        $array = array('status' => false);
        //    }
            foreach ($result as $row){
                $retorno[] = $row;
            }
            /* DEVOLVE RETORNO */
            $array = array('status' => true, 'chipsSims' => $retorno);

       }else{
           $array = array('status' => false);
       }

       return $array;
    }

    /**
    * FUNÇÃO PARA FILTRAR OS CHIPS SIM DE ACORDO COM SEUS STATUS
    */
    public function filtroChipSims($statusChip){

        if(is_numeric($statusChip)){

            $condicoes  = "";

            switch ($statusChip) {
                case '0':
                    $condicoes  .= " sim.status_ativo ='1'";
                break;
                case '1':
                    $condicoes  .= " sim.status_ativo ='0'";
                break;
                case '2':
                    $condicoes  .= " sim.id_cliente > 0 AND sim.status_ativo ='1'";
                break;
                case '3':
                    $condicoes  .= " sim.id_cliente = '0' AND sim.status_ativo ='1'";
                break;

                default:
                    $condicoes  .= " sim.status_ativo ='1'";
                break;
            }

            $query      = "SELECT sim.num_sim, sim.id_cliente, sim.id_filial, sim.versao_projeto, sim.telefone_chip, sim.data_teste, sim.data_instalacao_clie, sim.data_desativacao,
                            clie.nome AS 'cliente', fili.nome AS 'filial'
                            FROM tb_sim sim
                            LEFT JOIN tb_cliente clie ON sim.id_cliente = clie.id
                            LEFT JOIN tb_filial fili ON sim.id_filial = fili.id
                            WHERE  ".$condicoes." ";
            // var_dump($query);

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'chipsSims' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'chipsSims' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;

    }

    /**
    * FUNÇÃO PARA FILTRAR OS CHIPS SIM DE ACORDO COM SEUS STATUS E CLIENTE
    */
    public function filtroChipSimsCliente($statusChip, $idCliente){

        if(is_numeric($statusChip) && is_numeric($idCliente)){

            $condicoes  = "";

            switch ($statusChip) {
                case '0':
                    $condicoes  .= " sim.status_ativo ='1'";
                break;
                case '1':
                    $condicoes  .= " sim.status_ativo ='0'";
                break;
                case '2':
                    $condicoes  .= " sim.id_cliente > 0 AND sim.status_ativo ='1'";
                break;
                case '3':
                    $condicoes  .= " AND sim.id_cliente = '0' AND sim.status_ativo ='1'";
                break;

                default:
                    $condicoes  .= " sim.status_ativo ='1'";
                break;
            }

            $query      = "SELECT sim.num_sim, sim.id_cliente, sim.id_filial, sim.versao_projeto, sim.telefone_chip, sim.data_teste, sim.data_instalacao_clie, sim.data_desativacao,
                            clie.nome AS 'cliente', fili.nome AS 'filial'
                            FROM tb_sim sim
                            LEFT JOIN tb_cliente clie ON sim.id_cliente = clie.id
                            LEFT JOIN tb_filial fili ON sim.id_filial = fili.id
                            WHERE  ".$condicoes." AND clie.id = '$idCliente'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result))
            {
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'chipsSims' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'chipsSims' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CARREGA OS DADOS DO CHIP SIM
    */
    public function carregarDadosChipSim($idChipSim){

        $query = "SELECT sim.num_sim, sim.id_cliente, sim.id_filial, sim.versao_projeto, sim.modelo_chip, sim.telefone_chip, sim.ativo_cliente, sim.status_ativo,
                  sim.data_teste, sim.data_instalacao_clie, sim.data_desativacao, clie.nome AS 'cliente', fili.nome AS 'filial'
                  FROM tb_sim sim
                  LEFT JOIN tb_cliente clie ON sim.id_cliente = clie.id
                  LEFT JOIN tb_filial fili ON sim.id_filial = fili.id
                  WHERE sim.num_sim = '$idChipSim'";

        /* MONTA RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if(!empty($result))
        {
            // /* VERIFICA SE EXISTE VALOR */
            // if (@mysql_num_rows($result) > 0)
            // {
            //     /* ARMAZENA NA ARRAY */
            //     while ($row = @mysql_fetch_assoc ($result))
            //     {
            //         $retorno[] = $row;
            //     }
            //
            //     /* DEVOLVE RETORNO */
            //     $array = array('status' => true, 'informacoesChip' => $retorno);
            // }else{
            //     $array = array('status' => false);
            // }
            foreach ($result as $row){
                $retorno[] = $row;
            }
            /* DEVOLVE RETORNO */
            $array = array('status' => true, 'informacoesChip' => $retorno);
        }else{
            $array = array('status' => false);
        }

        return $array;

    }

    /*
    * ATUALIZAR DADOS DO SIM CHIP
    */
    public function atualizarDadosSimChip($simChip, $telefoneChip, $modeloS, $versaoProjeto, $dataTeste){

        $query = "UPDATE tb_sim
                 SET telefone_chip = '$telefoneChip', modelo_chip = '$modeloS', versao_projeto = '$versaoProjeto', data_teste = '$dataTeste'
                 WHERE num_sim = '$simChip'";

        /* monta result */
        $result = $this->db->query($query);

        if ($result){
          $array = array('status' => true);
        }else{
          $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CADASTRAR NOVO CHIP SIM
    */
    public function cadastrarNovoChipSim($numeroChip, $numeroTelefone, $modeloChip, $versaoProjeto){

        if(is_numeric($numeroChip)){

            $numeroChip         = $this->tratamento($numeroChip);
            $numeroTelefone     = $this->tratamento($numeroTelefone);
            $modeloChip         = $this->tratamento($modeloChip);
            $versaoProjeto      = $this->tratamento($versaoProjeto);

            $query = "INSERT INTO tb_sim(num_sim, versao_projeto, modelo_chip, telefone_chip, ambiente_local_sim) VALUES('$numeroChip', '$numeroTelefone', '$modeloChip', '$versaoProjeto', 'Não informado.')";

            /* MONTA RESULT */
            $result = $this->db->query($query);
                //var_dump($query);
            if ($result){
                $array = array('status' => true);
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CARREGAR OS DADOS DE CALIBRAÇÃO DO EQUIPAMENTO
    */
    public function posicoesCalibradas($idEquip){

        if(is_numeric($idEquip)){

            $query = "SELECT caliEquip.id, caliEquip.id_equip, caliEquip.posicao_tab, caliEquip.variavel_cal
                      FROM tb_equipamento_calibracao caliEquip
                      WHERE caliEquip.id_equip = '$idEquip'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){

                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'posicoesCalibradas' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }
                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'posicoesCalibradas' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CARREGA AS POSICOES DO TIPO DE EQUIPAMENTO
    */
    public function posicoesTipoEquipamento($idTipoEquipamento){

        if(is_numeric($idTipoEquipamento)){

            $query = "SELECT tpEquipamento.posicoes_tabela
                      FROM tb_tipo_equipamento tpEquipamento
                      WHERE tpEquipamento.id = '$idTipoEquipamento'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'posicoesTipoEquip' => $retorno);
                // }else{
                //     $array = array('status' => false);
                // }
                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'posicoesTipoEquip' => $retorno);
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * TENTA CARREGAR O ÚLTIMO DADO ENVIADO PELO EQUIPAMENTO NA POSIÇÃO INFORMADA
    */
    public function ultimoDadoenviadoPelaPosicao($idEquipamento, $posicao){
        /*
        * NOTA : EM ORDEM PARA QUE A FUNÇÃO RETORNE O VALOR DESEJADO, O EQUIPAMENTO DEVE ESTAR VINCULADO COM UM CHIP SIM E ESTAR CONFIGURADO PARA RECEBER PARAMETROS
        */

        if(is_numeric($idEquipamento)){

            $query = "SELECT $posicao
                       FROM tb_dados dados
                       JOIN tb_sim_equipamento  simEquip ON simEquip.id_sim = dados.num_sim
                       WHERE simEquip.id_equipamento = '$idEquipamento' AND simEquip.status_ativo = '1'
                       ORDER BY dados.dt_criacao DESC LIMIT 1";

            //var_dump($query);

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){
                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'ultimoDadoPosicao' => $retorno[0]);
                // }else{
                //     $array = array('status' => false);
                // }
                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'ultimoDadoPosicao' => $retorno[0]);
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;

    }

    /*
    * APÓS GERAR O VALOR DE VARIAVEL DE CALIBRAÇÃO, É EFETUADO O REGISTRO NO BANCO DE DADOS
    */
    public function salvarPosicaoTabelaJson($idEquipamento, $posicao, $variaveCalibracao){

    }

    /*
    * RECUPERAÇÃO DE VARIAVEL DE CALIBRAÇÃO JÁ EXISTENTE
    */
    public function recuperaVariavelExistente($idEquipamento, $posicao){

        if(is_numeric($idEquipamento)){

            $query = "SELECT equipCali.id
                      FROM tb_equipamento_calibracao equipCali
                      WHERE equipCali.id_equip  = '$idEquipamento' AND equipCali.posicao_tab = '$posicao'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){

                // /* VERIFICA SE EXISTE VALOR */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* ARMAZENA NA ARRAY */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* DEVOLVE RETORNO */
                //     $array = array('status' => true, 'idVariavel' => $retorno[0]);
                // }else{
                //     $array = array('status' => false);
                // }

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'idVariavel' => $retorno[0]);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CADASTRA NOVA VARIAVEL DE CALIBRACAO
    */
    public function registraNovaVariavelCalibri($idEquipamento, $posicao, $variavel){

        if(is_numeric($idEquipamento)){

            $query = "INSERT INTO tb_equipamento_calibracao(id_equip, posicao_tab, variavel_cal) VALUES ('$idEquipamento','$posicao','$variavel')";

            /* MONTA RESULT */
            $result = $this->db->query($query);
                //var_dump($query);
            if ($result){
                $array = array('status' => true, 'operatio' => 'Cadastrado');
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * ATUALIZAR A VARIAVEL DE CALIBRACAO DA POSICAO DO EQUIPAMENTO
    */
    public function atualizarVariavelCalibri($idVariavel, $variavelCalibri){

        if(is_numeric($idVariavel)){

            $query = "UPDATE tb_equipamento_calibracao equipCalibri
                      SET equipCalibri.variavel_cal = '$variavelCalibri'
                      WHERE equipCalibri.id = '$idVariavel'";

            /* MONTA RESULT */
            $result = $this->db->query($query);

            if ($result){
                $array = array('status' => true, 'operatio' => 'Atualizado');
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    public function ufEquipamentosCliente($idCliente){

        if(is_numeric($idCliente)){

            $query = "SELECT
                        estados.id AS 'idMatriz',
                        estados.nome AS 'estadoMatriz',
                        estadoFili.id,
                        estadoFili.nome
                      FROM tb_cliente clie
                      JOIN tb_equipamento equip ON clie.id = equip.id_cliente
                      LEFT JOIN tb_filial fili ON fili.id = equip.id_filial
                      LEFT JOIN tb_estado estados ON estados.id = clie.id_estado AND equip.id_filial = '0'
                      LEFT JOIN tb_estado estadoFili ON estadoFili.id = fili.id_estado AND equip.id_filial > '0'
                      WHERE clie.id = '$idCliente' AND equip.status_ativo = '1'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'estados' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * RETORNA O TIPO DE EQUIPAMENTO
    */

    public function carregarTipoEquipamento($idTipoEquip){

        if(is_numeric($idTipoEquip)){

            $query = "SELECT equip.tipo_equipamento
                      FROM tb_tipo_equipamento equip
                      WHERE equip.id = '$idTipoEquip' AND equip.status = '1'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'tipoEquipamento' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{

            $array = array('status' => false);

        }

        return $array;
    }

    /*
    * CARREGA DADOS DA PLANTA BAIXA DE UM EQUIPAMENTO
    */
    public function dadosEquipamentoPlantaBaixa($idEquipamento){

        if(is_numeric($idEquipamento)){

            $query = "SELECT
                        planta.id_planta,
                        planta.id_cliente,
                        planta.id_filial,
                        planta.descricao_imagem,
                        planta.imagem_planta
                      FROM tb_plantaBaixa planta
                      JOIN tb_equipamento equip ON equip.id = planta.id_equipamento
                      WHERE equip.id = '$idEquipamento' AND planta.status_ativo = '1'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'dadosPlanta' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{

            $array = array('status' => false);

        }

        return $array;
    }

    /*
    * EXCLUI A PLANTA BAIXA DO BANCO DE DADOS
    */
    public function removerPLantaBaixa($idPlanta){

        if(is_numeric($idPlanta)){

            $query = "DELETE FROM tb_plantaBaixa WHERE id_planta = '$idPlanta'";

            /* MONTA RESULT */
            $result = $this->db->query($query);

            if ($result){
                $array = array('status' => true, 'operatio' => 'Removido');
            }else{
                $array = array('status' => false);
            }

        }else{

            $array = array('status' => false);

        }

        return $array;
    }

    /*
    * REMOVER PONTOS CADASTRADOS PARA A PLANTA BAIXA
    */
    public function removerPontosPlanta($idPlanta){

        if(is_numeric($idPlanta)){

            $query = "DELETE FROM tb_plantaPonto WHERE id_planta = '$idPlanta'";

            /* MONTA RESULT */
            $result = $this->db->query($query);

            if ($result){
                $array = array('status' => true, 'operatio' => 'Removido');
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * SALVAR DADOS DA PLANTA BAIXA
    */
    public function cadastrarPlantaJson($cliente, $filial, $equipId, $textoPlanta, $arquivoFinal){

        if(is_numeric($cliente) && is_numeric($filial)){

            $query = "INSERT INTO tb_plantaBaixa (id_cliente, id_filial, id_equipamento, descricao_imagem, imagem_planta) VALUES ('$cliente','$filial', '$equipId', '$textoPlanta','$arquivoFinal')";

            /* MONTA RESULT */
            $result = $this->db->query($query);

            // Verifica se gravou com sucesso
            if ($result)
            {
                $array = array('status' => true);
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CARREGA OS PONTOS CADASTRADOS DO EQUIPAMENTO
    */
    public function carregarPontosPlantaBaixa($idEquip){

        if(is_numeric($idEquip)){

            $query = "SELECT id_ponto, id_planta, id_equipamento, coordenada_x, coordenada_y, ponto_tabela FROM tb_plantaPonto WHERE id_equipamento = '$idEquip' AND status_ativo = '1'";

            /* MONTA RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if(!empty($result)){

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'pontosPLanta' => $retorno);

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * VERIFICA SE PONTO DO EQUIPAMENTO ESXISTE
    */
    public function verificaPosicionamentoExistente($idEquipamento, $idPLantaBaixa, $pontoCad){

        $query = "SELECT id_planta, id_ponto
                    FROM tb_plantaPonto
                    WHERE id_planta = '$idPLantaBaixa'  AND id_equipamento = '$idEquipamento' AND  	ponto_tabela = '$pontoCad' AND status_ativo = '1'";

        /* MONTA RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if(!empty($result)){

            /* DEVOLVE RETORNO */
            $array = array('status' => true);

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * CADASTRA O POSICIONAMENTO DE UM PONTO
    */
    public function cadastrarPosicionamento($idEquip, $idPlantaBaixa, $idPosicao, $posx, $posy){

        $query = "INSERT INTO tb_plantaPonto (id_planta, id_equipamento, coordenada_x, coordenada_y, ponto_tabela) VALUES ('$idPlantaBaixa', '$idEquip', '$posx', '$posy', '$idPosicao')";

        //print_r($query);

        $result   = $this->db->select($query);

        // Verifica se gravou com sucesso
        if ($result)
        {
            $array = array('status' => true);
        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * ATUALIZA O POSICIONAMENTO DE UM PONTO DO EQUIPAMENTO
    */
    public function atualizarPosicionamento($idEquip, $idPlantaBaixa, $idPosicao, $posx, $posy){

        $query = "UPDATE tb_plantaPonto
                  SET coordenada_x = '$posx', coordenada_y = '$posy'
                  WHERE id_planta = '$idPlantaBaixa' AND id_equipamento = '$idEquip' AND ponto_tabela = '$idPosicao'";

        /* MONTA RESULT */
        $result = $this->db->query($query);

        if ($result){
            $array = array('status' => true);
        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * DESATIVA OS POSICIONAMENTOS DE UM PONTO
    */
    public function desativarPosicionamentos($idEquip, $idPlantaBaixa){

        $query = "UPDATE tb_plantaPonto
                  SET status_ativo = '0'
                  WHERE id_planta = '$idPlantaBaixa' AND id_equipamento = '$idEquip'";

        /* MONTA RESULT */
        $result = $this->db->query($query);

        if ($result){
            $array = array('status' => true);
        }else{
            $array = array('status' => false);
        }

        return $array;
    }
}


?>
