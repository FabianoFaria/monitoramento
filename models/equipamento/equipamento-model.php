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
                    JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                    LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                    LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                    LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                    LEFT JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id
                    WHERE equip.status_ativo = '1'";

        /* MONTA A RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if ($result)
        {
            /* VERIFICA SE EXISTE VALOR */
            if (@mysql_num_rows($result) > 0)
            {
                /* ARMAZENA NA ARRAY */
                while ($row = @mysql_fetch_assoc ($result))
                {
                    $retorno[] = $row;
                }

                /* DEVOLVE RETORNO */
                return $retorno;
            }
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

            $query = "SELECT equip.id, equip.nomeModeloEquipamento, equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante', equip.potencia, equip.qnt_bateria, equip.tipo_bateria , clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip'
                        FROM tb_equipamento equip
                        JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                        LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                        LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                        LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                        WHERE equip.id_cliente = '$idCliente' AND equip.status_ativo = '1'
                        GROUP BY equip.id";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if($result)
            {
                /* VERIFICA SE EXISTE VALOR */
                if (@mysql_num_rows($result) > 0)
                {
                    /* ARMAZENA NA ARRAY */
                    while ($row = @mysql_fetch_assoc ($result))
                    {
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
                        JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                        LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                        LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                        LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0
                        WHERE equip.id_cliente = '$idCliente' AND equip.id_filial = '$idFili'
                        GROUP BY equip.id";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if($result)
            {
                /* VERIFICA SE EXISTE VALOR */
                if (@mysql_num_rows($result) > 0)
                {
                    /* ARMAZENA NA ARRAY */
                    while ($row = @mysql_fetch_assoc ($result))
                    {
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

        }else{
            $array = array('status' => false, 'equipamentos' => '');
        }

        return $array;
    }

    /*
    * FILTRAR EQUIPAMENTOS DE ACORDO COM O LOCAL E O TIPO DE EQUIPAMENTO ESCOLHIDO
    */
    public function listarEquipamentosFilialClienteTipo($idCliente, $idFili, $idTipo){

        if(is_numeric($idCliente) && is_numeric($idFili) && is_numeric($idTipo)){
            $query = "SELECT equip.id,
             equip.nomeModeloEquipamento,
             equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante',
             equip.potencia,
             equip.qnt_bateria,
             equip.tipo_bateria,
             equip.localBateria,
             clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip' ";

            $query .= "";

            $query .= " FROM tb_equipamento equip";
            $query .= " JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante";
            $query .= " LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id";
            $query .= " LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id";
            $query .= " LEFT JOIN tb_filial fili ON fili.id = equip.id_filial AND equip.id_filial > 0";
            $query .= " WHERE";
            if($idCliente != 0 ){
                $query .= " equip.id_cliente = '$idCliente'";
            }
            if($idFili != 0  && $idCliente != 0 ){

                $query .= " AND equip.id_filial = '$idFili'";
            }
            if($idTipo != 0 ){
                if($idCliente != 0 ){
                    $query .= " AND equip.tipo_equipamento = '$idTipo'";
                }else{
                    $query .= " equip.tipo_equipamento = '$idTipo'";
                }
            }

            $query .= " GROUP BY equip.id";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if($result)
            {
                /* VERIFICA SE EXISTE VALOR */
                if (@mysql_num_rows($result) > 0)
                {
                    /* ARMAZENA NA ARRAY */
                    while ($row = @mysql_fetch_assoc ($result))
                    {
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
                    equip.qnt_bateria,
                    equip.quantidade_banco_bateria,
                    equip.quantidade_bateria_por_banco,
                    equip.tipo_bateria,
                    equip.localBateria,
                    clie.id as 'idClie', clie.nome as 'cliente', fili.nome as 'filial', tipo_equip.tipo_equipamento as 'tipoEquip'
                      FROM tb_equipamento equip
                      LEFT JOIN tb_tipo_equipamento tipo_equip ON equip.tipo_equipamento = tipo_equip.id
                      LEFT JOIN tb_cliente clie ON clie.id = equip.id_cliente
                      LEFT JOIN tb_filial fili ON fili.id = equip.id_filial
                      WHERE  equip.id = '$idEquipamento'";

            /* MONTA A RESULT */
            $result = $this->db->select($query);

            /* VERIFICA SE EXISTE RESPOSTA */
            if($result)
            {
                /* VERIFICA SE EXISTE VALOR */
                if (@mysql_num_rows($result) > 0)
                {
                    /* ARMAZENA NA ARRAY */
                    while ($row = @mysql_fetch_assoc ($result))
                    {
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
        }else{
            $array = array('status' => false, 'equipamento' => '');
        }

        return $array;

    }


    /*
    * Registra vis JSON os dados do equipamento
    */

    public function registrarEquipamentoJson($idCliente, $idFilial, $equipamento, $fabricante, $nomeModelo, $correnteBateria, $potencia, $tensaoBancoBat, $correnteBanco, $quantBat, $quantBancoBat, $quantBatPorBanc, $tipoBateria, $localBateria){

        // Verifica se os cambos obrigatorios nao sao nulos
        if ($idCliente != "" && $equipamento != "" && $equipamento != "" && $fabricante != "")
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

            // Se nao estiver em branco
            // Realiza a insercao no banco
            $query          = "INSERT INTO tb_equipamento (
                id_users,id_fabricante,id_cliente,id_filial,tipo_equipamento,nomeModeloEquipamento,correnteBateria,potencia,tensaoBancoBateria,correnteBancoBateria,qnt_bateria,quantidade_banco_bateria,quantidade_bateria_por_banco,tipo_bateria,localBateria)
                VALUES ('$idUser','$idFabri','$idCliente','$idFilial','$tipoEquip','$nomeEquipamento','$correnteBateria','$potencia','$tensaoBancoBat','$correnteBanco','$qntBateria','$quantBancoBat','$quantBatPorBanc','$tipoBateria','$localBateria')";

            //var_dump($query);

            $result         = $this->db->select($query);

            $idEquip        = mysql_insert_id();

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
        $localBateria)
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
          if(isset($localBateria)){  $query .= "localBateria  = '$localBateria' ";}

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
                        WHERE simEquip.id_equipamento = '$idEquip'";

            $result         = $this->db->select($query);
            /* VERIFICA SE EXISTE RESPOSTA */
            if($result)
            {
                /* VERIFICA SE EXISTE VALOR */
                if (@mysql_num_rows($result) > 0)
                {
                    /* ARMAZENA NA ARRAY */
                    while ($row = @mysql_fetch_assoc ($result))
                    {
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
                if($result)
                {
                    /* VERIFICA SE EXISTE VALOR */
                    if (@mysql_num_rows($result) > 0)
                    {
                        /* ARMAZENA NA ARRAY */
                        while ($row = @mysql_fetch_assoc ($result))
                        {
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
            if($result)
            {
                /* VERIFICA SE EXISTE VALOR */
                if (@mysql_num_rows($result) > 0)
                {
                    /* ARMAZENA NA ARRAY */
                    while ($row = @mysql_fetch_assoc ($result))
                    {
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

}

?>
