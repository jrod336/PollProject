<?
	require 'inc/main.php';
	require 'inc/polls.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Voting Poll -- View Poll</title>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>

<body>
	<div id="main">
	<?
		if($option == 'viewpoll'){
			//If vote found, display results
			if($mypoll->voteFound){
	?>
    		<h3>Poll Results</h3>
            <p><b><?= $mypoll->question ?></b></p>
            <p><u>Total Votes:</u> <?= $mypoll->totalvotes ?></p>
            <div class="menucontainer">
                <ul class="results">
                   <? if(!empty($mypoll->r1)) { ?><li><?= $mypoll->r1 ?> <?= $mypoll->r1votes ?> Vote(s)</li><? } ?>
                   <? if(!empty($mypoll->r2)) { ?><li><?= $mypoll->r2 ?> <?= $mypoll->r2votes ?> Vote(s)</li><? } ?>
                   <? if(!empty($mypoll->r3)) { ?><li><?= $mypoll->r3 ?> <?= $mypoll->r3votes ?> Vote(s)</li><? } ?>
                   <? if(!empty($mypoll->r4)) { ?><li><?= $mypoll->r4 ?> <?= $mypoll->r4votes ?> Vote(s)</li><? } ?>
                   <? if(!empty($mypoll->r5)) { ?><li><?= $mypoll->r5 ?> <?= $mypoll->r5votes ?> Vote(s)</li><? } ?>
                </ul>
            </div>
		<?
			//Check whether to display the poll or not
			} else {
		?>
				<h3>Please Vote Below</h3>
				 <form action="viewpoll.php" method="post">
                 <p><b><?= $mypoll->question ?></b></p>
                <div class="menucontainer">
                     <ul class="voting">
                        <? if(!empty($mypoll->r1)) { ?><li><input type="radio" name="value" value="1" /> <?= $mypoll->r1 ?></li><? } ?>
                        <? if(!empty($mypoll->r2)) { ?><li><input type="radio" name="value" value="2" /> <?= $mypoll->r2 ?></li><? } ?>
                        <? if(!empty($mypoll->r3)) { ?><li><input type="radio" name="value" value="3" /> <?= $mypoll->r3 ?></li><? } ?>
                        <? if(!empty($mypoll->r4)) { ?><li><input type="radio" name="value" value="4" /> <?= $mypoll->r4 ?></li><? } ?>
                        <? if(!empty($mypoll->r5)) { ?><li><input type="radio" name="value" value="5" /> <?= $mypoll->r5 ?></li><? } ?>
                    </ul>
                 </div>
                	<input type="hidden" value="pollid" value="<?= $mypoll->pollid ?>" />
                    <input type="submit" value="Vote!" name="s_vote" />
                </form>
	<?
			}
	?>
    		<p><a href="viewpoll.php">&laquo; Back to View Polls</a></p>
    <?
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
