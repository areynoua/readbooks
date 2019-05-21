<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

    <!-- Meta Tags -->

    <meta http-equiv="Content-Type" content="text/html" charset="<?php bloginfo( 'charset' ); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <link rel="profile" href="http://gmpg.org/xfn/11" />

<?php if ( is_singular() && pings_open( get_queried_object() ) ) { ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php } ?>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header id="main-header">

    <section id="top-bar" class="clearfix">

        <div class="container">

            <nav id="top-bar-menu">

                    <?php wp_nav_menu( array( 'theme_location'   => 'secondary') ); ?>

            </nav><!-- end #top-bar-menu -->



            <?php get_search_form(); ?>

        </div><!-- end .container -->

    </section><!-- end #top-bar -->



    <section id="inner-header" class="clearfix">

        <div class="container">


            <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                the_custom_logo();
                if (is_customize_preview()){ ?>
                    <div class="logo bookrev-hidden-preview">
                        <h1 itemprop="headline" id="site-title" class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                        <p itemprop="description" id="site-description" class="site-description">
			                <?php bloginfo( 'description' ); ?>
                        </p>
                    </div>
                    <?php
                }
            } else {?>
                <div class="logo">
                    <h1 itemprop="headline" id="site-title" class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			                <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                    <p itemprop="description" id="site-description" class="site-description">
		                <?php bloginfo( 'description' ); ?>
                    </p>
                </div>
                <?php
            } ?>


            <section id="ad-banner">

                <?php

                    if(get_theme_mod("head_display_ad",false)) {

                        $ad_banner_img = get_theme_mod('header-ad-img');

                        $ad_banner_url = get_theme_mod('header-ad-url');

                        $ad_banner_alt = get_theme_mod("header-ad-alt");



                        if( !empty($ad_banner_img))

                        {

                            echo "<a href='" . esc_url($ad_banner_url) . "'><img title='" . esc_attr($ad_banner_alt) . "' alt='" . esc_attr($ad_banner_alt) . "' src='" . esc_url($ad_banner_img) . "' /></a>";

                        } 

                    }

                ?>

            </section><!-- end #ad-banner -->

        </div><!-- end .container -->

    </section><!-- end #inner-header -->



    <section id="main-menu" class="clearfix">

        <div class="container">

            <nav>

                <ul>

                    <?php wp_nav_menu( array( 'theme_location'   => 'primary') ); ?>

                </ul>

            </nav><!-- end #main-menu -->



            <section id="menu-social-icons">

                <ul>

                    <?php

                    $social_links = array(

	                    array( 'gplus_href', 'fa-google-plus' ),

	                    array( 'facebook_href', 'fa-facebook' ),

	                    array( 'twitter_href', 'fa-twitter' ),

	                    array( 'instagram_href', 'fa-instagram' ),

	                    array( 'pinterest_href', 'fa-pinterest' ),

	                    array( 'youtube_href', 'fa-youtube' ),

	                    array( 'vimeo_href', 'fa-vimeo-square' ),

	                    array( 'tumblr_href', 'fa-tumblr' ),

	                    array( 'linkedin_href', 'fa-linkedin' ),

	                    array( 'flickr_href', 'fa-flickr' ),

                    );



                        foreach ($social_links as $social_link) {

                            $sl_href = get_theme_mod($social_link[0]);

                            if($sl_href != "") {

                                echo "<li><a href=". esc_url($sl_href) ."><i class='fa " . esc_html($social_link[1]) . "'></i></a></li>";

                            }                            

                        }

                    ?>

                </ul>

            </section><!-- end #menu-social-icons -->

        </div><!-- end .container -->

    </section><!-- end #main-menu -->

</header><!-- end #main-header -->

