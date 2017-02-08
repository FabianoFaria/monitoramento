<?php

/**
* Classe de modelo que gerencia as informacoes dos fabricantes
*/

class FabricanteModel extends MainModel
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

    /* FUNÇÃO RESPONSAVEL PELA LISTAGEM DE FABRICANTES
    *
    */
    public function listarFabricantes()
    {
        $query = "SELECT fabri.id, fabri.nome, fabri.telefone, fabri.ddd, fabri.endereco, fabri.cidade, est.nome as 'estado', pais.nome as 'pais' FROM tb_fabricante fabri
                    LEFT JOIN tb_estado est ON est.id = fabri.id_estado
                    JOIN tb_pais pais ON pais.id = fabri.id_pais
                    JOIN tb_users usr ON  usr.id = fabri.id_users
                    WHERE fabri.status_ativo = '1'";

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
    * Fabricante para registrar via JSON
    */
    public function registrarFabricanteJson($novoFabricante, $ddd, $telefone, $cep, $endereco, $numero, $bairro, $cidade, $estado, $pais, $email)
    {
        $idUser = $_SESSION['userdata']['userId'];

        $novoFabricante     = $this->tratamento($novoFabricante);
        $endereco           = $this->tratamento($endereco);
        $bairro             = $this->tratamento($bairro);
        $cidade             = $this->tratamento($cidade);
        $email              = $this->tratamento($email,1);

        $ddd        = str_replace('(', ' ', $ddd);
        $ddd        = str_replace(')', ' ', $ddd);
        $telefone   = str_replace('-', '', $telefone);
        $cep        = str_replace('-', '', $cep);

        // Monta a query
        $query = "insert into tb_fabricante (nome, ddd, telefone, cep, endereco, numero, cidade, bairro, id_pais, id_estado,id_users, email_fabricante)
                  values ('$novoFabricante','$ddd','$telefone','$cep','$endereco','$numero','$cidade',
                          '$bairro','$pais','$estado','$idUser', '$email')";


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
    * FUNÇÃO PARA CARREGAR OS DADOS DE DETERMINADO FABRICANTE
    */
    public function carregarDadosFabricanteViaJson($idFabricante){

        $query  = "SELECT id, id_estado, id_pais, nome, ddd, telefone, email_fabricante, cep, endereco, numero, cidade, bairro FROM tb_fabricante WHERE id = '$idFabricante'";

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
                $array = array('status' => true, 'dados' => $retorno[0]);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * FUNÇÃO PARA ATUALIZAR OS DADOS DO CLIENTE
    */
    public function atualizarFabricanteViaJson($idFabricante, $fabricante, $ddd, $telefone, $cep, $endereco, $numero, $bairro, $cidade, $estado, $pais, $email){

        // Coletar os dados do post
        $nome       = $this->tratamento($fabricante);
        $endereco   = $this->tratamento($endereco);
        $bairro     = $this->tratamento($bairro);
        $cidade     = $this->tratamento($cidade);
        $email      = $this->tratamento($email,1);

        $ddd        = str_replace('(', ' ', $ddd);
        $ddd        = str_replace(')', ' ', $ddd);
        $telefone   = str_replace('-', '', $telefone);
        $cep        = str_replace('-', '', $cep);

        $query = "UPDATE tb_fabricante SET ";
          if(isset($nome)){         $query .= "nome = '$nome' ";}
          if(isset($email)){        $query .= ", email_fabricante = '$email'";}

          if(isset($ddd)){          $query .= ", ddd = '$ddd'";}
          if(isset($telefone)){     $query .= ", telefone = '$telefone'";}

          if(isset($cep)){          $query .= ", cep = '$cep'";}
          if(isset($endereco)){     $query .= ", endereco = '$endereco'";}
          if(isset($numero)){       $query .= ", numero = '$numero'";}

          if(isset($bairro)){      $query .= ", bairro = '$bairro'";}
          if(isset($cidade)){      $query .= ", cidade = '$cidade'";}

          if(isset($estado)){       $query .= ", id_estado = '$estado'";}
          if(isset($pais)){         $query .= ", id_pais = '$pais'";}

          $query .= " WHERE id = '$idFabricante'";

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
    * FUNÇÃO PARA REMOÇÃO DO FABRICANTE DA LISTA
    */
    public function removerFabricanteViaJson($idFabricante){

        if(is_numeric($idFabricante)){

            $query = "UPDATE tb_fabricante SET status_ativo = '0' WHERE id = '$idFabricante'";

            /* MONTA RESULT */
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
