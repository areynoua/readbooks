<?php get_header(); ?>
<!-- front-page.php -->
<section id="main-content" class="clearfix">
<?php
// Customizer Display Bookrev Slider
if(get_theme_mod("mp_display_slider",true) != "") get_template_part('templates/bookrev_slider_template');
?>

    <section id="main-content-inner" class="container">
<?php
// Display featured carousel template
if(get_theme_mod("mp_display_ffc") != "") get_template_part('templates/bookrev_feat_carousel_template');
// Display the sidebar on the left side if set.
if(get_theme_mod("mp_layout_type") == "sidebarleft") get_sidebar();
?>

    <div class="article-container">
<?php
// Display Latest Reviews Block Template
if(get_theme_mod("mp_display_lac") != "") get_template_part('templates/bookrev_latest_reviews_block_template');
// Display the Highlight of the day template
if(get_theme_mod("mp_display_hotd") != "") get_template_part('templates/bookrev_highlight_day_template');
// Display the articles list
get_template_part("templates/bookrev_articles_list_template");
?>
    </div><!-- end .article-container -->

<?php
// Display the sidebar on the right side if set.
if(get_theme_mod("mp_layout_type","sidebarright") == "sidebarright") get_sidebar();
?>
    </section><!-- end .main-content-inner -->

</section><!-- end #main-content -->
<?php get_footer(); ?>
