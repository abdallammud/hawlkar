<?php require('config/functions.php');?>  
<?php require('components/header.php');?>

<div id="wrapper">
    <?php //require("./components/topbar.php"); ?>
    <!-- end topbar -->

    <?php require("./components/logo-header.php"); ?> 
    <!-- end header -->

    <?php require("./components/navbar.php");?> 

    <?php $article = get_signleArticle($_GET['article'])[0]; ?>

    <!-- <div class="page-title wb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h2><i class="fa fa-leaf bg-green"></i> Blog</h2>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blog</li>
                    </ol>
                </div>                
            </div>
        </div>
    </div> -->

     <section class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-wrapper">
                        <div class="blog-title-area">
                            <span class="color-green"><a href="garden-category.html" title=""><?=$article['name'];?></a></span>

                            <h3><?=$article['title'];?></h3>

                            <div class="blog-meta big-meta">
                                <small><a href="garden-single.html" title=""><?=formatDate($article['created_at']);?></a></small>
                                <small><a href="blog-author.html" title="">by <?=$article['full_name'];?></a></small>
                                <small><a href="#" title=""><i class="fa fa-eye"></i> <?=$article['views'];?></a></small>
                            </div><!-- end meta -->

                            <div class="post-sharing">
                                <ul class="list-inline">
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https://hawlkar.com/article/<?=$article['post_id'];?>" target="_blank" rel="noopener noreferrer" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url=https://hawlkar.com/article/<?=$article['post_id'];?>" target="_blank" rel="noopener noreferrer" class="tw-button btn " style="background-color: #333 !important;"><i class="fa fa-times"></i> <span class="down-mobile">Tweet on X</span></a></li>
                                    
                                </ul>
                            </div><!-- end post-sharing -->
                        </div><!-- end title -->

                        <div class="single-post-media">
                            <img style="height:460px; width: 800px;" src="<?=BASE_URI;?>/assets/images/articles/<?=$article['image'];?>" alt="" class="img-fluid">
                        </div><!-- end media -->

                        <div class="blog-content">  
                            <div class="pp">
                            	<?=$article['content'];?>
                            </div><!-- end pp -->
                        </div><!-- end content -->

                        <div class="blog-title-area">
                            <div class="tag-cloud-single">
                                <span class="btn btn-primary py-1">Tags</span>
                                <?php  
                                $tags = explode(",", $article['tags']);
                                foreach ($tags as $tag) {
                                	echo '<small><a>'.$tag.'</a></small>';
                                }


                                ?>
                                
                               
                            </div><!-- end meta -->

                            <div class="post-sharing">
                                <ul class="list-inline">
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https://hawlkar.com/article/<?=$article['post_id'];?>" target="_blank" rel="noopener noreferrer" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url=https://hawlkar.com/article/<?=$article['post_id'];?>" target="_blank" rel="noopener noreferrer" class="tw-button btn " style="background-color: #333 !important;"><i class="fa fa-times"></i> <span class="down-mobile">Tweet on X</span></a></li>
                                    
                                </ul>
                            </div><!-- end post-sharing -->
                        </div><!-- end title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="banner-spot clearfix">
                                    <div class="banner-img">
                                        <img src="upload/banner_01.jpg" alt="" class="img-fluid">
                                    </div><!-- end banner-img -->
                                </div><!-- end banner -->
                            </div><!-- end col -->
                        </div><!-- end row -->

                        <hr class="invis1">

                        <div class="custombox authorbox clearfix">
                            <h4 class="small-title">About author</h4>
                            <div class="row">
                                <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <img src="upload/author.jpg" alt="" class="img-fluid rounded-circle"> 
                                </div> --><!-- end col -->

                                <div style="padding-left: 30px;" class="col-lg-12 col-md-10 col-sm-10 col-xs-12">
                                	<?php $author = get_authorInfo($article['author_id']);  ?>
                                    <h4><a href="#"><?=$author['full_name'];?></a></h4>
                                    <p><?=$author['bio'];?></p>

                                    <div class="topsocial">
                                    	<?php if($author['facebook']) { ?>
                                        	<a href="<?=$author['facebook'];?>" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook"></i></a>
                                        <?php } if($author['twitter']) { ?>
                                        	<a href="<?=$author['twitter'];?>" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter"></i></a>
                                        <?php } if($author['web']) { ?>
	                                        <a href="<?=$author['web'];?>" data-toggle="tooltip" data-placement="bottom" title="Website"><i class="fa fa-link"></i></a>
	                                    <?php } ?>
                                    </div><!-- end social -->

                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end author-box -->

                        <hr class="invis1">

                        <div class="custombox clearfix">
                            <h4 class="small-title">You may also like</h4>
                            <div class="row">
                            	<?php 
                            		$relatedPosts = get_articles4Category($article['category_id'], 4); 
                            		foreach ($relatedPosts as $related) { 
                            			if($related['post_id'] != $article['post_id']) {
                            		?>
                            			<div class="col-lg-6">
		                                    <div class="blog-box">
		                                        <div class="post-media">
		                                            <a href="<?=BASE_URI;?>/article/<?=$related['post_id'];?>" title="">
		                                                <img style="height:200px" src="<?=BASE_URI;?>/assets/images/articles/<?=$related['image'];?>" alt="" class="img-fluid">
		                                                <div class="hovereffect">
		                                                    <span class=""></span>
		                                                </div><!-- end hover -->
		                                            </a>
		                                        </div><!-- end media -->
		                                        <div class="blog-meta">
		                                            <h4><a href="<?=BASE_URI;?>/article/<?=$related['post_id'];?>" title=""><?=$related['title'];?></a></h4>
		                                            <small><a href="<?=BASE_URI;?>/<?=$related['name'];?>" title=""><?=$related['name'];?></a></small>
		                                            <small><a href="<?=BASE_URI;?>/article/<?=$related['post_id'];?>" title=""><?=formatDate($related['created_at']);?></a></small>
		                                        </div><!-- end meta -->
		                                    </div><!-- end blog-box -->
		                                </div>
                            		<?php } }
                            	?>
                                <!-- end col -->

                                
                            </div><!-- end row -->
                        </div><!-- end custom-box -->

                        <hr class="invis1">
                        
                    </div><!-- end page-wrapper -->
                </div><!-- end col -->

                <?php require("./components/most-viewed-posts.php");?>
            </div><!-- end row -->
        </div><!-- end container -->
    </section>

 	<?php require("./components/footer-content.php");?>
    
</div><!-- end wrapper -->

<?php require("./components/footer.php");?>

<script type="text/javascript">
    get_mostViewed();
</script>

<style type="text/css">
	.widget.search-widget {
		display: none;
	}
</style>

<?php
$_SESSION['readThis'] = false;
if(!isset($_SESSION['readThis'])) {
	add_articleView($article['post_id']);
	$_SESSION['readThis'] = true;
}
?>