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
    *   Carregar dados equipamento
    */

    public function dadosEquipamentoCliente($idEquipamento)
    {

        if(is_numeric($idEquipamento)){
            $query = "SELECT equip.id, equip.id_cliente, equip.id_filial, equip.tipo_equipamento, equip.modelo, equip.potencia, equip.qnt_bateria, equip.caracteristica_equip, equip.tipo_bateria, equip.amperagem_bateria, clie.nome as 'cliente', fili.nome as 'filial'
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

    public function registrarEquipamentoJson($idCliente, $idFilial, $equipamento, $modEquip, $fabricante, $quantBateria, $caracteristicas, $amperagem, $tipoBateria, $potencia){

        // Verifica se os cambos obrigatorios nao sao nulos
        if ($idCliente != "" && $equipamento != "" && $modEquip != "" && $fabricante != "")
        {

            // Trata os valores
            $idUser         = $_SESSION['userdata']['userId'];
            $idCliente      = $idCliente;
            $idFilial       = ($idFilial == '') ? 0 : $idFilial;
            $idFabri        = $fabricante;
            $tipoEquip      = isset($equipamento) && !empty ($equipamento) ? $this->converte($this->tratamento($equipamento)) : '';
            $modeloEquip    = isset($modEquip) && !empty ($modEquip) ? $this->converte($this->tratamento($modEquip)) : '';
            $potencia       = isset($potencia) && !empty ($potencia) ? $this->converte($this->tratamento($potencia)) : '';
            $qntBateria     = isset($quantBateria) && !empty ($quantBateria) ? $this->converte($this->tratamento($quantBateria)) : 0;
            $caracteristica = isset($caracteristicas) && !empty ($caracteristicas) ? $this->converte($this->tratamento($caracteristicas)) : '';
            $tipoBateria    = isset($tipoBateria) ? $tipoBateria : '';
            $amperagem      = isset($amperagem) && !empty ($amperagem) ? $this->converte($this->tratamento($amperagem)) : '';

            // Se nao estiver em branco
            // Realiza a insercao no banco
            $query          = "INSERT INTO tb_equipamento (id_users, id_fabricante, id_cliente, id_filial, tipo_equipamento, modelo, potencia,qnt_bateria, caracteristica_equip, tipo_bateria, amperagem_bateria) VALUES ('$idUser','$idFabri', '$idCliente', '$idFilial','$tipoEquip','$modeloEquip','$potencia','$qntBateria','$caracteristica','$tipoBateria','$amperagem')";

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

    public function editarEquipamentoJson($idEquip, $idFabricante, $idCliente, $idFilial, $equipamento, $modEquip, $caracteristicas, $quantBateria, $amperagem, $tipoBateria, $potencia)
    {

        // Armazena o retorno do post
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
          if(isset($id_fabricante)){  $query .= "id_fabricante = '$idFabricante' ,";}
          if(isset($cliente)){  $query .= "id_cliente = '$cliente' ,";}
          if(isset($filial)){  $query .= "id_filial = '$filial' ,";}
          if(isset($equipamento)){  $query .= "id_filial = '$equipamento' ,";}
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

}

?>
