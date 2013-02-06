<?
	//User Menu Controller
	
	//Create a Database Connection
	$db = new mydb();
	
	//Handle Login
	$user = new User();
	if($_SESSION['loggedin']){
		$user->getUser($db, $_SESSION['userid']);
	}
	
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
		$polls = new Polls();
		
		$polls->updatePoll($db, $_POST);
	} elseif(isset($_POST['s_delete'])){
		//Delete a Poll Submitted
		$polls = new Polls();
		
		$polls->deletePoll($db, $_POST);
	} elseif(isset($_POST['s_login'])){
		//User Logging In
			
		//Create the User
		$user->authenticated = $user->authenticate($db, $_POST);
		if($user->authenticated) {
			$_SESSION['loggedin'] = true;
			$_SESSION['userid'] = $user->userid;
		} else {
			$login_error = "<p><b style='color:red'>You have entered an incorrect login. Please try again.</b></p>";
		}
	}
	

?>