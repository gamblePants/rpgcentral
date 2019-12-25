<?php
include "includes/connect.php";
include "includes/session.php";
connect();

// check if logged in
if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) === true){
	
	// check if showing form or adding post
	if(!$_POST){
		// showing form, check if id in query string	
		if(!isset($_GET['post_id'])){
			header("Location: threadList.php");
			exit;
		}
		
		// create variable for form
		$username = ($_SESSION['username']);
		
		// create safe values for sql		
		$clean_id = mysqli_real_escape_string($connection, $_GET['post_id']);
		
		// create sql to verify thread and post
		$verify_sql =	"SELECT t.id, t.title, t.topic_id FROM posts
						AS p LEFT JOIN threads AS t ON p.thread_id = t.id
						WHERE p.id = '".$clean_id."'";
						
		// run query and create result set
		$dbThreads = mysqli_query($connection, $verify_sql)
			or die(mysqli_error($connection));
			
		if(mysqli_num_rows($dbThreads) < 1){
			header("Location: threadlist.php");
			exit;
		}else{
			// create temp array and assign thread id and title to variables
			while($arrThreads = mysqli_fetch_array($dbThreads)){
				$id = $arrThreads['id'];
				$title = $arrThreads['title'];
				$topic = $arrThreads['topic_id'];
			}
?>

<!DOCTYPE html>
<html>
<head>
<title>Post reply in <?php echo $title; ?></title>
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
		<h1>Post reply in <?php echo $title; ?></h1>		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<p>Back to <a href="showThread.php?thread_id=<?php echo $id; ?>&topic_id=<?php echo $topic; ?>"><?php echo $title; ?></a></p>
			<p><label size="40">Username: <?php echo $username; ?></label><br/></p>			
			<p><label for="text">Post:</label><br/></br>
			<textarea id="text" name="post" rows="8" cols="40" required></textarea></p>
			<input type="hidden" name="thread_id" value="<?php echo $id; ?>">
			<input type="hidden" name="username" value="<?php echo $username; ?>">
			<input type="hidden" name="topic_id" value="<?php echo $topic; ?>">
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
		mysqli_free_result($dbThreads);
		mysqli_close($connection);
	}else if($_POST){
		// check if all fields filled out on form
		if((!$_POST['thread_id']) || (!$_POST['post']) || (!$_POST['username'])){
			header("Location: threadList.php");
			exit;
		}
		
		// create safe values for sql
		$clean_id = mysqli_real_escape_string($connection, $_POST['thread_id']);
		$clean_post = mysqli_real_escape_string($connection, $_POST['post']);
		$clean_username = mysqli_real_escape_string($connection, $_POST['username']);
		
		// create sql to add post
		$addpost_sql =	"INSERT INTO posts (thread_id, post, timeAdded, username) VALUES
						('".$clean_id."', '".$clean_post."', now(), '".$clean_username."')";
						
		// run query
		$dbAddpost = mysqli_query($connection, $addpost_sql)
			or die(mysqli_error($connection));
			
		// close connection and redirect to thread
		mysqli_close($connection);
		header("Location: showThread.php?thread_id=$clean_id&topic_id=$_POST[topic_id]");
		exit;
	}

// if not logged in - redirect to login page with post and thread ids
}else{
	$post_id = mysqli_real_escape_string($connection, $_GET['post_id']);
	$thread_id = mysqli_real_escape_string($connection, $_GET['thread_id']);
	header("Location: login.php?post_id=$post_id&thread_id=$thread_id");
	exit;
}
?>