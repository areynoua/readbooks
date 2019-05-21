<?php get_header(); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        $argsFetchDocumentPoint = array(
            'post_parent' => $post->ID,
            'post_type'   => 'document_point', 
            'numberposts' => -1,
            'post_status' => 'any' 
        );
        $childrenDocumentPoint = get_children($argsFetchDocumentPoint);
        $childrenDocumentPoint = order_post_by_score($childrenDocumentPoint);

        $argsFetchRequestPoint = array(
            'post_parent' => $post->ID,
            'post_type'   => 'point_request', 
            'numberposts' => -1,
            'post_status' => 'any' 
        );
        $childrenRequestPoint = get_children($argsFetchRequestPoint);

        ?>
		
		
		<ul class="inner-nav">
			<li><p><a href="#document-search">Points of interest</a></p></li>
			<li><p><a href="#requests">POI requests</a></p></li>
			<li><p><a href="#new_doc_form">Add a / Request for POI</a></p></li>
		</ul>

        <?php if(!empty($childrenDocumentPoint) || !empty($childrenRequestPoint)) { ?>
        <div style="margin-top: 10px;">
            <input type="text" value="" class="point-search" id="document-search" placeholder="Search point of interest"  />
        </div>
        <?php }

        $listCategory = get_list_category_of_document($post->ID);
        if(!empty($listCategory)) { ?>
            <div><br />
                Filter: 
                <?php foreach ($listCategory as $category) {
                    $color = get_category_color($category);
                    echo '<span class="badge badge-pill category-button selective" ' . 
                                'data-selected="false" data-category="'.$category.'" '.
                                'style="border: 1px solid ' . $color . ';background-color: ' . $color . ';">' . 
                            ucfirst($category) .
                            ' <span class="unselect" style="display: none;background-color: ' . $color . '">x</span>' .
                        '</span>';
                }?>
                <br />
            </div>
        <?php }
        
        if(count($childrenDocumentPoint) > 0) {
            echo '<h4>Point of interests</h4>';
        }
        foreach ($childrenDocumentPoint as $document_point) { 
            $document_point_id = $document_point->ID;
            $document_point_link = $document_point->guid;
            $document_point_author_id = $document_point->post_author;
            $authorInfo = get_user_by('id', $document_point_author_id);
            $document_point_author_name = $authorInfo->data->display_name;
            $listCategory = get_post_meta($document_point_id, 'category'); ?>

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
                            echo '<span class="approved-icon" title="approved"><i class="fa fa-star"></i></span>';
                        } ?>
                        <a href="<?php echo $document_point_link; ?>" class="title"><?php echo $document_point->post_title; ?></a>
                        <div class="meta">
                            <span class="author"><?php echo $document_point_author_name; ?></span>
                            <span class="date"><?php echo get_the_date(get_option('date_format'), $document_point_id); ?></span>
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

            <?php
            if(!empty($childrenRequestPoint)) {
                echo '<div><h4 id="requests">Request point of interests</h4>';

                $listSkill = get_list_skill_of_request_list($childrenRequestPoint);
                if(!empty($listSkill)) {
                    echo '<div>';
                    echo 'Select skills: ';
                    foreach ($listSkill as $slug => $skillName) {
                        echo '<span class="badge badge-pill skill-button selective" ' . 
                                'data-selected="false" data-skill="'.$slug.'">' . 
                            ucfirst($skillName) .
                            ' <span class="unselect" style="display: none;">x</span>' .
                        '</span>';
                    }
                    echo '</div>';
                }

                foreach ($childrenRequestPoint as $point_request) { 
                    $point_request_id = $point_request->ID;
                    $linkToCreate = get_site_url().'/reply-to-point-of-interest-request/?id='.$point_request_id;
                    $point_request_author_id = $point_request->post_author;
                    $authorInfo = get_user_by('id', $point_request_author_id);
                    $point_request_author_name = $authorInfo->data->display_name;
                    $listCategory = get_post_meta($point_request_id, 'category'); 
                    $listSkills = wp_get_post_terms($point_request_id, 'Skills'); ?>
                    <article class="clearfix summary document_point" 
                            data-category="<?php echo '[\''.implode('\',\'', $listCategory).'\']'; ?>" 
                            data-skill="<?php echo (empty($listSkills)) ? '' : $listSkills[0]->slug; ?>"
                            id="request-<?php echo $point_request_id ?>">
                        <a href="<?php echo $linkToCreate; ?>" class="title pre-title"><?php echo $point_request->post_title; ?></a>
                        <div class="content">
                            <header>
                                <a href="<?php echo $linkToCreate; ?>" class="title"><?php echo $point_request->post_title; ?></a>
                                <div class="meta">
                                    <span class="author"><?php echo $point_request_author_name; ?></span>
                                    <span class="date"><?php echo get_the_date(get_option('date_format'), $point_request_id); ?></span>
                                </div><!-- end .meta -->
                            </header>
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
                            <?php 
                            if(!empty($listSkills)) {
                                echo '<div>';
                                echo '<b>Required skill:</b> ';
                                echo listTermsToText($listSkills,
                                    '<a href="' . get_site_url() . '/skills/%term%/">',
                                    '</a>');
                                echo '</div>';
                            }
                            ?>
                        </div><!-- end .content -->
                    </article>
                <?php }
                echo '</div>';
            } ?>
		      
            <div class="form-container" id="new_doc_form">
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
                    <div class="warning-protected-content">
                        <b>Remark:</b><br />
                        By posting a comment, you agree not to violate any intellectual law. This includes not using proprietary content and quote sources.
                    </div>
    				<?php Ninja_Forms()->display(7); ?>
    			</div>

                <div class="tabcontent" id="document_point_request">
                    <h2>
                        Request a point of interest
                    </h2>
                    <?php Ninja_Forms()->display(8); ?>
                </div>
            </div>

        <?php // get_template_part("templates/bookrev_review_wrap_up_template"); ?>
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


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
var postId = <?php echo $post->ID; ?>;
var availableTags = <?php echo '["' . implode('", "', get_all_categories()) . '"]'; ?>

</script>
<script src="<?php echo get_template_directory_uri(). "/../custom/js/form_point_document.js"; ?>"></script>
<script>
    var listSelectCategory = []
    var searchWord = "";
    var selectSkill = "";
    var selectSkillElement = null;

    jQuery.each(jQuery('.category-button.selective'), function(k, buttonValue) {
        jQuery(buttonValue).click(function() {
            var category = jQuery(this).data('category')
            var selected = jQuery(this).data('selected');

            switchSelectElement(jQuery(this))

            // If the category was selected
            if(selected) {
                // remove this category
                console.log('before:')
                console.log(listSelectCategory)
                listSelectCategory.splice(listSelectCategory.indexOf(category), 1)
                console.log('Pop:' + category)
            } else {
                listSelectCategory.push(category)
            }

            console.log('Select ' + category + " -> " + selected + " [" + listSelectCategory + "]")
            // Test if select or not
            hideOrShowPoint();
        });
    });

    function switchSelectElement(categoryElement) {
        var selected = categoryElement.data('selected');
        categoryElement.data('selected', !selected);
        switchColorElement(categoryElement, selected)
    }

    function switchColorElement(selectElement, selected) {
        if(selected) {
            var color = selectElement.css('color');
            selectElement.css('color', 'white');
            selectElement.css('background-color', color);
            selectElement.find('.unselect').hide();
        } else {
            var color = selectElement.css('background-color');
            selectElement.css('color', color);
            selectElement.css('background-color', 'white');
            selectElement.find('.unselect').show();
        }
    }


    jQuery.each(jQuery('.skill-button.selective'), function(k, buttonValue) {
        jQuery(buttonValue).click(function() {
            var skill = jQuery(this).data('skill')

            if(selectSkill == skill) {
                switchColorElement(jQuery(this), true)
                selectSkill = "";
                selectSkillElement = null;
            } else {
                if(selectSkillElement !== null) {
                    switchColorElement(selectSkillElement, true);
                }
                switchColorElement(jQuery(this), false)
                selectSkill = skill;
                selectSkillElement = jQuery(this);
            }
            // console.log('Select ' + category + " -> " + selected + " [" + listSelectCategory + "]")
            // // Test if select or not
            hideOrShowPoint();
        });
    });


    function hideOrShowPoint() {
        jQuery("article.document_point").filter(function() {
            jQuery(this).toggle(
                jQuery(this).text().toLowerCase().indexOf(searchWord) > -1
                &&
                jQuery(eval(jQuery(this).data('category'))).filter(listSelectCategory).size() == listSelectCategory.length
                &&
                ((typeof jQuery(this).data('skill') === 'undefined' || 
                    jQuery(this).data('skill') == "" || 
                    selectSkill == "") ? true : jQuery(this).data('skill') == selectSkill));
        });
    }

    jQuery("#document-search").on("keyup", function() {
        searchWord = jQuery(this).val().toLowerCase();
        hideOrShowPoint()
      });
</script>

<script>
function openTab(evt, tabName) {
    jQuery.each(jQuery('.tabcontent'), function(k, tabContent) {
        jQuery(tabContent).hide();
    });
    jQuery.each(jQuery('.tablinks span'), function(k, tabLink) {
        jQuery(tabLink).removeClass('active');
    });

    jQuery('.tabcontent#'+tabName).show();
    jQuery('.tablinks.'+tabName+' span').addClass('active');
}
</script>

