<?php

class UsuarioModel extends MainModel
{



    public function __construct ($db = false , $controller = null)
    {
        /* carrega a conexao */
        $this->db = $db;

        /* carrega o controller */
        $this->controller = $controller;

        /* carrega os parametros */
        $this->parametros = $this->controller->parametros;
    }


    public function dadosUsuario($idUser)
    {
        //Validação da id informada
        if($idUser > 0){

            $query = "SELECT * FROM tb_users WHERE id = ".$idUser." ";

            /* monta a result */
            $busca = $this->db->select($query);

            /* verifica se a query executa */
            if($busca){
                /* Retorna a row com os dados do usuário */
                while($row = @mysql_fetch_assoc($busca)){

                    return $row;
                }
            }
            else{
                return false;
            }

        }

        return false;
    }

    //atualiza os dados do usuário
    public function atualizarUsuario()
    {
        // Coletar os dados do post
        $id_user   = $_POST['txt_userId'];
        $nome      = $this->tratamento($_POST['txt_nome']);
        $sobrenome = $this->tratamento($_POST['txt_sobrenome']);
        $email     = $this->tratamento($_POST['txt_email'],1);
        $perfil    = is_numeric($_POST['opc_perfil']) ? $_POST['opc_perfil'] : 0 ;
        $cliente   = explode("-",$_POST['opc_cliente']);
        $local     = isset($_POST['opc_local']) ? $_POST['opc_local'] : 0;


        // Verifica se existe valor e se a variavel esta definida
        if (isset($cliente[1]) && is_numeric($cliente[1]))
        {
            // Verifica se o cliente eh uma filial
            if ($cliente[1] == 'c')
                $tipo_inst = 0;
            else if ($cliente[1] == 'f')
                $tipo_inst = 1;
        }else{
            $cliente[0] = 0;
            $tipo_inst = 0;
        }

        if(!empty($_POST['txt_senha']) && ($_POST['txt_senha'] == $_POST['txt_cfsenha'])){
            //efetua o tratamento da senha
            $senha = $this->tratamento($_POST['txt_senha'],2);

            // Verifica se existe um perfil selecionado
            if ($senha != $_POST['txt_senha'])
            {
                // Apresenta uma mensagem de erro
                echo "<div class='mensagemError'><span>Verifique se existe caracteres inv&aacute;lidos na senha</span></div>";

                // Encerra o processo
                return;
            }


            $senha = md5($_POST['txt_senha']);
        }else{
            $senha = "";
        }

        // Verifica se existe um perfil selecionado
        if ($perfil == 0)
        {
            // Apresenta uma mensagem de erro
            echo "<div class='mensagemError'><span>Nenhuma permissão foi selecionado!</span></div>";

            // Encerra o processo
            return;
        }

        // Verifica qual eh o local do usuario
        if ($local == 3)
        {
            // Se o local nao estiver definido
            // Apresenta uma mensagem de erro
            echo "<div class='mensagemError'><span>Nenhum local foi selecionado!</span></div>";

            // Encerra o processo
            return;
        }

        // Verifica se existe campo em braco
        if ($nome != "" && $sobrenome != "" && $email != "" && $perfil != "" && $cliente != "")
        {
            //query diferenciada em caso de alteração de senha
            if($senha != ""){
                $query = "UPDATE tb_users SET senha='$senha', id_perfil_acesso='$perfil', nome='$nome', sobrenome='$sobrenome', email='$email', local_usu='$local', id_cliente='$cliente[0]', tipo_inst='$tipo_inst' WHERE id = '$id_user'";
            }else{
                $query = "UPDATE tb_users SET id_perfil_acesso='$perfil', nome='$nome', sobrenome='$sobrenome', email='$email', local_usu='$local', id_cliente='$cliente[0]', tipo_inst='$tipo_inst' WHERE id = '$id_user'";
            }

            // Insere no banco e exibe uma mensagem
            $this->validaInsercaoBanco($query, "Usuário atualizado com sucesso!", "Erro durante o processo de atualização.");
        }
        else
        {
            // Se existir campo em branco
            // Apresentar mensagem informando que existe campo em branco
            echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
        }

    }


    /**
     * Funcao que valida a gravacao da query no banco
     *
     * @param string $query - recebe uma string contendo a query
     * @param string $msgSuc - recebe uma string contendo a mensagem de sucesso
     * @param string $msgErr - recebe uma string contendo a mensagem de erro
     */
    private function validaInsercaoBanco($query, $msgSuc, $msgErr)
    {
        // Verifica se gravou com sucesso
        if ($this->db->query($query))
        {
            // Se gravou
            // Apresenta a mensagem de sucesso
            echo "<div class='mensagemSucesso'><span>{$msgSuc}</span></div>";
        }
        else
        {
            // Se ocorreu um erro
            // Grava o erro no log
            // Monta a query do log
            $queryLog = "insert into tb_log (log) values ('Erro ao gravar o cadastro : [".str_replace("'","" , $query)."]')";

            // Executa a query
            $this->db->query($queryLog);

            // Apresenta a mensagem de erro
            echo "<div class='mensagemError'><span>{$msgErr}</span></div>";
        }
    }

    /**
     * Funcao que lista os usuários atualmente cadastrados
     *
      */
    public function listagemUsuario(){

        $query = "SELECT id, nome, sobrenome, email, dt_criaco FROM tb_users";

        /* monta a result */
        $result = $this->db->select($query);

        /* verifica se existe resposta */
        if ($result)
        {
            /* verifica se existe valor */
            if (@mysql_num_rows($result) > 0)
            {
                /* armazena na array */
                while ($row = @mysql_fetch_assoc ($result))
                {
                    $retorno[] = $row;
                }

                /* devolve retorno */
                return $retorno;
            }
        }
        else
            return false;

    }

    //Funções para tratamento de dados via JSON
    public function registrarUsuarioParaCliente($nome, $sobrenome, $email, $celular, $telefone, $senha, $idCliente){

        // Verifica se os cambos obrigatorios nao sao nulos
        if ($nome != "" && $sobrenome != "" && $email != "" && $celular != "" && $telefone != "")
        {

            // Coletar os dados do post
            $nome      = $this->tratamento($nome);
            $sobrenome = $this->tratamento($sobrenome);
            $email     = $this->tratamento($email,1);

            $query = "INSERT INTO tb_users(id_perfil_acesso, nome, sobrenome, email, telefone, celular, senha, local_usu, status_ativo, id_cliente) VALUES('2', '$nome', '$sobrenome', '$email', '$telefone', '$celular', '$senha', '1', '1', $idCliente)";

            //var_dump($query);

            // Verifica se gravou com sucesso
            if ($this->db->query($query))
            {
                $idGerada  = mysql_insert_id();
                $array = array('status' => true, 'idUsuario' => $idGerada);
            }else{
                $array = array('status' => false, 'idUsuario' => 0);
            }

        }else{
            $array = array('status' => false, 'idUsuario' => 0);
        }

        return $array;
    }

    /*
    * ATUALIZA OS DADOS ENVIADOS DO PRÓPIO USUÁRIO
    */
    public function atualizarUsuarioManual($id_usuario, $nome, $sobrenome, $email, $celular, $telefone, $senha, $confirmaS){

        // Coletar os dados do post
        $id_user   = $id_usuario;
        $nome      = $this->tratamento($nome);
        $sobrenome = $this->tratamento($sobrenome);
        $email     = $this->tratamento($email,1);
        if($senha == $confirmaS){
            $senha  = ($confirmaS != '') ? md5($confirmaS) : null;
        }else{
            $senha  = null;
        }

        $query = "UPDATE tb_users SET ";
          if(isset($nome)){         $query .= "nome = '$nome' ";}
          if(isset($sobrenome)){    $query .= ", sobrenome = '$sobrenome'";}
          if(isset($email)){        $query .= ", email = '$email'";}
          if(isset($celular)){      $query .= ", celular = '$celular'";}
          if(isset($telefone)){     $query .= ", telefone = '$telefone'";}
          if(isset($senha)){        $query .= ", senha = '$senha'";}
          $query .= " WHERE id = '$id_user'";

        /* MONTA RESULT */
        $result = $this->db->query($query);

        if ($result){
            $array = array('status' => true);
        }else{
            $array = array('status' => false);
        }

        return $array;

    }

    //Função para atualizar o usuario
    public function atualizarUsuarioJson($id_usuario, $nome, $sobrenome, $email, $celular, $telefone, $confirmaS, $idCliente)
    {

        // Coletar os dados do post
        $id_user   = $id_usuario;
        $nome      = $this->tratamento($nome);
        $sobrenome = $this->tratamento($sobrenome);
        $email     = $this->tratamento($email,1);
        $senha     = ($confirmaS != '') ? md5($confirmaS) : null;

        $query = "UPDATE tb_users SET ";
          if(isset($nome)){         $query .= "nome = '$nome' ";}
          if(isset($sobrenome)){    $query .= ", sobrenome = '$sobrenome'";}
          if(isset($email)){        $query .= ", email = '$email'";}
          if(isset($celular)){      $query .= ", celular = '$celular'";}
          if(isset($telefone)){     $query .= ", telefone = '$telefone'";}
          if(isset($senha)){        $query .= ", senha = '$senha'";}
          $query .= " WHERE id = '$id_user'";

          /* monta result */
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
