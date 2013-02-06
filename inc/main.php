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
		#$this->sql_error($res,$sql); 
		//$this->error = mysql_error();
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
	
	  function dropdown($name,$vars,$curr) {
		$o = "<select name=\"$name\">";
		foreach($vars as $k => $v) {
		  $o .= "<option value=\"$k\"";
		  if($curr == $k) $o .= " selected";
		  $o .= ">$v</option>";
		}
		$o .= "</select>";
		return $o;
	  }
	
	  function get_id() {
		$this->lastid = mysql_insert_id();
		return  $this->lastid;
	  }
	
	  function get_enum($table,$col) {
		$sql = "SHOW COLUMNS FROM $table LIKE '$col'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result)>0){
		$row=mysql_fetch_row($result);
		  $options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));
		}
		return $options;
	  }
	} //end db class
	
	//User Class
	class User{
		public $userid;
		public $username;
		
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
	} //end user class
	
	//Poll Class
	class Poll{
		public $pollid;
		public $question;
		public $userid;
		public $r1;
		public $r2;
		public $r3;
		public $r4;
		public $r5;
		public $totalvotes = 0;
		
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
			$this->items = $poll_items;
			return $poll_items;
		}
		
		//Returns an array of votes for a specific poll
		function getVotes($db, $pollid){
			$sql = "select * from `votes` where pollid='".$pollid."'";
			$db->query($sql);
			$polls = array();
			while($row = $db->nextRow()) {
				$votes[] = $db->row;
			}
			$this->totalvotes = sizeof($votes);
			return $votes;
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
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('1', '".$data['r1']."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r2']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('2', '".$data['r2']."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r3']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('3', '".$data['r3']."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r4']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('4', '".$data['r4']."', '".$pollid."')";
				$db->query($sql);
			}
			if(!empty($data['r5']))	{
				$sql = "insert into `poll_items` (value, label, pollid) VALUES('5', '".$data['r5']."', '".$pollid."')";
				$db->query($sql);
			}
		}
	}	//end polls class

?>