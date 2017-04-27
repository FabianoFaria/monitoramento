<?php

class LogModel extends MainModel
{

    public function __construct ($db = false, $controller = null)
    {
        /* carrega a conexao */
        $this->db = $db;

        /* carrega o controller */
        $this->controller = $controller;

        /* carrega os parametros */
        $this->parametros = $this->controller->parametros;
    }

    /*
    * Função para registrar atividade do usuário
    */
    public function registrarAtividade($idUsuario, $idAtividade){

        $query = "INSERT INTO tb_atividades_usuarios (id_usuario, id_atividade) VALUES ('$idUsuario','$idAtividade')";

        /* MONTA A RESULT */
        $result = $this->db->select($query);

        return;

    }

    /*
    * Função para carregar as atividades de determinado usuário
    */
    public function listarAtividadesUsuarios($idUsuarioDesejado){

        if(is_numeric($idUsuarioDesejado)){

            $query = "SELECT users.id, users.nome, users.sobrenome, atividadesUsr.id_atividade, atividadesUsr.data_registro, atividades.nome_atividade
                      FROM tb_users users
                      JOIN tb_atividades_usuarios atividadesUsr ON atividadesUsr.id_usuario = users.id
                      JOIN tb_atividade atividades ON atividadesUsr.id_atividade = atividades.id
                      WHERE users.id = '$idUsuarioDesejado'
                      ORDER BY atividadesUsr.id DESC LIMIT 50";

            /* monta a result */
            $result = $this->db->select($query);

            /* verifica se existe resposta */
            if(!empty($result))
            {
                // /* verifica se existe valor */
                // if (@mysql_num_rows($result) > 0)
                // {
                //     /* armazena na array */
                //     while ($row = @mysql_fetch_assoc ($result))
                //     {
                //         $retorno[] = $row;
                //     }
                //
                //     /* devolve retorno */
                //     //return $retorno;
                //     $array = array('status' => true, 'atividades' => $retorno);
                // }else{
                //     $array = array('status' => false, 'atividades' => ' ');
                // }

                foreach ($result as $row){
                    $retorno[] = $row;
                }
                /* DEVOLVE RETORNO */
                $array = array('status' => true, 'atividades' => $retorno);
            }
            else{
                $array = array('status' => false, 'atividades' => ' ');
            }

        }else{
            $array = array('status' => false, 'atividades' => ' ');
        }

        return $array;

    }


}

?>
