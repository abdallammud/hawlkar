<!-- Large, medium -->
<?php 
$active = 'dashboard';
if(isset($_GET['menu'])) $active = $_GET['menu'];

?>
<div class="app-sidebar bg-black-900 Large sidebar">
    <ul>
        <?php if($_SESSION['dashboard'] == 'on') { ?>
        <li>
            <a href="./" class="white-50 <?php if($active == 'dashboard') echo 'active'; ?>">
                <i class="bi bi-columns-gap"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php } if($_SESSION['articles'] == 'on') { ?>
        <li>
            <a href="./articles" class="white-50 <?php if($active == 'articles') echo 'active'; ?>">
                <i class="bi bi-file-post"></i>
                <span>Articles</span>
            </a>
        </li>
        <?php } if($_SESSION['categories'] == 'on') { ?>
        <li>
            <a href="./categories" class="white-50 <?php if($active == 'categories') echo 'active'; ?>">
                <i class="bi bi-table"></i>
                <span>Categories</span>
            </a>
        </li>
        <?php } if($_SESSION['users'] == 'on') { ?>
        <li>
            <a href="./users" class="white-50 <?php if($active == 'users') echo 'active'; ?>">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li>
        <?php } if($_SESSION['settings'] == 'on') { ?>
        <li>
            <a href="./setting" class="white-50 <?php if($active == 'settings') echo 'active'; ?>">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>
        <?php }  ?>

        <!-- <li>
            <a href="">
                <i class="bi bi-currency-dollar"></i>
                <span>Sales</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="bi bi-people"></i>
                <span>Customers</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="bi bi-graph-up"></i>
                <span>Reports</span>
            </a>
        </li>
        <li>
            <a href="">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li> -->
    </ul>
</div>
<div class="sidebar-overlay"></div>