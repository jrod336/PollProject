<?
	//User Menu Controller
	
	//Create a Database Connection
	$db = new mydb();
	
	//Create the User
	$user = new User();
	$user->userid = 1;	//Temp setting
	
	//Handle the option selection
	if($_REQUEST['option'] == 'create'){
		$option = 'create';
	} elseif($_REQUEST['option'] == 'update'){
		$option = 'update';
		$mypolls = $user->getPolls($db);
	} elseif($_REQUEST['option'] == 'delete'){
		$option = 'delete';
		$mypolls = $user->getPolls($db);
	} else {
		$option = false;
	}
?>