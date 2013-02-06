<?
	require 'inc/main.php';
	require 'inc/usermenu.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Voting Poll -- Menu</title>
<script type="text/javascript">
	function verifyPoll(){
		var r1=document.forms["myForm"]["r1"].value;
		var r2=document.forms["myForm"]["r2"].value;
		if (r1==null || r1=="" || r2==null || r2=="")
		  {
		  alert("You must fill out at least Results 1 and 2");
		  return false;
		  }	
	}
</script>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>

<body>
	<div id="main">
    	<?
		if(!$_SESSION['loggedin']){
			//Show Login Form
			if(!empty($login_error)) echo $login_error;
			if($option == 'register') {
				//Register a New User
				
		?>
        	<h1><img src="images/login_icon.gif" width="25" height="25" alt="Login" /> User Registration</h1>
        	<form action="index.php" method="post">
            	<b>Username:</b> <input type="text" class="textinput" name="username" maxlength="255" /><br />
                <b>Password:</b> <input type="password" class="textinput" name="password" maxlength="255" /><br />
                <input type="submit" value="Register a New User" name="s_register" />
                <p>Already have a login? <a href="index.php">Login Here.</a></p>
            </form>
        <?
			} else {
		?>
        	<h1><img src="images/login_icon.gif" width="25" height="25" alt="Login" /> Polls Login</h1>
        	<form action="index.php" method="post">
            	<b>Username:</b> <input type="text" class="textinput" name="username" maxlength="255" /><br />
                <b>Password:</b> <input type="password" class="textinput" name="password" maxlength="255" /><br />
                <input type="submit" value="Login" name="s_login" />
                <p>Don't have a login? <a href="?option=register">Register Here.</a></p>
            </form>
    	<?
			}
		} else {
			if(!$option){
		?>
        <h1><img src="images/menu.png" width="25" height="25" alt="Menu" /> Main Menu</h1>
        <div class="menucontainer">
            <ul class="mainmenu">
                <li><a href="?option=create">Create a New Poll</a></li>
                <li><a href="?option=update">Update an Existing Poll</a></li>
                <li><a href="?option=delete">Delete an Existing Poll</a></li>
                <li><a href="?option=logout">Logout</a></li>
                <li><a href="viewpoll.php">View all Polls</a></li>
            </ul>
        </div>
        <?
			} elseif($option == 'create') {
		?>
        	<h1>Create a New Poll</h1>
            <h3>Please fill out the form below. You must choose at least 2 answers per poll.</h3>
            <form name="myForm" action="index.php" method="post" onsubmit="return verifyPoll()">
            	<div class="menucontainer">
                	<div>
                    	<b class="question_label">Question:</b> <textarea name="question" class="textbox"></textarea>
                     </div>
                    <br />
                	<b>Result 1:</b> <input type="text" class="textinput" name="r1" maxlength="255" /><br />
                    <b>Result 2:</b> <input type="text" class="textinput" name="r2" maxlength="255" /><br />
                    <b>Result 3:</b> <input type="text" class="textinput" name="r3" maxlength="255" /><br />
                    <b>Result 4:</b> <input type="text" class="textinput" name="r4" maxlength="255" /><br />
                    <b>Result 5:</b> <input type="text" class="textinput" name="r5" maxlength="255" /><br />
                </div>
                <input type="hidden" name="userid" value="<?= $user->userid ?>" />
                <input type="submit" value="Create Poll" name="s_create" />
            </form>
        	<p><a href="index.php">&laquo; Back to Main Menu</a></p>
        <?
			} elseif($option == 'update') {
				if($pollid != false){
		?>
        	<h1>Update an Existing Poll #<?= $pollid ?></h1>
            <?
				if($poll->totalvotes > 0){
			?>
            <h3>You cannot update a poll with votes.</h3>
            <?
				} else {
			?>
        	<form name="myForm" action="index.php" method="post" onsubmit="return verifyPoll()">
            	<div class="menucontainer">
                	<div>
                    	<b class="question_label">Question:</b> <textarea name="question" class="textbox"><?= $mypoll->question ?></textarea>
                     </div>
                    <br />
                	<b>Result 1:</b> <input type="text" class="textinput" name="r1" maxlength="255" value="<?= $mypoll->r1 ?>" /><br />
                    <b>Result 2:</b> <input type="text" class="textinput" name="r2" maxlength="255" value="<?= $mypoll->r2 ?>" /><br />
                    <b>Result 3:</b> <input type="text" class="textinput" name="r3" maxlength="255" value="<?= $mypoll->r3 ?>" /><br />
                    <b>Result 4:</b> <input type="text" class="textinput" name="r4" maxlength="255" value="<?= $mypoll->r4 ?>" /><br />
                    <b>Result 5:</b> <input type="text" class="textinput" name="r5" maxlength="255" value="<?= $mypoll->r5 ?>" /><br />
                </div>
                <input type="submit" value="Update Poll" name="s_update" />
                <input type="hidden" name="id" value="<?= $pollid ?>" />
            </form>
            <?
				}
			?>
            <p><a href="index.php">&laquo; Back to Main Menu</a> &bull; <a href="?option=update">&laquo; Back to Poll List</a></p>
        <?
				} else {
		?>
        	<h1>Update an Existing Poll</h1>
            <h3><?= $user->username ?></b> you have <?= sizeof($mypolls) ?> poll(s)</h3>
            	<div class="menucontainer">
                	<?
						if(sizeof($mypolls) > 0){
					?>
                    	<ul>
                    <?
							foreach($mypolls as $v){
					?>
                    		<li><a href="?option=update&pollid=<?= $v['id'] ?>"><?= $v['question'] ?></a></li>
                    <?
							}
					?>
                    	</ul>
                    <?
						} else {
					?>
                    	<p><i>You have no polls to select</i></p>
                    <?
						}
					?>
                </div>
        	<p><a href="index.php">&laquo; Back to Main Menu</a></p>
        <?
				}
			} elseif($option == 'delete') {
				//Delete a Poll
				if($pollid != false){
		?>
        	<h1>Delete an Existing Poll #<?= $pollid ?></h1>
            <h3>Are you sure you want to delete this poll?</h3>
            <form action="index.php" method="post">
            	<input type="submit" value="Confirm Deletion" name="s_delete" />
            	<input type="hidden" name="id" value="<?= $pollid ?>" />
            </form>
        	<p><a href="index.php">&laquo; Back to Main Menu</a> &bull; <a href="?option=delete">&laquo; Back to Poll List</a></p>
        <?
				} else {
		?>
        	<h1>Delete an Existing Poll</h1>
            <p><b><?= $user->username ?></b> you have <?= sizeof($mypolls) ?> polls</p>
            	<div class="menucontainer">
                	<?
						if(sizeof($mypolls) > 0){
					?>
                    	<ul>
                    <?
							foreach($mypolls as $v){
					?>
                    		<li><a href="?option=delete&pollid=<?= $v['id'] ?>"><?= $v['question'] ?></a></li>
                    <?
							}
					?>
                    	</ul>
                    <?
						} else {
					?>
                    	<p><i>You have no polls to select</i></p>
                    <?
						}
					?>
                </div>
        	<p><a href="index.php">&laquo; Back to Main Menu</a></p>
        <?
				}
			}
		}
		?>
    </div>
</body>
</html>
