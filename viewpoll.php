<?
	require 'inc/main.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Voting Poll -- View Poll</title>
<script type="text/javascript" src="js/ajax.js"></script>
<link type="text/css" href="css/styles.css" />
</head>

<body>
	<?
		//If vote found, display results
		if($poll->voteFound($pollid)){
	?>
    	<div class="container">
        	<ul class="results">
            	<?
					foreach($poll->getResults($pollid) as $v){
				?>
                	<li></li>
                <?
					}
				?>
            </ul>
        </div>
    <?
		//Check whether to display the poll or not
		} else {
	?>
    	<div class="container">
        	<h3>Please Vote Below</h3>
            <p><b>What is your favorite food?</b></p>
            <ul>
            	<li>Cheeseburger</li>
            </ul>
        </div>
    <?
		}
	?>
</body>
</html>
