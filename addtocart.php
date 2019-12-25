<?php

include "includes/session.php";

if(isset($_POST['item_id'])){
	
	include "includes/connect.php";
	connect();
	
	// create safe values for sql
	$clean_id = mysqli_real_escape_string($connection, $_POST['item_id']);		
	$clean_qty = mysqli_real_escape_string($connection, $_POST['item_qty']);
	
	// validate item and get result set
	$sql = "SELECT title FROM shop_items WHERE id = '".$clean_id."'";
	$result = mysqli_query($connection, $sql)
		or die(mysqli_error($connection));
		
	if(mysqli_num_rows($result) < 1){
		// free result, close connection and redirect
		mysqli_free_result($result);
		mysqli_close($connection);
		header("Location: shop.php");		
		exit;
	}else{
		
		// create sql to update stock on hand
		$update = 	"UPDATE shop_items SET quantity = quantity - '".$clean_qty."' 
					WHERE id = '".$clean_id."'";
		// attempt to execute
		mysqli_query($connection, $update)
			or die (mysqli_error($connection));		
		
		// get title and free result
		while($arrItem = mysqli_fetch_array($result)){
			$title = stripcslashes($arrItem['title']);
		}
		mysqli_free_result($result);
		// insert info to shoppingcart table
		$insert = 	"INSERT INTO shoppingcart
					(session_id, item_id, item_qty)
					VALUES ('".$_COOKIE['PHPSESSID']."',
					'".$clean_id."',
					'".$clean_qty."')";
		$res = mysqli_query($connection, $insert)
			or die(mysqli_error($connection));
			
		// close connection and redirect
		mysqli_close($connection);
		header("Location: showcart.php?item_id=$clean_id&cat_id=$_POST[cat_id]");
		exit;
	}
}else{
	// item id not found - redirect
	header("Location: shop.php");		
	exit;
}

?>