<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<style type="text/css">
			@import "/css/admin/drag-drop-folder-tree.css";
			@import "/css/admin/context-menu.css";
			@import "/css/admin/tooltip.css";
			@import "/css/admin/admin.css";
</style>

<script type="text/javascript" src="/js/admin/ajax.js"></script>
<!--<script type="text/javascript" src="/js/context-menu.js"></script>-->
<script type="text/javascript" src="/js/admin/drag-drop-folder-tree.js"></script>

<script type="text/javascript" src="/js/admin/confirm.js"></script>
<script type="text/javascript" src="/js/admin/translit.js"></script>
<script type="text/javascript" src="/js/admin/show.js"></script>

<script type="text/javascript" src="/js/admin/tooltip.js"></script>
<script type="text/javascript" src="/js/admin/live_type.js"></script>

<script type="text/javascript" src="/js/admin/date.js"></script>

<script type="text/javascript" src="/js/admin/jquery.js"></script>
<script type="text/javascript" src="/js/admin/jquery.tablednd.js"></script>

<script type="text/javascript" src="/js/admin/visible.js"></script>

<!--icon-->
<link rel="icon" href="/Iconico.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/Iconico.ico" type="image/x-icon" />


<script type="text/javascript">
	//--------------------------------
	// Save functions
	//--------------------------------
	var ajaxObjects = new Array();
	
	// Use something like this if you want to save data by Ajax.
	function saveMyTree()
	{
			saveString = treeObj.getNodeOrders();
			var ajaxIndex = ajaxObjects.length;
			ajaxObjects[ajaxIndex] = new sack();
			var url = 'saveNodes/?saveString=' + saveString;
			ajaxObjects[ajaxIndex].requestFile = url;	// Specifying which file to get
			ajaxObjects[ajaxIndex].onCompletion = function() { saveComplete(ajaxIndex); } ;	// Specify function that will be executed after file has been found
			ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function			
		
	}
	function saveComplete(index)
	{
		//alert(ajaxObjects[index].response);
		alert('Структура збережена!');
	}

	
	// Call this function if you want to save it by a form.
	function saveMyTree_byForm()
	{
		document.myForm.elements['saveString'].value = treeObj.getNodeOrders();
		document.myForm.submit();
	}
	

	</script>

<script type="text/javascript" src="/js/FlyToBasket/fly-to-basket.js"></script>


<script type="text/javascript" src="/js/admin/getTranslationLinks.js"></script>


<script type="text/javascript" src="/js/admin/compiled.js"></script>

<title>Панель Адміністратора</title>
</head>

<body>
<table style="height: 779px;" id="main" border="0" cellpadding="0" cellspacing="0">
<tbody>
	<tr id="header">
		<td colspan="2" class="logo"><img src="/img/admin/logo_sub.jpg" width="189" height="93" /></td>
	</tr>
	<tr id="vmenu">
		<td nowrap="nowrap" id="mnav"><div id="mnav_b"><a href="/admin/logout/" class="gray of_exit"><img src="/img/admin/ico_exit.gif" height="9" width="11" />&nbsp;&nbsp;{EXIT}</a></div>
	  </td>
	  <td align="left" valign="middle" id="navibar">
	  	<table width="100%" cellpadding="0" cellspacing="0" border="0" height="30px"><tr>
	  		<td align="left" valign="middle" style="padding:0 10px">
	  			{USER_NAME}
	  		</td>
	  		<td align="center" valign="middle" width="50%" style="padding:0 10px">
	  			{LANGUAGES}
	  		</td>
	  		<td align="right" valign="middle" style="padding:0 10px">
	  			<a href="/" target="_blank">Перейти на сайт</a>
	  		</td>
	  	</tr></table>
	  </td>
	</tr>
	<tr>
		<td id="menu">
<div id="menu_b">
			
			
			{MODULS}
   
    	</div></td>
	<td valign="top" id="content_d">
	<div id="content_b">
		<div id="my_widget">
	
	  		<h1>{HEADLINE}</h1>
			<br />
			{CONTENT}
		</div>
	</div>
	<p style="margin: 80px 0;">&nbsp;</p>
<script type="text/javascript">
	treeObj = new JSDragDropTree();
	treeObj.setTreeId('dhtmlgoodies_tree2');
	treeObj.setMaximumDepth(7);
	treeObj.setMessageMaximumDepthReached('Maximum depth reached'); // If you want to show a message when maximum depth is reached, i.e. on drop.
	treeObj.initTree();
	treeObj.expandAll();
</script>
    </td></tr>

<tr id="footer">
	<td colspan="2">
	<div id="copy">Copyright ©<script type="text/javascript">document.write(getYear(2007));</script> <a class="l u" target="_blank" href="http://www.websvit.com.ua/">www.websvit.com.ua</a></div>
	<div id="support">Техническая поддержка: <a class="l u" href="http://www.websvit.com.ua/" target="_blank">www.websvit.com.ua</a></div></td>
</tr></tbody></table>
</body></html>
