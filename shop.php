<?php 
include "includes/session.php";
include "includes/connect.php";
connect();

$display = "<div class='shopwrapper'><div class='row'>";

// create sql and execute to select categories
$select_sql = "SELECT id, title, image FROM shop_categories ORDER BY title";
$dbCategories = mysqli_query($connection, $select_sql)
	or die(mysqli_error($connection));
	
if(mysqli_num_rows($dbCategories) < 1){
	$display = "<p><em>Sorry, there are no shop categories in the database</em></p>";
}else{
	// display categories in 3 column grid
	$index = 1;
	while($arr_cats = mysqli_fetch_array($dbCategories)){
		$cat_id = $arr_cats['id'];
		$cat_title = $arr_cats['title'];	
		$cat_image = $arr_cats['image'];
		
		$display .= "<div class='col-33'>		
					<figure class='grow'><a href=\"category.php?cat_id=".$cat_id."\"><img src='images/$cat_image'></a>		
					<figcaption>".$cat_title."</figcaption>
					</figure></div>";
		
		// if end of categories
		if($index == mysqli_num_rows($dbCategories)){
			$display .= "</div></div>";
		}
		
		// if 3rd category prepare next row
		else if($index / 3 == 1){
			$display .= "</div><div class='row'>";
		}					
		$index ++;		
	}
}
mysqli_free_result($dbCategories);
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
		<div class="spacearound"><h1>RPGCentral Shop</h1><h1><a href="showcart.php">Shopping Cart</a></h1></div>	
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
