<?php
include "includes/session.php";
include "includes/connect.php";
connect();

// initialise variable for display in html
$title = "shop item";

// create safe values for sql 
$clean_id = mysqli_real_escape_string($connection, $_GET['item_id']);

// create sql and result set 
$item_sql = "SELECT c.id as cat_id, c.title as cat_title, si.title, si.price, si.detail, si.image, si.quantity
			FROM shop_items AS si LEFT JOIN shop_categories AS c on c.id = si.cat_id
			WHERE si.id = '".$clean_id."'";
$dbItems = mysqli_query($connection, $item_sql)
	or die(mysqli_error($connection));
	
if(mysqli_num_rows($dbItems) < 1){
	$display = "<p><em>No items found in the database</em></p>";
}else{
	while($arr_items = mysqli_fetch_array($dbItems)){
		$cat_id = $arr_items['cat_id'];
		$cat_title = $arr_items['cat_title'];
		$title = stripcslashes($arr_items['title']);
		$price = $arr_items['price'];
		$detail = stripslashes($arr_items['detail']);
		$image = $arr_items['image'];
		$quantity = $arr_items['quantity'];
	}
	
	// display photo and description in 2 column grid
	$display = <<<END_OF_TEXT
	<div class='shopwrapper'><div class='row'><div class='col-50'><div class="grow">
	<img src="images/$image" id="shopitem" alt="$title"/></div></div>
	<div class='col-50'>
	<p>$detail</p>
	<p>Back to <a href="category.php?cat_id=$cat_id">$cat_title</a></p>
	<p>Price: \$$price</p>
	<form method="post" action="addtocart.php">
END_OF_TEXT;

	mysqli_free_result($dbItems);
	$display .= "
	<p><label for=\"quantity\">Select Quantity:</label>
	<select id=\"quantity\" name=\"item_qty\">";
	
	for($i = 1; $i < ($quantity + 1); $i++){
		$display .= "<option value=\"".$i."\">".$i."</option>";
	}
	
	$display .= <<<END_OF_TEXT
	</select></p>
	<input type="hidden" name="item_id"
	value="$clean_id" />
	<input type="hidden" name="cat_id"
	value="$cat_id" />
	<input type="submit" value="Add to Cart">
	</form>	
	</div></div></div>
END_OF_TEXT;
}

mysqli_close($connection);

?>

<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Shop</title>
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
		<div class="spacearound"><h1><?php echo $title; ?></h1>
		<h1><a href="showcart.php?cat_id=<?php echo $cat_id; ?>">Shopping Cart</a></h1></div>		
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
