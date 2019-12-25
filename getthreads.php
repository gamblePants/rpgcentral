<?php
include "includes/connect.php";
include "includes/pagination.php";
connect();

// ajaxthreads.js redirects here
if(isset($_POST['topic_id']) || isset($_POST['page'])){	
	
	$item_per_page = 5;
	// if selecting page number
	if(isset($_POST["page"])){		
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} 
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}
	
	// create safe value for displaying topic info 
	$clean_id = mysqli_real_escape_string($connection, $_POST['topic_id']);
	
	// get total number of records from database for pagination
	$total = $connection->query("SELECT COUNT(*) FROM threads WHERE topic_id = '".$clean_id."'");
	$get_total_rows = $total->fetch_row(); //hold total records in an array
	// break records into pages
	$total_pages = ceil($get_total_rows[0]/$item_per_page);
	// get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);	
	
	// prepare statement for threads within a page range. 
	$results = $connection->prepare("SELECT 
									threads.id,
									threads.title,
									DATE_FORMAT(threads.timeAdded, '%b %e %Y at %r') as fmt_timeAdded,
									threads.username,
									COUNT(posts.id) posts
									from threads
									inner join posts on posts.thread_id = threads.id
									where threads.topic_id = '".$clean_id."'
									group by threads.id,threads.title,threads.timeAdded,threads.username
									ORDER by threads.timeAdded DESC
									LIMIT $page_position, $item_per_page");	
	$results->execute(); // execute prepared Query
	$results->bind_result($id, $title, $timeAdded, $username, $posts); // bind variables to prepared statement	
		
	if($get_total_rows[0] < 1){
		echo "<em>No threads exist.</em>";		
	}else{
		// create display with heredoc
		echo <<<END_TEXT
		<table>
		<tr>
		<th>THREAD TITLE</th>
		<th class="num_posts">No. of Posts</th>
		</tr>
END_TEXT;
		// loop through records and add to display
		while($results->fetch()){			
			echo <<<END_TEXT
			<tr>
			<td><a href="showThread.php?thread_id=$id">
			$title</a><br/>
			<span class="medium">Created on $timeAdded by $username</span></td>
			<td class="num_posts">$posts</td>
			</tr>
END_TEXT;
		}	
		echo "</table>";		
		echo '<div align="center">';
		// call function to generate pagination links		
		echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
		echo '</div>';
	}
	// free results		
	mysqli_free_result($total);
	$results -> close();	
	// close connection
	mysqli_close($connection);	
}else{
	// no $_POST values redirect
	header("Location: index.php");
	exit;
}

?>