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
        $query = "SELECT equip.id, equip.tipo_equipamento as 'equipamento', fabri.nome as 'fabricante', equip.modelo, equip.potencia, equip.qnt_bateria, equip.caracteristica_equip, equip.tipo_bateria, equip.amperagem_bateria FROM tb_equipamento equip
                    JOIN tb_fabricante fabri ON fabri.id = equip.id_fabricante";

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
    * Registra vis JSON os dados do equipamento
    */

    public function registrarEquipamentoJson($idCliente, $idFilial, $equipamento, $modEquip, $fabricante, $quantBateria, $caracteristicas, $amperagem, $tipoBateria, $potencia){

        // Verifica se os cambos obrigatorios nao sao nulos
        if ($idCliente != "" && $equipamento != "" && $modEquip != "" && $fabricante != "")
        {

            // Trata os valores
            $idUser         = $_SESSION['userdata']['userId'];
            $idCliente      = $idCliente;
            $idFilial       = ($idFilial == "") ? 0 : $idFilial;
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
            $query          = "insert into tb_equipamento (id_users, id_fabricante, id_cliente, id_filial,
                                tipo_equipamento, modelo, potencia,qnt_bateria, caracteristica_equip, tipo_bateria, amperagem_bateria)
                                values ('$idUser','$idFabri', $idCliente, $idFilial,'$tipoEquip','$modeloEquip','$potencia','$qntBateria'
                                ,'$caracteristica','$tipoBateria','$amperagem')";
            
            //var_dump($query);

            $result         = $this->db->select($query);

            $idEquip        = mysql_insert_id();

            $array = array('status' => $result, 'idequipamento' => $idEquip);

        }else{

            $array = array('status' => false, 'idequipamento' => 0);

        }

        return $array;

    }

}

?>
