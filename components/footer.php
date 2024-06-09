<div class="container mt-5">
	<footer class="bg-white border-top p-3 text-muted small">
	<div class="row align-items-center justify-content-between">
		<div>
            <span class="navbar-brand mr-2"><strong>Hawlkar</strong></span> Copyright &copy;
			<script>document.write(new Date().getFullYear())</script>
			 . All rights reserved.
		</div>
	</div>
	</footer>
</div>
<!-- End Footer -->
    
<!--------------------------------------
JAVASCRIPTS
--------------------------------------->
<script src="<?=BASE_URI;?>/assets/js/vendor/jquery.min.js" type="text/javascript"></script>
<script src="<?=BASE_URI;?>/assets/js/vendor/popper.min.js" type="text/javascript"></script>
<script src="<?=BASE_URI;?>/assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=BASE_URI;?>/assets/js/functions.js" type="text/javascript"></script>

<script type="text/javascript">
	let category = '';
	<?php if(isset($_GET['menu'])) { ?>
		category = '<?=$_GET['menu'];?>';
	<?php } ?>
	/*document.addEventListener("DOMContentLoaded", (event) => {
		get_navbar();
		get_articles(category)
	});*/
</script>
</body>
</html>