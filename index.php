<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/conf/conf.php";

$db = new DB_MySQL();
$template = new Template_Parser();

/*
if(empty($_REQUEST['mod']) or !isset($_SESSION['admin'])) {
	$tpl = 'login.html';
}
else {
	$tpl = 'default.html';
}
*/


if ($_REQUEST['mod'] == 'getresponse') {
	$apiUrl = 'http://api.getresponse360.com/alexschool';
	//$apiUrl = 'http://api2.getresponse.com'; // test url
	$modTplDir = '/getResponse';
	
	$client = new jsonRPCClient($apiUrl);
	$getResponse = new GetResponse();
	
	if ($_REQUEST['sub'] == 'newForm') {
		$campaigns = $getResponse->getCampaigns();
		$gr['campaigns'] = $getResponse->printCampaigns($campaigns);
		$content = $template->ParseTpl($modTplDir.'/newForm.html', $gr, false);
		
		$macros['content'] = $content;
	}
	else $macros['content'] = file_get_contents(TPLDIR.$modTplDir.'/getResponse.html');
	
	$macros['headline'] = 'Автоматизация GR подписчиков';
	$macros['breadcrumb'] = '<li class="active"><i class="fa fa-envelope"></i> '.$macros['headline'].'</li>';
}
else {
	$macros['content'] = 'DASHBOARD на даный момент не содержит информации';
	$macros['headline'] = 'DASHBOARD';
	$macros['breadcrumb'] = '';
}


$tpl = 'default.html';
$template->ParseTpl($tpl, $macros);

?>