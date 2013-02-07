<?
	//Polls Controller
	
	//Create a Database Connection
	$db = new mydb();
	
	//Create the User
	$polls = new Polls();
	$mypolls = $polls->getPolls($db);
	
	//Handle the option selection
	if(isset($_POST['s_vote'])){
		//Vote Submitted
		$pollid = $_POST['pollid'];
		$value = $_POST['value'];
		$option = 'viewpoll';
		$mypoll = new Poll();
		$mypoll->getPoll($db, $pollid);
		$mypoll->getItems($db, $pollid);
		$mypoll->getVotes($db, $pollid);
		
		//Submit the Poll
		if(!$mypoll->voteFound){
			$mypoll->addVote($db, $pollid, $value);
		}
		
		//Recount the Votes for this poll
		$mypoll->getVotes($db, $pollid);
	} elseif(isset($_REQUEST['pollid'])){
		//View a Poll
		$pollid = $_REQUEST['pollid'];
		$option = 'viewpoll';
		$mypoll = new Poll();
		$mypoll->getPoll($db, $pollid);
		$mypoll->getItems($db, $pollid);
		$mypoll->getVotes($db, $pollid);
	} else {
		$option = 'viewallpolls';
	}

?>