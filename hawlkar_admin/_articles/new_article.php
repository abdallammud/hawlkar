<div class="modal fade" data-bs-focus="false" id="addArticle" tabindex="-1" role="dialog" aria-labelledby="addArticleLabel" aria-hidden="true">
    <div class="modal-dialog " role="Category" style="max-width:1200px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; margin-top: -15px; " onsubmit="return submitArticle(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleLabel">ADD ARTICLE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addArticleForm">
                    <div class="row">
						<div class="col col-lg-5">
							<div class="form-group">
				                <label class="label required" for="articleTitle">Article title <span class="form-error">This is required</span></label>
				                <input  type="text" placeholder="Article title" class="form-control"  id="articleTitle" >
				            </div>
						</div>
						<div class="col col-lg-3">
							<div class="form-group">
				                <label class="label" for="slcArticleCategory">Category <span class="form-error">This is required</span></label>
				                <select type="text" class="form-control" id="slcArticleCategory" name="slcArticleCategory">
				                    <option value="">Select</option>
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
						<div class="col col-lg-4">
							<div class="mb-3 form-group">
								<label for="articleImage" class="form-label label">Article image <span class="form-error">This is required</span></label>
								<input style="padding:2px;" class="form-control cursor" type="file" id="articleImage">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col col-lg-8">
							<div class="form-group">
				                <textarea id="article" rows="10">Howdy! Happy writng!</textarea>
				            </div>
						</div>
						<div class="col col-lg-4">
							<div class="row">
								<div class="col col-sm-12">
									<div class="form-group">
										<textarea id="excerpt" rows="10">Excerpt </textarea>
									</div>
								</div>
								<div class="col col-sm-12">
									<div class="mb-3 form-group">
										<label for="articleTags" class="form-label label">Tags</label>
										<input type="text" placeholder="E.g: Technology, AI, OpenAI" class="form-control"  id="articleTags" >
									</div>
								</div>
								<div class="col col-sm-12">
									<button type="submit" class="mbtn cursor primary ld-ext-right running full ">
										<span class="text">Submit</span>
										<span class="ld loader " ></span>
									</button>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
	addEventListener("DOMContentLoaded", (event) => {
	    // loadArticles();
	    articles();

	    tinymce.init({
			selector: 'textarea#article',
			height : "380",
			setup: function(ed) {
		        ed.on('keyup', function(event) {
		            let article = tinyMCE.get('article').getContent();
		            tinyMCE.get('excerpt').setContent('');
		            if (article.length > 200) article = article.slice(0,200) 
		            tinyMCE.get('excerpt').setContent(article);	            
		        });
		    }
		});

		tinymce.init({
			selector: 'textarea#excerpt',
			height : "250",

		});
	});
</script>