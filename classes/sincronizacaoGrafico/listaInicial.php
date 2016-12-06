<?php

class ListaInicial
{
    /**
     * $data
     * 
     * Armazena valor que vai para o grafico
     * 
     * @access private
     */
    private $data;
    
    
    /**
     * $db
     * 
     * Recebe os parametros da conexao com banco
     * 
     * @access private
     */
    private $db;
    
    
    /**
     * Metodo construtor
     * 
     * @param numeric $limite    - limite de linhas que sera exibido no select
     * @param conexao $db        - parametros de conexao com 
     * @param array   $parametro - parametros da url
     */
    public function __construct ($limite, $db = false, $parametros)
    {
        // Chama os parametros de conexao com o banco
        $this->db = $db;
        
        // Decodifica o parametro do sim
        $parametro = base64_decode($parametros[0]);
        
        // Recebe os parametos da data
        // Verifica se existem e tem valor
        if (isset($parametros[4]) && isset($parametros[5]) && !empty($parametros[4]) && !empty($parametros[5]))
        {
            // Decodifica as datas
            $dti = base64_decode($parametros[4]);
            $dtf = base64_decode($parametros[5]);
            
            // Remove o T
            $dti = str_replace("T"," ",$dti);
            $dtf = str_replace("T"," ",$dtf);
            
            // Monta a query utilizando datas
            $select = $this->db->select("select h,i,dt_criacao from tb_dados where num_sim = {$parametro} and status_ativo = 1 and dt_criacao between '{$dti}:00' and '{$dtf}:59' order by id desc");
        }
        else
        {
            // Monta a query sem datas
            $select = $this->db->select("select h,i,dt_criacao from tb_dados where num_sim = {$parametro} and status_ativo = 1 order 
                                         by id desc limit {$limite}");
        }
        
        // Verifica se existe resposta do select
        if ($select)
        {
            // Verifica se existe valor na result
            if (@mysql_num_rows($select) > 0)
            {
                // Coleta os valores da result e transforma em array
                while($row = @mysql_fetch_array($select))
                {
                    // Converte a data e hora em array
                    $separando = explode(' ',$row['dt_criacao']);
                    
                    // Converte a data em array, separando o dia, mes e ano
                    $sepData = explode('-',$separando['0']);
                    
                    // Converte a hora em array, separando a hora, min e sec
                    $sepHora = explode(':',$separando['1']);
                    
                    // Ajusta os dados no padrao de dados do grafico
                    $this->data['entrada'][] = "[Date.UTC({$sepData[0]},{$sepData[1]},{$sepData[2]},{$sepHora[0]},{$sepHora[1]},{$sepHora[2]}),".intval($row['h'])."]";
                    
                    $this->data['saida'][] = "[Date.UTC({$sepData[0]},{$sepData[1]},{$sepData[2]},{$sepHora[0]},{$sepHora[1]},{$sepHora[2]}),".intval($row['i'])."]";
                }
            }
            else
            {
                // Caso nao exista valor na result
                // Armazena false na data
                $this->data = false;
                return;
            }
        }
        else
        {
            // Caso nao exista retorno do select
            // Informa que nao existe nenhum valor
            echo "Nenhum valor<script>alert('nada');</script>";
        }
    }
    
    /**
     * Funcao que carrega os valores do grafico
     * E converte no formato de exibicao dele
     */
    public function carregaValorTri($socket = "entrada")
    {
        // Verifica se existe valor na data
        if (isset($this->data) && !empty($this->data) && is_array($this->data))
        {
            // Fim
            return $this->data[$socket];
        }
    }
}

?>