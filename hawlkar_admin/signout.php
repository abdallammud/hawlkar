<?php
require('./incs/utils.php');
setLoginInfo($_SESSION['user_id'], true);
session_start();
session_destroy();
header("Location: ./login");
?>