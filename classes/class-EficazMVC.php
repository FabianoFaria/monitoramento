<?php

/**
 * Classe que gerencia o sistema MVC
 */
class EficazMVC
{
    /**
     * $controlador
     * 
     * Recebe o nome do controller por parametro
     * 
     * @access private
     */
    private $controlador;
    
    /**
     * $acao
     * 
     * Recebe as acoes
     * 
     * @access private
     */
    private $acao;
    
    /**
     * $parametros
     * 
     * Recebe os parametros
     * 
     * @access private
     */
    private $parametros;
    
    /**
     * $not_found
     * 
     * Armazena o diretorio da pagina de erro
     * 
     * @access private
     */
    private $not_found = "/includes/404.php";
    
    /**
     * Funcao do metodo construtor
     * 
     * Realiza o tratamento da url
     * e gerencia o controller e o model a ser implementado
     */
    public function __construct ()
    {
        // Obtem os valores
        $this->get_url_data();
        
        // Define o caminho do auto complete
        $phpAutoCom = EFIPATH . '/views/_api/phpAutocomplete_Lite/conf.php';
        // Verifica se o arquivo existe
        if (! file_exists($phpAutoCom))
        {
            // Mostra a pagina 404
            require_once EFIPATH . $this->not_found;
            
            // Finaliza a aplicacao
            return;
        }
        
        require_once $phpAutoCom;
        
        // Verifica se o controlador existe
        if (!$this->controlador)
        {
            // Adiciona o controlador padrao
            require_once EFIPATH . '/controllers/home-controller.php';
            
            // Cria o objeto do controlador
            $this->controlador = new HomeController();
            
            // Executa o metodo index
            $this->controlador->index();
            
            // Fim
            return;
        }
        
        // Verfica se o arquivo existe
        if (! file_exists (EFIPATH . '/controllers/' . $this->controlador . '.php'))
        {
            // Para pagina nao encontrada
            require_once EFIPATH . $this->not_found;
            
            // Fim
            return;
        }
        
        // Inclui o arquivo do controlador
        require_once EFIPATH . '/controllers/' . $this->controlador . '.php';
        
        // Remove caracteres invalidos do nome do controlador
        $this->controlador = preg_replace('/[^a-zA-Z]/i', '', $this->controlador );
        
        // Verifica se a classe do controlador existe
        if(! class_exists($this->controlador))
        {
            // Mostra a pagina de erro
            require_once EFIPATH . $this->not_found;
            // Fim
            return;
        }
        
        // Cria o obejto do controlador
        $this->controlador = new $this->controlador($this->parametros);
        
        // Verifica se o metodo indicado existe
        if(method_exists($this->controlador, $this->acao))
        {
            // Chama o metodo indicado
            $this->controlador->{$this->acao}($this->parametros);
            // Fim
            return;
        }
        
        // Caso nao exista uma acao , chama o metodo padrao
        if(! $this->acao && method_exists($this->controlador, 'index'))
        {
            // Chama o metodo padrao
            $this->controlador->index($this->parametros);
            // Fim
            return;
        }
        
        // Para pagina nao encontrada
        require_once EFIPATH . $this->not_found;
        
        // Fim
        return;
    }
    
    /**
     * Funcao que verifica e trata a url
     * para montar o controller
     */
    public function get_url_data()
    {
        // Verifica se o paramentro existe
        if (isset($_GET['path']))
        {
            // Armazena o parametro
            $path = $_GET['path'];
            
            // Limpa os dados
            $path = rtrim($path,'/');
            $path = filter_var($path, FILTER_SANITIZE_URL);
            
            // Cria um array com o parametro
            $path = explode('/', $path);
            
            // Configura as propriedades
            $this->controlador = chk_array($path , 0);
            $this->controlador .= '-controller';
            $this->acao = chk_array($path, 1);
            
            // Configura os parametros
            if (chk_array($path, 2))
            {
                // Limpa as posicoes do array
                unset ($path[0]);
                unset ($path[1]);
                // Retorna os valores do array indexados
                $this->parametros = array_values($path);
            }
            
            // Modo desenvolvimento
            if (defined('DEVTOOLS') && DEVTOOLS == true)
            {
                echo "<pre>";
                echo "[Controlador] => " . $this->controlador . "<br>";
                echo "[Acao] => " . $this->acao . "<br>";
                print_r($this->parametros);
                echo "</pre>";
            }
        }
    }
}

?>