<?php
// require ReCaptcha class
// require('src/autoload.php');

// script grabbed from https://code-boxx.com/php-contact-form-recaptcha/
// still not working properly

if($_POST){	
	// define recaptcha variables
	$secret = '6LcyLMMUAAAAAK9OeLvnbGGGbaL-FouUJo9DUdkc'; // generated from https://www.google.com/recaptcha/admin
	$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=".$_POST['g-recaptcha-response'];
	$verify = json_decode(file_get_contents($url));

	// process form
	if ($verify->success) {
	  $to = "koan.stevenson@gmail.com"; 
	  $subject = "RPGCentral Contact Form";
	  $message = "Name - " . $_POST['name'] . "<br>";
	  $message .= "Email - " . $_POST['email'] . "<br>";
	  $message .= "Message - " . $_POST['message'] . "<br>";
	  if (@mail($to, $subject, $message)) {
		// Send mail OK
		// @TODO - Show a nice thank you page or something
		echo "<p>message success</p>";
	  } else {
		// Send mail error
		// @TODO - Ask user to retry or give alternative
		echo "<p>message fail</p>";
	  }
	} else {
	  // Invalid captcha
	  // @TODO - Show error message, ask user to retry
	  echo "<p>invalid captcha</p>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Contact</title>
<link rel="stylesheet" href="forum.css">
<script src='https://www.google.com/recaptcha/api.js'></script>
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
		<h1>Contact Us</h1>	
			<form action="contact.php" method="post" id="contact">		
			<label>Your Name</label><br><br>
			<input type="text" name="name" required autofocus/><br>
			<label>Email Address</label><br><br>
			<input type="email" name="email" required/><br>
			<label>Message</label><br><br>
			<textarea name="message" required></textarea><br>
			
			<!-- [PUT THE CAPTCHA WHERE YOU WANT IT] -->			
			<div class="g-recaptcha" data-sitekey="6LcyLMMUAAAAAGXIh30-FjCj7DshyWHOtN_R2rta"></div><br>
			<input type="submit" value="Submit"/>
			</form>
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