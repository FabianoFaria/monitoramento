<?php

// caminho raiz
define('EFIPATH', dirname(__FILE__));
// caminho pasta upload
define('UP_EFIPATH' , EFIPATH . '/views/_uploads');
// url da home
define('HOME_URI' , 'http://127.0.0.1/eficazmonitor'); // versao desenvolvedor
//define('HOME_URI' , 'http://eficazsystem.com.br/eficazmonitor');
//define('HOME_URI' , 'http://monitor.eficazsystem.com.br');
//define('HOME_URI , 'https://monitor.eficazsystem.com.br');  // versao produção segura
/* configuracao da base de dados */

// hostname
// define('HOSTNAME' , '127.0.0.1');
// // usuario da base
// define('USERNAME' , 'root');
// // senha
// define('USERPASS' , '');
// // nome da base de dados
// define('DBNAME' , 'eficazsystem22');

// localhost
// hostname
define('HOSTNAME' , 'mysql03.eficazsystem2.hospedagemdesites.ws');
// usuario da base
define('USERNAME' , 'eficazsystem22');
// senha
define('USERPASS' , 'monitor2981');
// nome da base de dados
define('DBNAME' , 'eficazsystem22');


/* modo desenvolvedor */
define('DEBUG' , false);
define('DEVTOOLS', false);

/* carrega o inicializador */
require_once EFIPATH . '/loader.php';

?>
