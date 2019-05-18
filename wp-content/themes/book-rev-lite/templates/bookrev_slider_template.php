<?php

$default_cat = get_categories();

$cat = 0;
if( !empty($default_cat) ) {
    if ( ! empty( $default_cat[0]->cat_ID ) ) {
        $cat = get_theme_mod( 'mp_slider_cat', $default_cat[0]->cat_ID );
    }
}

$args = array('cat' => (int)$cat); ?>



<section id="slider">

    <div class="container cycle-slideshow" data-cycle-slides=".slide" data-cycle-prev=".cycle-prev" data-cycle-next=".cycle-next">

<?php $query = new WP_Query($args);

		if($query->have_posts()) :

			while ($query->have_posts()) :

				$query->the_post();

                $book_rev_lite_link = get_permalink(get_the_ID()); ?>

            <div class="slide clearfix" id="slide-<?php echo get_the_ID(); ?>">

                <div class="book-cover">

					<?php
					$book_rev_lite_wpr_get_product_image = book_rev_lite_wpr_get_product_image();

					if( !empty($book_rev_lite_wpr_get_product_image) ) {
						echo ' <a href="'.esc_url($book_rev_lite_link).'">';
							echo '<img src="'.esc_url($book_rev_lite_wpr_get_product_image).'">';
						echo '</a>';
					}
					?>

                </div><!-- end .book-cover -->



                <div class="slide-description">

                    <div class="inner-sd">

                        <div class="top-sd-head clearfix">

                            <div class="tsh-left">

                            <h2 class="sd-title"><a href="<?php echo esc_url($book_rev_lite_link); ?>"><?php echo get_the_title(); ?></a></h2>

                            </div><!-- end .tsh-left -->



                            <?php $grade = book_rev_lite_get_review_grade(get_the_ID()); if(!empty($grade)): ?>



                            <span class="grade <?php echo book_rev_lite_display_review_class($grade); ?>"> <?php book_rev_lite_display_review_grade($grade);?> </span> <?php endif; ?>

                        </div><!-- end .top-sd-head -->



                        <div class="sd-body">

                            <p><?php book_rev_lite_get_limited_content(get_the_ID(), 450, '...'); ?></p>

                        </div><!-- end .sd-body -->



                        <div class="sd-meta">

                            <span class="sd-comments">

                                <a href="<?php echo get_comments_link(get_the_ID()); ?>"><i class="fa fa-comments"></i> <?php comments_number(__("No Comments", "book-rev-lite"), __("1 Comment", "book-rev-lite"), __("% Comments", "book-rev-lite")); ?></a>

                            </span><!-- end .sd-comments -->



                            <span class="sd-author">

                                <i class="fa fa-user"></i> <?php the_author(); ?>

                            </span><!-- end .sd-author -->

                            <a class="read-more" href="<?php echo esc_url($book_rev_lite_link); ?>"><?php _e("Read More", "book-rev-lite"); ?></a>

                        </div><!-- end .sd-meta -->

                    </div><!-- end .inner-sd -->

                </div><!-- end .slide-description -->

            </div><!-- end .slide -->

<?php endwhile; endif; wp_reset_postdata(); ?>

        <div class="cycle-pager"></div>

    </div><!-- end .container .cycle-slideshow -->

    <div class="cycle-prev"><i class="fa fa-chevron-left"></i></div>

    <div class="cycle-next"><i class="fa fa-chevron-right"></i></div>

</section><!-- end #slider -->



