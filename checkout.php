<?php
include "includes/connect.php";
include "includes/session.php";
connect();

// define variables and initialise with empty values
$total = 0;
$bfirstname = $blastname = $ccnumber = $expiry = $cvv = $bstreet = $bsuburb = $bstate = $bpostcode = $bphone = $email = "";
$bfirstname_err = $blastname_err = $ccnumber_err = $expiry_err = $cvv_err = $bstreet_err = $bsuburb_err = $bstate_err = $bpostcode_err = $bphone_err = $email_err = "";
$firstname = $lastname = $street = $suburb = $state = $postcode = $phone = "";
$firstname_err = $lastname_err = $street_err = $suburb_err = $state_err = $postcode_err = $phone_err = "";

// build display for invoice
$display = <<<END_OF_TEXT
	<table>
	<tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
END_OF_TEXT;

// prepare statement to show items from cart
$cart = $connection->prepare("SELECT c.id, i.id as item_id, i.title, i.price, c.item_qty FROM
							shoppingcart AS c LEFT JOIN shop_items AS i ON
							i.id = c.item_id WHERE session_id = '".$_COOKIE['PHPSESSID']."'");
$cart->execute();
$cart->bind_result($cart_id, $item_id, $item_title, $item_price, $qty);

// loop through records and add to display
while($cart->fetch()){
	$subtotal = sprintf("%.02f", $item_price * $qty);
	$item_price = sprintf("%.02f", $item_price);
	$total += $subtotal;
	$display .= <<<END_OF_TEXT
	<tr><td>$item_title</td><td>\$$item_price</td><td>$qty</td><td>\$$subtotal</td></tr>
END_OF_TEXT;
}
$total = sprintf("%.02f", $total +=10);

// add shipping and total to table
$display .= <<<END_OF_TEXT
				<tr><td>Shipping</td><td></td><td></td><td>\$10.00</td></tr>
				<tr><td>Total</td><td></td><td></td><td>\$$total</td></tr>
				</table><br>				
END_OF_TEXT;

// after submitting credit card details
if($_POST){
	// validation
	if(empty(trim($_POST['bfirstname']))){
		$bfirstname_err = "Please enter first name";
	}
	if(empty(trim($_POST['blastname']))){
		$blastname_err = "Please enter last name";
	}
	if(empty(trim($_POST['ccnumber']))){
		$ccnumber_err = "Please enter credit card number";
	}
	elseif(!is_numeric($_POST['ccnumber'])){
		$ccnumber_err = "Please enter digits only";
	}
	if(empty(trim($_POST['expiry']))){
		$expiry_err = "Please enter expiry date (MMYY)";
	}
	elseif(!is_numeric($_POST['expiry'])){
		$expiry_err = "Please enter digits only";
	}
	if(empty(trim($_POST['cvv']))){
		$cvv_err = "Please enter CVV on back of card";
	}
	elseif(!is_numeric($_POST['cvv'])){
		$cvv_err = "Please enter digits only";
	}
	if(empty(trim($_POST['bstreet']))){
		$bstreet_err = "Please enter street and number";
	}
	if(empty(trim($_POST['bsuburb']))){
		$bsuburb_err = "Please enter suburb";
	}
	if(empty(trim($_POST['bstate']))){
		$bstate_err = "Please enter state";
	}
	if(empty(trim($_POST['bpostcode']))){
		$bpostcode_err = "Please enter postcode";
	}
	if(empty(trim($_POST['bphone']))){
		$bphone_err = "Please enter phone";
	}
	if(empty(trim($_POST['email']))){
		$email_err = "Please enter email";
	}elseif(!filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL)){
		$email_err = "Please enter a valid email format";
	}
	
	// check no errors before inserting into database
	if(empty($bfirstname_err) && empty($blastname_err) && empty($ccnumber_err) && empty($expiry_err) && empty($cvv_err) && empty($bstreet_err) 
		&& empty($bsuburb_err) && empty($bstate_err) && empty($bpostcode_err) && empty($bphone_err) && empty($email_err)){	
	
		// create password hash for creditcard
		$param_cc = password_hash($ccnumber, PASSWORD_DEFAULT);
		// prepare statement to insert order
		$order = $connection->prepare("INSERT INTO orders
										(user_id, timeAdded, bfirstname, blastname, bstreet, bsuburb,
										baus_state, bpostcode, email, bphone, total, creditcard, expiry,
										cvv, status, firstname, lastname, street, suburb, aus_state, 
										postcode, phone, invoiceno) 
										VALUES ('".$_SESSION['id']."', now(), '".$_POST['bfirstname']."', '".$_POST['blastname']."', '".$_POST['bstreet']."', '".$_POST['bsuburb']."',
										'".$_POST['bstate']."', '".$_POST['bpostcode']."', '".$_POST['email']."', '".$_POST['bphone']."', '".$total."', '".$param_cc."', '".$_POST['expiry']."',
										'".$_POST['cvv']."', 'complete', '".$_POST['firstname']."', '".$_POST['lastname']."', '".$_POST['street']."', '".$_POST['suburb']."', '".$_POST['state']."',
										'".$_POST['postcode']."', '".$_POST['phone']."', 'date_plus_num')");
		$order->execute();
		
		// grab auto id from order created
		$orderID = $order->insert_id;
		
		// insert shoppingcart items into orderitems table										
		$dump = $connection->prepare("INSERT INTO orderitems (order_id, item_id, item_qty, item_price)
									SELECT $orderID, c.item_id, c.item_qty, i.price FROM shoppingcart c
									LEFT JOIN shop_items i ON c.item_id = i.id;");
		
		$dump->execute();
				
		// empty shoppingcart
		$empty = $connection->prepare("TRUNCATE shoppingcart");
		$empty->execute();
		
		// free results
		$cart -> close();
		$order -> close();
		$dump -> close();
		$empty -> close();
		
		// close connection	
		mysqli_close($connection);
		
		// redirect to thankyou page
		header("Location: thankyou.php");
		exit;
	}										
}
?>



<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Checkout</title>
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
		<h1>Checkout</h1>
		<div class="spacebetween"><p class="medium">For demonstration purposes only</p><p><a href="showcart.php">Back to cart</a></p></div>
		<p class="medium">
		<p><?php echo $display; ?></p>		
		<div class="row"><div class="col-40">Credit Card Details</div></div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="row">
				<div class="col-20"><label>First Name</label></div>				
				<div class="col-40"><input type="text" name="bfirstname" maxlength="20" value="<?php echo $bfirstname; ?>"></div>			
				<div class="col-40"><span class="error"><?php echo $bfirstname_err; ?></span></div> 				              
            </div>    
            <div class="row">
				<div class="col-20"><label>Last Name</label></div>			
				<div class="col-40"><input type="text" name="blastname" maxlength="30" value="<?php echo $blastname; ?>"></div>				
				<div class="col-40"><span class="error"><?php echo $blastname_err; ?></span></div>			               
            </div>
			<div class="row">
				<div class="col-20"><label>Credit Card No</label></div>			
				<div class="col-40"><input type="text" name="ccnumber" maxlength="12" value="<?php echo $ccnumber; ?>"></div>				
				<div class="col-40"><span class="error"><?php echo $ccnumber_err; ?></span></div>			               
            </div>
			<div class="row">
				<div class="col-20"><label>Expiry (MMYY)</label></div>			
				<div class="col-40"><input type="text" name="expiry" maxlength="4" value="<?php echo $expiry; ?>"></div>				
				<div class="col-40"><span class="error"><?php echo $expiry_err; ?></span></div>			               
            </div>
			<div class="row">
				<div class="col-20"><label>CVV</label></div>			
				<div class="col-40"><input type="text" name="cvv" maxlength="3" value="<?php echo $cvv; ?>"></div>				
				<div class="col-40"><span class="error"><?php echo $cvv_err; ?></span></div>			               
            </div>
            <div class="row">
				<div class="col-20"><label>Street</label></div>			
				<div class="col-40"><input type="text" name="bstreet" maxlength="40" value="<?php echo $bstreet; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $bstreet_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>Suburb</label></div>			
				<div class="col-40"><input type="text" name="bsuburb" maxlength="40" value="<?php echo $bsuburb; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $bsuburb_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>State</label></div>			
				<div class="col-40"><input type="text" name="bstate" maxlength="30" value="<?php echo $bstate; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $bstate_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>Postcode</label></div>			
				<div class="col-40"><input type="text" name="bpostcode" maxlength="4" value="<?php echo $bpostcode; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $bpostcode_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>Phone</label></div>				
				<div class="col-40"><input type="text" name="bphone" maxlength="20" value="<?php echo $bphone; ?>"></div>			
				<div class="col-40"><span class="error"><?php echo $bphone_err; ?></span></div>                			
            </div>
			<div class="row">
				<div class="col-20"><label>Email</label></div>				
				<div class="col-40"><input type="email" name="email" maxlength="60" value="<?php echo $email; ?>"></div>			
				<div class="col-40"><span class="error"><?php echo $email_err; ?></span></div>                			
            </div>
			<br>
			<div class="row"><div class="col-40">Shipping Address</div></div>
			<div class="row">
				<div class="col-20"><label>First Name</label></div>				
				<div class="col-40"><input type="text" name="firstname" maxlength="20" value="<?php echo $firstname; ?>"></div>			
				<div class="col-40"><span class="error"><?php echo $firstname_err; ?></span></div> 				              
            </div>    
            <div class="row">
				<div class="col-20"><label>Last Name</label></div>			
				<div class="col-40"><input type="text" name="lastname" maxlength="30" value="<?php echo $lastname; ?>"></div>				
				<div class="col-40"><span class="error"><?php echo $lastname_err; ?></span></div>			               
            </div>			
            <div class="row">
				<div class="col-20"><label>Street</label></div>			
				<div class="col-40"><input type="text" name="street" maxlength="30" value="<?php echo $street; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $street_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>Suburb</label></div>			
				<div class="col-40"><input type="text" name="suburb" maxlength="30" value="<?php echo $suburb; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $suburb_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>State</label></div>			
				<div class="col-40"><input type="text" name="state" maxlength="30" value="<?php echo $state; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $state_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>Postcode</label></div>			
				<div class="col-40"><input type="text" name="postcode" maxlength="4" value="<?php echo $postcode; ?>"></div>                
				<div class="col-40"><span class="error"><?php echo $postcode_err; ?></span></div> 			               
            </div>
			<div class="row">
				<div class="col-20"><label>Phone</label></div>				
				<div class="col-40"><input type="email" name="phone" maxlength="20" value="<?php echo $phone; ?>"></div>			
				<div class="col-40"><span class="error"><?php echo $phone_err; ?></span></div>                			
            </div><br>
            <div class="row">
				<div>
					<input type="submit" value="Submit">   
				</div>
            </div>
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
