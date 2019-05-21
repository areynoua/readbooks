<!-- templates/bookrev_articles_list_template.php -->
<?php while( have_posts() ) : the_post(); ?>
	<article class="clearfix book-metadata" id="post-<?php the_ID(); ?>">
            <?php 
                $tmt = $post;
                $link_to_book = true;
                $tmt_points_preview = true;
                $tmt_cover_placeholder = true;
                require("readbook_text_metadata_template.php");
            ?>
    </article>



<?php  endwhile;

    the_posts_pagination( array(
        'prev_text'          => __( '&#171;', 'book-rev-lite' ),
        'next_text'          => __( '&#187;', 'book-rev-lite' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'book-rev-lite' ) . ' </span>',
    ) ); ?>