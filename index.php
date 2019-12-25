<?php
include "includes/session.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Home</title>
<link rel="stylesheet" href="forum.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<div id="wrapper">	
	<header>
		<?php include "includes/header.php" ?>
	</header>
	<nav id="primary">
		<?php include "includes/navPrimary.php" ?>
	</nav>
	<div id="mobile">
		<?php include "includes/navMobile.php" ?>
	</div>		
	<main>			
		<section>
		<h1>Home</h1>		
		<p>Welcome to RPGCentral. We are a warehouse collective in Marrickville; dedicated to providing a space for role-playing games in Sydney, and a forum for gamers.</p>		
		<p>RPGCentral hosts regular game nights and one-off game events. Please check our <a href="events.html">events</a> page for the schedule.</p>
		<p>If you would like to join one of the games, please <a href="contact.php">contact</a> us prior to arriving, preferrably one week in advance. This gives 
		our game masters time to prepare their story for an extra character. Or if you just want come in for a chat or check-out the place feel free to come by any time.</p>		
		<p>We also have a small range of 2nd hand role-playing games and accessories available for sale online and on premesis. Check out the <a href="shop.html">shop</a> to view available products.</p>
		<p>Before posting in any of the discussion forums, please read the <a href="rules.html">guidelines</a> beforehand.
		It doesn't take long, and cuts down work for our website administrators when discussions are posted in the correct place.</p>		
		<p>Thanks for checking out our website, and happy gaming!</p>
		</section>			
		<nav id='secondary'>
			<h1>Forum Topics</h1>
			<?php include "includes/navSecondary.php" ?>
		</nav>				
	</main>
	<footer>
		<?php include "includes/footer.php" ?>
	</footer>	
</div>  
</body>
