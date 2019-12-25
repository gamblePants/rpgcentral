<?php
include "includes/session.php";

// redirect back if id not in query string
if(!isset($_GET['thread_id'])){
	header("Location: threadList.php");
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Show Thread</title>
<link rel="stylesheet" href="forum.css">
<script src="resources/ajaxposts.js"></script>
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
		<h1>Show Thread</h1>		
		<p id="display"></p>
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

<script>	
	getPosts(<?php echo $_GET['thread_id']; ?>, 0);
</script>
</body>
</html>

