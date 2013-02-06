<?
	//User Menu Controller
	class User{
		public $userid;
		public $username;
		
		//Returns an array of polls for this user
		public getPolls(){
			$sql = "select * from `polls` where userid='".$this->$userid."'";
			$db->query($sql);
			$polls = array();
			while($row = $db->nextRow()) {
				$polls[] = $row['friend_id'];
			}
			return $polls;
		}
	}
	
	$user = new User();
	$user->userid = 1;	//Temp setting
	
	if($_REQUEST['option'] == 'create'){
		$option = 'create';
	} elseif($_REQUEST['option'] == 'update'){
		$option = 'update';
	} elseif($_REQUEST['option'] == 'delete'){
		$option = 'delete';
	}
?>