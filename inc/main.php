<?
	//Main PHP 
	session_start();
	
	//Class for database access
	class mydb {
	
	  var $res;
	  var $link;
	  var $db;
	  var $user;
	  var $pass;
	  var $host;
	  var $mailto;
	  var $numrows;
	  var $affrows;
	  var $row;
	
	  function mydb($host = "p41mysql93.secureserver.net",$user = 'testjandc',$pass = 't3stDB!47',$db = 'testjandc',$link = "") {
		
		$this->mailto = "errors";
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db = $db;
		$this->error = "";
	
		if($link == "") {
	
		  $this->link = mysql_connect($host,$user,$pass) or die(mysql_error());
		  $res = mysql_select_db($db,$this->link);
		  #$this->sql_error($this->link,"Database Login");
		  #$this->sql_error($res,"Database Connection");
		}
		else {
		  $this->link = $link;
		}
	  }
	
	  function sql_error($res,$sql) {
		global $HTTP_HOST, $REQUEST_URI, $HTTP_REFERER;
		if(!$res) {
		  #$body = "SQL ERROR at ".date("Y-m-d H:i:s")."\n\nServer: $HTTP_HOST\nPage: $REQUEST_URI\n\nSQL: $sql\n\nError: " . mysql_error() . "\n\nReferer: $HTTP_REFERER";
		  #mail($this->mailto, "SQL ERROR on $HTTP_HOST",$body,"From: errors\n");
		}
	  }
	
	  function query($sql) {
		$res = mysql_query($sql, $this->link);
		@$this->numrows = mysql_num_rows($res);
		@$this->affrows = mysql_affected_rows($res);
		$this->error = mysql_error();
		$this->res = $res;
		return $res;
	  }

	  function nextRow() {
		@$this->row = mysql_fetch_array($this->res);
		$status = is_array($this->row);
		return $status;
	  }
	
	  function oneResult() {
		$result = mysql_result($this->res,0,0);
		return $result;
	  }

	} //end db class
	
	//User Class
	class User{
		public $userid;
		public $username;
		public $authenticated = false;
		
		//check for username duplicate
		function checkUsername($db, $data){
			$sql = "select * from `users` where username='".$data['username']."'";
			$db->query($sql);
			$user = array();
			if($db->numrows == 0){
				return true;
			} else {
				return false;
			}
		}
				
		//Gets a User
		function getUser($db, $userid){
			$sql = "select * from `users` where id='".$userid."'";
			$db->query($sql);
			$user = array();
			while($row = $db->nextRow()) {
				$user = $db->row;
			}
			
			//Set object variables
			$this->userid = $user['id'];
			$this->username = $user['username'];
			$this->authenticated = true;
			
			return $user;
		}
		
		//Register a new User
		function registerUser($db, $data){
			$dt = date("Y-m-d H:i:s");
			$sql = "insert into `users` (username, password, datecreated) VALUES('".$data['username']."', '".$data['password']."', '".$dt."')";
			$db->query($sql);
			
			//Set object variables
			$this->username = $user['username'];
			$this->authenticated = true;
		}
		
		//Returns an array of polls for this user
		function getPolls($db){
			$sql = "select * from `polls` where userid='".$this->userid."'";
			$db->query($sql);
			$polls = array();
			while($row = $db->nextRow()) {
				$polls[] = $db->row;
			}
			return $polls;
		}
		
		//Authenticates a new user
		function authenticate($db, $data){
			$sql = "select * from `users` where username='".$data['username']."' and password='".$data['password']."'";
			$db->query($sql);
			$user = array();
			if($db->numrows > 0){
				while($row = $db->nextRow()) {
					$user = $db->row;
				}
				
				$this->userid = $user['id'];
				$this->username = $user['username'];
				return true;
			} else {
				return false;
			}
		}
	} //end user class
	
	//Poll Class
	class Poll{
		public $pollid;
		public $question;
		public $userid;
		public $r1 = '';
		public $r2 = '';
		public $r3 = '';
		public $r4 = '';
		public $r5 = '';
		public $r1votes = 0;
		public $r2votes = 0;
		public $r3votes = 0;
		public $r4votes = 0;
		public $r5votes = 0;
		public $r1percent = 0;
		public $r2percent = 0;
		public $r3percent = 0;
		public $r4percent = 0;
		public $r5percent = 0;
		public $totalvotes = 0;
		public $voteFound = false;
		
		//Returns an array of polls for this user
		function getPoll($db, $pollid){
			$sql = "select * from `polls` where id='".$pollid."'";
			$db->query($sql);
			$poll = array();
			while($row = $db->nextRow()) {
				$poll = $db->row;
			}
			
			//Set object variables
			$this->pollid = $poll['id'];
			$this->question = stripslashes($poll['question']);
			$this->userid = $poll['userid'];
			
			return $poll;
		}
		
		//Returns an array of the items for this poll
		function getItems($db, $pollid){
			$sql = "select * from `poll_items` where pollid='".$pollid."'";
			$db->query($sql);
			$poll_items = array();
			while($row = $db->nextRow()) {
				$data = $db->row;
				//Set object variables
				if($data['value'] == 1) $this->r1 = stripslashes($data['label']); 
				if($data['value'] == 2) $this->r2 = stripslashes($data['label']); 
				if($data['value'] == 3) $this->r3 = stripslashes($data['label']); 
				if($data['value'] == 4) $this->r4 = stripslashes($data['label']); 
				if($data['value'] == 5) $this->r5 = stripslashes($data['label']); 
				$poll_items[] = $data;
			}
			return $poll_items;
		}
		
		//Returns an array of votes for a specific poll
		function getVotes($db, $pollid){
			$sql = "select * from `votes` where pollid='".$pollid."'";
			$db->query($sql);
			$polls = array();
			while($row = $db->nextRow()) {
				$data = $db->row;
				if($data['ip'] == $_SERVER["REMOTE_ADDR"]) $this->voteFound = true;
				if($data['value'] == 1) $this->r1votes++; 
				if($data['value'] == 2) $this->r2votes++; 
				if($data['value'] == 3) $this->r3votes++;  
				if($data['value'] == 4) $this->r4votes++;  
				if($data['value'] == 5) $this->r5votes++; 
				$votes[] = $data;
			}
			$this->totalvotes = sizeof($votes);
			
			//Tally Percentages
			if($this->totalvotes > 0){
				$this->r1percent = number_format((($this->r1votes / $this->totalvotes) * 100), 1);
				$this->r2percent = number_format((($this->r2votes / $this->totalvotes) * 100), 1);
				$this->r3percent = number_format((($this->r3votes / $this->totalvotes) * 100), 1);  
				$this->r4percent = number_format((($this->r4votes / $this->totalvotes) * 100), 1); 
				$this->r5percent = number_format((($this->r5votes / $this->totalvotes) * 100), 1); 
			}
			return $votes;
		}
		
		//Add a vote to this poll
		function addVote($db, $pollid, $value){
			$dt = date("Y-m-d H:i:s");
			$sql = "insert into `votes` (pollid, value, dt, ip) values('".$pollid."', '".$value."', '".$dt."', '".$_SERVER["REMOTE_ADDR"]."')";
			$db->query($sql);	
			$this->totalvotes++;	
			if($value == 1) $this->r1votes++; 
			if($value == 2) $this->r2votes++; 
			if($value == 3) $this->r3votes++;  
			if($value == 4) $this->r4votes++;  
			if($value == 5) $this->r5votes++; 
			$this->r1percent = number_format((($this->r1votes / $this->totalvotes) * 100), 1);
			$this->r2percent = number_format((($this->r2votes / $this->totalvotes) * 100), 1);
			$this->r3percent = number_format((($this->r3votes / $this->totalvotes) * 100), 1);  
			$this->r4percent = number_format((($this->r4votes / $this->totalvotes) * 100), 1); 
			$this->r5percent = number_format((($this->r5votes / $this->totalvotes) * 100), 1); 
			$this->voteFound = true;
		}
		
	}	//end poll class
	
	//Polls Class
	class Polls{
		public $count;
		
		//Returns an array of polls for this user
		function getPolls($db){
			$sql = "select * from `polls`";
			$db->query($sql);
			$polls = array();
			while($row = $db->nextRow()) {
				$polls[] = $db->row;
			}
			$this->count = sizeof($polls);
			return $polls;
		}
		
		//Adds a Poll
		function addPoll($db, $data){
			$dt = date("Y-m-d H:i:s");
			
			//Insert Poll
			$sql = "insert into `polls` (userid, question, dt) VALUES('".$data['userid']."', '".addslashes($data['question'])."', '".$dt."')";
			$db->query($sql);
			
			//Get ID of new poll
			$sql = "select id from `polls` where userid='".$data['userid']."' and question='".addslashes($data['question'])."' and dt='".$dt."'";
			$db->query($sql);
			$pollid = $db->oneResult();
			
			//Insert Items
			if(!empty($data['r1']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('1', '".addslashes($data['r1'])."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r2']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('2', '".addslashes($data['r2'])."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r3']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('3', '".addslashes($data['r3'])."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r4']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('4', '".addslashes($data['r4'])."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r5']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('5', '".addslashes($data['r5'])."', '".$pollid."')";
				$db->query($sql);
			}
		}
		
		//Updates a Poll
		function updatePoll($db, $data){	
	
			//Update Poll
			$pollid = $data['id'];
			$sql = "update `polls` set question='".addslashes($data['question'])."' where id='".$pollid."'";
			$db->query($sql);
			
			//Get Poll Info	
			$mypoll = new Poll();
			$mypoll->getPoll($db, $pollid);	
			$mypoll->getItems($db, $pollid);
			
			//Insert/Update Items
			if(!empty($data['r1']))	{
				if(empty($mypoll->r1)){
					$sql = "insert into `poll_items` (value, label, pollid) VALUES('1', '".addslashes($data['r1'])."', '".$pollid."')";
				} else {
					$sql = "update `poll_items` set label='".addslashes($data['r1'])."' where pollid='".$pollid."' and value='1'";
				}
				$db->query($sql);
			}
			if(!empty($data['r2']))	{
				if(empty($mypoll->r2)){
					$sql = "insert into `poll_items` (value, label, pollid) VALUES('2', '".addslashes($data['r2'])."', '".$pollid."')";
				} else {
					$sql = "update `poll_items` set label='".addslashes($data['r2'])."' where pollid='".$pollid."' and value='2'";
				}
				$db->query($sql);
			}
			if(!empty($data['r3']))	{
				if(empty($mypoll->r3)){
					$sql = "insert into `poll_items` (value, label, pollid) VALUES('3', '".addslashes($data['r3'])."', '".$pollid."')";
				} else {
					$sql = "update `poll_items` set label='".addslashes($data['r3'])."' where pollid='".$pollid."' and value='3'";
				}
				$db->query($sql);
			}
			if(!empty($data['r4']))	{
				if(empty($mypoll->r4)){
					$sql = "insert into `poll_items` (value, label, pollid) VALUES('4', '".addslashes($data['r4'])."', '".$pollid."')";
				} else {
					$sql = "update `poll_items` set label='".addslashes($data['r4'])."' where pollid='".$pollid."' and value='4'";
				}
				$db->query($sql);
			}
			if(!empty($data['r5']))	{
				if(empty($mypoll->r5)){
					$sql = "insert into `poll_items` (value, label, pollid) VALUES('5', '".addslashes($data['r5'])."', '".$pollid."')";
				} else {
					$sql = "update `poll_items` set label='".addslashes($data['r5'])."' where pollid='".$pollid."' and value='5'";
				}
				$db->query($sql);
			}
		}
		
		//Deletes a specific poll
		function deletePoll($db, $data){	
			$pollid = $data['id'];
			$sql = "delete from `polls` where id='".$pollid."'";
			$db->query($sql);
		}
	}	//end polls class

?>