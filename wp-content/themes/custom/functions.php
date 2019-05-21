<?php
/**
** activation theme
**/
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles() {
    wp_enqueue_style('book-rev-lite', get_template_directory_uri() . '/style.css');
}

require_once(get_template_directory() . "/../custom/templates/bookrev_comments_cb_template.php");
