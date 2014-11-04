<?php
require_once $_SERVER['DOCUMENT_ROOT']."/conf/conf.php";
$db = new DB_MySQL();
$getResponse = new GetResponse();

switch ($_REQUEST['do']) {
	case 'deleteProcess':
		$getResponse->deleteProcess($_REQUEST['id']);
	break;
	
	default:
		;
	break;
}
?>