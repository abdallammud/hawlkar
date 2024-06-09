<div class="page-content">

	<p class="data-table-heading center-items flex space-bw mr-b-20 mr-t-10 mfs-8 bold">
		<span>ALL CATEGORIES</span>
		<button type="button" data-bs-toggle="modal" data-bs-target="#addCategory" class="mbtn cursor primary">Add Category</button>
	</p>
	<table style="width: 100%;" class="table mfs-8  mcon mfs-9 table-striped " id="categoriesTable"></table>
</div>
<?php require('category_dp.php'); ?>
<script>
	addEventListener("DOMContentLoaded", (event) => {
	    loadCategories();
	    // articles();
	});
</script>