<?php require('config/functions.php');?>  
<?php require('components/header.php');?>

<div id="wrapper">
    <?php //require("./components/topbar.php"); ?>
    <!-- end topbar -->

    <?php require("./components/logo-header.php"); ?> 
    <!-- end header -->

    <?php require("./components/navbar.php");?> 
    <!-- end header -->

    <?php require("./components/featured-posts.php");?>
    <!-- end top three -->
    <section class="section wb">
        <div class="container">
            <div class="row">
                <?php require("./components/all-posts.php");?>
                <!-- All posts -->

                <?php require("./components/most-viewed-posts.php");?>
                <!-- recent posts -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section>

    <?php require("./components/footer-content.php");?>
    
</div><!-- end wrapper -->

<?php require("./components/footer.php");?>

<script type="text/javascript">
    let category = '';
    let page = 1;
    <?php if(isset($_GET['menu'])) { ?>
        category = '<?=$_GET['menu'];?>';
    <?php } ?>

    <?php if(isset($_GET['page'])) { ?>
        page = '<?=$_GET['page'];?>';
    <?php } ?>

    let data = {"category": category, "page":page}
    get_mostViewed();
    get_allPosts(data);
</script>