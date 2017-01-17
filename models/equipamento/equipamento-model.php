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
        $query = "SELECT equip.id, equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante', equip.modelo, equip.potencia, equip.qnt_bateria, equip.caracteristica_equip, equip.tipo_bateria, equip.amperagem_bateria , clie.nome as 'cliente', simEquip.id_sim as 'sim_clie'
                    FROM tb_equipamento equip
                    JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                    LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                    LEFT JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id";

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
    * Função para carregar lista de equipamentos de cliente especifico
    */
    public function listarEquipamentosCliente($idCliente)
    {
        if(is_numeric($idCliente)){

            $query = "SELECT equip.id, equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante', equip.modelo, equip.potencia, equip.qnt_bateria, equip.caracteristica_equip, equip.tipo_bateria, equip.amperagem_bateria , clie.nome as 'cliente', simEquip.id_sim as 'sim_clie'
                        FROM tb_equipamento equip
                        JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante
                        LEFT JOIN tb_cliente clie ON equip.id_cliente = clie.id
                        LEFT JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id
                        WHERE equip.id_cliente = '$idCliente'";

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
    *   Carregar dados equipamento
    */

    public function dadosEquipamentoCliente($idEquipamento)
    {

        if(is_numeric($idEquipamento)){
            $query = "SELECT equip.id, equip.id_cliente, equip.id_filial, equip.tipo_equipamento, equip.nomeEquipamento, equip.modelo, equip.potencia, equip.qnt_bateria, equip.caracteristica_equip, equip.tipo_bateria, equip.amperagem_bateria, clie.nome as 'cliente', fili.nome as 'filial'
                      FROM tb_equipamento equip
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

    public function registrarEquipamentoJson($idCliente, $idFilial, $equipamento, $nomeEquipamento, $modEquip, $fabricante, $quantBateria, $caracteristicas, $amperagem, $tipoBateria, $potencia){

        // Verifica se os cambos obrigatorios nao sao nulos
        if ($idCliente != "" && $equipamento != "" && $modEquip != "" && $fabricante != "")
        {

            // Trata os valores
            $idUser         = $_SESSION['userdata']['userId'];
            $idCliente      = $idCliente;
            $idFilial       = ($idFilial == '') ? 0 : $idFilial;
            $idFabri        = $fabricante;
            $tipoEquip      = $equipamento;
            $nomeEquipamento = isset($nomeEquipamento) && !empty ($nomeEquipamento) ? $this->converte($this->tratamento($nomeEquipamento)) : '';
            $modeloEquip    = isset($modEquip) && !empty ($modEquip) ? $this->converte($this->tratamento($modEquip)) : '';
            $potencia       = isset($potencia) && !empty ($potencia) ? $this->converte($this->tratamento($potencia)) : '';
            $qntBateria     = isset($quantBateria) && !empty ($quantBateria) ? $this->converte($this->tratamento($quantBateria)) : 0;
            $caracteristica = isset($caracteristicas) && !empty ($caracteristicas) ? $this->converte($this->tratamento($caracteristicas)) : '';
            $tipoBateria    = isset($tipoBateria) ? $tipoBateria : '';
            $amperagem      = isset($amperagem) && !empty ($amperagem) ? $this->converte($this->tratamento($amperagem)) : '';

            // Se nao estiver em branco
            // Realiza a insercao no banco
            $query          = "INSERT INTO tb_equipamento (id_users, id_fabricante, id_cliente, id_filial, tipo_equipamento, nomeEquipamento, modelo, potencia,qnt_bateria, caracteristica_equip, tipo_bateria, amperagem_bateria) VALUES ('$idUser','$idFabri', '$idCliente', '$idFilial','$tipoEquip','$nomeEquipamento','$modeloEquip','$potencia','$qntBateria','$caracteristica','$tipoBateria','$amperagem')";

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

    public function editarEquipamentoJson($nomeEquipamento, $idEquip, $idFabricante, $idCliente, $idFilial, $equipamento, $modEquip, $caracteristicas, $quantBateria, $amperagem, $tipoBateria, $potencia)
    {

        // Armazena o retorno do post
        $nomeEquipamento    = $this->tratamento($nomeEquipamento);
        $idEquip            = $this->tratamento($idEquip);
        $idFabricante       = $this->tratamento($idFabricante);
        $cliente            = $this->tratamento($idCliente);
        $filial             = $this->tratamento($idFilial);
        $equipamento        = $this->tratamento($equipamento);
        $modEquip           = $this->tratamento($modEquip);
        $caracteristicas    = $this->tratamento($caracteristicas);
        $quantBateria       = $this->tratamento($quantBateria);
        $amperagem          = $this->tratamento($amperagem);
        $tipoBateria        = $this->tratamento($tipoBateria);
        $potencia           = $this->tratamento($potencia);


        $query = "UPDATE tb_equipamento SET ";
          if(isset($nomeEquipamento)){  $query .= "nomeEquipamento = '$nomeEquipamento' ,";}
          if(isset($id_fabricante)){  $query .= "id_fabricante = '$idFabricante' ,";}
          if(isset($cliente)){  $query .= "id_cliente = '$cliente' ,";}
          if(isset($filial)){  $query .= "id_filial = '$filial' ,";}
          if(isset($equipamento)){  $query .= "tipo_equipamento = '$equipamento' ,";}
          if(isset($modEquip)){  $query .= "modelo = '$modEquip' ,";}
          if(isset($caracteristicas)){  $query .= "caracteristica_equip = '$caracteristicas' ,";}
          if(isset($quantBateria)){  $query .= "qnt_bateria = '$quantBateria' ,";}
          if(isset($amperagem)){  $query .= "amperagem_bateria = '$amperagem' ,";}
          if(isset($tipoBateria)){  $query .= "tipo_bateria = '$tipoBateria' ,";}
          if(isset($potencia)){  $query .= "potencia = '$potencia' ";}
        $query .= " WHERE id = '$idEquip'";

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
    * Função para registrar posicionamento do equipamento na tabela
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


}

?>
