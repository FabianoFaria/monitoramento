<?php

/**
 * Classe de modelo que gerencia as informacoes do cadastro
 */
class CadastroModel extends MainModel
{
    /**
     * Metodo construtor da classe
     * 
     * @param object $db         - Recebe os dados de conexao com o banco
     * @param array  $controller - Recebe os parametros
     */
    public function __construct ($db = false , $controller = null)
    {
        // Conexao com o banco
        $this->db = $db;
        
        // Configuracao do controller
        $this->controller = $controller;
        
        // Configura os parâmetros
		$this->parametros = $this->controller->parametros;
    }
    
    /**
     * Funcao que cadastra o cliente
     * Sempre que ocorrer uma acao no botao submit
     * Esta funcao eh acionada
     */
    public function cadastrarCliente()
    {
        // Se ocorrer uma acao
        if (isset($_POST['btn_salvar']))
        {
            // Armazena o retorno do post
            $cliente  = $this->tratamento($_POST['txt_cliente']);
            $endereco = $this->tratamento($_POST['txt_endereco']);
            $numero   = !empty ($_POST['txt_numero']) ? $this->tratamento($_POST['txt_numero'],3) : 0;
            $ddd      = !empty($_POST['txt_ddd']) ? $this->tratamento($_POST['txt_ddd'],3) : 0;
            $telefone = !empty ($_POST['txt_telefone']) ? $this->tratamento($_POST['txt_telefone'],3) : 0;
            $cep      = $this->tratamento($_POST['txt_cep'],3);
            $pais     = $this->tratamento($_POST['opc_pais']);
            $estado   = $this->tratamento($_POST['opc_estado']);
            $cidade   = $this->tratamento($_POST['txt_cidade']);
            $bairro   = $this->tratamento($_POST['txt_bairro']);
            
            // Verifica se os cambos obrigatorios nao sao nulos
            if ($cliente != "" && $endereco != "" && $cep != "" && $cidade != "" && $bairro != "")
            {
                // Realiza o upload da imagem
                $up_resp = $this->validaUpload($_FILES);
                // Grava no banco os valores
                $query = "insert into tb_cliente (nome, endereco, numero, cep, id_pais, id_estado, ddd, telefone , cidade, bairro, id_users ,
                                                  foto) 
                          values ('{$cliente}', '{$endereco}', '{$numero}', '{$cep}', '{$pais}', '{$estado}', '{$ddd}', '{$telefone}',
                          '{$cidade}', '{$bairro}', '{$_SESSION['userdata']['userId']}', '{$up_resp}')";
                          
                // Realiza a chamada para gravar e verficar se gravou com sucesso
                $this->validaInsercaoBanco ($query, "Cadastro salvo com sucesso!", "Erro durante o salvamento.");
            }
            else
            {
                // Se os dados estiveren vaizos
                // Apresenta uma mensagem informa que existe campo em branco
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
            }
        }
    }
    
    /**
     * Funcao que realiza o cadastro das filiais
     * Sempre que ocorrer uma acao no botao submit
     * Esta funcao eh ativada
     */
    public function cadastrarFilial ()
    {
        // Capta a acao do botao submit
        if (isset($_POST['btn_enviar']))
        {
            // coleta os dados
            $filial   = $this->tratamento($_POST['txt_filial']);
            $matriz   = $this->tratamento($_POST['opc_matriz']);
            $ddd      = !empty ($_POST['txt_ddd']) ? $this->tratamento($_POST['txt_ddd'],3) : 0;
            $telefone = !empty ($_POST['txt_telefone']) ? $this->tratamento($_POST['txt_telefone'],3) : 0;
            $cep      = $this->tratamento($_POST['txt_cep'],3);
            $endereco = $this->tratamento($_POST['txt_endereco']);
            $numero   = !empty ($_POST['txt_numero']) ? $this->tratamento($_POST['txt_numero'],3) : 0;
            $cidade   = $this->tratamento($_POST['txt_cidade']);
            $bairro   = $this->tratamento($_POST['txt_bairro']);
            $pais     = $this->tratamento($_POST['opc_pais']);
            $estado   = $this->tratamento($_POST['opc_estado']);
            
            // Verifica se nao estao em branco
            if ($filial != "" && $cep != "" && $endereco != "" && $cidade != "" && $bairro != "" && $matriz != "")
            {
                // Se nao estiver em branco
                // Realiza o upload da imagem
                $up_resp = $this->validaUpload($_FILES);
                
                // Monta a query
                $query = "insert into tb_filial (nome, id_matriz, endereco, numero, cep, id_pais, id_estado, cidade, bairro, ddd, 
                                                 telefone,id_users, foto) 
                          values ('{$filial}','{$matriz}','{$endereco}','{$numero}','{$cep}','{$pais}','{$estado}', '{$cidade}','{$bairro}',
                                  '{$ddd}','{$telefone}','{$_SESSION['userdata']['userId']}','{$up_resp}')";
                
                // Realiza a chamada para gravar e verficar se gravou com sucesso
                $this->validaInsercaoBanco ($query, "Cadastro salvo com sucesso!", "Erro durante o salvamento.");
                
                // Monta a url de redirecionamento
                $move_uri = HOME_URI . "/cadastrar/filial/";
                // Redireciona a pagina
                echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $move_uri . '"},1500);</script>';
            }
            else
            {
                // Se existir campo em branco
                // Apresenta mensagem informando que existe campo em branco
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
            }
        }
    }
    
    /**
     * Funcao responsavel por cadastrar o fabricante
     * Sempre que o botao submit sofrer uma acao
     * Aciona esta funcao
     */
    public function cadastrarFabricante()
    {
        // Verifica se existe acao de envio
        if (isset($_POST['btn_salvar']))
        {
            // Coleta os dados
            $fabricante = $this->tratamento($_POST['txt_fabricante']);
            $ddd        = !empty($_POST['txt_ddd']) ? $this->tratamento($_POST['txt_ddd'],3) : 0;
            $telefone   = !empty($_POST['txt_telefone']) ? $this->tratamento($_POST['txt_telefone'],3) : 0;
            $cep        = $this->tratamento($_POST['txt_cep'],3);
            $endereco   = $this->tratamento($_POST['txt_endereco']);
            $numero     = !empty($_POST['txt_numero']) ? $this->tratamento($_POST['txt_numero'],3) : 0;
            $cidade     = $this->tratamento($_POST['txt_cidade']);
            $bairro     = $this->tratamento($_POST['txt_bairro']);
            $pais       = $this->tratamento($_POST['opc_pais']);
            $estado     = $this->tratamento($_POST['opc_estado']);
            
            // Verifica se existe campo em braco
            if ($fabricante != "" && $cep != "" && $endereco != "" && $cidade != "" && $bairro != "")
            {
                // Se nao existir campo em branco
                // Monta a query
                $query = "insert into tb_fabricante (nome, ddd, telefone, cep, endereco, numero, cidade, bairro, id_pais, id_estado,id_users)
                          values ('{$fabricante}','{$ddd}','{$telefone}','{$cep}','{$endereco}','{$numero}','{$cidade}',
                                  '{$bairro}','{$pais}','{$estado}','{$_SESSION['userdata']['userId']}')";
                
                // Insere no banco e exibe uma mensagem 
                $this->validaInsercaoBanco($query, "Cadastro salvo com sucesso!", "Erro durante o salvamento.");
            }
            else
            {
                // Se existir campo em branco
                // Apresentar mensagem informando que existe campo em branco
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
            }
        }
    }
    
    /**
     * Funcao responsavel por cadastrar o equipamento
     * Sempre que o botao submit sofrer uma acao
     * Esta funcao eh chamada
     */
    public function gravarEquipamento()
    {
        // Verifica se existe uma resposta do salvar
        if (isset($_POST['btn_salvar']))
        {
            // Trata os valores
            $idFabri = $_POST['opc_fabricante'];
            $tipoEquip = isset($_POST['txt_tipoEquip']) && !empty ($_POST['txt_tipoEquip']) ? $this->converte($this->tratamento($_POST['txt_tipoEquip'])) : '';
            $modeloEquip = isset($_POST['txt_modeloEquip']) && !empty ($_POST['txt_modeloEquip']) ? $this->converte($this->tratamento($_POST['txt_modeloEquip'])) : '';
            $potencia = isset($_POST['txt_potencia']) && !empty ($_POST['txt_potencia']) ? $this->converte($this->tratamento($_POST['txt_potencia'])) : '';
            $qntBateria = isset($_POST['txt_qntBateria']) && !empty ($_POST['txt_qntBateria']) ? $this->converte($this->tratamento($_POST['txt_qntBateria'])) : 0;
            $caracteristica = isset($_POST['txt_caracteristica']) && !empty ($_POST['txt_caracteristica']) ? $this->converte($this->tratamento($_POST['txt_caracteristica'])) : '';
            $tipoBateria = isset($_POST['opc_tipoBateria']) ? $_POST['opc_tipoBateria'] : '';
            $amperagem = isset($_POST['txt_amperagem']) && !empty ($_POST['txt_amperagem']) ? $this->converte($this->tratamento($_POST['txt_amperagem'])) : '';
            
            
            // Verifica se nao esta em branco
            if ($tipoEquip != "" && $idFabri != "")
            {
                // Se nao estiver em branco
                // Realiza a insercao no banco
                $query = "insert into tb_equipamento (id_users, id_fabricante,
                          tipo_equipamento, modelo, potencia,qnt_bateria, caracteristica_equip, tipo_bateria, amperagem_bateria) 
                          values ('{$_SESSION['userdata']['userId']}','{$idFabri}','{$tipoEquip}','{$modeloEquip}','{$potencia}','{$qntBateria}'
                                  ,'{$caracteristica}','{$tipoBateria}','{$amperagem}')";
                
                // Insere no banco e exibe uma mensagem 
                $this->validaInsercaoBanco($query, "Cadastro salvo com sucesso!", "Erro durante o salvamento.");
                
                // Monta a url de redirecionamento
                $move_uri = HOME_URI . "/cadastrar/equipamento/";
                // Redireciona a pagina
                echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $move_uri . '"},1500);</script>';
            }
            else
            {
                // Se existir campo em branco
                // Apresenta uma mensagem informando que existe campo em branco
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
            }
        }
    }
    
    
    
    /**
     * Funcao que realiza o cadastro do usuario
     * 
     * Cadastra todos os usuarios que utilizaram o sistema
     * Separando por interno (Eficaz) e externo (Cliente)
     */
    public function cadastrarUsuario()
    {
        // Verifica se existe uma acao post
        if (isset($_POST['btn_salvar']))
        {
            // Coletar os dados do post
            $nome      = $this->tratamento($_POST['txt_nome']);
            $sobrenome = $this->tratamento($_POST['txt_sobrenome']);
            $email     = $this->tratamento($_POST['txt_email'],1);
            $senha     = $this->tratamento($_POST['txt_senha'], 2);
            $cfsenha   = $this->tratamento($_POST['txt_cfsenha'], 2);
            $perfil    = isset($_POST['opc_perfil']) ? $_POST['opc_perfil'] : 0 ;
            $cliente   = explode("-",$_POST['opc_cliente']);
            $local     = isset($_POST['opc_local']) ? $_POST['opc_local'] : 0;
            
            // Verifica se existe um perfil selecionado
            if ($senha != $_POST['txt_senha'])
            {
                // Apresenta uma mensagem de erro
                echo "<div class='mensagemError'><span>Verifique se existe caracteres inv&aacute;lidos na senha</span></div>";
                
                // Encerra o processo
                return;
            }
            
            
            // Verifica se existe campo em branco
            if ($_POST['txt_nome'] != "" && $_POST['txt_sobrenome'] != "" && $_POST['txt_email'] != "" && $_POST['txt_senha'] !== ""
               && $_POST['txt_cfsenha'] != "")
            {
                // Verifica se existe um perfil selecionado
                if ($perfil == 0)
                {
                    // Apresenta uma mensagem de erro
                    echo "<div class='mensagemError'><span>Nenhum perfil foi selecionado!</span></div>";
                    
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
                
                
                // Verifica se existe valor e se a variavel esta definida
                if (isset($cliente[1]))
                {
                    // Verifica se o cliente eh uma filial
                    if ($cliente[1] == 'c')
                        $tipo_inst = 0;
                    else if ($cliente[1] == 'f')
                        $tipo_inst = 1;
                }
                
                // Verifica se a senha e a confirmacao sao iguais
                if ($senha == $cfsenha)
                {
                    // Monta query para buscar o email no sistema
                    $query = "select id, email from tb_users where email = '{$email}'";
                    
                    // Monta a result
                    $result = $this->db->select($query);
                    
                    // Verifica se existe resposta
                    if ($result)
                    {
                        // Se existir resposta
                        // Verifica se existe valor
                        if(@mysql_num_rows($result) > 0)
                        {
                            // Se existir o usuario
                            // Apresentar mensagem
                            echo "<div class='mensagemError'><span>Usu&aacute;rio cadastrado!</span></div>";
                        }
                        else
                        {
                            // Aplica criptografia unidirecional na senha
                            $senha = md5($senha);
                            
                            // Se o usuario nao for encontrado
                            // Verificando se o usuario eh externo ou interno
                            if ($local == 1)
                            {
                                // Para usuario interno
                                $query = "insert into tb_users (id_perfil_acesso, nome, sobrenome, email, senha, local_usu, id_cliente)
                                          values ('{$perfil}','{$nome}','{$sobrenome}','{$email}','{$senha}','{$local}','{$cliente[0]}')";
                            }
                            else
                            {
                                // Verifica se o campo do cliente nao esta vazio
                                // E se eh um array
                                if (!empty($cliente) && is_array($cliente))
                                {
                                    // Para usuario externo
                                    // Monta query
                                    $query = "insert into tb_users (id_perfil_acesso, nome, sobrenome, email, senha, local_usu, id_cliente,tipo_inst)
                                              values ('{$perfil}','{$nome}','{$sobrenome}','{$email}','{$senha}','{$local}','{$cliente[0]}','{$tipo_inst}')";
                                }
                                else
                                {
                                    // Se estiver vazio
                                    // Apresenta uma mensagem
                                    echo "<div class='mensagemError'><span>Erro ao salvar.</span></div>";
                                }
                            }
                            
                            // Insere no banco e exibe uma mensagem 
                            $this->validaInsercaoBanco($query, "Cadastro salvo com sucesso!", "Erro ao salvar.");
                            
                            // Apaga dados do formulario
                            unset($_POST);
                        }
                    }
                }
                else
                {
                    // Caso as senhas sejam diferente
                    // Apresenta a mensagem de erro
                    echo "<div class='mensagemError'><span>Senhas diferentes</span></div>";
                }
                
            }
            else 
            {
                // Se existir campo em branco
                // Apresenta uma mensagem
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
            }
        }
    }
    
    /*
     *      busca matriz
     *      funcao que traz, clientes, filiais
     */
    public function loadCateg($num = 0)
    {
        // Verifica categoria
        if ($num == 1)
        {
            // Verifica se existe matriz
            $query = "select id, nome from tb_cliente where status_ativo = 1";
        }
        else if ($num == 2)
        {
            // Verifica se existe filial
            $query = "select id, nome from tb_filial where status_ativo = 1";
        }
        else if ($num == 3)
        {
            // Verifica se existe equipamento
            $query = "select id, tipo_equipamento as nome from tb_equipamento where status_ativo = 1";
        }
        
        // Verifica se exite valor
        $respMatriz = $this->verificaResposta($query);
        
        // Retorna a resposta do select
        return $respMatriz;
    }
    
    
    
    /**
     * loadPerfilAcesso
     * 
     * Funcao que gera a lista de todas as permissoes
     * 
     * @access public
     */
    public function loadPerfilAcesso()
    {
        $pac2 = new C_PhpAutocomplete('permissaoac');
        $pac2->display('SELECT');
        
        // Monta a query para buscar as permissoes
        $query = "select id, nome from tb_perfil_acesso where status_ativo = 1";
        
        // Monta a result
        $result = $this->db->select($query);
        
        // Criar o array de resposta
        $resultado = array();
        
        // Verifica se existe valor na result
        if (@mysql_num_rows($result) > 0)
        {
            // Monta o array de dados
            while ($rowfabricante = @mysql_fetch_assoc($result))
                $resultado[] = $rowfabricante;
        }
        
        // Exibe as permissoes no option
        echo "<select id='permissaoac' name='opc_perfil' class='font-texto-01' required><option>Selecione uma permiss&atilde;o</option>";
                // Monta a lista de permissoes
                foreach ($resultado as $rowfabricante)
                {
                    // Exibe as permissoes
                    echo "<option value='{$rowfabricante['id']}'>{$rowfabricante['nome']}</option>";
                }
        echo "</select>";
    }
    
    
    /**
     * Funcao que busca todos os fabricantes - matar
     * cadastrados no sistema
     */
    public function carregarFabricante ()
    {
        // Monta a query
        $query = "select id, nome from tb_fabricante where status_ativo = 1";
        
        // Verifica se existe algum valor
        $respFabri = $this->verificaResposta($query);
        
        // Retorna um valor
        return $respFabri;
    }
    
    
    /**
     * Funcao que verifica se existe valor no select
     * 
     * @param string $query - Recebe uma string com o select
     * 
     * @return array or false $resp - Retona um array se realizou o select
     * ou false caso nao encontre nada
     */
    private function verificaResposta($query)
    {
        // Monta a result
        $result = $this->db->select($query);
        // Verifica se executou
        if ($result)
        {
            // Verfica se existe valor
            if (@mysql_num_rows($result) > 0)
            {
                // Armazena os valores no vetor
                while ($row = @mysql_fetch_assoc($result))
                    $resp[] = $row;
                // Retorna o vetor
                return $resp;
            }
            // Fim
            return false;
        }
        // Fim
        return false;
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
     * Funcao que realiza o upload da foto
     * 
     * @param array $files - Recebe um array com os dados da foto
     *
     * @return string $up_resp - Devolve o nome da foto
     */
    private function validaUpload($files)
    {
        // Verifica se existe arquivo no upload
        if (!empty($files['file_foto']['name']) && !empty($files['file_foto']['tmp_name']) && !empty($files['file_foto']['type']))
        {
            // Se existir arquivo para upload
            // Envia o array e aguarda a resposta
            $up_resp = $this->upload($files);
        }
        else
        {
            // Se nao existir arquivo para realizar upload
            $up_resp = '';
        }
        // Devolve o nome do arquivo
        return $up_resp;
    }
}

?>