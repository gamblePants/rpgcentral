<?php
include "includes/connect.php";
include "includes/session.php";
connect();

// redirect back if id not in query string
if(!isset($_GET['topic_id'])){
	header("Location: index.php");
	exit;
}

// create safe value for displaying topic info 
$clean_id = mysqli_real_escape_string($connection, $_GET['topic_id']);
// create sql for getting topic - change to prepared statement?			
$gettopic_sql = 	"SELECT * FROM topics
					WHERE id = '".$clean_id."'";						
// run query and create result set for topic	
$dbTopic = mysqli_query($connection, $gettopic_sql)
	or die(mysqli_error($connection));		
// redirect back if no topic pulled from db 
if(mysqli_num_rows($dbTopic) < 1){
	header("Location: index.php");
	exit;
}	
// assign variables for topic
while($arrTopic = mysqli_fetch_array($dbTopic)){	
	$topic_title = $arrTopic['title'];
	$topic_description = $arrTopic['description'];
}
// free result and close connection
mysqli_free_result($dbTopic);
mysqli_close($connection);

?>

<!DOCTYPE html>
<html>
<head>
<title>Threads in <?php echo $topic_title; ?></title>
<link rel="stylesheet" href="forum.css">
<script src="resources/ajaxthreads.js"></script>
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
		<h1>Threads in <?php echo $topic_title; ?></h1>		
		<p><?php echo $topic_description; ?></p>
		<p><a href="addThread.php?topic_id=<?php echo $clean_id; ?>">Add new thread</a></p>
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
	getThreads(<?php echo $clean_id; ?>, 0);
</script>
</body>
</html>