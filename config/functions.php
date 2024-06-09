<?php 
require('db.php');
define("BASE_URI", "https://hawlkar.com/");
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
    	$navs .= '<li class="nav-item active">
            <a class="nav-link ';
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
	`is_popular`,
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
		$is_popular 	= ucwords(str_replace("'", '', $row['is_popular']));
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
    	
    	if($is_popular == 'Yes') {
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
	$article = '';
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
	`is_popular`,
	`image`
	FROM `posts` A LEFT JOIN `users` U ON U.`user_id` = A.`author_id` LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` WHERE A.`status`  IN ('Published') AND `post_id` = '$id'";
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
		$is_popular 	= ucwords(str_replace("'", '', $row['is_popular']));
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

		$article .= '<div class="article">'.$content.'<div>';
	}
	return $article;
}

if(isset($_GET['get'])) {
	if($_GET['get'] == 'navbar') {
		$result = array('status' => 200, 'error' => false, 'msg' => 'good');
		$get_category = "SELECT * FROM `categories` WHERE `status`  IN ('Published')";
	    $categorySet = $GLOBALS['conn']->query($get_category);

	    $result['navs'] = [];
	    while($row = $categorySet->fetch_assoc()) {
	    	// 
	    	$category = $row['name'];
	    	$link = strtolower(str_replace(" ", "_", $category));

	    	$array = array('category' => $category, 'link' => $link);
	    	array_push($result['navs'], $array);
	    	
	    }
	    echo json_encode($result);
	} else if($_GET['get'] == 'articles') {
		$result = array('status' => 200, 'error' => false, 'msg' => 'good');

		$category = '';
		if(isset($_POST['category'])) $category = $_POST['category'];

		$category = str_replace("_", " ", $category);

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
		`is_popular`,
		`image`
		FROM `posts` A LEFT JOIN `users` U ON U.`user_id` = A.`author_id` LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` WHERE A.`status`  IN ('Published') ";

		if($category) {
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
			$is_popular 	= ucwords(str_replace("'", '', $row['is_popular']));
			$created_at 	= new dateTime($row['created_at']);
			$image 			= $row['image'];

			$created_at 	= $created_at->format('F d, Y');
			if(!$excerpt) $excerpt = substr($content, 0, 200);
			$excerpt = clean(substr($excerpt, 0, 100));

			$category 		= strtoupper($row['name']);
			$author 		= $row['full_name'];
	    	// $published_at 	= new dateTime($row['published_at']);
	    	// $published_at 	= $published_at->format('M d');

	    	$wpm 		= 300;
	    	$words 		= preg_split('/\s+/', $content);
			$wordCount 	= count($words);
			$time 		= ceil($wordCount/$wpm);

	    	$link 			= strtolower(str_replace(" ", "_", $title));
	    	$link = str_replace(",", "", $link);
	    	$array 			= array('title' => $title, 'link' => $link, 'excerpt' => $excerpt, 'category' => $category, 'author' => $author, 'published_at' => $created_at, 'image' => $image, 'time' => $time);

	    	if($is_popular == 'Yes') {
	    		array_push($result['popular'], $array);
	    	} else {
	    		array_push($result['articles'], $array);
	    	}
	    	
	    	
	    }
	    echo json_encode($result);
	}
} else {

}




?>