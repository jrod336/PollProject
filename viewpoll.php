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
<script type="text/javascript">
	
	//Adjusts the size of the bar1 based off the percentage of votes
	function adjustBarSize1(fwidth){
	   var bar = document.getElementById('r1bar');
	   var w = bar.clientWidth;
	   var finalw = fwidth*2;
	   if (w < finalw) {
			bar.style.width = w + 5 + "px";
	   } else {
			clearInterval(myBar1);
	   }
	}
	
	//Adjusts the size of the bar2 based off the percentage of votes
	function adjustBarSize2(fwidth){
	   var bar = document.getElementById('r2bar');
	   var w = bar.clientWidth;
	   var finalw = fwidth*2;
	   if (w < finalw) {
			bar.style.width = w + 5 + "px";
	   } else {
			clearInterval(myBar2);
	   }
	}
	
	//Adjusts the size of the bar3 based off the percentage of votes
	function adjustBarSize3(fwidth){
	   var bar = document.getElementById('r3bar');
	   var w = bar.clientWidth;
	   var finalw = fwidth*2;
	   if (w < finalw) {
			bar.style.width = w + 5 + "px";
	   } else {
			clearInterval(myBar3);
	   }
	}
	
	//Adjusts the size of the bar4 based off the percentage of votes
	function adjustBarSize4(fwidth){
	   var bar = document.getElementById('r4bar');
	   var w = bar.clientWidth;
	   var finalw = fwidth*2;
	   if (w < finalw) {
			bar.style.width = w + 5 + "px";
	   } else {
			clearInterval(myBar4);
	   }
	}
	
	//Adjusts the size of the bar5 based off the percentage of votes
	function adjustBarSize5(fwidth){
	   var bar = document.getElementById('r5bar');
	   var w = bar.clientWidth;
	   var finalw = fwidth*2;
	   if (w < finalw) {
			bar.style.width = w + 5 + "px";
	   } else {
			clearInterval(myBar5);
	   }
	}
	
	<? if($option == 'viewpoll' && $mypoll->voteFound){ ?>
		var myBar1;
		var myBar2;
		var myBar3;
		var myBar4;
		var myBar5;
		window.onload = function() {
			<? if(!empty($mypoll->r1)) { ?>myBar1 = setInterval(function(){ adjustBarSize1(<?= $mypoll->r1percent ?>) },50);<? } ?>
			<? if(!empty($mypoll->r2)) { ?>myBar2 = setInterval(function(){ adjustBarSize2(<?= $mypoll->r2percent ?>) },50);<? } ?>
			<? if(!empty($mypoll->r3)) { ?>myBar3 = setInterval(function(){ adjustBarSize3(<?= $mypoll->r3percent ?>) },50);<? } ?>
			<? if(!empty($mypoll->r4)) { ?>myBar4 = setInterval(function(){ adjustBarSize4(<?= $mypoll->r4percent ?>) },50);<? } ?>
			<? if(!empty($mypoll->r5)) { ?>myBar5 = setInterval(function(){ adjustBarSize5(<?= $mypoll->r5percent ?>) },50);<? } ?>
		}
	<? } ?>
</script>
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
                   <? if(!empty($mypoll->r1)) { ?>
                   		<li><?= $mypoll->r1 ?>  <div class="percentage"><?= $mypoll->r1votes ?> Vote(s)</div>
                        	<ul class="innerResults">
								<li><?= $mypoll->r1percent ?>%</li>
                                <li><div id="r1bar"></div></li>
                            </ul>
                        </li>
				   <? } 
                    if(!empty($mypoll->r2)) { ?>
                   		<li><?= $mypoll->r2 ?> <div class="percentage"><?= $mypoll->r2votes ?> Vote(s)</div>
                        	<ul class="innerResults">
								<li><?= $mypoll->r2percent ?>%</li>
                                <li><div id="r2bar"></div></li>
                            </ul>
                        </li>
				   <? }
                    if(!empty($mypoll->r3)) { ?>
                   		<li><?= $mypoll->r3 ?> <div class="percentage"><?= $mypoll->r3votes ?> Vote(s)</div>
                        	<ul class="innerResults">
								<li><?= $mypoll->r3percent ?>%</li>
                                <li><div id="r3bar"></div></li>
                            </ul>
                        </li>
					<? }
                   if(!empty($mypoll->r4)) { ?>
                   		<li><?= $mypoll->r4 ?> <div class="percentage"><?= $mypoll->r4votes ?> Vote(s)</div>
                        	<ul class="innerResults">
								<li><?= $mypoll->r4percent ?>%</li>
                                <li><div id="r4bar"></div></li>
                            </ul>
                        </li>
					<? } ?>
                   <? if(!empty($mypoll->r5)) { ?>
                   		<li><?= $mypoll->r5 ?> <div class="percentage"><?= $mypoll->r5votes ?> Vote(s)</div>
                        	<ul class="innerResults">
								<li><?= $mypoll->r5percent ?>%</li>
                                <li><div id="r5bar"></div></li>
                            </ul>
                        </li>
					<? } ?>
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
                	<input type="hidden" name="pollid" value="<?= $mypoll->pollid ?>" />
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
    		<h3>Plese select a poll below or <a href="index.php">create your own</a></h3>
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
