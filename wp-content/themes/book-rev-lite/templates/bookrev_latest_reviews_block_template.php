        <section id="latest-reviews-block" class="newsblock clearfix">

            <header>

                <h2><?php book_rev_lite_string_template_category_replace('mp_lab_title', 'mp_lab_cat', 'category_selected'); ?></h2>

            </header>



            <?php 

                $noPosts = get_theme_mod('mp_lab_count');

                $cat = get_theme_mod('mp_lab_cat');

                $args = array(

                    'posts_per_page'    => $noPosts,

                    'cat'               => $cat,

                    'orderby'          => 'post_date',

                    'order'            => 'DESC',

                );



                $posts = get_posts($args);

             ?>



            <div class="lrb-inner clearfix">

                <nav class="lrb-navigation">

                    <div class="nav-top">

                        <i class="fa fa-angle-up"></i>

                    </div><!-- end .nav-top -->

                    <ul>

                        <?php $i = 0;  ?>

                        <?php foreach($posts as $post) : setup_postdata($post); ?>

                        <li class="article-link <?php if($i==0) echo "active"; ?>" id="<?php the_ID(); ?>">

                            <h2 class="article-title">

                                <a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>

                            </h2><!-- end .article-title -->

                            <div class="article-meta">

                                <span class="categ"><?php the_category(' , '); ?></span>

                                <span class="date"><?php echo get_the_date(); ?></span>

                            </div><!-- end .article-meta -->

                        </li><!-- end .article-link -->

                        <?php $i++; ?>

                        <?php endforeach; ?>



                    </ul>

                    <div class="nav-bottom">

                        <i class="fa fa-angle-down"></i>

                    </div><!-- end .nav-top -->

                </nav><!-- end .lrb-navigation -->

                <div class="article-display ">



                <?php $i = 0; ?>

                <?php foreach($posts as $post) {

                 setup_postdata($post); ?>

                    

                    <div class="article-content <?php if($i==0) echo "active"; ?>" id="<?php the_ID(); ?>">

                        <header>

                            <h3 class="article-title"><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></h3>

                            <div class="a-details">

                                <span class="category"><?php the_category(' , '); ?></span>

                                <span class="date">/ <?php echo get_the_date(); ?></span>

                            </div><!-- end .a-details -->

                        </header>

                            <div class="article-text clearfix"> <?php book_rev_lite_get_limited_content(get_the_ID(), 850, '...'); ?> </div><!-- end .article-text -->

                    </div><!-- end .article-content -->



                <?php $i++; }  ?>



                </div><!-- end .article-display -->

            </div><!-- end .lrb-inner -->

        </section><!-- end #latest-reviews-block -->