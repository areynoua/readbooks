	    <section class="featured-carousel newsblock">

	        <header class="clearfix">

	            <h2><?php book_rev_lite_string_template_category_replace('mp_fcb_title', 'mp_ffc_cat', 'category_selected'); ?></h2>

	            <div class="cycle-nav">

	                <div class="prev"><i class="fa fa-chevron-left"></i></div>

	                <div class="next"><i class="fa fa-chevron-right"></i></div>

	            </div><!-- end .cycle-nav -->

	        </header>

	        <section class="carousel-slides cycle-slideshow" data-cycle-slides=".slide" data-cycle-prev=".featured-carousel .prev" data-cycle-next=".featured-carousel .next"  data-cycle-timeout="0">



				<?php

				$args = "cat=".get_theme_mod("mp_ffc_cat"); 

				$query = new WP_Query($args);



				if($query->have_posts()):

					while($query->have_posts()): $query->the_post();

						$book_rev_lite_link = get_permalink(get_the_ID()); ?>



		            <article class="slide clearfix">

		                <div class="feat-img">

		                    <a href="<?php echo esc_url($book_rev_lite_link); ?>">
								<?php 
								if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
									the_post_thumbnail('single-post-thumbnail');
								} 
								else {
									$def = get_theme_mod('default-article-image-upload');
									if( !empty($def) ) {
										echo '<img src="'.$def.'">';
									}
								}
								?>
							</a>

		                    <div class="comment-count">

		                        <i class="fa fa-comments"></i>

		                        <a href="<?php echo get_comments_link(get_the_ID()); ?>"><?php comments_number("0", "1", "%"); ?></a>

		                    </div><!-- end .comment-count -->

							<?php $grade = book_rev_lite_get_review_grade(get_the_ID()); ?>

                            <span class="grade <?php echo book_rev_lite_display_review_class($grade); ?>"> <?php if(!empty($grade)) book_rev_lite_display_review_grade($grade); ?> </span>

		                </div><!-- end .feat-img -->



		                <div class="article-content">

		                    <header>

		                        <a href="<?php echo esc_url($book_rev_lite_link); ?>" class="title"><h3><?php the_title(); ?></h3></a>

		                        <div class="meta">

		                            <span class="category"><?php the_category(' , '); ?></span>

		                            <span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>

		                        </div><!-- end .article-meta -->

		                    </header>

		                    <div class="content">

		                        <p><?php book_rev_lite_get_limited_content(get_the_ID(), 550, '...'); ?></p>

		                    </div><!-- end .content -->

		                </div><!-- end .article-content -->

		            </article><!-- end .slide -->	





			  <?php endwhile;

				endif;

				wp_reset_postdata();  ?>

	



	        </section><!-- end .carousel-slides -->

	    </section><!-- end .featured-carousel -->