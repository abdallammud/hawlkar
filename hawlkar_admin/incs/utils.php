<?php 
require('db.php');
session_start();

if(isset($_GET['action'])) {
	if($_GET['action'] == 'login') {
		$result['msg'] = 'Correct action';
		$result['status'] = 201;

		$username = $_POST['username'];
	    $password = $_POST['password'];

	    $getUser = "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` LIKE '$username')";
	    $userSet = $GLOBALS['conn']->query($getUser);
	    if($userSet->num_rows < 1) {
	        $result['error'] = true;
	        $result['errType']  = 'username';
	        $result['msg'] = ' Username is not found.';
	        echo json_encode($result); 
	        exit();
	    }

	    while($row = $userSet->fetch_assoc()) {
	        $user_id    = $row['user_id'];
	        $passDB     = $row['password'];
	        $status     = $row['status'];
	        $role     	= $row['role'];
	        $full_name  = $row['full_name'];

	        $user_actions     = $row['user_actions'];
	        $user_privileges  = $row['user_privileges'];

	        if (!password_verify($password, $passDB)) {
	            $result['error'] = true;
	            $result['errType']  = 'password';
	            $result['msg'] = ' Incorrect password.';
	            echo json_encode($result); 
	            exit();
	        }

	        if(strtolower($status) != 'active') {
	            $result['error'] = true;
	            $result['errType']  = 'username';
	            $result['msg'] = ' Inactive user. Please contact system adminstrator.';
	            echo json_encode($result); 
	            exit();
	        }
	    }

	    if(set_sessions($username, $user_actions, $user_privileges, $role, $full_name, $user_id)) {
	        setLoginInfo($user_id);
	    } else {
	        $result['msg']    = ' Couln\'t set sessions.';
	        $result['error'] = true;
	        $result['errType']  = 'sessions';
	        echo json_encode($result); exit();
	    }

	    $result['msg'] = "Succefully logged in.";
	    $result['error'] = false;
	    $result['actions'] = $user_actions;
	    $result['privilegs'] = $user_privileges;
	    echo json_encode($result); exit(); 

	}
}
function load(){
	if(isset($_GET['menu'])) {
		if($_GET['menu'] == 'articles') {
			if($_SESSION['articles'] != 'on') {
				require('404.php');
				exit;
			}
			if(isset($_GET['action'])) {
				if($_GET['action'] == 'show') {
					require('./_articles/show_article.php');
				} else if($_GET['action'] == 'update') {
					require('./_articles/update_article.php');
				} else if($_GET['action'] == 'create') {
					require('./_articles/article_add.php');
				}
			} else if(isset($_GET['tab'])) {
				if($_GET['tab'] == 'categories') {
					require('./_articles/categories.php');
				}
			} else {
				require('./_articles/all_articles.php');
			}
		} else if($_GET['menu'] == 'users') {
			if($_SESSION['users'] != 'on') {
				require('404.php');
				exit;
			}
			if(isset($_GET['action'])) {
				if($_GET['action'] == 'update') {
					require('./hrm/show_user.php');
				} else if($_GET['action'] == 'update') {
					require('./hrm/update_user.php');
				}
			} else {
				require('./hrm/users.php');
			}
		} else if($_GET['menu'] == 'categories') {
			if($_SESSION['categories'] != 'on') {
				require('404.php');
				exit;
			}
			if(isset($_GET['action'])) {
				if($_GET['action'] == 'update') {
					require('./_articles/show_category.php');
				} else if($_GET['action'] == 'update') {
					require('./_articles/update_category.php');
				}
			} else {
				require('./_articles/all_categories.php');
			}
		} else if($_GET['menu'] == 'settings') {
			if($_SESSION['settings'] != 'on') {
				require('404.php');
				exit;
			}
			require('settings.php');
		} else {
			if($_SESSION['dashboard'] == 'on') {
				require('dashboard.php');
			} else {
			 	require('404.php');
			}
		}
	} else {
		require('dashboard.php');
	}
}

function set_sessions($username, $actions, $privileges, $role = 'user', $fullName = '', $user_id = '') {
	$_SESSION['role'] = $role;
	$_SESSION['myUser'] = $username;
	$_SESSION['fullName'] = $fullName;
	$_SESSION['user_id'] = $user_id;
	$_SESSION['isLogged'] = true;

	$actions 	= explode(",", $actions);
	$privileges = explode(",", $privileges);

	$_SESSION['dashboard'] = 'off';
	$_SESSION['articles'] = 'off';
	$_SESSION['categories'] = 'off';
	$_SESSION['users'] = 'off';
	$_SESSION['settings'] = 'off';

	$_SESSION['create'] = 'off';
	$_SESSION['update'] = 'off';
	$_SESSION['delete'] = 'off';

	if(in_array("dashboard", $privileges)) $_SESSION['dashboard'] = 'on';
	if(in_array("articles", $privileges)) $_SESSION['articles'] = 'on';
	if(in_array("categories", $privileges)) $_SESSION['categories'] = 'on';
	if(in_array("users", $privileges)) $_SESSION['users'] = 'on';
	if(in_array("settings", $privileges)) $_SESSION['settings'] = 'on';

	if(in_array("create", $actions)) $_SESSION['create'] = 'on';
	if(in_array("update", $actions)) $_SESSION['update'] = 'on';
	if(in_array("delete", $actions)) $_SESSION['delete'] = 'on';

	// $_SESSION['role'] = 'admin';
	return true;
}

function reload() {
	if(!isset($_SESSION['myUser']) || !$_SESSION['myUser']) {
        return false;
    }

    $username = $_SESSION['myUser'];

    $getUser = "SELECT * FROM `users` WHERE (`username` = '$username' OR `email` LIKE '$username') AND `status` NOT IN ('deleted')";
    $userSet = $GLOBALS['conn']->query($getUser);
    $status = '';
    while($row = $userSet->fetch_assoc()) {
        $user_id    = $row['user_id'];
        $passDB     = $row['password'];
        $status     = $row['status'];
        $role     	= $row['role'];
        $full_name  = $row['full_name'];
        $user_actions  		= $row['user_actions'];
        $user_privileges  	= $row['user_privileges'];
    }

    if(strtolower($status) != 'active') {
    	$_SESSION['isLogged'] = false;
    	return;
    }

    set_sessions($username, $user_actions, $user_privileges, $role, $full_name, $user_id); 
}

function setLoginInfo($userID, $logout = false) {
    $this_time = date('Y-m-d h:i:s');
    $is_logged = 'yes';
    $column = 'this_time';
    if($logout) { $is_logged = 'no'; $column = 'last_logged';}
    $stmt = $GLOBALS['conn']->prepare("UPDATE `users` SET `is_logged` = ?, `$column` = ? WHERE `user_id` = ?");
    $stmt->bind_param("sss", $is_logged, $this_time, $userID);
    if(!$stmt->execute()) {
        echo $stmt->error;
    }
}

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


// Get_details
function get_categoryInfo($category_id, $column = '') {
	$name = $parent_id = '';
	$get_category = "SELECT * FROM `categories` WHERE `category_id` = '$category_id'";
	if($column) $get_category = "SELECT * FROM `categories` WHERE `$column` = '$category_id'";
    $categorySet = $GLOBALS['conn']->query($get_category);
    while($row = $categorySet->fetch_assoc()) {
    	$name = $row['name'];
    }

    return array('name' => $name);
}

function get_userInfo($user_id, $username = '') {
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

function get_post($post_id) {
	$result = [];
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
	FROM `posts` A LEFT JOIN `users` U ON U.`user_id` = A.`author_id` LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` WHERE `post_id` = '$post_id'";
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

?>
