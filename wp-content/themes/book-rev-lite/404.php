<?php get_header(); ?>



<!-- parent 404.php -->
<section id="main-content" class="clearfix">



    <?php 

        // Customizer Display Bookrev Slider

    	if(get_theme_mod("mp_display_slider",true) != "") get_template_part('templates/bookrev_slider_template');

    ?>



    <section id="main-content-inner" class="container">



	<?php 

		// Display the sidebar on the left side if set.

		if(get_theme_mod("mp_layout_type") == "sidebarleft") get_sidebar();

	?>



    <div class="article-container not-found-page">

        <h1><?php _e("404 Error!", "book-rev-lite"); ?></h1>

        <h3><?php _e("The page you are looking for could not be found!", "book-rev-lite"); ?></h3>

    </div><!-- end .article-container -->



	<?php

		// Display the sidebar on the right side if set.

		if(get_theme_mod("mp_layout_type","sidebarright") == "sidebarright") get_sidebar();

	?>



    </section><!-- end .main-content-inner -->

</section><!-- end #main-content -->



<?php get_footer(); ?>





