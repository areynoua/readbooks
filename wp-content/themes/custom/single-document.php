<?php
$len_content = 200;
?>

<?php get_header(); ?>
<!-- single-book Theme -->
<section id="main-content" class="clearfix">
    <section id="main-content-inner" class="container">
    <div class="article-container post clearfix">

        <?php while ( have_posts() ) : the_post(); ?>
        <header class="book-metadata">
            <h1 class="title pre-title"><?php the_title(); ?></h1>

            <?php if(get_post_meta($post->ID, 'text_img', true) != "") : ?>
            <img class="text-img" src="<?php echo get_post_meta($post->ID, 'text_img', true); ?>" />
            <?php endif; ?>

            <h1 class="title"><?php the_title(); ?></h1>

            <div class="meta col-items">
				<!-- TODO make clickable (category and theme) to make automaticaly a research -->
                <div class="author">
					<span><i class="fa fa-pencil"></i> Author:</span>
					<span><a href="#"><?php echo get_post_meta($post->ID, 'text_author', true); ?></a></span>
				</div>
				<div class="date">
					<span><i class="fa fa-calendar"></i> Publish date:</span>
					<span><?php the_time( get_option( 'date_format' ) ); ?></span>
				</div>
				<div class="category">
					<span><i class="fa fa-list"></i> Category:</span>
					<span><?php echo listTermsToText(wp_get_post_terms($post->ID, "PublicationTypes")); ?></span>
				</div>
			    <div class="theme">
					<span><i class="fa fa-tags"></i> Theme:</span>
					<span><?php echo listTermsToText(wp_get_post_terms($post->ID, 'Theme')); ?></span>
				</div>
            </div>
			<?php if(get_post_meta($post->ID, 'text_link', true) != "") { ?>
			<span class="link"><a target="_blank" href="<?php echo get_post_meta($post->ID, 'text_link', true); ?>"><i class="fa fa-external-link"></i> Get the Text</a></span>
			<?php } ?>
			<div></div>
        </header>

        <div><br />
            <?php foreach (get_list_category_of_document($post->ID) as $category) {
                echo '<span class="badge badge-pill category-button selective" data-selected="false" data-category="'.$category.'" style="background-color: ' . get_category_color($category) . ';">' . $category .'</span>';
            }?>
            <br />
        </div>
        
<?php
$args = array(
	'post_parent' => $post->ID,
	'post_type'   => 'document_point', 
	'numberposts' => -1,
	'post_status' => 'any' 
);
$children = get_children($args);
foreach ($children as $document_point) { 
  $document_point_id = $document_point->ID;
  $document_point_link = $document_point->guid;
  $document_point_author_id = $document_point->post_author;
  $authorInfo = get_user_by('id', $document_point_author_id);
  $document_point_author_name = $authorInfo->data->display_name;
  $listCategory = get_post_meta($document_point_id, 'category');
?>
            <article class="clearfix summary document_point" data-category="<?php echo '[\''.implode('\',\'', $listCategory).'\']'; ?>">
				<a href="<?php echo $document_point_link; ?>" class="title pre-title"><?php echo $document_point->post_title; ?></a>
                <div class="feat-img">
                    <a href="<?php echo $document_point_link; ?>">
                        <?php echo get_avatar($document_point_author_id, 64); ?>
                    </a>
                    <div class="comment-count">
                        <i class="fa fa-comments"></i>
                        <?php echo $document_point->comment_count; ?>
                    </div><!-- end .comment-count -->
                </div><!-- end .feat-img -->
                <div class="content">
                    <header>
                        <a href="<?php echo $document_point_link; ?>" class="title"><?php echo $document_point->post_title; ?></a>
                        <div class="meta">
                            <span class="author"><?php echo $document_point_author_name; ?></span>
                            <span class="date"><?php echo get_the_date(); ?></span>
                        </div><!-- end .meta -->
                    </header>
					<div class="poi-content-excerpt">
                    	<?php echo substr($document_point->post_content, 0, $len_content); if(strlen($document_point->post_content) > $len_content) { echo '...'; } ?>
					</div>

                    <?php echo wpc_avg_rating_custom(array('title' => 'Rating'), array('post_id' => $document_point_id)); ?>

                    <div>
                        <?php foreach ($listCategory as $category) {
                            echo '<a href="#" style="border: 1px solid gray;border-radius: 15px; padding: 2px; margin: 5px;color: white;background-color: ' . get_category_color($category) . ';">' . $category .'</a>';
                        } ?>
                    </div>

					<div class="read-more">
						<a href="<?php echo $document_point_link; ?>">Read more</a>
					</div>
                </div><!-- end .content -->
            </article>
			<?php } ?>
		
			<div class="form-container">
				<h2>
					Add a point of interest
				</h2>
				<?php Ninja_Forms()->display(7); ?>
			</div>
<?php	
// DEBUG
//echo '<pre>';
//print_r($children);
//echo '</pre>';
// echo '<pre>';
// print_r($authorInfo);
// echo '</pre>';

?>
        <?php get_template_part("templates/bookrev_review_wrap_up_template"); ?>
        <?php wp_link_pages(); ?>

        <?php endwhile; ?>

        <nav class="nav-single link-pages">
            <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'book-rev-lite' ) . '</span> %title' ); ?></span>
            <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'book-rev-lite' ) . '</span>' ); ?></span>
            <div style="clear:both;"></div>
        </nav><!-- .nav-single -->
        <?php comments_template(); ?>
    </div><!-- end .article-container -->
    <?php get_sidebar(); ?>
    </section><!-- end .main-content-inner -->
</section><!-- end #main-content -->

<?php get_footer(); ?>

<script>
    function addInput() {
        $('#nf-field-45-container').css('display', 'none');
        jQuery( '#nf-field-45').val(<?php echo $post->ID; ?>).trigger( 'change' );
    }

    $(function() {
        setTimeout(addInput, 1000);
    });



    $.each($('.category-button.selective'), function(k, buttonValue) {
        $(buttonValue).click(function() {
            var category = $(this).data('category')
            var selected = $(this).data('selected');

            $(this).data('selected', !selected);


            console.log('Select ' + category + " -> " + selected)
            // Test if select or not
            $.each($('article.document_point'), function(k, pointValue) {
                pointValue = $(pointValue);
                var listPointCategory = eval(pointValue.data('category'));
                // If the category correspond and we unselect
                if(listPointCategory.includes(category) && !selected) {
                    pointValue.show();
                // If the category doesn't correspond and we select
                } else if(!listPointCategory.includes(category) && selected) {
                    pointValue.hide();
                }
            }); 
        });
    });

</script>