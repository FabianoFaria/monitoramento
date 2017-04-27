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
            if(!empty($busca)){
                // /* Retorna a row com os dados do usuário */
                // while($row = @mysql_fetch_assoc($busca)){
                //
                //     return $row;
                // }
                foreach ($busca as $row) {
                    $retorno = $row;
                }
                return $retorno;
            }
            else{
                return false;
            }

        }

        return false;
    }

    /*
    * CARREGA O AVARTAR DO USUÁRIO
    */
    public function carregarUserAvatar($usuarioId){
        //Validação da id informada
        if($usuarioId > 0){

            $query = "SELECT imagem_usuario FROM tb_users WHERE id = '$usuarioId'";

            /* monta a result */
            $busca = $this->db->select($query);

            /* verifica se a query executa */
            if(!empty($busca)){
                /* Retorna a row com os dados do usuário */
                // while($row = @mysql_fetch_assoc($busca)){
                //
                //     return $row;
                // }
                foreach ($busca as $row) {
                    $retorno = $row;
                }
                 return $retorno;
            }
            else{
                return false;
            }

        }else{
            return false;
        }
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

        $query = "SELECT
                    usr.id,
                    usr.nome,
                    usr.sobrenome,
                    usr.email,
                    usr.dt_criaco,
                    usr.id_cliente,
                    clie.nome AS 'cliente'
                FROM tb_users usr
                LEFT JOIN tb_cliente clie ON clie.id = usr.id_cliente
                WHERE usr.status_ativo = '1'";

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
            //     return $retorno;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }
            return $retorno;
        }
        else
            return false;

    }

    /**
     * Funcao que lista os usuários cadastrados para determinado cliente
     *
     */
    public function listagemUsuarioCliente($idCliente){
        $query = "SELECT
                    usr.id,
                    usr.nome,
                    usr.sobrenome,
                    usr.email,
                    usr.dt_criaco,
                    usr.id_cliente,
                    clie.nome AS 'cliente'
                FROM tb_users usr
                LEFT JOIN tb_cliente clie ON clie.id = usr.id_cliente
                WHERE usr.status_ativo = '1' AND clie.id = '$idCliente'";

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
            //     return $retorno;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }
            return $retorno;
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

            $resultado = $this->db->query($query);

            // Verifica se gravou com sucesso
            if(!empty($resultado))
            {
                if(is_numeric($resultado)){
                    $idGerada = $result;
                }else{
                    $idGerada = null;
                }

                //$idGerada  = mysql_insert_id();
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
    * REGISTRA USUÁRIO PARA O SISTEMA
    */
    public function registrarUsuarioParaSistema($nome, $sobrenome, $email, $celular, $telefone, $senha, $idCliente, $acesso){

        $nome      = $this->tratamento($nome);
        $sobrenome = $this->tratamento($sobrenome);
        $email     = $this->tratamento($email,1);
        $perfil    = is_numeric($acesso) ? $acesso : 0 ;
        $cliente   = $idCliente;
        $local     = 0;

        $query = "INSERT INTO tb_users(id_perfil_acesso, nome, sobrenome, email, telefone, celular, senha, local_usu, status_ativo, id_cliente) VALUES('$perfil', '$nome', '$sobrenome', '$email', '$telefone', '$celular', '$senha', '1', '1', '$cliente')";

        // Verifica se gravou com sucesso
        if ($this->db->query($query))
        {
            $array = array('status' => true);
        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    //$_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['celular'], $_POST['telefone'], $senha, $_POST['cliente'], $_POST['acesso']

    /*
    * RECUPERAR A LISTA DE CLIENTES PARA RELACIONAR O USUARIO
    */
    public function listarClientesUsuario(){

        $query = "SELECT id, nome FROM tb_cliente WHERE status_ativo = '1'";

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
            //     return $retorno;
            // }
            // /* DEVOLVE RETORNO */
            // $array = array('status' => true, 'clientes' => $retorno);

            foreach ($result as $row) {
                $retorno[] = $row;
            }

             /* DEVOLVE RETORNO */
            $array = array('status' => true, 'clientes' => $retorno);

        }else{
            $array = array('status' => false, 'clientes' => '');
        }

        return $array;
    }

    /*
    * RECUPERAR A LISTA DE CLIENTES PARA CLIENTES
    */
    public function buscaClienteUsuario($idClienteUsuario){
        $query = "SELECT id, nome FROM tb_cliente WHERE status_ativo = '1' AND id = '$idClienteUsuario'";

        /* MONTA A RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if (!empty($result))
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
            //     //return $retorno
            //     $array = array('status' => true, 'clientes' => $retorno);
            // }else{
            //     /* DEVOLVE RETORNO */
            //     $array = array('status' => false, 'clientes' => '');
            // }

            foreach ($result as $row){
                $retorno[] = $row;
            }

            /* DEVOLVE RETORNO */
            $array = array('status' => true, 'clientes' => $retorno);

        }else{
            $array = array('status' => false, 'clientes' => '');
        }

        return $array;

    }


    /*
    * RECUPERA A LISTA DE PERFIS DE ACESSO
    */
    public function listarAcessosUsuario(){

        $query = "SELECT id, nome FROM tb_perfil_acesso WHERE status_ativo = '1'";

        /* MONTA A RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if (!empty($result))
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
            //     return $retorno;
            // }
            // /* DEVOLVE RETORNO */
            // $array = array('status' => true, 'acessos' => $retorno);

            foreach ($result as $row){
                $retorno[] = $row;
            }

            /* DEVOLVE RETORNO */
            $array = array('status' => true, 'acessos' => $retorno);

        }else{
            $array = array('status' => false, 'acessos' => '');
        }

        return $array;
    }

    /*
    * RECUPERA A LISTA DE PERFIS DE ACESSO PARA USUÁRIOS
    */
    public function listarAcessosUsuarioParaUsuario(){

        /*
        * Query irá trazer todos os perfis de acesso, exceto o de administrador e tecnico
        */
        $query = "SELECT id, nome FROM tb_perfil_acesso
                    WHERE status_ativo = '1' AND id > '1' AND id < '4'";

        /* MONTA A RESULT */
        $result = $this->db->select($query);

        /* VERIFICA SE EXISTE RESPOSTA */
        if (!empty($result))
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
            //     return $retorno;
            // }
            // /* DEVOLVE RETORNO */
            // $array = array('status' => true, 'acessos' => $retorno);

            foreach ($result as $row){
                $retorno[] = $row;
            }

            /* DEVOLVE RETORNO */
            $array = array('status' => true, 'acessos' => $retorno);

        }else{
            $array = array('status' => false, 'acessos' => '');
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

    /*
    * FUNÇÃO PARA ATUALIZAR O USUÁRIO VIA SISTEMA
    */
    public function atualizarUsuarioViaSistema($id_usuario, $nome, $sobrenome, $email, $celular, $telefone, $senha, $confirmaS, $cliente, $acesso){

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
          if(isset($cliente)){      $query .= ", id_cliente = '$cliente'";}
          if(isset($acesso)){       $query .= ", id_perfil_acesso = '$acesso'";}
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
    public function atualizarUsuarioJson($id_usuario, $nome, $sobrenome, $email, $celular, $telefone, $senhaPassada, $confirmaS, $imagemUsuario)
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
          if(!empty($imagemUsuario) && ($imagemUsuario != ' ')){ $query .= ", imagem_usuario  = '$imagemUsuario'";}
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


    /*
    * FUNÇÃO PARA ATUALIZAR O USUÁRIO CONTATO DO CLIENTE
    */
    public function atualizarUsuarioContatoJson($idUsuario, $nome, $sobrenome, $email, $celular, $telefone, $senha, $iCliente){

        // Coletar os dados do post
        $id_user   = $idUsuario;
        $nome      = $this->tratamento($nome);
        $sobrenome = $this->tratamento($sobrenome);
        $email     = $this->tratamento($email,1);
        $senha     = ($senha != '') ? md5($senha) : null;

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

    /*
    * FUNÇÃO PARA EXCLUIR O USUÁRIO
    */
    public function excluirUsuarioViaJson($id_usuario){
        // Coletar os dados do post
        $id_user   = $id_usuario;

        if(is_numeric($id_user)){

            $query = "UPDATE tb_users SET  status_ativo = '0' WHERE id = '$id_user'";

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
