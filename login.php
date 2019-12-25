<?php

// php script adapted from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php

include "includes/connect.php"; // which is better - include or require_once?
connect();

// define variables and initialise with empty values
$username = $password = "";
$username_err = $password_err = "";
$post_id = $thread_id = $topic_id = "";

// get post, thread or topic ids if redirected from those pages
if(isset($_GET['post_id'])){
	$post_id = $_GET['post_id'];
	$thread_id = $_GET['thread_id'];
}
if(isset($_GET['topic_id'])){
	$topic_id = $_GET['topic_id'];
}

if($_POST){
	// validate username and password
	if(empty(trim($_POST['username']))){
		$username_err = "Please enter username";
	}else{
		$username = trim($_POST['username']);
	}
	if(empty(trim($_POST['password']))){
		$password_err = "Please enter password";
	}else{
		$password = trim($_POST['password']);
	}
	
	// check database
	if(empty($username_err) && empty($password_err)){
		// prepare statement
		$sql = "SELECT id, username, password FROM users WHERE username = ?";
		
		if($stmt = mysqli_prepare($connection, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			// set parameter
			$param_username = $username;
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				// store result
				mysqli_stmt_store_result($stmt);
				// if username exists veryify password
				if(mysqli_stmt_num_rows($stmt) == 1){
					// bind result variables
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
					if(mysqli_stmt_fetch($stmt)){
						if(password_verify($password, $hashed_password)){
							
							// password correct 
							session_start();
							$_SESSION['loggedin'] = true;
							$_SESSION['id'] = $id;
							$_SESSION['username'] = $username;
							
							// redirect to thread if posting
							if(($_POST['post_id']) != ""){	
								header("Location: showThread.php?thread_id=".$_POST['thread_id']); 											
							}							
							// redirect to topic if adding new thread
							else if (($_POST['topic_id']) != ""){
								header("Location: threadList.php?topic_id=".$_POST['topic_id']);
							}
							// otherwise redirect user to welcome page
							else{
								header("Location: index.php");
							}
							
						}else{
							$password_err = "Incorrect password";
						}
					}
				}else{
					$username_err = "Username not found";
				}
			}else{
				echo "There was a problem with the database. Please try again later.";
			}
		}
		// close statement
		mysqli_stmt_close($stmt);
	}
	// close connection
	mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Login</title>
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
		<h1>Login</h1>		
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row">
				<div class="col-20">
					<label>Username</label>
				</div>
				<div class="col-40">
					<input type="text" name="username" value="<?php echo $username; ?>">
				</div>				
				<div class="col-40">					
					<span class="error"><?php echo $username_err; ?></span>					
				</div>				
			</div>               
            <div class="row">
				<div class="col-20">
					<label>Password</label>
				</div>
				<div class="col-40">
					<input type="password" name="password">
				</div>				
				<div class="col-40">
					<span class="error"><?php echo $password_err; ?></span>
				</div>			
			</div>            
            <div class="row">
				<div>
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
					<input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>">
					<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
					<input type="submit" value="Submit">
				</div>
            </div>		            		
        </form>
		<p>Don't have an account? <a href="register.php?post_id=<?php echo $post_id; ?>&thread_id=<?php echo $thread_id; ?>&topic_id=<?php echo $topic_id; ?>">Sign up now</a></p>
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
