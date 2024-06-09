<?php require('config/functions.php');?>  
<?php require('components/header.php');?>
<!--------------------------------------
NAVBAR
--------------------------------------->
<?php require('components/navbar.php');?>
<!-- End Navbar -->
    
    
<!--------------------------------------
HEADER
--------------------------------------->
<?php require('components/hero.php');?>
<!-- End Header -->
 
    
<!--------------------------------------
MAIN
--------------------------------------->
    
<!-- Featured stories -->
    
<div class="container">
	<div class="row justify-content-between">
		<div class="col-md-8" id="all-articles">
			<h5 class="font-weight-bold spanborder"><span>All Articles</span></h5>
			<!-- <div class="mb-3 d-flex justify-content-between">
				<div class="pr-3">
					<h2 class="mb-1 h4 font-weight-bold">
					<a class="text-dark" href="./article.html">Nearly 200 Great Barrier Reef coral species also live in the deep sea</a>
					</h2>
					<p>
						There are more coral species lurking in the deep ocean that previously thought.
					</p>
					<div class="card-text text-muted small">
						 Jake Bittle in SCIENCE
					</div>
					<small class="text-muted">Dec 12 &middot; 5 min read</small>
				</div>
				<img height="120" src="./assets/img/demo/blog8.jpg">
			</div> -->
			<div class="row">
				<?php echo all_articles()['all_articles']; ?>
				<!-- <div class="col-md-6 col-lg-4 col-ms-12"> -->
					
				<!-- </div> -->
			</div>
			<?php //echo all_articles()['all_articles']; ?>
		</div>
		<div class="col-md-4 pl-4">
            <h5 class="font-weight-bold spanborder"><span>Popular</span></h5>
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