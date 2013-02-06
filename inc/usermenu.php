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
		//Create a new poll
		$option = 'create';
	} elseif($_REQUEST['option'] == 'update'){
		//Update Polls
		$option = 'update';
		$mypolls = $user->getPolls($db);
		if($_REQUEST['pollid']){
			//Update a Poll
			$pollid = $_REQUEST['pollid'];
			$mypoll = new Poll();
			$mypoll->getPoll($db, $pollid);
			$mypoll->getItems($db, $pollid);
			$mypoll->getVotes($db, $pollid);
		} else{
			$pollid = false;
		}
	} elseif($_REQUEST['option'] == 'delete'){
		//Delete Polls
		$option = 'delete';
		$mypolls = new Polls();
		$mypolls = $user->getPolls($db);
		if($_REQUEST['pollid']){
			//Delete a Poll
			$pollid = $_REQUEST['pollid'];
			$mypoll = new Poll();
			$mypoll->getPoll($db, $pollid);
			$mypoll->getItems($db, $pollid);
			$mypoll->getVotes($db, $pollid);
		} else{
			$pollid = false;
		}
	} else {
		//Main Menu
		$option = false;
	}
	
	//Handle Submissions
	if(isset($_POST['s_create'])){
		//Create a Poll Submitted
		$polls = new Polls();
		
		$polls->addPoll($db, $_POST);
	} elseif(isset($_POST['s_update'])){
		//Update a Poll Submitted
	} elseif(isset($_POST['s_delete'])){
		//Delete a Poll Submitted
	}
?>