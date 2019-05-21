<!-- templates/bookrev_loop_article_template.php -->
<?php
$book_rev_lite_link = get_permalink(get_the_ID());

if ($post->post_type == 'document') :
?>
<article class="clearfix book-metadata" id="post-<?php the_ID(); ?>">
	<?php 
	$tmt = $post;
	$link_to_book = true;
	$tmt_points_preview = true;
	$tmt_cover_placeholder = true;
	require("readbook_text_metadata_template.php");
	?>
</article>
<?php
else : if ($post->post_type == 'document_point') :

	$dpt = $post;
	$dpt_print_doc = true;
	include "readbook_poi_summary_template.php";

else :
?>
            <article class="clearfix">
				<pre><?php print_r($post); ?></pre>

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

                        <a href="<?php echo esc_url($book_rev_lite_link); ?>" class="title"><?php echo the_title(); ?></a>

                        <div class="meta">

                            <span class="categ"><?php the_category(' , '); ?></span>

                            <span class="date">/ <?php echo get_the_date(); ?></span>

                        </div><!-- end .meta -->

                    </header>

                    <p><?php the_excerpt(); ?></p>

                </div><!-- end .content -->

            </article>
<?php
endif; endif;
?>