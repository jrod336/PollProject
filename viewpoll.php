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
    		<h3>Poll Results</h3>
            <p><b><?= $poll->question ?></b></p>
            <ul class="results">
               <? if(!empty($poll->r1)) { ?><li><?= $poll->$r1 ?> X Votes</li><? } ?>
               <? if(!empty($poll->r2)) { ?><li><?= $poll->$r2 ?> X Votes</li><? } ?>
               <? if(!empty($poll->r3)) { ?><li><?= $poll->$r3 ?> X Votes</li><? } ?>
               <? if(!empty($poll->r4)) { ?><li><?= $poll->$r4 ?> X Votes</li><? } ?>
               <? if(!empty($poll->r5)) { ?><li><?= $poll->$r5 ?> X Votes</li><? } ?>
            </ul>
		<?
			//Check whether to display the poll or not
			} else {
		?>
				<h3>Please Vote Below</h3>
				 <form action="viewpoll.php" method="post">
                 <p><b><?= $poll->question ?></b></p
				<ul>
					<? if(!empty($poll->r1)) { ?><li><input type="radio" name="vote" value="1" /> <?= $poll->$r1 ?></li><? } ?>
				    <? if(!empty($poll->r2)) { ?><li><input type="radio" name="vote" value="2" /> <?= $poll->$r2 ?></li><? } ?>
                    <? if(!empty($poll->r3)) { ?><li><input type="radio" name="vote" value="3" /> <?= $poll->$r3 ?></li><? } ?>
                    <? if(!empty($poll->r4)) { ?><li><input type="radio" name="vote" value="4" /> <?= $poll->$r4 ?></li><? } ?>
                    <? if(!empty($poll->r5)) { ?><li><input type="radio" name="vote" value="5" /> <?= $poll->$r5 ?></li><? } ?>
				</ul>
                	<input type="hidden" value="pollid" value="<?= $poll->pollid ?>" />
                </form>
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
