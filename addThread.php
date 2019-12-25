<?php
include "includes/connect.php";
include "includes/session.php";
connect();

// if not logged in redirect
if(!isset($_SESSION['loggedin'])){
	$topic_id = mysqli_real_escape_string($connection, $_GET['topic_id']);
	header("Location: login.php?topic_id=$topic_id");	
	exit;
}

//check if showing form or adding thread
if(!$_POST){
	// showing form, check if id in query string
	if(!isset($_GET['topic_id'])){
		header("Location: threadList.php");
		exit;
	}
	
	// create safe value for sql
	$clean_topicid = mysqli_real_escape_string($connection, $_GET['topic_id']);	
	
	// create sql for getting topic
	$gettopic_sql = 	"SELECT title FROM topics
						WHERE id = '".$clean_topicid."'";
						
	// run query and create result
	$dbTopicTitle = mysqli_query($connection, $gettopic_sql)
		or die(mysqli_error($connection));
		
	if(mysqli_num_rows($dbTopicTitle) < 1){
		header("Location: threadlist.php");
		exit;
	}else{
		
	// assign variable for topic title
	while($arrTitle = mysqli_fetch_array($dbTopicTitle)){
		$topictitle = stripcslashes($arrTitle['title']);
	}	
?>	
	
<!DOCTYPE html>
<html>
<head>
<title>Add Thread for <?php echo $topictitle; ?></title>
<link rel="stylesheet" href="forum.css">
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
		<h1>Add Thread for <?php echo $topictitle; ?></h1>		
		<form method="post" action="">
			<p>Back to <a href="threadList.php?topic_id=<?php echo $clean_topicid; ?>"><?php echo $topictitle; ?></a></p>
			<p><label>Username: <?php echo $_SESSION['username']; ?></label></p>
			<p><label for="thread">Thread Title:</label><br/></br>
			<input type="text" id="thread" name="threadtitle" size="40" maxlength="35" required></p>
			<p><label for="post">First Post:</label><br/></br>
			<textarea id="post" name="firstpost" rows="8" cols="50" required></textarea></p>
			<input type="hidden" name="topic_id" value="<?php echo $clean_topicid; ?>">
			<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
			<input type="submit" value="Submit">
		</form>
		</section>	
		<nav id='secondary'>
			<?php include "includes/navSecondary.php" ?>
		</nav>				
	</main>
	<footer>
		<?php include "includes/footer.php" ?>
	</footer>		
</div>
</body>
</html>

<?php
	}
	// free result and close connection
	mysqli_free_result($dbTopicTitle);
	mysqli_close($connection); 

}else if($_POST){	
	// if required fields are missing redirect back to html page
	if((!$_POST["topic_id"]) || (!$_POST["username"]) || (!$_POST["threadtitle"]) || (!$_POST["firstpost"])){
		header("Location: index.php");
		exit;
	}

	// create safe values for updating db
	$clean_topicid = mysqli_real_escape_string($connection, $_POST['topic_id']);	
	$clean_username = mysqli_real_escape_string($connection, $_POST["username"]);
	$clean_threadtitle = mysqli_real_escape_string($connection, $_POST["threadtitle"]);
	$clean_firstpost = mysqli_real_escape_string($connection, $_POST["firstpost"]);

	// create insert sql
	$addthread_sql =	"INSERT INTO threads
						(title, timeAdded, username, topic_id)
						VALUES ('".$clean_threadtitle."', now(),
						'".$clean_username."', '".$clean_topicid."')";
					
	// run query and create result
	$dbAddthread = mysqli_query($connection, $addthread_sql)
		or die(mysqli_error($connection));
		
	// get id of the last query (looks at lines above for first db result)
	$thread_id = mysqli_insert_id($connection);

	// create 2nd insert sql
	$addpost_sql =  "INSERT INTO posts
					(thread_id, post, timeAdded, username)
					VALUES ('".$thread_id."', '".$clean_firstpost."',
					now(), '".$clean_username."')";
					
	// run query and create result
	$dbAddpost = mysqli_query($connection, $addpost_sql)
		or die(mysqli_error($connection));
		
	// free resut, close connection and redirect to threadlist
	mysqli_free_result($dbAddpost);
	mysqli_close($connection);
	header("Location: threadlist.php?topic_id=$clean_topicid");	
}
?>




				
