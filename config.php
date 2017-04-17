<?php

// caminho raiz
define('EFIPATH', dirname(__FILE__));
// caminho pasta upload
define('UP_EFIPATH' , EFIPATH . '/views/_uploads');
// caminho pasta upload de imagem de usuários
define('UP_USER_IMG_PATH', EFIPATH.'/views/_uploads/users');
// caminho pasta upload de imagem de clientes
define('UP_CLIE_IMG_PATH', EFIPATH.'/views/_uploads/clients');
// url da home
define('HOME_URI' , 'http://127.0.0.1/eficazmonitor'); // versao desenvolvedor
//define('HOME_URI' , 'http://eficazsystem.com.br/eficazmonitor');
//define('HOME_URI' , 'http://monitor.eficazsystem.com.br');
//define('HOME_URI , 'https://monitor.eficazsystem.com.br');  // versao produção segura
/* configuracao da base de dados */

// hostname
define('HOSTNAME' , '127.0.0.1');
// usuario da base
define('USERNAME' , 'root');
// senha
define('USERPASS' , '');
// nome da base de dados
define('DBNAME' , 'eficazsystem22');

// localhost
// hostname
// define('HOSTNAME' , 'mysql03.eficazsystem2.hospedagemdesites.ws');
// // usuario da base
// define('USERNAME' , 'eficazsystem22');
// // senha
// define('USERPASS' , 'monitor2891');
// // nome da base de dados
// define('DBNAME' , 'eficazsystem22');


/* modo desenvolvedor */
define('DEBUG' , TRUE);
define('DEVTOOLS', false);

/* carrega o inicializador */
require_once EFIPATH . '/loader.php';

?>
