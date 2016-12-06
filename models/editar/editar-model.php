<?php

class EditarModel extends MainModel
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
     *      Cliente
     */
    
    /* carregar os dados do cliente */
    public function carregaCliente ($cliente)
    {
        /* monta a query */
        $query = "select
                    c.nome , c.endereco, c.numero, c.cep, c.cidade, c.bairro, c.ddd, c.telefone , p.nome as pais , 
                    e.nome as estado , p.id as idpais, e.id as idestado
                  from tb_cliente c
                  inner join tb_pais p on p.id = c.id_pais
                  inner join tb_estado e on e.id = c.id_estado
                  where c.id = {$cliente}";
        
        /* monta result */
        $result = $this->db->select($query);
        /* verifica se retorna */
        if ($result)
        {
            /* verifica se existe valor */
            if (@mysql_num_rows($result)>0)
            {
                /* pega os valores e monta um array */
                while ($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;
                
                /* retorna o select */
                return $retorno;
            }
            else
                /* fim */
                return false;
        }
        else
            /* fim */
            return false;
    }
    
    /* editar cliente */
    public function editarCliente($clienteid)
    {
        // se ocorrer uma acao
        if (isset($_POST['btn_salvar']))
        {
            // armazena o retorno do post
            $cliente  = $this->tratamento($_POST['txt_cliente']);
            $endereco = $this->tratamento($_POST['txt_endereco']);
            $numero   = !empty ($_POST['txt_numero']) ? $this->tratamento($_POST['txt_numero'],3) : 0;
            $ddd      = !empty ($_POST['txt_ddd']) ? $this->tratamento($_POST['txt_ddd'],3) : 0;
            $telefone = !empty ($_POST['txt_telefone']) ? $this->tratamento($_POST['txt_telefone'],3) : 0;
            $cep      = $this->tratamento($_POST['txt_cep'],3);
            $pais     = $this->tratamento($_POST['opc_pais']);
            $estado   = $this->tratamento($_POST['opc_estado']);
            $cidade   = $this->tratamento($_POST['txt_cidade']);
            $bairro   = $this->tratamento($_POST['txt_bairro']);
            
            // verifica se os cambos obrigatorios nao sao nulos
            if ($cliente != "" && $endereco != "" && $cep != "" && $cidade != "" && $bairro != "")
            {
                // grava no banco os valores
                $query = " update tb_cliente set nome = '{$cliente}' , endereco = '{$endereco}' , numero = '{$numero}', cep = '{$cep}' ,
                           id_pais = '{$pais}', id_estado = '{$estado}' , ddd = '{$ddd}' , telefone = '{$telefone}' , cidade = '{$cidade}' ,
                           bairro = '{$bairro}' where id = {$clienteid}";
                
                /* verifica se gravou com sucesso */
                if ($this->db->query($query))
                {
                    echo "<div class='mensagemSucesso'><span>Alterado com sucesso!</span></div>";
                    $login_uri = HOME_URI . "/pesquisar/clientecadastrado/";
                    /* redireciona a pagina */
                    echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $login_uri . '"},1500);</script>';
                }
                else
                {
                    echo "<div class='mensagemError'><span>Erro durante o salvamento.</span></div>";
                }
            }
            else
            {
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
            }
        }
    }
    
    
    
    
    /*
     *      Filal
     */
    
    /* carrega as informacoes da filial */
    public function carregaFilial($filialid)
    {
        /* monta query */
        $query = "select
                    f.nome, c.nome as matriz, f.id_matriz as matrizid, f.endereco, f.numero, f.cep, f.cidade, f.bairro, f.ddd,
                    f.telefone, f.id_pais as idPais, f.id_estado as idEstado, e.nome as estado, p.nome as pais
                from tb_filial f
                inner join tb_pais p on p.id = f.id_pais
                inner join tb_estado e on e.id = f.id_estado
                inner join tb_cliente c on c.id = f.id_matriz
                where f.id = {$filialid}";
        
        /* monta result */
        $result = $this->db->select($query);
        /* verifica se existe resposta */
        if ($result)
        {
            /* verifica se exite valor */
            if(@mysql_num_rows($result) > 0)
            {
                /* armazena a resposta no array de retorno */
                while ($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;
                /* retorno o array */
                return $retorno;
            }
            else
                /* fim */
                return false;
        }
        else
            /* fim */
            return false;
    }
    
    /* editar filial , salva todas as alteracoes */
    public function editarFilial($filialid)
    {
        /* verifica se existe acao do posto */
        if (isset($_POST['btn_enviar']))
        {
            /* coleta e trata os dados */
            $filial   = $this->tratamento($_POST['txt_filial']);
            $endereco = $this->tratamento($_POST['txt_endereco']);
            $cidade   = $this->tratamento($_POST['txt_cidade']);
            $bairro   = $this->tratamento($_POST['txt_bairro']);
            
            $ddd      = !empty($_POST['txt_ddd']) ? $this->tratamento($_POST['txt_ddd'] , 3) : 0;
            $telefone = !empty($_POST['txt_telefone']) ? $this->tratamento($_POST['txt_telefone'] , 3) : 0;
            $cep      = $this->tratamento($_POST['txt_cep'] , 3);
            $numero   = !empty($_POST['txt_numero']) ? $this->tratamento($_POST['txt_numero'] , 3) : 0;
            
            $matriz   = $this->tratamento($_POST['opc_matriz']);
            $pais     = $this->tratamento($_POST['opc_pais']);
            $estado   = $this->tratamento($_POST['opc_estado']);
            
            
            if ($filial != "" && $cep != "" && $endereco != "" && $cidade != "" && $bairro != "" && $matriz != "")
            {
                /* monta query */
                $query = "update tb_filial set nome = '{$filial}' , id_matriz = '{$matriz}' , endereco = '{$endereco}' , numero = '{$numero}' ,
                    cep = '{$cep}' , id_pais = '{$pais}' , id_estado = '{$estado}' , cidade = '{$cidade}' , bairro = '{$bairro}' , 
                    ddd = '{$ddd}' , telefone = '{$telefone}'
                where id = {$filialid}";
                
                /* verifica se gravou com sucesso */
                if ($this->db->query($query))
                {
                    echo "<div class='mensagemSucesso'><span>Alterado com sucesso!</span></div>";
                    $login_uri = HOME_URI . "/pesquisar/filialcadastrado/";
                    /* redireciona a pagina */
                    echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $login_uri . '"},1500);</script>';
                }
                else
                {
                    echo "<div class='mensagemError'><span>Erro durante o salvamento.</span></div>";
                }
            }
            else
            {
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
            }
        }
    }
    
    
    // busca todos os paises
    public function carregaPais()
    {
        // carrega a lista de paises
        $result = $this->db->select("select id , nome from tb_pais where status_ativo = 1");
        // verifica se existe retorno
        if ($result)
        {
            // verifica se a resposta contem valores
            if (@mysql_num_rows($result) > 0)
            {
                // converte a resposta em array
                while ($row = @mysql_fetch_assoc($result))
                {
                    $respPais[] = $row;
                }
                // fim
                return $respPais;
            }
            // retorna false*/
            return false;
        }
        // retorna false
        return false;
    }
    
    // busca todos os estados cadastros
    public function carregaEstado ()
    {
        // verifica se existe estado cadastrado
        $result = $this->db->select("select id, nome from tb_estado where status_ativo = 1");
        // verifica se existe resposta
        if ($result)
        {
            // verfica se existe valor
            if (@mysql_num_rows($result))
            {
                // armazena os valores no vetor
                while ($row = @mysql_fetch_assoc($result))
                    $respEstado[] = $row;
                // retorna o vetor
                return $respEstado;
            }
            // fim
            return false;
        }
        // fim
        return false;
    }
    
    // busca matriz
    public function carregaMatriz()
    {
        // verifica se existe matriz
        $result = $this->db->select ("select id, nome from tb_cliente where status_ativo = 1");
        // verifica se existe resposta
        if ($result)
        {
            // verifica se existe valor
            if(@mysql_num_rows($result) > 0)
            {
                // armazena
                while($row = @mysql_fetch_assoc($result))
                    $respMatriz[] = $row;
                
                return $respMatriz;
            }
            return false;
        }
        return false;
    }
    
    // carregar fabricante
    public function carregarFabricante ()
    {
        // verificar se encontra algum fabricante
        $result = $this->db->select ("select id, nome from tb_fabricante where status_ativo = 1");
        
        // verifica se a query executou
        if ($result)
        {
            // verificar se existe valor
            if (@mysql_num_rows($result) > 0)
            {
                // cria arrya de valores
                while ($row = @mysql_fetch_assoc($result))
                    $respFabri[] = $row;

                return $respFabri;
            }
            // fim
            return false;
        }
        return false;
    }
    
    
    
    /* carregar as configuracoes do equipamento */
    public function carregarEquipamento($equipid)
    {
        /* verifica se existe valor */
        if (isset($equipid) && !empty ($equipid))
        {
            /* monta query */
            $query = "select
                        e.tipo_equipamento as nome , f.nome as fabricante , f.id as idFabri
                      from tb_equipamento e
                      inner join tb_fabricante f on f.id = e.id_fabricante
                      where e.id = {$equipid}";
            
            /* monta result */
            $result = $this->db->select($query);
            
            /* verifica se existe respota */
            if ($result)
            {
                /* verifica se existe valor */
                if (@mysql_num_rows($result) > 0)
                {
                    /* arruma os valores no array */
                    while ($row = @mysql_fetch_assoc($result))
                        $retorno[] = $row;
                    /* retorna o array com os valores */
                    return $retorno;
                }
                else
                    /* fim */
                    return false;
            }
            else
                /* fim */
                return false;
        }
        else
            /* fim */
            return false;
    }
    
    /* editar as informacoes do equipamento */
    public function editarEquipamento($equipid)
    {
        /* verifica se existe acao no botao */
        if(isset($_POST['btn_salvar']))
        {
            /* coleta as informacoes */
            $equip = isset($_POST['txt_equipamento']) ? $this->tratamento($_POST['txt_equipamento']) : '';
            $idEquip = isset($_POST['opc_fabricante']) ? $this->tratamento($_POST['opc_fabricante']) : 0;
            
            /* montar query */
            $query = "update tb_equipamento set nome = '{$equip}' , id_fabricante = {$idEquip} where id = {$equipid}";
            
            /* verifica se realizou o update */
            if ($this->db->query($query))
            {
                echo "<div class='mensagemSucesso'><span>Alterado com sucesso!</span></div>";
                $login_uri = HOME_URI . "/pesquisar/equipamentocadastrado/";
                /* redireciona a pagina */
                echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $login_uri . '"},1500);</script>';
            }
            else
            {
                echo "<div class='mensagemError'><span>Erro durante o salvamento.</span></div>";
            }
        }
    }
    
    /* carrega dados fabricante */
    public function carregaFabricante ($idfab)
    {
        /* monta a query */
        $query = "select 
                    f.nome, f.ddd, f.telefone, f.cep, f.endereco, f.numero, f.cidade, f.bairro, f.id_pais, f.id_estado ,
                    p.nome as pais, e.nome as estado
                from tb_fabricante f
                inner join tb_pais p on p.id = f.id_pais
                inner join tb_estado e on e.id = f.id_estado
                where f.id = {$idfab}";
        
        /* monta result */
        $result = $this->db->select($query);
        
        /* verifica se existe resposta */
        if ($result)
        {
            /* verifica se existe valor */
            if (@mysql_num_rows($result) > 0)
            {
                /* monta array */
                while($row = @mysql_fetch_assoc($result))
                    $retorno[] = $row;
                
                /* retorna array */
                return $retorno;
            }
            else
                /* fim */
                return false;
        }
        else
            /* fim */
            return false;
    }
    
    /* funcao que grava os dados do fabricante no banco */
    public function editarFabricante ($idfab)
    {
        /* verifica se existe acao */
        if(isset($_POST['btn_salvar']))
        {
            /* coleta e trata os dados */
            
            $nome = isset($_POST['txt_fabricante']) && !empty($_POST['txt_fabricante']) ? $this->tratamento($_POST['txt_fabricante']) : '' ;
            $endereco = isset($_POST['txt_endereco']) && !empty($_POST['txt_endereco']) ? $this->tratamento($_POST['txt_endereco']) : '' ;
            $cidade = isset($_POST['txt_cidade']) && !empty($_POST['txt_cidade']) ? $this->tratamento($_POST['txt_cidade']) : '' ;
            $bairro = isset($_POST['txt_bairro']) && !empty($_POST['txt_bairro']) ? $this->tratamento($_POST['txt_bairro']) : '' ;
            
            $ddd = isset($_POST['txt_ddd']) && !empty($_POST['txt_ddd']) ? $this->tratamento($_POST['txt_ddd'],3) : 0 ;
            $numero = isset($_POST['txt_numero']) && !empty($_POST['txt_numero']) ? $this->tratamento($_POST['txt_numero'],3) : 0 ;
            $telefone = isset($_POST['txt_telefone']) && !empty($_POST['txt_telefone']) ? $this->tratamento($_POST['txt_telefone'],3) : 0 ;
            $cep = isset($_POST['txt_cep']) && !empty($_POST['txt_cep']) ? $this->tratamento($_POST['txt_cep'],3) : 0 ;
            $pais = isset($_POST['opc_pais']) && !empty($_POST['opc_pais']) ? $this->tratamento($_POST['opc_pais'],3) : 0;
            $estado = isset($_POST['opc_estado']) && !empty($_POST['opc_estado']) ? $this->tratamento($_POST['opc_estado'],3) : 0 ;
            
            
            /* monta query */
            $query = "update tb_fabricante set nome = '{$nome}', ddd = '{$ddd}', telefone = '{$telefone}', cep = '{$cep}', 
                      endereco = '{$endereco}', numero = '{$numero}', cidade = '{$cidade}', bairro = '{$bairro}', id_pais = '{$pais}',
                      id_estado = '{$estado}' 
                      where id = {$idfab}";
            
            /* monta result */
            $result = $this->db->query($query);
            
            /* verifica se gravou */
            if ($result)
            {
                echo "<div class='mensagemSucesso'><span>Alterado com sucesso!</span></div>";
                $login_uri = HOME_URI . "/pesquisar/fabricantecadastrado/";
                /* redireciona a pagina */
                echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $login_uri . '"},1500);</script>';
            }
            else
            {
                echo "<div class='mensagemError'><span>Erro durante o salvamento.</span></div>";
            }
        }
    }
}

?>