<?php require('config/functions.php');?>  
<?php require('components/header.php');?>
<!--------------------------------------
NAVBAR
--------------------------------------->
<?php require('components/navbar.php');?>
<!-- End Navbar -->
 <div class="container">
	<div class="row justify-content-between">
		<div class="col-md-8">
			<h5 class="font-weight-bold spanborder">
				<span>All Articles</span>
			</h5>
			<?php echo get_signleArticle($_GET['article']); ?>
		</div>
		<div class="col-md-4 pl-4">
            <h5 class="font-weight-bold spanborder">
            	<span>Popular</span>
            </h5>
			<ol class="list-featured">
				<?php echo all_articles()['popular']; ?>
			</ol>
		</div>
	</div>
</div>

    
<!--------------------------------------
FOOTER
--------------------------------------->
<?php require('components/footer.php');?>