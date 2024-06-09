<?php require('new_article.php'); ?>
<div class="page-content">
	<p class="data-table-heading center-items flex space-bw mr-b-20 mr-t-10 mfs-8 bold">
		<span>ALL ARTICLES</span>
		<!-- <a href="./articles/create"  class="mbtn cursor primary">Add Article</a> -->

		<button type="button" data-bs-toggle="modal" data-bs-target="#addArticle" class="mbtn cursor primary">Add Article</button>
	</p>
	<div class="row justify-end">
		<div class="col-lg-3">
			<div class="form-group">
            	<label class="label" for="authorFilter">Author <span class="form-error">This is required</span></label>
            	<select type="text" class="form-control" id="authorFilter" name="authorFilter">
                	<option value="">All</option>
                	<?php 
                        $get_users = "SELECT * FROM `users` WHERE `status` NOT IN ('deleted') AND `user_id` IN (SELECT `author_id` FROM `posts`)";
                        $users = $GLOBALS['conn']->query($get_users);
                        while($usersRow = $users->fetch_assoc()) {
                            $full_name = $usersRow['full_name'];
                            $user_id = $usersRow['user_id'];

                            echo '<option value="'.$user_id.'">'.$full_name.'</option>';
                        }

                	?>
            	</select>
        	</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
            	<label class="label" for="categoryFilter">Category <span class="form-error">This is required</span></label>
            	<select type="text" class="form-control" id="categoryFilter" name="categoryFilter">
                	<option value="">All</option>
                	<?php 
                        $get_categories = "SELECT * FROM `categories` WHERE `status` NOT IN ('deleted')";
                        $categories = $GLOBALS['conn']->query($get_categories);
                        while($categoriesRow = $categories->fetch_assoc()) {
                            $name = $categoriesRow['name'];
                            $category_id = $categoriesRow['category_id'];

                            echo '<option value="'.$category_id.'">'.$name.'</option>';
                        }

                	?>
            	</select>
        	</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
            	<label class="label" for="statusFilter">Status <span class="form-error">This is required</span></label>
            	<select type="text" class="form-control" id="statusFilter" name="statusFilter">
                	<option value="">All</option>
                	<option value="Darft">Darft</option>
                	<option value="Published">Published</option>
                	<option value="Deleted">Deleted</option>
            	</select>
        	</div>
		</div>
	</div>
	<table style="width: 100%;" class="table mfs-8  mcon mfs-9 table-striped " id="articlesDataTable"></table>
</div>
<?php require('article_dp.php'); ?>
<script>
	addEventListener("DOMContentLoaded", (event) => {
		let authorFilter = $('#authorFilter').val();
		let categoryFilter = $('#categoryFilter').val();
		let statusFilter = $('#statusFilter').val();
	    loadArticles(authorFilter, categoryFilter, statusFilter);

	    $('#authorFilter, #categoryFilter, #statusFilter').on('change', (e) => {
	    	authorFilter = $('#authorFilter').val();
			categoryFilter = $('#categoryFilter').val();
			statusFilter = $('#statusFilter').val();
			loadArticles(authorFilter, categoryFilter, statusFilter);
	    })

	    articles();
	});
</script>