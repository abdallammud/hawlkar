<div class="modal fade" data-bs-focus="false" id="editArticle" tabindex="-1" role="dialog" aria-labelledby="editArticleLabel" aria-hidden="true">
    <div class="modal-dialog " role="Category" style="max-width:1200px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; margin-top: -15px; " onsubmit="return editArticle(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="editArticleLabel">Edit Article</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editArticleForm">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="label" for="title4Edit">Title <span class="form-error">This is required</span></label>
                                <input type="hidden" id="post_id">
                                <input  type="text" placeholder="Article title" class="form-control"  id="title4Edit" >
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="label" for="category4ArticleEdit">Category <span class="form-error">This is required</span></label>
                                <select type="text" class="form-control" id="category4ArticleEdit" name="category4ArticleEdit">
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
                        <div class="col-lg-3">
                            <div class="mb-3 form-group">
                                <label for="articleImage4Edit" class="form-label label">Article image <span class="form-error">This is required</span></label>
                                <input style="padding:2px;" class="form-control cursor" type="file" id="articleImage4Edit">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="label" for="slcAuthor4Edit">Author <span class="form-error">This is required</span></label>
                                <select type="text" class="form-control" id="slcAuthor4Edit" name="slcAuthor4Edit">
                                    <option value="">Select</option>
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
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <!-- <label class="label" for="missingSerial">Article <span class="form-error">This is required</span></label> -->
                               <textarea id="article4Edit" rows="10">Howdy! Happy writng!</textarea>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <div class="col col-sm-12">
                                    <div class="form-group">
                                        <textarea id="excerpt4Edit" rows="10">Excerpt </textarea>
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

<div class="modal fade" data-bs-focus="false" id="editArticleStatus" tabindex="-1" role="dialog" aria-labelledby="editArticleStatusLabel" aria-hidden="true">
    <div class="modal-dialog " role="ArticleStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return editArticleStatus(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleStatusLabel">Edit Article Status</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addArticleStatusForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcArticleStatus">Status <span class="form-error">This is required</span></label>
                                <input type="hidden" id="post_id4StatusChange">
                                <select class="form-control"  id="slcArticleStatus" >
                                    <option value="Darft">Darft</option>
                                    <option value="Published">Publish</option>
                                    <option value="Deleted">Delete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">Apply</button>
            </div>
        </form>
    </div>
</div>
<script>
    addEventListener("DOMContentLoaded", (event) => {
        // loadArticles();
        articles();

        tinymce.init({
            selector: 'textarea#article4Edit',
            height : "350",
            setup: function(ed) {
                ed.on('keyup', function(event) {
                    let article = tinyMCE.get('article4Edit').getContent();
                    tinyMCE.get('excerpt4Edit').setContent('');
                    if (article.length > 200) article = article.slice(0,200) 
                    tinyMCE.get('excerpt4Edit').setContent(article);             
                });

                // ed.on('init', function(){
                //     this.execCommand("fontName", false, "tahoma");
                //     this.execCommand("fontSize", false, "12px");
                // });
            }
        });

        tinymce.init({
            selector: 'textarea#excerpt4Edit',
            height : "250",

        });
    });
</script>