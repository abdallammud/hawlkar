<?php 
require('db.php');
define("BASE_URI", "/projects/2024/hawlkar");

function clean($clear) {
	// Strip HTML Tags
	$clear = strip_tags($clear);
	// Clean up things like &amp;
	$clear = html_entity_decode($clear);
	// Strip out any url-encoded stuff
	$clear = urldecode($clear);
	// Replace non-AlNum characters with space
	$clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);
	// Replace Multiple spaces with single space
	$clear = preg_replace('/ +/', ' ', $clear);
	// Trim the string of leading/trailing space
	$clear = trim($clear);

	return $clear;
}

function navbar() {
	$navs = '';
	$get_category = "SELECT * FROM `categories` WHERE `status`  IN ('Published')";
	$categorySet = $GLOBALS['conn']->query($get_category);
    $result['navs'] = [];
    while($row = $categorySet->fetch_assoc()) {
    	$category = $row['name'];
    	$link = strtolower(str_replace(" ", "_", $category));

    	$menu = '';
    	if(isset($_GET['menu'])) {
    		$menu = $_GET['menu'];
    	}


    	$navs .= '<li class="nav-item">
            <a class="nav-link color-green-hover';
            if(strtolower($menu) == strtolower($category)) $navs .= ' active ';
            $navs .= '" href="'.BASE_URI.'/'.$link.'">'.$category.'</a>
        </li>';
    	
    }
    return $navs;
}

function all_articles($date = '') {
	$all_articles = '';
	$popular = '';
	$get_articles = "SELECT 
	A.`category_id`, 
	A.`author_id`, 
	`full_name`, 
	`name`, 
	`title`, 
	A.`status`, 
	A.`created_at`, 
	`content`, 
	`excerpt`, 
	`post_id`,
	`published_at`,
	`is_featured`,
	`image`
	FROM `posts` A LEFT JOIN `users` U ON U.`user_id` = A.`author_id` LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` WHERE A.`status`  IN ('Published') ";

	if(isset($_GET['menu'])) {
		$category = $_GET['menu'];
		$get_articles .= " AND C.`name` LIKE '$category%'";
	}

    $articlesSet = $GLOBALS['conn']->query($get_articles);
    $result['articles'] = [];
    $result['popular'] = [];
    while($row = $articlesSet->fetch_assoc()) {
    	$post_id 		= $row['post_id'];
		$title 			= $row['title'];
		$content 		= $row['content'];
		$excerpt 		= $row['excerpt'];
		$category_id 	= $row['category_id'];
		$author_id 		= $row['author_id'];
		$status 		= ucwords(str_replace("'", '', $row['status']));
		$is_featured 	= ucwords(str_replace("'", '', $row['is_featured']));
		$created_at 	= new dateTime($row['created_at']);
		$image 			= $row['image'];

		$created_at 	= $created_at->format('F d, Y');
		if(!$excerpt) $excerpt = substr($content, 0, 200);
		$excerpt = clean(substr($excerpt, 0, 100));

		$category 		= strtoupper($row['name']);
		$author 		= $row['full_name'];

    	$wpm 		= 300;
    	$words 		= preg_split('/\s+/', $content);
		$wordCount 	= count($words);
		$time 		= ceil($wordCount/$wpm);

		$all_articles .= '<a href="./article/'.$post_id.'" class="mb-3 post d-flex justify-content-between col-md-6 col-lg-6 col-ms-12">
			<img class="post_image" src="./assets/img/articles/'.$image.'">
			<div class="">
				<h2 class="post_title">
				<span class="text-dark" >'.$title.'</span>
				</h2>
				<div class="card-text text-muted small">
					 '.$author.'
				</div>
				<span class="category">'.ucwords(strtolower($category)).'</span>
			</div>
		</a>';
    	
    	if($is_featured == 'Yes') {
    		$popular .= '<li>
				<span>
					<h6 class="font-weight-bold">
						<a href="./article.html" class="text-dark">Did Supernovae Kill Off Large Ocean Animals?</a>
					</h6>
					<p class="text-muted">
						Jake Bittle in SCIENCE
					</p>
				</span>
			</li>';
    	}
    }

    return array('all_articles' => $all_articles, 'popular' => $popular);
}

function get_signleArticle($id) {
	$get_articles = "SELECT 
	A.`category_id`, 
	A.`author_id`, 
	`full_name`, 
	`name`, 
	`title`, 
	A.`status`, 
	A.`created_at`, 
	`content`, 
	`excerpt`,
	`tags`,
	`views`,
	`post_id`,
	`published_at`,
	`is_featured`,
	`image`
	FROM `posts` A LEFT JOIN `users` U ON U.`user_id` = A.`author_id` LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` WHERE A.`status`  IN ('Published') AND `post_id` = '$id'";
	 $articlesSet = $GLOBALS['conn']->query($get_articles);
    $result = [];
    while($row = $articlesSet->fetch_assoc()) {
    	$post_id 		= $row['post_id'];
		$title 			= $row['title'];
		$content 		= $row['content'];
		$excerpt 		= $row['excerpt'];
		$category_id 	= $row['category_id'];
		$author_id 		= $row['author_id'];
		$status 		= ucwords(str_replace("'", '', $row['status']));
		$is_featured 	= ucwords(str_replace("'", '', $row['is_featured']));
		$created_at 	= new dateTime($row['created_at']);
		$image 			= $row['image'];

		$created_at 	= $created_at->format('F d, Y');
		if(!$excerpt) $excerpt = substr($content, 0, 200);
		$excerpt = clean(substr($excerpt, 0, 100));

		$category 		= strtoupper($row['name']);
		$author 		= $row['full_name'];

    	$wpm 		= 300;
    	$words 		= preg_split('/\s+/', $content);
		$wordCount 	= count($words);
		$time 		= ceil($wordCount/$wpm);

		$result[] = $row;

		// $article .= '<div class="article">'.$content.'<div>';
	}
	return $result;
}

function get_featuredPosts() {
	$posts = [];
	$limit = 3;
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
    WHERE A.`status`  IN ('Published') AND `is_featured` = 'Yes'";

	// Apply limit
	$get_articles .= " LIMIT $limit";

	// Execute query and fetch results
	$result = $GLOBALS['conn']->query($get_articles);

	while($row = $result->fetch_assoc()) {
	    $posts[] = $row;
	}

	// Return posts data as JSON
	return  $posts;
}

function make_categoryLink($category) {
	return $link = strtolower(str_replace(" ", "_", $category));
}
function get_categories() {
	$result = [];
	$get_categories = "SELECT * FROM `categories` WHERE `status`  IN ('Published')";
	$categorySet = $GLOBALS['conn']->query($get_categories);
    while($row = $categorySet->fetch_assoc()) {
    	$result[] = $row;
    }
    return $result;
}

function get_categoryPostsCount($category_id) {
	$posts = $GLOBALS['conn']->query("SELECT `post_id` FROM `posts` WHERE `category_id` = '$category_id'");
	return $posts->num_rows;
}

function get_authorInfo($user_id, $username = '') {
	$name = $parent_id = '';
	$result = [];
	$get_user = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
	if($username) $get_user = "SELECT * FROM `users` WHERE `username` = '$username'";
    $userSet = $GLOBALS['conn']->query($get_user);
    while($row = $userSet->fetch_assoc()) {
    	$result = $row;
    }

   

    return $result;
}

function add_articleView($post_id) {
	$stmt = $GLOBALS['conn']->prepare("UPDATE `posts` SET `views` =? WHERE `post_id` =?");
    $stmt->bind_param("ss", $views, $post_id);
    $postInfo = get_signleArticle($post_id)[0];
	$views = $postInfo['views']+1;
   	$stmt->execute();
}

function get_articles4Category($category_id, $limit = 10) {
	$posts = [];
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
    WHERE A.`status`  IN ('Published') AND A.`category_id` = '$category_id'";

	// Apply limit
	$get_articles .= " LIMIT $limit";

	// Execute query and fetch results
	$result = $GLOBALS['conn']->query($get_articles);

	while($row = $result->fetch_assoc()) {
	    $posts[] = $row;
	}

	// Return posts data as JSON
	return  $posts;
}


function formatDate($inputDate) {
  // Parse input string into a DateTime object
  $date = new DateTime($inputDate);

  // Define month names
  $monthNames = array(
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  );

  // Extract components
  $day = $date->format('d');
  $month = strtoupper($monthNames[$date->format('n') - 1]);
  $year = $date->format('Y');

  // Format the desired date string
  $formattedDate = "$day $month, $year";

  return $formattedDate;
}
















































?>