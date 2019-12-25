<?php
// php script adapted from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php

include "includes/connect.php";
connect();

// define variables and initialise with empty values
$username = $email = $password = $confirm = "";
$username_err = $email_err = $password_err = $confirm_err = "";
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
	// validate username
	if(empty(trim($_POST['username']))){
		$username_err = "Please enter a username";
	}else{		
		// prepare select statement
		$sql = "SELECT id FROM users WHERE username = ?";
		
		if($stmt = mysqli_prepare($connection, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			// set parameter
			$param_username = trim($_POST['username']);			
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				// store result
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1){
					$username_err = "This username is already taken";
				}else{
					$username = trim($_POST['username']);
				}
			}else{
				echo "There was a problem with the database. Please try again later.";
			}
		}		
		// close statement
		mysqli_stmt_close($stmt);
	}
	
	// validate email
	if(empty(trim($_POST['email']))){
		$email_err = "Please enter an email address";
	}elseif(!filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL)){
		$email_err = "Please enter a valid email format";
	}else{
		// prepare select statement
		$sql = "SELECT id FROM users WHERE email = ?";
		
		if($stmt = mysqli_prepare($connection, $sql)){
			// bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "s", $param_email);
			// set parameter
			$param_email = trim($_POST['email']);			
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				// store result
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1){
					$email_err = "This email is already taken";
				}else{
					$email = trim($_POST['email']);
				}
			}else{
				echo "There was a problem with the database. Please try again later.";
			}
		}		
		// close statement
		mysqli_stmt_close($stmt);
	}
		
	// validate password		
	if(empty(trim($_POST['password']))){
		$password_err = "Please enter a password";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password needs at least 6 characters";
    } else{
        $password = trim($_POST['password']);
    }

	// validate confirm
	if(empty(trim($_POST['confirm']))){
		$confirm_err = "Please confirm password";
	}else{
		$confirm = trim($_POST['confirm']);
		if(empty($password_err) && ($password != $confirm)){
			$confirm_err = "Password did not match";
		}
	}
	
	// check if error free before inserting in to database
	if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_err)){
		// prepare insert statement
		$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
		
		if($stmt = mysqli_prepare($connection, $sql)){
			// bind variables to statment
			mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
			// set parameters
			$param_username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT); // create password hash
			$param_email = $email;
			// attempt to execute
			if(mysqli_stmt_execute($stmt)){
				// redirect to login page
				header("location: login.php?post_id=$post_id&thread_id=$thread_id&topic_id=$topic_id");
			}else{
				echo "There was a problem with the database. Please try again later.";
			}
		}
		// close statment
		mysqli_stmt_close($stmt);
	}
	// close connection
	mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Registration</title>
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
		<h1>Sign Up</h1>					
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="row">
				<div class="col-20">
					<label>Username</label>
				</div>
				<div class="col-40">
					<input type="text" name="username" maxlength="20" value="<?php echo $username; ?>">
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
					<input type="password" name="password" maxlength="30" value="<?php echo $password; ?>">
				</div>
				<div class="col-40">
					<span class="error"><?php echo $password_err; ?></span>
				</div>               
            </div>
            <div class="row">
				<div class="col-20">
					<label>Confirm</label>
				</div>
				<div class="col-40">
					<input type="password" name="confirm" value="<?php echo $confirm; ?>">
                </div>
				<div class="col-40">
					<span class="error"><?php echo $confirm_err; ?></span>
				</div>                
            </div>
			<div class="row">
				<div class="col-20">
					<label>Email</label>
				</div>
				<div class="col-40">
					<input type="text" name="email" maxlength="60" value="<?php echo $email; ?>">
				</div>
				<div class="col-40">
					<span class="error"><?php echo $email_err; ?></span>
				</div>                
            </div>
            <div class="row">
				<div>
					<input type="submit" value="Submit">   
				</div>
            </div>
		</form>
        <p>Already have an account? <a href="login.php?post_id=<?php echo $post_id; ?>&thread_id=<?php echo $thread_id; ?>&topic_id=<?php echo $topic_id; ?>">Login here</a></p>        
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
