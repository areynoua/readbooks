<!-- comment-form.php -->
<?php
    $commenter = wp_get_current_commenter();
    $id = get_the_ID();
    $allow_comment_reviews = get_theme_mod("allow_comment_reviews");
    $default_review_cat = get_theme_mod("mp_reviews_cat");

    if(isset($commenter['comment_author_website'])) {
        $commenter['comment_author_website'] = esc_attr($commenter['comment_author_website']);
    } else {
        $commenter['comment_author_website'] = "";
    }

    $default_fields = array(
        'author' => '<input name="author" type="text" placeholder="'.__("Name", "book-rev-lite").'" aria-required="true" value='. esc_attr( $commenter['comment_author'] ) .'>',
        'email'  => '<input name="email" type="text" placeholder="'.__("Email", "book-rev-lite").'" aria-required="true" value='. esc_attr( $commenter['comment_author_email'] ) .'>',
        'url'    => '<input name="url" type="text" placeholder="'.__("Website", "book-rev-lite").'" value='. esc_attr( $commenter['comment_author_website'] ) .'>',
     ); 

    $default_args = array(
        'fields' => $default_fields,
        'comment_field' => "<textarea id='comment-content' name='comment' aria-required='true' placeholder='" . __("Your Message...;", "book-rev-lite") . "'></textarea>"
    );

    // If Comment Reviews are allowed, and is a single article posted in the default reviews category
    // then modify the fields in order for the commenteers to post reviews in their comments. 

    if($allow_comment_reviews && is_single() && book_rev_lite_wpr_get_status()=="Yes") {
        for ($i=1; $i < 6; $i++)
			$meta_options['meta_option_'.$i] = get_post_meta($id, 'option_'.$i.'_content', true);
        foreach ($meta_options as $k => $value)
			if(empty($meta_options[$k]))
				unset($meta_options[$k]);
        foreach ($meta_options as $k => $value) {
            $fields[$k] =
            "<div class='comment-form-meta-option'>
                <label for='$k'>$meta_options[$k]</label>
                <input type='text' id='$k' class='meta_option_input' value='0' name='$k' readonly='readonly'>
                <div class='comment_meta_slider'></div>
                <div class='clearfix'></div>
            </div>"; 
        }
    }
 ?>
<?php
if(is_page()) {
?>
    <div id="add-new-comment">
        <div class="anc-container">
            <?php comment_form($default_args); ?>
        </div>
    </div><!-- end #add-new-comment -->
<?php
} elseif(is_single()) {
	$args = array();
	if (book_rev_lite_wpr_get_status()=="Yes") {
		$args = array();
	}
	comment_form($args);
}
?>