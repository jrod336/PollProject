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
            </ul>
        </div>
        <?
			} elseif($option == 'create') {
		?>
        	<h1>Create a New Poll</h1>
        	<p><a href="index.php">&laquo; Back to Main Menu</a></p>
        <?
			} elseif($option == 'update') {
		?>
        	<h1>Update an Existing Poll</h1>
            <p><b><?= $user->username ?></b> you have <?= sizeof($mypolls) ?> poll(s)</p>
        	<p><a href="index.php">&laquo; Back to Main Menu</a></p>
        <?
			} elseif($option == 'delete') {
		?>
        	<h1>Delete an Existing Poll</h1>
            <p><b><?= $user->username ?></b> you have <?= sizeof($mypolls) ?> polls</p>
        	<p><a href="index.php">&laquo; Back to Main Menu</a></p>
        <?
			}
		?>
    </div>
</body>
</html>
