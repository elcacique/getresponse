<?php

//print_r('<pre>');
//var_dump($_REQUEST);
//var_dump($_SESSION['cart']);
//var_dump($_SESSION['customer_info']);
//var_dump($_FILES);
//print_r('</pre>');

if(!is_dir($_SERVER['DOCUMENT_ROOT']."/errors")) mkdir("errors", "0777");
if(!file_exists($_SERVER['DOCUMENT_ROOT']."/errors/errors.log"))
	fopen($_SERVER['DOCUMENT_ROOT']."/errors/errors.log", "w");

error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", true);
ini_set("log_errors", true);
ini_set("error_log", $_SERVER['DOCUMENT_ROOT']."/errors/errors.log");


require_once $_SERVER['DOCUMENT_ROOT'].'/lib/db/mysql.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/template/parser.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/authorization/authorization.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/mod/getResponse/jsonRPCClient.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/mod/getResponse/getResponse.php';


if($_SERVER['COMSPEC']) {
	define('HOSTNAME', 'localhost');
	define('USERNAME', 'root');
	define('PASSWORD', '');
	define('DATABASE', 'getresponse');
}
else {
	define('HOSTNAME', 'localhost');
	define('USERNAME', 'for_test');
	define('PASSWORD', 'mRTx7iQP');
	define('DATABASE', 'for_test');
}

define ('DOMEN', '/');
define ('TPLDIR', 'templates');


?>