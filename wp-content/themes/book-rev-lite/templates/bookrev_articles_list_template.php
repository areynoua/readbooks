<?php while( have_posts() ) : the_post(); ?>

    <article class="clearfix" id="post-<?php the_ID(); ?>">

        <div class="feat-img">

            <a href="<?php the_permalink(); ?>">
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

            <?php
            $grade = book_rev_lite_get_review_grade( get_the_ID() );
            if ( ! empty( $grade ) ) {
                echo '<span class="grade ' . book_rev_lite_display_review_class( $grade ) . '">';
                book_rev_lite_display_review_grade( $grade );
                echo '</span>';
            }
            ?>

        </div><!-- end .feat-img -->

        <div class="content">

            <header>

                <a href="<?php the_permalink(); ?>" class="title"><?php echo the_title(); ?></a>

                <div class="meta">

                    <span class="categ"><?php the_category(' , '); ?></span>

                    <span class="date">/ <?php echo get_the_date(); ?></span>

                </div><!-- end .meta -->

            </header>

            <p> <?php book_rev_lite_get_limited_content(get_the_ID() , 440, '...'); ?> </p>

        </div><!-- end .content -->

    </article>



<?php  endwhile;

    the_posts_pagination( array(
        'prev_text'          => __( '&#171;', 'book-rev-lite' ),
        'next_text'          => __( '&#187;', 'book-rev-lite' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'book-rev-lite' ) . ' </span>',
    ) ); ?>