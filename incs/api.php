<?php
require('../config/db.php');
if(isset($_GET['get'])) {
	if($_GET['get'] == 'posts') {
		$category = isset($_POST['category']) ? $_POST['category'] : null;
		$query = isset($_POST['query']) ? $_POST['query'] : null;
		$page = isset($_POST['page']) ? $_POST['page'] : 1;

		// Calculate limit based on page
		$limit = ($page - 1) * 10 + 10;
		$limit = ($page - 1) * 10 . ', 10';
		// Base query
		$get_articles = "SELECT 
		        A.`category_id`, 
		        A.`author_id`, 
		        `full_name`, 
		        `name`, 
		        `title`, 
		        A.`status`, 
		        A.`created_at`, 
		        `excerpt`, 
		        `post_id`,
		        `published_at`,
		        `views`,
		        `is_featured`,
		        `image`
		        FROM `posts` A 
		        LEFT JOIN `users` U ON U.`user_id` = A.`author_id` 
		        LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` 
		        WHERE A.`status`  IN ('Published')";

		// Apply category filter
		if($category) {
		    $get_articles .= " AND C.`name` LIKE '$category%'";
		}

		// Apply query filter
		if($query) {
		    $get_articles .= " AND (A.`title` LIKE '%$query%' OR `full_name` LIKE '%$query%')";
		}
		$no_limit = $get_articles;
		// Apply limit
		$get_articles .= " LIMIT $limit";

		// echo $get_articles;
		// Execute query and fetch results
		$result = $GLOBALS['conn']->query($get_articles);
		$totalRows = $GLOBALS['conn']->query($no_limit)->num_rows;

		// Process fetched results (example)
		$posts = [];
		while($row = $result->fetch_assoc()) {
		    $posts[] = $row;
		}

		// Return posts data as JSON
		echo json_encode(array("totalRows" => $totalRows, "data" => $posts));
	} else if($_GET['get'] == 'mostViewed') {
		$limit = 10;
		// Base query
		$get_articles = "SELECT 
		        A.`category_id`, 
		        A.`author_id`, 
		        `full_name`, 
		        `name`, 
		        `title`, 
		        A.`status`,
		        A.`created_at`, 
		        `excerpt`, 
		        `post_id`,
		        `published_at`,
		        `views`,
		        `is_featured`,
		        `image`
		        FROM `posts` A 
		        LEFT JOIN `users` U ON U.`user_id` = A.`author_id` 
		        LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` 
		        WHERE A.`status`  IN ('Published')";

		// Apply limit
		$get_articles .= " ORDER BY `views` DESC LIMIT $limit";

		// Execute query and fetch results
		$result = $GLOBALS['conn']->query($get_articles);

		// Process fetched results (example)
		$posts = [];
		while($row = $result->fetch_assoc()) {
		    $posts[] = $row;
		}

		// Return posts data as JSON
		echo json_encode(array("data" => $posts));
	}
}
?>