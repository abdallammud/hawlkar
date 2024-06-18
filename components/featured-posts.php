
<section class="section first-section">
    <div class="container-fluid">
        <div class="masonry-blog clearfix">

            <?php 
            $featured_posts = get_featuredPosts();
            $post_num = 1;
            $side = "left-side";
            foreach ($featured_posts as $post ) {
                if($post_num == 2) $side = "center-side";
                if($post_num == 3) $side = "right-side";
            ?>

            <div class="<?=$side;?>">
                <div class="masonry-box post-media">
                     <img src="<?=BASE_URI;?>/assets/images/articles/<?=$post['image'];?>" alt="" class="img-fluid">
                     <div class="shadoweffect">
                        <div class="shadow-desc">
                            <div class="blog-meta">
                                <span class="bg-aqua"><a href="<?=BASE_URI;?>/<?=$post['name'];?>" title=""><?=$post['name'];?></a></span>
                                <h4><a href="<?=BASE_URI;?>/article/<?=$post['post_id'];?>" ><?=$post['title'];?></a></h4>
                                <small><a href="<?=BASE_URI;?>/<?=$post['name'];?>" title=""><?=formatDate($post['created_at']);?></a></small>
                                <small><a title="">by <?=$post['full_name'];?></a></small>
                            </div><!-- end meta -->
                        </div><!-- end shadow-desc -->
                    </div><!-- end shadow -->
                </div><!-- end post-media -->
            </div>





            <?php 
                $post_num ++;
            }






            ?>



         





        </div><!-- end masonry -->
    </div>
</section>