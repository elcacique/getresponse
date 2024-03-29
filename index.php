<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/conf/conf.php";

$template = new Template_Parser();
$authorization = new Authorization();


if(!isset($_SESSION['admin'])) {
	$tpl = 'login.html';
}
else {
	$tpl = 'default.html';
}

if (!isset($_SESSION['admin'])) {
	$admin = $authorization->login($_REQUEST['login'], $_REQUEST['password']);
	$macros = array(null);
	if ($admin === true)
		print '<script language="javascript">document.location = "/";</script>';
}
elseif ($_REQUEST['mod'] == 'logout') {
	$authorization->logout();
	
}
elseif ($_REQUEST['mod'] == 'getresponse') {
	$apiUrl = 'http://api.getresponse360.com/alexschool';
	//$apiUrl = 'http://api2.getresponse.com'; // test url
	$modTplDir = '/getResponse';
	
	$client = new jsonRPCClient($apiUrl);
	$getResponse = new GetResponse();
	
	if ($_REQUEST['sub'] == 'newForm') {
		if (!empty($_REQUEST['sub2'])) {
			$process = $getResponse->getProcess($_REQUEST['sub2']);
			$campaign = $process['campaign'];
			$campaignTarget = $process['campaignTarget'];
			$action = $process['action'];
			$cycleDay = $process['cycleDay'];
			$eachDay = $process['eachDay'];
		}
		else {
			$campaign = null;
			$campaignTarget = null;
			$action = 1;
			$cycleDay = '-1';
			$eachDay = 1;
		}	
		
		$campaigns = $getResponse->getCampaigns();
		$data = array(
			'campaign' => $getResponse->printCampaigns($campaigns, $campaign),
			'campaignTarget' => $getResponse->printCampaigns($campaigns, $campaignTarget),
			'action' => $action,
			'cycleDay' => $cycleDay,
			'eachDay' => $eachDay
		);
		$content = $template->ParseTpl($modTplDir.'/newForm.html', $data, false);	
		$macros['content'] = $content;
	}
	elseif ($_REQUEST['sub'] == 'new') {
		$data = array(
			'action' => $_REQUEST['action'],
			'campaign' => $_REQUEST['campaign'],
			'campaignTarget' => $_REQUEST['campaignTarget'],
			'cycleDay' => (isset($_REQUEST['cycleDay']) ? $_REQUEST['cycleDay'] : '-1'),
			'eachDay' => $_REQUEST['eachDay']
		);
		$getResponse->addProcess($data);
		print '<script language="javascript">document.location = "/getresponse/";</script>';
	}
	else {
		$data['processes'] = $getResponse->getProcesses();
		$content = $template->ParseTpl($modTplDir.'/getResponse.html', $data, false);
		$macros['content'] = $content;
	}
	
	$macros['headline'] = 'Автоматизация GR подписчиков';
	$macros['breadcrumb'] = '<li class="active"><i class="fa fa-envelope"></i> '.$macros['headline'].'</li>';
}
else {
	$macros['content'] = 'DASHBOARD на даный момент не содержит информации';
	$macros['headline'] = 'DASHBOARD';
	$macros['breadcrumb'] = '';
}


$template->ParseTpl($tpl, $macros);

?>