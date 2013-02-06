<?

mysql_connect('p41mysql93.secureserver.net','testjandc','t3stDB!47');
mysql_select_db('testjandc');

//This function will insert into the current database to include this comment
function insertVote($value, $pollid) {
	//Insert new comment
	$dt = date("Y-m-d H:i:s");
	$sql = "SELECT * FROM `votes` WHERE ip='".$_SERVER["REMOTE_ADDR"]."' AND poll='".$pollid."'";
	$res = mysql_query($sql) or die("Vote Error #1: ".mysql_error());
	if(mysql_num_rows($res) == 0){ 
		//Add the vote
		$sql = "INSERT INTO `votes` (pollid, value, dt, ip) VALUES('$pollid', '$value', '$dt', '".$_SERVER["REMOTE_ADDR"]."')";
		$res = mysql_query($sql) or die("Vote Error #2: ".mysql_error());
		return "Your vote was succesfully added!";
	} else {
		//Duplicate Entry for IP
		return "Your vote already exists for this poll, please try again.";
	}
}

$value = mysql_real_escape_string($_REQUEST['value']);
$pollid = mysql_real_escape_string($_REQUEST['pollid']);

$status = insertVote($value, $pollid);

if(!empty($status)) {
  echo "<p><font color=red>".$status."</font></p>";
} else {
	echo "<p><font color=red>ERROR: There was a problem with submitting your vote. Please contact the administrator if this problem persists.</font></p>";;
}
?>