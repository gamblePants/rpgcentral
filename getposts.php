<?php
include "includes/connect.php";
include "includes/pagination.php";
connect();

// ajaxposts.js redirects here
if(isset($_POST['thread_id']) || isset($_POST['page'])){
		
	$item_per_page = 5;
	// if selecting page number
	if(isset($_POST["page"])){		
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} 
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}
	
	// create safe value for SQL
	$clean_id = mysqli_real_escape_string($connection, $_POST['thread_id']);
	
	// get total number of records from database for pagination
	$total = $connection->query("SELECT COUNT(*) FROM posts WHERE thread_id = '".$clean_id."'");
	$get_total_rows = $total->fetch_row(); //hold total records in an array
	// break records into pages
	$total_pages = ceil($get_total_rows[0]/$item_per_page);
	// get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);	
	// prepare statement for posts within a page range
	$results = $connection->prepare("SELECT 
									topics.title,
									threads.title,
									threads.topic_id,
									posts.id,
									posts.post,
									DATE_FORMAT(posts.timeAdded, '%b %e %Y<br/>%r') as fmt_timeAdded,
									posts.username
									from topics
									inner join threads on topics.id = threads.topic_id
									inner join posts on threads.id = posts.thread_id
									where posts.thread_id = '".$clean_id."'
									ORDER BY posts.timeAdded ASC
									LIMIT $page_position, $item_per_page");	
	$results->execute(); 
	$results->bind_result($topic_title, $threadtitle, $topic_id, $id, $post, $timeAdded, $username); // bind variables to prepared statement	
	$results->fetch();
	
	if($get_total_rows[0] < 1){
		echo "<em>No posts exist.</em>";
	}else{	
		// create display with heredoc
		echo <<<END_TEXT
		<p><div class="spacebetween"><div>Posts for $threadtitle</div>
		<div>Back to <a href="threadList.php?topic_id=$topic_id">$topic_title</a></div></div></p>
		<table>
		<tr>
		<th>USERNAME</th>
		<th>POST</th>
		</tr>
END_TEXT;
		// do loop because statement is fetched twice	
		do{			
			echo <<<END_TEXT
			<tr>
			<td>$username<br/>
			<span class="small">
			posted on:<br/>$timeAdded</td>
			</span>
			<td>$post<br/><br/>
			<a class="medium" href="reply.php?post_id=$id&thread_id=$clean_id">
			REPLY TO POST</a></td>
			</tr>
END_TEXT;
		}while($results->fetch());	
	echo "</table>";
	echo '<div align="center">';
		// call function from pagination.php	
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