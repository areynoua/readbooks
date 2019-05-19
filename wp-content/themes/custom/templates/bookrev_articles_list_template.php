<!-- templates/bookrev_articles_list_template.php -->
<?php while( have_posts() ) : the_post(); ?>
    <article class="clearfix" id="post-<?php the_ID(); ?>">
        <div class="feat-img">
            <a href="<?php the_permalink(); ?>">
				<?php 
                $img_url = get_post_meta($post->ID, 'text_img', true);
                if(isset($img_url) && $img_url != "") {
                    echo '<img src="'.$img_url.'">';
                } else {
					$def = get_theme_mod('default-article-image-upload');
					if( !empty($def) ) {
						echo '<img src="'.$def.'">';
					} else {
						echo '<div class="no-img"><p>No preview</p></div>';
					}
                }
				?>
            </a>
<?php /*
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
*/ ?>

        </div><!-- end .feat-img -->
        <div class="content">
            <header>
                <a href="<?php the_permalink(); ?>" class="title"><?php echo the_title(); ?></a>
                <div class="meta">
					<span class="text_author"><a href="#"><?php echo get_post_meta($post->ID, 'text_author', true); ?></a></span>
                    <span class="categ"><?php the_category(' , '); ?></span>
                    <span class="date">/ <?php echo get_the_date(); ?></span>
					<span class="text_type"><?php echo listTermsToText(wp_get_post_terms($post->ID, "PublicationTypes")); ?></span>
					<span class="text_theme"><?php echo listTermsToText(wp_get_post_terms($post->ID, 'Theme')); ?></span>
                </div><!-- end .meta -->
            </header>
			<ul class="POI-previews">
<?php
$args = array(
  'post_parent' => $post->ID,
  'post_type'   => 'document_point', 
  'numberposts' => -1, 
  'post_status' => 'any' 
);
$children = get_children($args);
foreach ($children as $document_point) :
?>				
				<li><a href="<?php echo $document_point->guid; ?>" class="title"><?php echo $document_point->post_title; ?></a></li>
<?php endforeach; ?>
			</ul>
            <?php /*
				<p>	<?php book_rev_lite_get_limited_content(get_the_ID() , 440, '...'); ?> </p>
			*/ ?>
        </div><!-- end .content -->

    </article>



<?php  endwhile;

    the_posts_pagination( array(
        'prev_text'          => __( '&#171;', 'book-rev-lite' ),
        'next_text'          => __( '&#187;', 'book-rev-lite' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'book-rev-lite' ) . ' </span>',
    ) ); ?>