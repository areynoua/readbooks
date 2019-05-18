<?php
if(!class_exists('WP_Customize_Control')){
	return;
}

class Bookrev_Info extends WP_Customize_Control {
	public $type = 'info';
	public $label = '';
	public function enqueue() {
		wp_enqueue_style( 'bookrev-theme-info-control', get_template_directory_uri().'/css/theme-info.css','1.0.0' );
	}


	public function render_content() {
		echo '<div class="bookrev-theme-info">';
		echo sprintf( '<a href="http://docs.themeisle.com/article/185-bookrev-lite-documentation" target="_blank">%s</a>', esc_html__( 'View Documentation', 'book-rev-lite' ) );
		echo '<hr/>';
		echo sprintf( '<a href="https://wordpress.org/support/theme/book-rev-lite/reviews/" target="_blank">%s</a>', esc_html__( 'Leave a review', 'book-rev-lite' ) );
		echo '</div>';
	}
}
