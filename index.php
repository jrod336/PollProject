<?
	require 'inc/main.php';
	require 'inc/usermenu.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Voting Poll -- Menu</title>
<script type="text/javascript" src="js/ajax.js"></script>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>

<body>
	<div id="main">
    	<?
			if(!$option){
		?>
        <h1><img src="images/menu.png" width="25" height="25" alt="Menu" /> Main Menu</h1>
        <div class="menucontainer">
            <ul class="mainmenu">
                <li><a href="?option=create">Create a New Poll</a></li>
                <li><a href="?option=update">Update an Existing Poll</a></li>
                <li><a href="?option=delete">Delete an Existing Poll</a></li>
                <li><a href="viewpoll.php">View all Polls</a></li>
            </ul>
        </div>
        <?
			} elseif($option == 'create') {
		?>
        	<h1>Create a New Poll</h1>
            <h3>Please fill out the form below. You must choose at least 2 answers per poll.</h3>
            <form action="index.php" method="post">
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
        	<form action="index.php" method="post">
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
				if($pollid != false){
		?>
        	<h1>Delete an Existing Poll #<?= $pollid ?></h1>
            <h3>Are you sure you want to delete this poll?</h3>
            <form action="index.php">
            	<input type="submit" value="Confirm Deletion" name="s_delete" /> <input type="submit" value="Cancel Deletion" name="s_delete_cancel" />
            	<input type="hidden" name="id" value="<?= $pollid ?>" />
            </form>
        	<p><a href="index.php">&laquo; Back to Main Menu</a> &bull; <a href="?option=delete">&laquo; Back to Poll List</a></p>
        <?
				} else {
		?>
        	<h1>Delete an Existing Poll</h1>
            <p><b><?= $user->username ?></b> you have <?= sizeof($mypolls) ?> polls</p>
            	<div class="menucontainer">
                
                </div>
        	<p><a href="index.php">&laquo; Back to Main Menu</a></p>
        <?
				}
			}
		?>
    </div>
</body>
</html>
