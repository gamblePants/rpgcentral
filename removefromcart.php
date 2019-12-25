<?php

include "includes/session.php";
include "includes/connect.php";
connect();

if(isset($_GET['id'])){
	// create safe values for sql 
	$clean_id = mysqli_real_escape_string($connection, $_GET['id']);
	$clean_qty = mysqli_real_escape_string($connection, $_GET['qty']);
	$clean_item = mysqli_real_escape_string($connection, $_GET['item_id']);
	
	/* for testing
	echo "<p>clean id: ".$clean_id."</p>";
	echo "<p>clean qty: ".$clean_qty."</p>";
	*/
	
	// remove from shopping cart
	$sql = 	"DELETE FROM shoppingcart WHERE
			id = '".$clean_id."' and session_id = '".$_COOKIE['PHPSESSID']."'";
	$result = mysqli_query($connection, $sql)
		or die(mysqli_error($connection));
		
	// update stock on hand for item
	$update = 	"UPDATE shop_items SET quantity = quantity + '".$clean_qty."' 
				WHERE id = '".$clean_item."'";
	mysqli_query($connection, $update)
		or die(mysqli_error($connection));		
	
	// close connection and redirect to cart
	mysqli_close($connection);
	header("Location: showcart.php?cat_id=$_GET[cat_id]");
	exit;
}else{
	// session id not found redirect to shop
	mysqli_close($connection);
	header("Location: shop.php");	
	exit;
}

?>