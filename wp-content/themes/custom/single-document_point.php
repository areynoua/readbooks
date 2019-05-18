<?php get_header(); ?>
<!-- single-book_summary Theme -->



<section id="main-content" class="clearfix">

    <section id="main-content-inner" class="container">

    <div class="article-container post clearfix">

        <?php while ( have_posts() ) : the_post(); ?>

        <header class="clearfix">

            <div class="article-details summary-details">
                
                <h1 class="title"><?php the_title(); ?></h1>

                <div class="meta col col-left">
                    <span class="author"><i class="fa fa-pencil"></i> Author: <a href="#"><?php echo get_post_meta($post->ID, 'text_author', true); ?></a></span><br />
                    <span class="date"><i class="fa fa-calendar"></i> Publish date: <?php the_time( get_option( 'date_format' ) ); ?></span>

                </div>

                <div class="meta col">
                    <!-- TODO make clickable (category and theme) to make automaticaly a research -->
                    <span class="category"><i class="fa fa-list"></i> Category: <?php echo listTermsToText(wp_get_post_terms($post->ID, "PublicationTypes")); ?></span><br />
                    <span class="theme"><i class="fa fa-tags"></i> Theme: <?php echo listTermsToText(wp_get_post_terms($post->ID, 'Theme')); ?></span>
                </div>

                <div class="meta">
                    <?php if(get_post_meta($post->ID, 'text_link', true) != "") { ?>
                        <span class="link"><a target="_blank" href="<?php echo get_post_meta($post->ID, 'text_link', true); ?>"><i class="fa fa-external-link"></i> Link to have the book</a></span>
                    <?php } ?>
                </div>
                <!-- end .meta -->

            </div><!-- end .article-details -->  

        </header>

        <article <?php post_class("clearfix"); ?>>
            <?php if(get_post_meta($post->ID, 'text_img', true) != "") {
                echo '<img class="text-img" src="' . get_post_meta($post->ID, 'text_img', true) . '" />';
            } ?>
            <h2>Summary:</h2>
            <?php the_content(); ?>
        
        <div class="article-tags">
            Write by: <?php the_author(); ?>
        <?php the_tags( __( 'Tags: ', 'book-rev-lite' ), __( ', ', 'book-rev-lite' ), '<br />' ); ?> 
        </div>

        </article>

        

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