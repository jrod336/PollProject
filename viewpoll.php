<?
	require 'inc/main.php';
	require 'inc/polls.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Voting Poll -- View Poll</title>
<script type="text/javascript" src="js/ajax.js"></script>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>

<body>
	<div id="main">
	<?
		if($option == 'viewpoll'){
			//If vote found, display results
			if($voteFound){
	?>
            <ul class="results">
                <li>Cheeseburger Votes</li>
                <li>Milkshake Votes</li>
            </ul>
		<?
			//Check whether to display the poll or not
			} else {
		?>
				<h3>Please Vote Below</h3>
				<p><b>What is your favorite food?</b></p>
				<ul>
					<li>Cheeseburger</li>
                    <li>Milkshake</li>
				</ul>
	<?
			}
		} else {
			//Display list of all available polls
	?>
    		<h1><img src="images/icon-poll.jpg" width="30" height="30" alt="Polls" /> View Polls</h1>
    		<h3>Plese select a poll below</h3>
            <div class="menucontainer">
                <ul>
                	<?
						if(sizeof($mypolls) > 0){
							foreach($mypolls as $row){
					?>
                    <li><a href="?pollid=<?= $row['id'] ?>"><?= $row['question'] ?></a></li>
                    <?
							}
						}
					?>
                </ul>
            </div>
    <?
		}
	?>
    </div>
</body>
</html>
