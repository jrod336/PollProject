<?
	//Polls Controller
	
	//Create a Database Connection
	$db = new mydb();
	
	//Create the User
	$polls = new Polls();
	$mypolls = $polls->getPolls($db);
	
	//Handle the option selection
	if(isset($_REQUEST['pollid'])){
		$pollid = $_REQUEST['pollid'];
		$option = 'viewpoll';
	} else {
		$option = 'viewallpolls';
	}
?>