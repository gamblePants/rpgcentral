<?php

include "includes/connect.php";
include "includes/session.php";
connect();

// initialise variables for display
$display = $breadcrumbs = "";
$cat_id = 0;

// get breadcrumbs from querystring
if(isset($_GET['cat_id'])){ $cat_id = $_GET['cat_id'];}
if(isset($_POST['cat_id'])){ $cat_id = $_POST['cat_id'];}

if ($cat_id != 0){
	// create safe value for sql
	$clean_cat = mysqli_real_escape_string($connection, $cat_id);
	// get category from database 
	$cat_sql = "SELECT title from shop_categories WHERE id = '".$clean_cat."'";
	$dbCat = mysqli_query($connection, $cat_sql)
		or die(mysqli_error($connection));
	$cTitle = mysqli_fetch_array($dbCat)['title'];
	
	$breadcrumbs = "Back to <a href='category.php?cat_id=$clean_cat'>$cTitle</a>";
}

// check for cart items based on session id
$sql = 	"SELECT c.id, i.id as item_id, i.title, i.price, c.item_qty FROM
		shoppingcart AS c LEFT JOIN shop_items AS i ON
		i.id = c.item_id WHERE session_id = '".$_COOKIE['PHPSESSID']."'";
$result = mysqli_query($connection, $sql)
	or die(mysqli_error($connection));
	
if(mysqli_num_rows($result) < 1){
	$display .= "<p><em><br>You have no items in your cart.</em></p>";
}else{
	// get info from result and build display
	$display .= <<<END_OF_TEXT
	<table>
	<tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Action</th></tr>
END_OF_TEXT;
	while($arrCart = mysqli_fetch_array($result)){
		$id = $arrCart['id'];
		$item_id = $arrCart['item_id'];
		$title = stripcslashes($arrCart['title']);
		$price = $arrCart['price'];
		$qty = $arrCart['item_qty'];
		$total = sprintf("%.02f", $price * $qty);
		
		$display .= <<<END_OF_TEXT
		<tr><td>$title <br></td><td>\$$price <br></td><td>$qty <br></td><td>\$$total</td>
		<td><a href="removefromcart.php?id=$id&item_id=$item_id&qty=$qty&cat_id=$cat_id">remove</a></td></tr>		
END_OF_TEXT;
		
	}
	// close table and add button
	$display .= <<<END_OF_TEXT
				</table>
				<div style="text-align: right;">
				<form action="checkout.php"><input type="submit" value="Checkout"></form>
				</div>
END_OF_TEXT;
}

mysqli_free_result($result);
mysqli_close($connection);

// no code to take items out of shoppingcart if session expires - add later

?>

<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Shopping Cart</title>
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
		<div class="spacebetween"><p>Shopping Cart</p><p><?php echo $breadcrumbs; ?></p></div>		
		<?php echo $display; ?>		
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
