<?
	//User Menu Controller
	
	if($_REQUEST['option'] == 'create'){
		$option = 'create';
	} elseif($_REQUEST['option'] == 'update'){
		$option = 'update';
	} elseif($_REQUEST['option'] == 'delete'){
		$option = 'delete';
	}
?>