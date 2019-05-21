<?php $rating_img = '<a href="https://wordpress.org/support/plugin/wp-post-comment-rating/reviews/?filter=5" target="_blank">
<img src=" '.plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/five_stars_rating.png" style="width: 54px;vertical-align: top;"></a>';
 //$message = _e('<span>Thank you for using WP Post Rating. Please rate '.$rating_img.'</span>', 'wp-post-comment-rating');
 printf( esc_html__( 'Thank you for using WP Post Rating. Please rate %s', 'wp-post-comment-rating' ), $rating_img );