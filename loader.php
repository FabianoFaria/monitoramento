<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

/* Define o limitador de cache para 'private' */
//session_cache_limiter('private');
//$cache_limiter = session_cache_limiter();

/* Define o limite de tempo do cache em 30 minutos */
//session_cache_expire(10);
//$cache_expire = session_cache_expire();

/* inicia a sessao */
session_name("EficazMonitor");
session_start();

/* verifica se o modo debug esta ativo */
if (!defined('DEBUG') || DEBUG == true)
{
    /* esconde os erros */
    error_reporting(0);
    ini_set("display_errors",0);
}
else
{
    /* mostra todos os erros */
    error_reporting(E_ALL);
    ini_set("display_errors",1);
}

/* carrega as funcoes globais */
require_once EFIPATH . '/functions/global-functions.php';

/* inicia a aplicacao */
$eficazmvc = new EficazMVC();

?>