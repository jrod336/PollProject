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
	
	$db = new mydb();

?>