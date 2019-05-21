<?php /* $dpt (required) WP_post: document_point
       * $dpt_tag (default: article)
       * $pdt_print_doc (default: false)
       */
$dpt_id = $dpt->ID;
$dpt_link = $dpt->guid;
$dpt_author_id = $dpt->post_author;
$authorInfo = get_user_by('id', $dpt_author_id);
$dpt_author_name = $authorInfo->data->display_name;
$listCategory = get_post_meta($dpt_id, 'category');
if (!isset($dpt_tag)) { $dpt_tag = 'article'; }
$dpt_print_doc = isset($dpt_print_doc) && $dpt_print_doc;
?>

    <<?php echo $dpt_tag; ?> class="clearfix summary document_point" data-category="<?php echo '[\''.implode('\',\'', $listCategory).'\']'; ?>">
        <a href="<?php echo $dpt_link; ?>" class="title pre-title"><?php echo $dpt->post_title; ?></a>
        <div class="feat-img">
            <a href="<?php echo $dpt_link; ?>">
                <?php echo get_avatar($dpt_author_id, 64); ?>
            </a>
            <div class="comment-count">
                <i class="fa fa-comments"></i>
                <?php echo $dpt->comment_count; ?>
            </div><!-- end .comment-count -->
        </div><!-- end .feat-img -->
		<?php if ($dpt_print_doc): ?>
			<p>About: <a class="title" style="font-size: small" href="<?php echo get_the_permalink($dpt->post_parent) ?>"><?php echo get_post($dpt->post_parent)->post_title; ?></a></p><br/>
		<?php endif; ?>
        <div class="content">
            <header>
                <?php if(get_post_meta($dpt_id, 'point_approved', true) == 1) {
                    echo '<span class="approved-icon" title="approved"><i class="fa fa-star"></i></span>';
                } ?>
                <a href="<?php echo $dpt_link; ?>" class="title"><?php echo $dpt->post_title; ?></a>
                <div class="meta">
                    <span class="author"><?php echo $dpt_author_name; ?></span>
                    <span class="date"><?php echo get_the_date(get_option('date_format'), $dpt_id); ?></span>
                </div><!-- end .meta -->
            </header>
            <div class="poi-content-excerpt">
                <?php echo format_preview_text($dpt->post_content); ?>
            </div>
            <div>
                <?php echo wpc_avg_rating_custom(array('title' => 'Rating'), array('post_id' => $dpt_id)); ?>
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
                <a href="<?php echo $dpt_link; ?>">Read more</a>
            </div>
        </div><!-- end .content -->
    </<?php echo $dpt_tag; ?>>