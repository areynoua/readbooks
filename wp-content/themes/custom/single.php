<?php get_header(); ?>
<!-- Single Post Theme -->


<section id="main-content" class="clearfix">

    <section id="main-content-inner" class="container">

    <div class="article-container post clearfix">

        <?php while ( have_posts() ) : the_post(); ?>

        <header class="clearfix">

            <div class="article-details">
                
                <h1 class="title"><?php the_title(); ?></h1>

                <div class="meta">
                    <span class="date"><?php the_time( get_option( 'date_format' ) ); ?></span>

                </div><!-- end .meta -->

            </div><!-- end .article-details -->  

        </header>

           

        <article <?php post_class("clearfix"); ?>> <?php the_content(); ?>
        
        <div class="article-tags">
            <i class="fa fa-tags"></i>
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