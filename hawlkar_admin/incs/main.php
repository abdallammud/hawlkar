<?php 
// session_start();

require('utils.php');
$role = $_SESSION['role'];
$myUser = $_SESSION['myUser'];
$result = array('error' => true, 'msg' => 'Incorrect addess', 'status' => 401);
if(isset($_GET['action'])) {
	if($_GET['action'] == 'save') {
		if(isset($_GET['save'])) {
			if($_GET['save'] == 'employee') {
				$result['msg'] = 'Employee saved succefully';
				$result['status'] = 201;

				$fullName 	= $_POST['fullName'];
				$phone 		= $_POST['phone'];
				$email 		= $_POST['email'];
				$username 	= $_POST['username'];
				$slcRole 	= $_POST['slcRole'];
				$password 	= $_POST['password'];
				$password   	= password_hash($password, PASSWORD_DEFAULT);

				$userActions = $userPrivileges = [];
				if(isset($_POST['userActions'])) $userActions 	= $_POST['userActions'];
				if(isset($_POST['userPrivileges'])) $userPrivileges	= $_POST['userPrivileges'];

				$actions 	= rtrim(implode(",", $userActions), ',');
				$privileges = rtrim(implode(",", $userPrivileges), ',');

				if(strtolower($role) != 'admin') {
					$result['msg'] = 'Can\'t add system user.';
					$result['error'] = true;
					echo json_encode($result);
					exit();
				} else if($_SESSION['create'] != 'on') {
					$result['msg'] = 'Can\'t add system user.';
					$result['error'] = true;
					echo json_encode($result);
					exit();
				}

				// Check if username already exist
		        $checkUser = "SELECT `username` FROM `users` WHERE `username` = '$username' AND `status` <> 'deleted'";
		        $userSet = $GLOBALS['conn']->query($checkUser);
		        if($userSet->num_rows > 0) {
		            $result['msg'] = ' Username name already exists. Please select differnt username.';
		            $result['error'] = true;
		            $result['errType'] = 'username';
		            echo json_encode($result); 
		            exit();
		        }

		         $stmt = $GLOBALS['conn']->prepare("INSERT INTO `users` (`full_name`, `phone`, `email`, `username`, `password`, `role`, `user_actions`, `user_privileges`, `reg_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		        $stmt->bind_param("sssssssss", $fullName, $phone, $email, $username, $password, $slcRole, $actions, $privileges, $myUser);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t record username.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' User saved succefully.';
		            $result['error'] = false;
		        }
			} else if($_GET['save'] == 'category') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$slcParentCategory = NULL;

				if(isset($_POST['slcParentCategory'])) $slcParentCategory = $_POST['slcParentCategory'];
				$categoryName = $_POST['categoryName'];

				if(strtolower($role) != 'admin') {
					$result['msg'] = 'Can\'t add category.';
					echo json_encode($result);
					exit();
				}

				// Check if username already exist
		        $check_exist = "SELECT `name` FROM `categories` WHERE `name` = '$categoryName' AND `status` <> 'deleted'";
		        $existSet = $GLOBALS['conn']->query($check_exist);
		        if($existSet->num_rows > 0) {
		            $result['msg'] = ' This category already exists.';
		            $result['error'] = true;
		            $result['errType'] = 'category';
		            echo json_encode($result); 
		            exit();
		        }

		        $stmt = $GLOBALS['conn']->prepare("INSERT INTO `categories` (`name`, `parent_id`, `created_by`) VALUES (?, ?, ?)");
		        $stmt->bind_param("sss", $categoryName, $slcParentCategory, $myUser);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t record category.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Category saved succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else if($_GET['save'] == 'article') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;
				$result['error'] = false;

				$articleTitle = $_POST['articleTitle'];
				$slcArticleCategory = $_POST['slcArticleCategory'];
				$article = $_POST['article'];
				$excerpt = $_POST['excerpt'];
				$articleTags = $_POST['articleTags'];

				$image = '';
				$author_id = $_SESSION['user_id'];

				$excerpt = substr(clean($article), 0, 200)."....";

				$stmt = $GLOBALS['conn']->prepare("INSERT INTO `posts` (`title`, `image`, `content`, `excerpt`, `tags`, `author_id`, `status`, `category_id`, `created_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		        $stmt->bind_param("sssssssss", $articleTitle, $image, $article, $excerpt, $articleTags, $author_id, $status, $slcArticleCategory, $myUser);
		        $status = 'Draft';
		        $uploadOk = false;
				// Check if form is submitted and there is no error
				if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
					// Get file information
				    $target_dir = "../../assets/images/articles/";
				    $file_name = basename($_FILES["file"]["name"]);

				    $temp = explode(".", $_FILES["file"]["name"]);
			    	$newfilename = round(microtime(true)) . '.' . end($temp);

				    $target_file = $target_dir . $newfilename;
				    $uploadOk = true;

				    // Check if image file is a actual image or fake image
			        $check = getimagesize($_FILES["file"]["tmp_name"]);
			        if ($check == false) {
			            $result['error'] = true;
			            $result['msg'] = 'File is not an image.';
			            $uploadOk = false;
			            echo json_encode($result);
						exit();
			        }

			        // Check if file already exists
				    /*if (file_exists($target_file)) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, post image  already exists.";
			            echo json_encode($result);
						exit();
				    }*/

				    // Check file size (optional)
				    if ($_FILES["file"]["size"] > 5000000) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, your file is too large.";
			            echo json_encode($result);
						exit();
				    }

				    // Allow certain file formats
				    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "webp");
				    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
				    if (!in_array($file_extension, $allowed_extensions)) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			            echo json_encode($result);
						exit();
				    }

				    if($uploadOk) {
				    	$image = $newfilename;
				    	if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			            	$result['error'] = true;
		            		$result['msg'] = "Sorry, there was an error uploading your file.";
		            		echo json_encode($result);
							exit();
			            }
				    } else {
				        $result['error'] = true;
	            		$result['msg'] = "Sorry, your file was not uploaded. Article not saved";
	            		echo json_encode($result);
	            		exit();
				    }
				} /*else {
				    $result['error'] = true;
            		$result['msg'] = "No file uploaded or upload error. Article not saved";
            		echo json_encode($result);
            		exit();
				}*/

				if($stmt->execute()) {
                	$result['error'] = false;
            		$result['msg'] = "Article saved succefully.";
		            $result['id'] = $stmt->insert_id;
                } else {
                	$result['error'] = true;
            		$result['msg'] = "Something went wrong with data storing.";
            		echo json_encode($result);
					exit();
                }
				
			}  
		} else {
			$result['msg'] = 'Incorrect action';
		}
		
		echo json_encode($result);
	} else if($_GET['action'] == 'load') {
		if(isset($_GET['load'])) {
			$role = '';
			$status = '';

			$length = 20;
			$searchParam = '';
			$orderBy = '';
			$order = 'ASC';
			$draw = 0;

			if(isset($_POST['role'])) $role = $_POST['role'];
			if(isset($_POST['status'])) $status = $_POST['status'];
			if(isset($_POST['length'])) $length = $_POST['length'];
			if(isset($_POST['draw'])) $draw = $_POST['draw'];
			if(isset($_POST['search'])) $searchParam = $_POST['search']['value'];

			if(isset($_POST['order'])) {
				$orderBy = $_POST['order'][0]['column'];
				$order = strtoupper($_POST['order'][0]['dir']);
			}

			$dataset = array();
			if($_GET['load'] == 'employees') {
				$result['status'] = 201;
				if(isset($_POST['order'])) {
					if($orderBy == '0') $orderBy = 'full_name';
					if($orderBy == '1') $orderBy = 'phone';
					if($orderBy == '2') $orderBy = 'email';
					if($orderBy == '3') $orderBy = 'username';
					if($orderBy == '4') $orderBy = 'status';
					if($orderBy == '5') $orderBy = 'role';
				}
				$get_employees = "SELECT * FROM `users` WHERE `status` NOT IN ('Deleted') ";
				// ORDER BY `reg_date` DESC
				if($searchParam) {
					$get_employees .= " AND (`full_name` LIKE '%$searchParam%' OR `phone` LIKE '%$searchParam%' OR `username` LIKE '%$searchParam%' OR `email` LIKE '%$searchParam%')";
				}

				if($orderBy) {
					$get_employees .= " ORDER BY `$orderBy` $order";
				}
				$get_employees .= " LIMIT 0, ".$length;
				$employees = $GLOBALS['conn']->query($get_employees);
				if($employees->num_rows > 0) {
					$result['foundRows'] = $employees->num_rows;
					$result['error'] = false;

					while($row = $employees->fetch_assoc()) {
						$dataset[] = $row;
					}
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = $employees->num_rows;
					$result['iTotalDisplayRecords'] = $employees->num_rows;

					$result['msg'] = $employees->num_rows . " records were found.";
				} else {
					// $result['error'] = true;
					$result['msg'] = "No records found";
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = 0;
					$result['iTotalDisplayRecords'] = 0;
				}
			} else if($_GET['load'] == 'categories') {
				$result['status'] = 201;
				$get_categories = "SELECT * FROM `categories` WHERE `status` != 'Deleted' ORDER BY `created_at` DESC";
				$categories = $GLOBALS['conn']->query($get_categories);
				if($categories->num_rows > 0) {
					$result['foundRows'] = $categories->num_rows;
					$result['error'] = false;

					while($row = $categories->fetch_assoc()) {
						// $dataset[] = $row;
						$category_id = $row['category_id'];
						$name = $row['name'];
						$parent_id = $row['parent_id'];

						$parent_category = get_categoryInfo($parent_id)['name'];
						if($parent_id == 0) $parent_category = 'None';
						
						$status 	= $row['status'];
						$created_at = new dateTime($row['created_at']);
						$created_at = $created_at->format('F d Y');

						$dataset[] = array('name' => $name, 'category_id' => $category_id, 'parent_category' => $parent_category, 'created_at' => $created_at, 'status' => ucwords($status));
					}
					$result['dataset']  = $dataset;

					$result['msg'] = $categories->num_rows . " records were found.";
				} else {
					$result['error'] = true;
					$result['msg'] = "No records found";
				}
			} else if($_GET['load'] == 'articles') {
				$result['status'] = 201;

				// var_dump($_POST); exit();
				$authorFilter = '';
				$categoryFilter = '';
				$statusFilter = '';

				if(isset($_POST['authorFilter'])) $authorFilter = $_POST['authorFilter'];
				if(isset($_POST['categoryFilter'])) $categoryFilter = $_POST['categoryFilter'];
				if(isset($_POST['statusFilter'])) $statusFilter = $_POST['statusFilter'];

				if(isset($_POST['order'])) {
					if($orderBy == '0') $orderBy = 'created_at';
					if($orderBy == '1') $orderBy = 'title';
					if($orderBy == '2') $orderBy = 'content';
					if($orderBy == '3') $orderBy = 'category_id';
					if($orderBy == '4') $orderBy = 'author_id';
					if($orderBy == '5') $orderBy = 'status';
				}
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
				`post_id` 
				FROM `posts` A LEFT JOIN `users` U ON U.`user_id` = A.`author_id` LEFT JOIN `categories` C ON C.`category_id` = A.`category_id` WHERE A.`status` NOT IN ('Deleted') ";
				// ORDER BY `reg_date` DESC
				if($searchParam) {
					$get_articles .= " AND (`full_name` LIKE '$searchParam%' OR `phone` LIKE '$searchParam%' OR `username` LIKE '$searchParam%' OR `email` LIKE '$searchParam%' OR `content` LIKE '%$searchParam%' OR `title` LIKE '$searchParam%' OR `name` LIKE '$searchParam%')";
				}

				if($authorFilter) {
					$get_articles .= " AND A.`author_id` = '$authorFilter'";
				}

				if($categoryFilter) {
					$get_articles .= " AND A.`category_id` = '$categoryFilter'";
				}

				if($statusFilter) {
					$get_articles .= " AND A.`status` LIKE '$statusFilter'";
				}

				if($orderBy && ($orderBy == 'created_at' || $orderBy == 'status')) {
					$get_articles .= " ORDER BY A.`$orderBy` $order";
				} else if($orderBy && ($orderBy == 'category_id')) {
					$get_articles .= " ORDER BY `name` $order";
				} else if($orderBy && ($orderBy == 'author_id')) {
					$get_articles .= " ORDER BY `full_name` $order";
				}

				$get_articles .= " LIMIT 0, ".$length;
				$articles = $GLOBALS['conn']->query($get_articles);
				if($articles->num_rows > 0) {
					$result['foundRows'] = $articles->num_rows;
					$result['error'] = false;

					while($row = $articles->fetch_assoc()) {
						$post_id 	= $row['post_id'];
						$title 		= $row['title'];
						$content 	= $row['content'];
						$excerpt 	= $row['excerpt'];
						$category_id = $row['category_id'];
						$author_id 	= $row['author_id'];
						$status 	= ucwords(str_replace("'", '', $row['status']));
						$created_at = new dateTime($row['created_at']);

						$created_at = $created_at->format('F d, Y');
						if(!$excerpt) $excerpt = substr($content, 0, 200);

						$category = $row['name'];
						$author 	= $row['full_name'];
						// $category = get_categoryInfo($category_id)['name'];
						// $author = get_userInfo($author_id)['full_name'];

						$dataset[] = array('post_id' => $post_id, 'excerpt' => $excerpt, 'title' => $title, 'category' => $category, 'category_id' => $category_id, 'author' => $author, 'author_id' => $author_id, 'status' => $status, 'created_at' => $created_at);
					}
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = $articles->num_rows;
					$result['iTotalDisplayRecords'] = $articles->num_rows;

					$result['msg'] = $articles->num_rows . " records were found.";
				} else {
					// $result['error'] = true;
					$result['msg'] = "No records found";
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = 0;
					$result['iTotalDisplayRecords'] = 0;
				}
			}
		} else {
			$result['msg'] = 'Incorrect action';
		}

		echo json_encode($result);
	} else if($_GET['action'] == 'update') {
		if(isset($_GET['update'])) {
			$updated_date = date('Y-m-d h:i:s');
			if($_GET['update'] == 'employee') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$user_id 	= $_POST['user_id'];
				$fullName 	= $_POST['fullName'];
				$phone 		= $_POST['phone'];
				$email 		= $_POST['email'];
				$slcRole 	= $_POST['slcRole'];
				$slcStatus 	= $_POST['slcStatus'];

				$twitter 	= $_POST['twitter'];
				$facebook 	= $_POST['facebook'];
				$web 		= $_POST['web'];
				$bio 		= $_POST['bio'];
				$linkedin 	= $_POST['linkedin'];

				$userActions = $userPrivileges = [];
				if(isset($_POST['userActions'])) $userActions 	= $_POST['userActions'];
				if(isset($_POST['userPrivileges'])) $userPrivileges	= $_POST['userPrivileges'];

				$actions 	= rtrim(implode(",", $userActions), ',');
				$privileges = rtrim(implode(",", $userPrivileges), ',');

				if(strtolower($role) != 'admin') {
					$result['msg'] = 'Can\'t edit system user.';
					$result['error'] = true;
					echo json_encode($result);
					exit();
				} else if($_SESSION['update'] != 'on') {
					$result['msg'] = 'Can\'t edit system user.';
					$result['error'] = true;
					echo json_encode($result);
					exit();
				} else if($_SESSION['delete'] != 'on' && strtolower($slcStatus) == 'deleted') {
					$result['msg'] = 'Can\'t deleted system user.';
					$result['error'] = true;
					echo json_encode($result);
					exit();
				}

				$updated_date = date('Y-m-d h:i:s');
		        $stmt = $GLOBALS['conn']->prepare("UPDATE `users` SET `full_name` =?, `phone` = ?, `email` = ?,  `role` = ?, `user_actions` =?, `user_privileges` =?, `twitter` =?, `facebook` =?, `web` =?, `bio` =?, `linkedin` =?, `status` = ?, `updated_date` = ?, `updated_by` = ? WHERE `user_id` = ?");
		        $stmt->bind_param("sssssssssssssss", $fullName, $phone, $email,  $slcRole, $actions, $privileges, $twitter, $facebook, $web, $bio, $linkedin, $slcStatus, $updated_date,  $myUser, $user_id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t edit employee details.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Employee editted succefully.';
		            $result['error'] = false;
		        }
			} else if($_GET['update'] == 'category') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$slcParentCategory = NULL;

				if(isset($_POST['slcParentCategory'])) $slcParentCategory = $_POST['slcParentCategory'];
				$categoryName = $_POST['categoryName'];
				$category_id = $_POST['category_id'];
				$slcCategoryStatus = $_POST['slcCategoryStatus'];

				if(strtolower($role) != 'admin') {
					$result['msg'] = 'Can\'t update category.';
					echo json_encode($result);
					exit();
				}

				// Check if username already exist
		        $check_exist = "SELECT `name` FROM `categories` WHERE `name` = '$categoryName' AND `status` <> 'deleted' AND `category_id` NOT IN ($category_id)";
		        $existSet = $GLOBALS['conn']->query($check_exist);
		        if($existSet->num_rows > 0) {
		            $result['msg'] = ' This category already exists.';
		            $result['error'] = true;
		            $result['errType'] = 'category';
		            echo json_encode($result); 
		            exit();
		        }

		        $stmt = $GLOBALS['conn']->prepare("UPDATE `categories` SET `name` =?, `status` =?, `parent_id` =?, `updated_at` =?, `updated_by` =? WHERE `category_id` = ?");
		        $stmt->bind_param("ssssss", $categoryName, $slcCategoryStatus, $slcParentCategory, $updated_date,  $myUser, $category_id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t update category.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Category editted succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else if($_GET['update'] == 'article') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;
				$result['error'] = false;

				$articleTitle = $_POST['articleTitle'];
				$slcArticleCategory = $_POST['slcArticleCategory'];
				$article = $_POST['article'];
				$excerpt = $_POST['excerpt'];
				$articleTags = $_POST['articleTags'];

				$post_id = $_POST['post_id'];
				$author_id = $_POST['slcAuthor4Edit'];

				$postInfo = get_post($post_id)[0];
				// var_dump($postInfo);
				$image = $postInfo['image'];

				$excerpt = substr(clean($article), 0, 200)."....";

				$stmt = $GLOBALS['conn']->prepare("UPDATE `posts` SET `title` =?, `image` =?, `content` =?, `excerpt` =?, `tags` =?, `author_id` =?, `status` =?, `category_id` =?, `updated_by` =?, `updated_at` =? WHERE `post_id` =?");
		        $stmt->bind_param("sssssssssss", $articleTitle, $image, $article, $excerpt, $articleTags, $author_id, $status, $slcArticleCategory, $myUser, $updated_date, $post_id);
		        $status = 'Draft';
		        $uploadOk = false;
				// Check if form is submitted and there is no error
				if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
					// Get file information
				    $target_dir = "../../assets/images/articles/";
				    $file_name = basename($_FILES["file"]["name"]);

				    $temp = explode(".", $_FILES["file"]["name"]);
			    	$newfilename = round(microtime(true)) . '.' . end($temp);

				    $target_file = $target_dir . $newfilename;
				    $uploadOk = true;

				    // Check if image file is a actual image or fake image
			        $check = getimagesize($_FILES["file"]["tmp_name"]);
			        if ($check == false) {
			            $result['error'] = true;
			            $result['msg'] = 'File is not an image.';
			            $uploadOk = false;
			            echo json_encode($result);
						exit();
			        }

			        // Check if file already exists
				    /*if (file_exists($target_file)) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, post image  already exists.";
			            echo json_encode($result);
						exit();
				    }*/

				    // Check file size (optional)
				    if ($_FILES["file"]["size"] > 5000000) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, your file is too large.";
			            echo json_encode($result);
						exit();
				    }

				    // Allow certain file formats
				    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "webp");
				    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
				    if (!in_array($file_extension, $allowed_extensions)) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			            echo json_encode($result);
						exit();
				    }

				    if($uploadOk) {
				    	$image = $newfilename;
				    	if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			            	$result['error'] = true;
		            		$result['msg'] = "Sorry, there was an error uploading your file.";
		            		echo json_encode($result);
							exit();
			            }
				    } else {
				        $result['error'] = true;
	            		$result['msg'] = "Sorry, your file was not uploaded. Article not saved";
	            		echo json_encode($result);
	            		exit();
				    }
				} /*else {
				    $result['error'] = true;
            		$result['msg'] = "No file uploaded or upload error. Article not saved";
            		echo json_encode($result);
            		exit();
				}*/

				if($stmt->execute()) {
                	$result['error'] = false;
            		$result['msg'] = "Article editted succefully.";
		            $result['id'] = $stmt->insert_id;
                } else {
                	$result['error'] = true;
            		$result['msg'] = "Something went wrong with data storing.";
            		echo json_encode($result);
					exit();
                }	
			} else if($_GET['update'] == 'articleStatus') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$status = $_POST['status'];
				$post_id = $_POST['post_id'];

		        $stmt = $GLOBALS['conn']->prepare("UPDATE `posts` SET `status` =?, `updated_at` =?, `updated_by` =? WHERE `post_id` = ?");
		        $stmt->bind_param("ssss", $status, $updated_date,  $myUser, $post_id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t update category.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Article status changed succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else {
				$result['msg'] = 'Incorrect action';
			}
		} else {
			$result['msg'] = 'Incorrect action';
		}
		echo json_encode($result);
	} else if($_GET['action'] == 'get') {
		if($_GET['get'] == 'category') {
			$category_id = $_POST['category_id'];
			$result = [];
			$get_category = "SELECT * FROM `categories` WHERE `category_id` = '$category_id'";
		    $categorySet = $GLOBALS['conn']->query($get_category);
		    while($row = $categorySet->fetch_assoc()) {
		    	$result[] = $row;
		    }
		    echo json_encode($result);
		} else if($_GET['get'] == 'post') {
			$post_id = $_POST['post_id'];
			$result = [];
			$get_post = "SELECT * FROM `posts` WHERE `post_id` = '$post_id'";
		    $postSet = $GLOBALS['conn']->query($get_post);
		    while($row = $postSet->fetch_assoc()) {
		    	$result[] = $row;
		    }
		    echo json_encode($result);
		}
	}
}




?>