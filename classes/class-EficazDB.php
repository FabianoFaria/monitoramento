<?php

/**
 * Classe de conexao com o banco
 *
 * Responsavel por gerenciar toda a conexao
 * Select , query e fechamento da conexao
 */
class EficazDB
{
    /**
     * $host
     *
     * Recebe o nome dos host onde esta o banco de dados
     *
     * @access private
     */
    private $host;

    /**
     * $dbname
     *
     * Recebe o nome do banco de dados onde contem os dados
     *
     * @access private
     */
    private $dbname;

    /**
     * $username
     *
     * Recebe o nome do usuario que realiza a conexao com o banco
     *
     * @access private
     */
    private $username;

    /**
     * $userpass
     *
     * Recebe a senha do usuario que conectara no banco de dados
     *
     * @access private
     */
    private $userpass;

    /**
     * Metodo de contrucao
     * quando instanciado realiza a conexao com o banco
     */
    public function __construct()
    {
        // Armazena os dados de conexao com o banco
        $this->host =     defined('HOSTNAME') ? HOSTNAME : "mysql03.eficazsystem2.hospedagemdesites.ws";
        $this->dbname =   defined('DBNAME')   ? DBNAME   : "eficazsystem22";
        $this->username = defined('USERNAME') ? USERNAME : "eficazsystem22";
        $this->userpass = defined('USERPASS') ? USERPASS : "monitor2891";
        // $this->host =     defined('HOSTNAME') ? HOSTNAME : "localhost";
        // $this->dbname =   defined('DBNAME')   ? DBNAME   : "eficazsystem22";
        // $this->username = defined('USERNAME') ? USERNAME : "root";
        // $this->userpass = defined('USERPASS') ? USERPASS : "";

        // Chama a conexao com o banco
        $this->connect();
    }

    /**
     * Funcao que cria a conexao com o banco de dados
     */
    final protected function connect ()
    {
        // Verifica se existe os valores nas variaveis de conexao --FAVOR RECOLOCAR NO CÓDIGO O TRECHO  && ! empty($this->userpass)
        if (! empty($this->host) && ! empty($this->dbname) && ! empty($this->username))
        {

            /*
            * IMPLEMENTAÇÃO DE CONEXÃO DE PDO
            */
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname.''; // define host name and database name
            $username = $this->username; // define the username
            $pwd = $this->userpass; // password

            try {
                $db = new PDO($dsn, $username, $pwd);

                //RETONA OBJETO PDO
                return $db;
            }
            catch (PDOException $e) {
                $error_message = $e->getMessage();
                echo "this is displayed because an error was found";
                //exit();
                return $error_message;
            }


            // Verifica se a conexao foi realiza com secesso
            // if (mysql_connect($this->host, $this->username, $this->userpass))
            // {
            //     // Seleciona o banco de dados
            //     if (mysql_select_db($this->dbname))
            //     {
            //         // Verifica se o modo desenvolvedor esta ativado
            //         if (defined('DEVTOOLS') && DEVTOOLS == true)
            //         {
            //             // Se estiver apresenta a mensagem
            //             echo "<p class='mensagemRetorno'>Conex&atilde;o efetuada com sucesso</p>";
            //         }
            //     }
            //     else
            //     {
            //         // Caso nao consiga selecionar uma base de dados
            //         // Apresenta uma mensagem de erro
            //         echo "<p class='mensagemRetorno'>Erro ao selecionar a base de dados" . mysql_error() . "</p>";
            //     }
            // }
            // else
            // {
            //     // Caso a conexao nao seja realizada com sucesso
            //     // Apresenta a mensagem de erro
            //     echo "<p class='mensagemRetorno'>N&atilde;o foi poss&iacute;vel conectar: " . mysql_error() . "</p>";
            // }
        }
        else
        {
            // Se os valores estiverem vazios
            // Apresenta a mensagem de erro
            echo "<p class='mensagemRetorno'>Erro de conexao</p>";
        }
    }

    /**
     * Funcao que realiza as querys no banco
     *
     * Returno true para sucesso
     * ou false para erro
     *
     * @param string $query - recebe o codigo sql
     */
    public function query ($query)
    {
        // Verifica se a query executou com secesso
        if (@mysql_query($query))
        {
            // Caso grave com sucesso
            // Retorna verdadeiro
            return true;
        }
        // Se der erro de execucao
        // Retorna falso
        return false;
    }

    /**
     * Funcao que realizao o select no banco
     *
     * @param string $query - Recebe o codigo sql
     */
    public function select ($query)
    {
        $pdo = $this->connect();

        // o método PDO::prepare() retorna um objeto da classe PDOStatement ou FALSE se ocorreu algum erro (neste caso use $pdo->errorInfo() para descobrir o que deu errado)
        $stmt = $pdo->prepare($query);

        // executamos o statement
        $ok = $stmt->execute();

        // agora podemos pegar os resultados (partimos do pressuposto que não houve erro)
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    /**
     * Funcao responsavel por finaliza a conexao
     * com o banco de dados
     */
    public function close ()
    {
        // Verifica se a conexao fechou
        if (@mysql_close())
        {
            // Verifica se o modo desenvolvedor esta ativo
            if (defined('DEVTOOLS') && DEVTOOLS == true)
            {
                // Se estiver ativo
                // Retorna confirmacao de fechamento
                echo "<p class='mensagemRetorno'>Conex&atilde;o fechada com sucesso.</p>";
            }
        }
        else
        {
            // Caso de erro na hora de fechar a conexao
            // Verifica se o modo desenvolvedor esta ativo
            if (defined('DEVTOOLS') && DEVTOOLS == true)
            {
                // Se estiver ativo
                // Mostra a mensagem de erro
                echo "<p class='mensagemRetorno'>Erro ao fechar a conex&atilde;o : " . @mysql_error() . "</p>";
            }
        }
    }
}

?>
