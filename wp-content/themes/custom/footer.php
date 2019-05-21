<footer id="main-footer" class="clearfix">




    <div class="lower-footer clearfix">

        <div class="container">

            <div class="footer-logo">

                <a href="<?php echo home_url(); ?>">

                    <?php

                        $display_footer_logo = get_theme_mod("mp_display_footer_logo_image",true);

                        if($display_footer_logo)

                        {

                            $footer_logo = get_theme_mod("footer-logo-upload",get_template_directory_uri().'/img/footerlogo.png');

                            if( !empty($footer_logo) )

                            {

                                echo "<img src='" . esc_url($footer_logo) . "'/>";

                            }

                        }

                    ?>

                </a>

            </div><!-- end .footer-logo -->



            <div class="copyright-info">
                
                <?php
                    $copyright_textbox = get_theme_mod( 'copyright_textbox', __('Copyright 2015 ThemeIsle',"book-rev-lite") );
                    if( !empty($copyright_textbox) ):
                        echo '<p>'.wp_kses_post($copyright_textbox).'</p>';
                    endif;
                ?>
                <p><a href="https://themeisle.com/themes/bookrev-lite/" target="_blank" rel="nofollow">Book Rev Lite</a> <?php _e('powered by','book-rev-lite'); ?> <a href="http://wordpress.org/" target="_blank" rel="nofollow">WordPress</a></p>
                
            </div><!-- end .copyright-info -->

        </div><!-- end .container -->

    </div><!-- end .lower-footer -->

    





</footer><!-- end .main-footer -->

<?php

    // Gets and includes the custom body code.

    //echo cwp("cwp_custom_body_code");

    wp_footer();

?>

</body>

</html>