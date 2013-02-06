<?
	//Polls Controller
	
	//Create a Database Connection
	$db = new mydb();
	
	//Create the User
	$poll = new Poll();
	$mypolls = $poll->getPolls($db);
	
	//Handle the option selection
	if(isset($_REQUEST['pollid'])){
		$pollid = $_REQUEST['pollid'];
		$option = 'viewpoll';
	} else {
		$option = 'viewallpolls';
	}
?>