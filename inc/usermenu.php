<?
	//User Menu Controller
	
	//Create a Database Connection
	$db = new mydb();
	
	//Create the User
	$user = new User();
	$user->userid = 1;			//Temp setting
	$user->username = 'jared';	//Temp setting
	
	//Handle the option selection
	if($_REQUEST['option'] == 'create'){
		$option = 'create';
	} elseif($_REQUEST['option'] == 'update'){
		$option = 'update';
		$mypolls = $user->getPolls($db);
		if($_REQUEST['pollid']){
			$pollid = $_REQUEST['pollid'];
			$mypoll = new Poll();
			$mypoll->getPoll($db, $pollid);
			$mypoll->getItems($db, $pollid);
			$mypoll->getVotes($db, $pollid);
		} else{
			$pollid = false;
		}
	} elseif($_REQUEST['option'] == 'delete'){
		$option = 'delete';
		$mypolls = new Polls();
		$mypolls = $user->getPolls($db);
	} else {
		$option = false;
	}
?>