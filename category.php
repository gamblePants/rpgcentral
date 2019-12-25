<?php

include "includes/session.php";
include "includes/connect.php";
connect();

$display = "<div class='shopwrapper'><div class='row'>";

// if category id set then show items
if (isset($_GET['cat_id'])){			
	// create safe value for sql 
	$clean_cat_id = mysqli_real_escape_string($connection, $_GET['cat_id']);
	
	// get items from database
	$items_sql = 	"SELECT id, title, price, image FROM shop_items 
					WHERE cat_id = '".$clean_cat_id."' AND quantity > 0 ORDER BY title";
	$dbItems = mysqli_query($connection, $items_sql)
		or die(mysqli_error($connection));
		
	// get title from database
	$title_sql = "SELECT title FROM shop_categories WHERE id = '".$clean_cat_id."'";
	$dbTitle = mysqli_query($connection, $title_sql)
		or die(mysqli_error($connection));
	$cTitle = mysqli_fetch_array($dbTitle)['title'];	
		
	if(mysqli_num_rows($dbItems) < 1){
		$display = "<p><em>Sorry, there are currently no shop items for this category.</em></p>";
	}else{
		// display items in 3 column grid		
		$index = 1;
		while($arr_items = mysqli_fetch_array($dbItems)){
			$id = $arr_items['id'];
			$title = stripslashes($arr_items['title']);
			$price = $arr_items['price'];
			$image = $arr_items['image'];
			
			$display .= "<div class='col-33'>
					<figure class='grow'><a href=\"showitem.php?item_id=".$id."\"><img src='images/$image'></a>		
					<figcaption class='medium'>".$title." \$".$price."</figcaption>
					</figure></div>";
		
			// if end of items
			if($index == mysqli_num_rows($dbItems)){
				$display .= "</div></div>";
			}
			
			// if 3rd item prepare next row
			else if($index / 3 == 1){
				$display .= "</div><div class='row'>";
			}		
					
			$index ++;		
		}
		mysqli_free_result($dbItems);	
}
mysqli_close($connection);
}else{
	// cat id not set redirect to shop
	mysqli_close($connection);
	header("Location; shop.php");
	exit;
}
	
?>

<!DOCTYPE html>
<html>
<head>
<title>RPGCentral Shop Category</title>
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
		<div class="spacearound"><h1><?php echo $cTitle; ?></h1>
		<h1><a href="showcart.php?cat_id=<?php echo $clean_cat_id; ?>">Shopping Cart</a></h1></div>
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
