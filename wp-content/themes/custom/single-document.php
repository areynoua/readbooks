<?php get_header(); ?>
<!-- single-document Theme -->
<section id="main-content" class="clearfix">
    <section id="main-content-inner" class="container">
    <div class="article-container post clearfix">

        <?php while ( have_posts() ) : the_post(); ?>
        <header class="book-metadata">
            <?php 
			$tmt = $post;
			require("templates/readbook_text_metadata_template.php");
			?>
        </header>

        <?php
        $listCategory = get_list_category_of_document($post->ID);
        if(!empty($listCategory)) { ?>
            <div><br />
                Select categories: 
                <?php foreach ($listCategory as $category) {
                    $color = get_category_color($category);
                    echo '<span class="badge badge-pill category-button selective" ' . 
                                'data-selected="false" data-category="'.$category.'" '.
                                'style="border: 1px solid ' . $color . ';background-color: ' . $color . ';">' . 
                            ucfirst($category) .
                            ' <span class="unselect" style="display: none;">x</span>' .
                        '</span>';
                }?>
                <br />
            </div>
        <?php } ?>

        <div>
            <input type="text" value="" placeholder="Search point of interest" />
        </div>
        
<?php
$args = array(
	'post_parent' => $post->ID,
	'post_type'   => 'document_point', 
	'numberposts' => -1,
	'post_status' => 'any' 
);
$children = get_children($args);
$children = order_post_by_score($children);
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
                        <?php if(get_post_meta($document_point_id, 'point_approved', true) == 1) {
                            echo '[V]';
                        } ?>
                        <a href="<?php echo $document_point_link; ?>" class="title"><?php echo $document_point->post_title; ?></a>
                        <div class="meta">
                            <span class="author"><?php echo $document_point_author_name; ?></span>
                            <span class="date"><?php echo get_the_date(); ?></span>
                        </div><!-- end .meta -->
                    </header>
					<div class="poi-content-excerpt">
                        <?php echo format_preview_text($document_point->post_content); ?>
					</div>
                    <div>
                        <?php echo wpc_avg_rating_custom(array('title' => 'Rating'), array('post_id' => $document_point_id)); ?>
                    </div>

                    <div>
                        <?php foreach ($listCategory as $category) {
                            $color = get_category_color($category);
                            echo '<span class="badge badge-pill category-button" ' . 
                                        'data-selected="false" data-category="'.$category.'" '.
                                        'style="border: 1px solid ' . $color . ';background-color: ' . $color . ';">' . 
                                    ucfirst($category) .
                                    ' <span class="unselect" style="display: none;">x</span>' .
                                '</span>';
                        } ?>
                    </div>

					<div class="read-more">
						<a href="<?php echo $document_point_link; ?>">Read more</a>
					</div>
                </div><!-- end .content -->
            </article>
			<?php } ?>
		      
            <div class="form-container">
                <ul class="tab">
                    <li class="tablinks document_point" onclick="openTab(event, 'document_point')">
                        <span class="active">
                            Add a point of interest
                        </span>
                    </li>
                    <li class="tablinks document_point_request" onclick="openTab(event, 'document_point_request')">
                        <span>
                            Request a point of interest
                        </span>
                    </li>
                </ul>

    			<div class="tabcontent" id="document_point" style="display: block;">
    				<h2>
    					Add a point of interest
    				</h2>
    				<?php Ninja_Forms()->display(7); ?>
    			</div>

                <div class="tabcontent" id="document_point_request">
                    <h2>
                        Request a point of interest
                    </h2>
                    <?php Ninja_Forms()->display(8); ?>
                </div>
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
var postId = <?php echo $post->ID; ?>;
</script>
<script src="<?php echo get_template_directory_uri(). "/../custom/js/form_point_document.js"; ?>"></script>
nf-field-53
<script>
    var listSelectCategory = []

    $.each($('.category-button.selective'), function(k, buttonValue) {
        $(buttonValue).click(function() {
            var category = $(this).data('category')
            var selected = $(this).data('selected');

            switchCategory($(this))

            // If the category was selected
            if(selected) {
                // remove this category
                listSelectCategory.pop(category)
            } else {
                listSelectCategory.push(category)
            }

            console.log('Select ' + category + " -> " + selected + " [" + listSelectCategory + "]")
            // Test if select or not
            $.each($('article.document_point'), function(k, pointValue) {
                pointValue = $(pointValue);

                if(listSelectCategory.length > 0) {
                    var listPointCategory = eval(pointValue.data('category'));
                    // If one category of this document_point is in the listSelectCategory
                    if($(listPointCategory).filter(listSelectCategory).size() == listSelectCategory.length) {
                        pointValue.show();
                    } else {
                        pointValue.hide();
                    }
                } else {
                    pointValue.show();
                }
            }); 
        });
    });

    function switchCategory(categoryElement) {
        var selected = categoryElement.data('selected');
        categoryElement.data('selected', !selected);
        if(selected) {
            var color = categoryElement.css('color');
            categoryElement.css('color', 'white');
            categoryElement.css('background-color', color);
            categoryElement.find('.unselect').hide();
        } else {
            var color = categoryElement.css('background-color');
            categoryElement.css('color', color);
            categoryElement.css('background-color', 'white');
            categoryElement.find('.unselect').show();
        }
    }

</script>

<script>
function openTab(evt, tabName) {
    $.each($('.tabcontent'), function(k, tabContent) {
        $(tabContent).hide();
    });
    $.each($('.tablinks span'), function(k, tabLink) {
        $(tabLink).removeClass('active');
    });

    $('.tabcontent#'+tabName).show();
    $('.tablinks.'+tabName+' span').addClass('active');
}
</script>