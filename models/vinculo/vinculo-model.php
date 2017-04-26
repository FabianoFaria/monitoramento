<?php

class VinculoModel extends MainModel
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
     *      Quando existir uma acao do do post
     *      Chama a funcao para salvar o vinculo
     */
    public function vincularSim ()
    {

        /* verifica se existe acao do post */
        if (isset($_POST['btn_vicular']))
        {
            /* capitura valores */
            $cliente = $_POST['opc_cliente'];
            $num_sim = $_POST['txt_numSim'];

            /* verificar se existe campo em branco */
            if (isset($cliente) && ! empty ($cliente) && $cliente != "" && isset($num_sim) && ! empty ($num_sim) && $num_sim != "")
            {
                /* quebra a resposta em array */
                $cliente = explode ('-',$cliente);
                /* verifica se eh um array */
                if (is_array($cliente))
                {
                    /* verifica se eh um array , se existe e se nao esta vazio */
                    if (is_array($cliente) && isset($cliente) && ! empty($cliente[1]))
                    {
                        /* chama a procedure */
                        $proc = $this->db->select("call cad_sim_cliente('{$cliente[0]}','{$num_sim}' , '{$cliente[1]}')");
                    }
                    else
                    {
                        /* se nao, apresenta a mensagem de erro */
                        echo "<div class='mensagemError'><span>Erro na inser&ccedil;&atilde;o. Erro 145.</span></div>";
                        return;
                    }

                    /* verifica se existe um valor de retorno */
                    if (@mysql_num_rows($proc) > 0)
                    {
                        /* trasforma a resposta em array */
                        while($row = @mysql_fetch_assoc($proc))
                        {
                            /* quebra o retorno em array */
                            $resultado = explode("|",$row['resposta']);
                            /* verifica se existe uma resposta verdadeira */
                            if ($resultado[1] == "verdade")
                            {
                                /* mostra a mensagem de sucesso*/
                                echo "<div class='mensagemSucesso'><span>{$resultado[0]}</span></div>";
                            }
                            /* para resposta falsa */
                            else if ($resultado[1] == "erro")
                            {
                                /* apresenta o erro */
                                echo "<div class='mensagemError'><span>{$resultado[0]}</span></div>";
                            }
                        }
                    }
                }
                else
                    echo "<div class='mensagemError'><span>Erro durante o salvamento, entre em contato com o administrador. Error 1001.</span></div>";
                    /* Erro 145 - erro de cliente, nao encontrou o cliente */
                    /* Erro 1001 - erro ao transformar a string em array */
            }
            else
                echo "<div class='mensagemError'><span>Existe campos em branco</span></div>";
        }
    }


    /*
     *      funcao que capita a acao do botao
     *      e realiza o cadastro do equipamento
     */
    public function cad_sim_equip()
    {
        /* se ocorrer a acao */
        if (isset($_POST['btn_vicular']))
        {
            /* coleta os valores */
            $sim = isset($_POST['opc_numSim']) ? $_POST['opc_numSim'] : 0;
            $equip = isset($_POST['opc_equipamento']) ? $_POST['opc_equipamento'] : 0;
            $numeroSerie = isset($_POST['txt_numeroSerie']) && !empty ($_POST['txt_numeroSerie']) ? $this->converte($this->tratamento($_POST['txt_numeroSerie'])) : 0;
            $ambiente = isset($_POST['txt_ambiente']) && !empty ($_POST['txt_ambiente']) ? $this->converte($this->tratamento($_POST['txt_ambiente'])) : '';

            /* verifica se os campos existem e nao estao em branco */
            if (isset($sim) && !empty($sim) && $sim != 0 && isset($equip) && !empty($equip) && $equip != 0 )
            {
                $equip = explode ("-",$equip);

                // monta a query
                if ($equip[1] == 'e')
                    $query = "insert into tb_sim_equipamento (id_equipamento, id_sim, num_serie, ambiente) values
                              ('{$equip[0]}','{$sim}' , '{$numeroSerie}','{$ambiente}')";

                $result = $this->db->query($query);

                // verifica se existe reposta
                if ($result)
                {
                    echo "<div class='mensagemSucesso'><span>Cadastro salvo com sucesso!</span></div>";
                    $login_uri = HOME_URI . "/vinculo/vincular/";
                    /* redireciona a pagina */
                    echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $login_uri . '"},1500);</script>';
                }
                else
                {
                    echo "<div class='mensagemError'><span>Erro durante o salvamento.</span></div>";
                }
            }
            else
                echo "<div class='mensagemError'><span>Verifique se os campos est&atilde;o corretos.</span></div>";
        }
    }
    /* fim da funcao de cadastro */


    /*
     *      busca matriz
     *      funcao que traz, clientes, filiais
     */
    public function loadCateg($num = 0)
    {
        /* verifica categoria */
        if ($num == 1)
        {
            /* verifica se existe matriz */
            $query = "select id, nome from tb_cliente where status_ativo = 1";
        }
        else if ($num == 2)
        {
            /* verifica se existe matriz */
            $query = "select id, nome from tb_filial where status_ativo = 1";
        }
        else if ($num == 3)
        {
            /* verifica se existe equipamento */
            $query = "select id, tipo_equipamento from tb_equipamento where status_ativo = 1";
        }

        // Busca query no banco
        $retorno = $this->resultado_query($query);
        // Retorna o resultado
        return $retorno;
    }


    /* tabela de clientes que possuem um dispositivo */
    public function tabelaDeCliente()
    {
        // Monta a query
        $query = "call proc_relacionamento";

        // Busca query no banco
        $retorno = $this->resultado_query($query);
        // Retorna o resultado
        return $retorno;
    }



    /*
     *      Funcao que carega todos os clientes que
     *      possuem um sim cadastrado
     */
    public function view_sim_cliente ($num = 0)
    {
        /* seleciona o tipo de tabela */
        if ($num == 1)
        {
            /* 1 para cliente */
            $query = "select s.num_sim, c.nome
                        from tb_sim s
                        inner join tb_cliente c on c.id = s.id_cliente
                        where s.status_ativo = 1 and s.id_cliente is not null";
        }
        else if ($num == 2)
        {
            /* 2 Para filiais */
            $query = "select  s.num_sim, c.nome
                        from tb_sim s
                        inner join tb_filial c on c.id = s.id_filial
                        where s.status_ativo = 1 and s.id_filial is not null";
        }
        // Busca a query
        $retorno = $this->resultado_query($query);
        // Retorna array
        return $retorno;
    }


    /**
     * Funcao que carrega o cliente cadastrado no vinculo
     * de acordo com o id cadastrado
     *
     * Funcao chamada no vinculo da posicao da tabela
     *
     * @param numeric $id - O id da tabela de vinculo do equipamento com o sim
     */
    public function busca_cliente_vinc($id)
    {
        // Monta a query
        $query = "
                select
                sq.id_equipamento, sq.id_sim, s.id_cliente, s.id_filial
                from tb_sim_equipamento sq
                inner join tb_sim s on s.num_sim = sq.id_sim
                where id = {$id}";

        // Result que busca os valores
        $result = $this->db->select($query);

        // Verifica se existe resposta
        if ($result)
        {
            // Verifica se existe valor
            if (@mysql_num_rows($result) > 0)
            {
                // Coleta os dados
                $row = @mysql_fetch_assoc($result);

                // Busca cliente
                if (isset($row['id_cliente']) && !empty($row['id_cliente']))
                    // monta a busca de cliente
                    $queryCli = "select nome from tb_cliente where id = {$row['id_cliente']}";


                // Busca filial
                if (isset($row['id_filial']) && !empty($row['id_filial']))
                    // monta a busca de filial
                    $queryCli = "select nome from tb_cliente where id = {$row['id_filial']}";


                // Busca equipamento
                if (isset($row['id_equipamento']) && !empty($row['id_equipamento']))
                    // monta a busca de equipamento
                    $queryEqui = "select tipo_equipamento as nome from tb_equipamento where id = {$row['id_equipamento']}";


                // Realiza a busca da query de cliente e equipamento
                $buscaCli  = $this->resultado_query($queryCli);
                $buscaEqui = $this->resultado_query($queryEqui);

                // coleta os dados e monta a variavel com o nome do cliente e equipamento
                $buscaCli = isset($buscaCli[0]['nome']) && !empty($buscaCli[0]['nome']) ? $this->converte($buscaCli[0]['nome'], 1) : "";
                $buscaEqui = isset($buscaEqui[0]['nome']) && !empty($buscaEqui[0]['nome']) ? $this->converte($buscaEqui[0]['nome'],1) : "";

                return $buscaCli . "/" . $buscaEqui;
            }
        }
    }


    /**
     * Funcao que captura acao no botao de vunculo
     *
     * @param string $parametro - contem as chaves e a posicao na tabela
     */

    public function vinc_equip_sim_tabela ($parametro)
    {
        // Verifica se existe acao sobre a opcao salvar
        if (isset($_POST['btn_salvar']))
        {
            // Coleta os dados do post
            $poss = $_POST['opc_posicao'];

            // Variavel de controle
            $controle = 0;
            // Marca posicao
            $marca = array();

            // Verifica as posicoes da tabela
            foreach ($poss as $confpos)
            {
                // Monta a query para verificar se existe a posicao cadastrada no banco
                $query = "select * from tb_posicao where id_num_sim = {$parametro[1]} and posicao = '{$confpos}'";
                // Verifica se existe resposta do banco
                if (@mysql_num_rows($this->db->select($query)) > 0)
                {
                    // Incremeta um valor no controle
                    $controle++;
                    // Marcao a posicao que exite
                    $marca[] = $confpos;
                }
            }

            // Verifica o controle
            if ($controle == 0)
            {
                // Insere no banco
                foreach ($poss as $posicao)
                {
                    // Monta a query
                    $query = "insert into tb_posicao  (id_sim_equipamento,posicao,id_num_sim) values ({$parametro[0]} ,'{$posicao}',{$parametro[1]})";

                    // Verifica e realiza a insercao das informacoes no banco
                    if (!$this->db->query($query))
                    {
                        // Apresenta mensagem de erro
                        echo "<div class='mensagemError'><span>Erro ao salvar.</span></div>";
                        // Fim
                        return;
                    }
                }

                // Monta a query de update, para atualizar a relacao de vinculo
                $query = "update tb_sim_equipamento set vinc_tabela = 1 where id = {$parametro[0]}";

                // Realiza a verificacao e o update das informacoes
                if (!$this->db->query($query))
                {
                    // Apresenta mensagem de erro
                    echo "<div class='mensagemError'><span>Erro ao atualizar a tabela de vinculo.</span></div>";
                    // Fim
                    return;
                }
                // Mensagem de sucesso
                echo "<div class='mensagemSucesso'><span>Cadastro salvo com sucesso!</span></div>";

                // Monta a url de redirecionamento
                $login_uri = HOME_URI . "/vinculo/equipamentolista/";
                // Redireciona a pagina
                echo '<script type="text/javascript">setTimeout(function(){window.location.href = "' . $login_uri . '"},1500);</script>';
            }
            else
            {
                $mensa = "";
                // Monta string das posicoes encontradas
                for ($a=0;$a < $b = sizeof($marca);$a++)
                {
                    // Verifica se eh a ultima posicao
                    if ($a + 1 == $b)
                        $mensa .= $marca[$a];
                    else
                        $mensa .= $marca[$a] . " , ";
                }
                // Mostra mensagem de erro
                echo "<div class='mensagemError'><span>Posi&ccedil;&atilde;o j&aacute; cadastra {$mensa}.</span></div>";
            }
        }
    }



    /**
     * listaClienteSim
     *
     * Funcao que gera a lista de todos os clientes e filiais junto do sim
     *
     * @access public
     */
    public function listaClienteSim()
    {
        $pac2 = new C_PhpAutocomplete('simNumInput');
        $pac2->display('SELECT');

        // Monta a query para buscar os clientes e filiais junto do sim
        $query = "select s.num_sim, c.nome
                        from tb_sim s
                        inner join tb_cliente c on c.id = s.id_cliente
                        where s.status_ativo = 1 and s.id_cliente is not null";

        // Monta a result
        $result = $this->db->select($query);

        // Criar o array de resposta
        $resultado = array();

        // Verifica se existe valor na result
        if (@mysql_num_rows($result) > 0)
        {
            // Monta o array de dados
            while ($rowestado = @mysql_fetch_assoc($result))
                $resultado[] = $rowestado;
        }

        $query = "select  s.num_sim, c.nome
                        from tb_sim s
                        inner join tb_filial c on c.id = s.id_filial
                        where s.status_ativo = 1 and s.id_filial is not null";

        // Monta a result
        $result = $this->db->select($query);

        // Verifica se existe valor na result
        if (@mysql_num_rows($result) > 0)
        {
            // Monta o array de dados
            while ($rowestado = @mysql_fetch_assoc($result))
                $resultado[] = $rowestado;
        }

        // Exibe os clientes e filiais junto do sim no option
        echo "<select id='simNumInput' name='opc_numSim' class='font-texto-01' required><option>Selecione um cliente/filial</option>";
                // Monta a lista de clientes e filiais junto do sim
                foreach ($resultado as $rowestado)
                {
                    // Exibe os clientes e filiais junto do sim
                    echo "<option value='{$rowestado['num_sim']}'>{$rowestado['num_sim']} - {$rowestado['nome']}</option>";
                }
        echo "</select>";
    }


    /**
     * listaEquipamento
     *
     * Funcao que gera a lista de todos os equipamentos
     *
     * @access public
     */
    public function listaEquipamento()
    {
        $pac2 = new C_PhpAutocomplete('equipLista');
        $pac2->display('SELECT');

        // Monta a query para buscar os equipamentos
        $query = "select id, tipo_equipamento as nome from tb_equipamento where status_ativo = 1";

        // Monta a result
        $result = $this->db->select($query);

        // Criar o array de resposta
        $resultado = array();

        // Verifica se existe valor na result
        if (@mysql_num_rows($result) > 0)
        {
            // Monta o array de dados
            while ($rowequiperes = @mysql_fetch_assoc($result))
                $resultado[] = $rowequiperes;
        }

        // Exibe os equipamentos no option
        echo "<select id='equipLista' name='opc_equipamento' class='font-texto-01' required><option>Selecione um equipamento</option>";
                // Monta a lista de equipamentos
                foreach ($resultado as $rowequip)
                {
                    // Exibe os equipamentos
                    echo "<option value='{$rowequip['id']}-e'>{$rowequip['nome']}</option>";
                }
        echo "</select>";
    }



    /**
     * Funcao utilizada para verificar se existe resultado
     *
     * @param string $query  - Codigo sql para pesquisar no banco
     * @return array $retorno - Resultado da busca
     */
    public function resultado_query($query)
    {
        // Realiza a query no banco
        $result = $this->db->select ($query);

        // Verifica se existe resposta
        if ($result)
        {
            // Verifica se existe resultado
            if (@mysql_num_rows($result) > 0)
            {
                // Converte para array
                while ($row = @mysql_fetch_assoc($result))
                    // Armazena no array de retorno
                    $retorno[] = $row;

                // Retorna o valor
                return $retorno;
            }
            // Fim
            return false;
        }
        // Fim
        return false;
    }


    /*
    * Função para retornar os SIMs que estão vinculados a um Cliente
    */
    public function ListarVinculosCliente($idCliente)
    {
        if(is_numeric($idCliente)){

            $query = "SELECT sim.num_sim, sim.id_cliente, sim.id_filial, clie.nome AS 'cliente', fili.nome AS 'filial'
                        FROM tb_sim sim
                        JOIN tb_cliente clie ON sim.id_cliente = clie.id
                        LEFT JOIN tb_filial fili ON sim.id_filial = fili.id
                        WHERE sim.id_cliente = $idCliente AND sim.status_ativo = 1";

            // Monta a result
            $result = $this->db->select($query);

            // Verifica se existe resposta
            if($result)
            {
                // Verifica se existe resultado
                if (@mysql_num_rows($result) > 0)
                {
                    // Converte para array
                    while ($row = @mysql_fetch_assoc($result))
                        // Armazena no array de retorno
                        $retorno[] = $row;

                    // Retorna o valor
                    $array = array('status' => true, 'sims' => $retorno);
                }else{
                    $array = array('status' => false, 'sims' => '');
                }
                // Fim

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * Função para retornar lista de sims de acordo com o cliente e filial
    */
    public function listarSimsFilialClienteTipo($idCliente, $idFilial){

        if(is_numeric($idCliente) && is_numeric($idFilial)){

            $query = "SELECT sim.num_sim, sim.id_cliente, sim.id_filial, clie.nome AS 'cliente', fili.nome AS 'filial'
                        FROM tb_sim sim
                        JOIN tb_cliente clie ON sim.id_cliente = clie.id
                        LEFT JOIN tb_filial fili ON sim.id_filial = fili.id
                        WHERE sim.id_cliente = '$idCliente' AND sim.id_filial = '$idFilial' AND sim.status_ativo = '1'";

            // Monta a result
            $result = $this->db->select($query);

            // Verifica se existe resposta
            if($result)
            {
                // Verifica se existe resultado
                if (@mysql_num_rows($result) > 0)
                {
                    // Converte para array
                    while ($row = @mysql_fetch_assoc($result))
                        // Armazena no array de retorno
                        $retorno[] = $row;

                    // Retorna o valor
                    $array = array('status' => true, 'sims' => $retorno);
                }else{
                    $array = array('status' => false, 'sims' => '');
                }
                // Fim

            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }
        return $array;
    }

    /*
    * Função para retornar as posições de vinculo de um tipo de equipamento
    */
    public function posicoesEquipamentoVincular($idEquipamentopamento)
    {
        if(is_numeric($idEquipamentopamento)){

            $query  = "SELECT equip.tipo_equipamento, tpEquip.posicoes_tabela, tpEquip.limite_equipamentos
                        FROM tb_equipamento equip
                        LEFT JOIN tb_tipo_equipamento tpEquip ON tpEquip.id = equip.tipo_equipamento
                        WHERE equip.id = '$idEquipamentopamento'";

            // Monta a result
            $result = $this->db->select($query);

            // Verifica se existe resposta
            if($result){

                // Verifica se existe resultado
                if (@mysql_num_rows($result) > 0)
                {
                    // Converte para array
                    while ($row = @mysql_fetch_assoc($result))
                        // Armazena no array de retorno
                        $retorno[] = $row;

                    // Retorna o valor
                    $array = array('status' => true, 'posicoes' => $retorno);
                }else{
                    $array = array('status' => false, 'posicoes' => '');
                }

            }else{
                $array = array('status' => false);
            }

        }else {

            $array = array('status' => false);

        }

        return $array;

    }

    /*
    * Função para recuperar as posições ocupadas em um SIM
    */
    public function posicoesOcupadas($numeroSim)
    {

        if(is_numeric($numeroSim)){

            $query = "SELECT pos.posicao
                      FROM  tb_posicao pos
                      WHERE pos.id_num_sim = '$numeroSim' AND pos.status_ativo = '1'";

            // Monta a result
            $result = $this->db->select($query);

            // Verifica se existe resposta
            if($result){

                // Verifica se existe resultado
                if (@mysql_num_rows($result) > 0)
                {
                    // Converte para array
                    while ($row = @mysql_fetch_assoc($result))
                        // Armazena no array de retorno
                        $retorno[] = $row;

                    // Retorna o valor
                    $array = array('status' => true, 'posicoes_ocupadas' => $retorno);
                }else{
                    $array = array('status' => false, 'posicoes_ocupadas' => '');
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
    * Função para registrar o vinculo via JSON
    */
    public function cadastrarVinculoCliente($idCliente, $idFilial, $numSim, $ambiente)
    {
        if(is_numeric($idCliente)){

            if(!is_numeric($idFilial)){
                $idFilial = 0;
            }

            $ambiente  = $this->tratamento($ambiente);

            //QUERY ATUALIZADA PARA EFETUAR UM UPDATE NO num_sim AO INVÉS DE GERAR UM INSERT
            //$query = "INSERT INTO tb_sim (num_sim, id_cliente, id_filial, ambiente_local_sim) VALUES ('$numSim', '$idCliente', '$idFilial', '$ambiente')";

            $query = "UPDATE tb_sim SET id_cliente = '$idCliente', id_filial = '$idFilial', ambiente_local_sim = '$ambiente' WHERE num_sim = '$numSim' AND status_ativo = '1'";

            //var_dump($query);

            // Verifica se gravou com sucesso
            if ($this->db->query($query))
            {
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
    * Função para registrar vinculo com equipamento
    */

    public function cadastrarVinculoEquipamento($idEquipamento, $simVinculado, $ambiente){

        if(is_numeric($idEquipamento)){

            /*
            * O número de série é o mesmo que o número SIM
            */

            $query = "INSERT INTO tb_sim_equipamento (id_equipamento, id_sim, num_serie, ambiente) VALUES ('$idEquipamento', '$simVinculado', '$simVinculado', '$ambiente')";

            $result = $this->db->query($query)

            // Verifica se gravou com sucesso
            if(!empty($result))
            {
                if(is_numeric($result)){
                    $idGerada = $result;
                }else{
                    $idGerada = null;
                }

                //var_dump($query);
                // $idGerada  = mysql_insert_id();
                $array = array('status' => true, 'id_sim_equipamento' => $idGerada);
            }else{
                $array = array('status' => false);
            }

        }else{
            $array = array('status' => false);
        }

        return $array;
    }

    /*
    * REMOVER VINCULO COM O SIM
    */
    public function removerVinculoCliente($simNUmber){

        /*
        * NÃO É EFETUADO A DESATIVAÇÃO DO NUM_SIM PARA SIM A DESVINCULAÇÃO DO CHIP COM O CLIENTE E FILIAL
        * CHIP PERNACE ATIVO E SE TORNA DISPONIVEL PARA NOVO VINCULO COM CLIENTE
        */

        //$query = "UPDATE tb_sim SET status_ativo = '0' WHERE num_sim = '$simNUmber'";
        $query = "UPDATE tb_sim SET id_cliente = '0', id_filial = '0' WHERE num_sim = '$simNUmber'";

        // Verifica se gravou com sucesso
        if ($this->db->query($query))
        {
            $array = array('status' => true);
        }else{
            $array = array('status' => false);
        }

        return $array;

    }

    /*
    * VERIFICAR SE NÚMERO SIM JÁ EXISTE NO SISTEMA
    */
    public function verificarSimExistente($numSim){

        //$query = "SELECT num_sim FROM tb_sim WHERE num_sim = '$numSim' AND status_ativo = '1'";
        $query = "SELECT num_sim FROM tb_sim WHERE num_sim = '$numSim'";

        // Monta a result
        $result = $this->db->select($query);

        // Verifica se existe resposta
        if($result){

            // Verifica se existe resultado
            if (@mysql_num_rows($result) > 0)
            {
                // Converte para array
                while ($row = @mysql_fetch_assoc($result))
                    // Armazena no array de retorno
                    $retorno[] = $row;

                // Retorna o valor
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
