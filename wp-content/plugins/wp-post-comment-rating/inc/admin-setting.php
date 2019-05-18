<?php
function wpcr_admin_page() { ?>
<div class="wpcsr_wrapper">
  <h3><span class="dashicons dashicons-admin-generic"></span><?php echo ( esc_html__('Settings', 'wp-post-comment-rating'));?></h3>
  <div class="left-area">
  <form method="post" action="options.php">
  <?php
  settings_fields('wpcr_options_group');
  $wpcr_options = get_option('wpcr_settings');
  ?>
  <div class="main_options_outer">
  
	<ul class="nav nav-tabs wpcr_nav_tabs">
		<li class="active"><a data-toggle="tab" href="#home"><?php echo ( esc_html__('General', 'wp-post-comment-rating'));?></a></li>
		<li><a data-toggle="tab" href="#menu1"><?php echo ( esc_html__('Stars', 'wp-post-comment-rating'));?></a></li>
		<li><a data-toggle="tab" href="#menu2"><?php echo ( esc_html__('Tooltip', 'wp-post-comment-rating'));?></a></li>
		<li><a data-toggle="tab" href="#menu3"><?php echo ( esc_html__('Floating Links', 'wp-post-comment-rating'));?></a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Enable rating', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="checkbox" name="wpcr_settings[checkbox1]" value="yes" <?php checked('yes', $wpcr_options['checkbox1']); ?> />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Show average rating', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="checkbox" name="wpcr_settings[checkbox2]" value="yes" <?php checked('yes', $wpcr_options['checkbox2']); ?> />
		  <p class="averagerating_info"><?php echo ( esc_html__( 'Add the_tags() function after title if average rating is not shown', 'wp-post-comment-rating' ) ); ?>. </p>
		  <p class="averagerating_info"><?php echo ( esc_html__( 'You can also use shortcode [wppr_avg_rating] to show average rating', 'wp-post-comment-rating' ) ); ?>.</p>
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Rating label', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[rtlabel]" placeholder="Please rate" value="<?php echo esc_attr( $wpcr_options['rtlabel']); ?>"  />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Rating label Color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[txtcolor]" value="<?php echo sanitize_hex_color( $wpcr_options['txtcolor'])?>" data-default-color="#ccc" />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Enable Google Rich Snippets?', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="checkbox" name="wpcr_settings[wpcrrichschema]" value="yes" <?php checked('yes', $wpcr_options['wpcrrichschema']); ?> />
		  </div>
		  </div>
		  
    </div>
	
	
    <div id="menu1" class="tab-pane fade">
		<div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Rating Image', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <div class="imgrow">
		  <input type="radio" name="wpcr_settings[rateimage]" value="ylrateimg" <?php checked('ylrateimg', $wpcr_options['rateimage']); ?>  />
		  <span class="enable_grateimg"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/star0.png'?>" alt=""/></span>
		  </div>
		  <div class="imgrow">
		  <input type="radio" name="wpcr_settings[rateimage]" value="grateimg" <?php checked('grateimg', $wpcr_options['rateimage']); ?>  />
		  <span class="enable_grateimg"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/star1.png'?>" alt=""/></span>
		  </div>
		  <div class="imgrow">
		  <input type="radio" name="wpcr_settings[rateimage]" value="orateimg" <?php checked('orateimg', $wpcr_options['rateimage']); ?>  />
		  <span class="enable_orateimg"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/star2.png'?>" alt=""/></span>
		  </div>
		  </div>
		 </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Empty stars color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php if(isset($wpcr_options['stremptycolor']) && !empty($wpcr_options['stremptycolor'])){
		        $emptycolor = $wpcr_options['stremptycolor'];
		  }else{
		        $emptycolor = '#ddd';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[stremptycolor]" value="<?php echo sanitize_hex_color( $emptycolor)?>" data-default-color="#ddd" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Filled stars color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <?php if(isset($wpcr_options['strfillcolor']) && !empty($wpcr_options['strfillcolor'])){
		        $filledcolor = $wpcr_options['strfillcolor'];
		  }else{
		        $filledcolor = '#ffd700';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[strfillcolor]" value="<?php echo sanitize_hex_color( $filledcolor)?>" data-default-color="#ffd700" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Selected stars color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		      <?php if(isset($wpcr_options['strselectedcolor']) && !empty($wpcr_options['strselectedcolor'])){
		        $seltedcolor = $wpcr_options['strselectedcolor'];
		  }else{
		        $seltedcolor = '#ea0';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[strselectedcolor]" value="<?php echo sanitize_hex_color( $seltedcolor)?>" data-default-color="#ea0" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Star size', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[starsize]" placeholder="22" value="<?php echo esc_attr( $wpcr_options['starsize']); ?>" style="width: 50px;" /><span><?php echo ( esc_html__('px', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		  
		  		  
    </div>
    <div id="menu2" class="tab-pane fade">
      <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Show average rating as', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <div class="aggr_options">
		  <input type="radio" name="wpcr_settings[tooltip_inline]" value="1" <?php checked(1, $wpcr_options['tooltip_inline']); ?>  />
		  <span class="aggr_label"><?php echo ( esc_html__('Tooltip', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="aggr_options">
		  <input type="radio" name="wpcr_settings[tooltip_inline]" value="0" <?php checked(0, $wpcr_options['tooltip_inline']); ?>  />
		  <span class="aggr_label"><?php echo ( esc_html__('Inline', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Average rating text', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[wpcravg_text]" placeholder="Average rating" value="<?php echo esc_attr( $wpcr_options['wpcravg_text']); ?>" />
		  </div>
		  </div>
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Tooltip background color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		      <?php if(isset($wpcr_options['tltpbgcolor']) && !empty($wpcr_options['tltpbgcolor'])){
		        $tltbgcolor = $wpcr_options['tltpbgcolor'];
		  }else{
		        $tltbgcolor = 'rgba(0,0,0,.8)';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[tltpbgcolor]" value="<?php echo sanitize_hex_color( $tltbgcolor)?>" data-default-color="rgba(0,0,0,.8)" />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Tooltip text color', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		      <?php if(isset($wpcr_options['tiptxtcolor']) && !empty($wpcr_options['tiptxtcolor'])){
		        $tiptxtcolor = $wpcr_options['tiptxtcolor'];
		  }else{
		        $tiptxtcolor = '#fff';
		  }?>
		  <input type="text" class="wpcrcolor-field" name="wpcr_settings[tiptxtcolor]" value="<?php echo sanitize_hex_color( $tiptxtcolor)?>" data-default-color="#fff" />
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="col-1">
		  <span><?php echo ( esc_html__('Tooltip text size', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="col-2">
		  <input type="text" name="wpcr_settings[tiptxtsize]" placeholder="12" value="<?php echo esc_attr( $wpcr_options['tiptxtsize']); ?>" style="width: 50px;" /><span><?php echo ( esc_html__('px', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		  
    </div>
	
	<div id="menu3" class="tab-pane fade">
      <div class="wpcr_pagioptions">
		<div class="right-main-sec">
		 <div class="wpcr_pagioptions">
			
		  <div class="row-outer">
		  <div class="colright-1">
		  <span><?php echo ( esc_html__('Enable next/prev links?', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="colright-2">
		  <div class="navlinks_options">
		  <input type="checkbox" name="wpcr_settings[shownav]" value="1" <?php checked(1, $wpcr_options['shownav']); ?>  />
		  </div>
		  </div>
		  </div>
		  
		  <div class="row-outer">
		  <div class="colright-1">
		  <span><?php echo ( esc_html__('Enable social share links?', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="colright-2">
		  <div class="navlinks_options">
		  <input type="checkbox" name="wpcr_settings[wpcr_social]" value="1" <?php checked(1, $wpcr_options['wpcr_social']); ?>  />
		  </div>
		  </div>
		  </div>
		  
		 		  
		  <div class="row-outer">
		  <div class="colright-1">
		  <span><?php echo ( esc_html__('Position', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="colright-2">
		  <div class="nav_position">
		  <input type="radio" name="wpcr_settings[navpos]" value="1" <?php checked(1, $wpcr_options['navpos']); ?>  />
		  <span class="nav_label"><?php echo ( esc_html__('Left', 'wp-post-comment-rating'));?></span>
		  </div>
		  <div class="nav_position">
		  <input type="radio" name="wpcr_settings[navpos]" value="0" <?php checked(0, $wpcr_options['navpos']); ?>  />
		  <span class="nav_label"><?php echo ( esc_html__('Right', 'wp-post-comment-rating'));?></span>
		  </div>
		  </div>
		</div>
		</div>
    </div>
    
  </div>
 </div> <!-- main options outer div close -->   
 
	
 
  <?php submit_button(); ?>
  </form>
  <div class="donate-message" style="float:right;">
	<?php //load_template( dirname( __FILE__ ) . '/message.php' );?>
	<?php $rating_img = '<a href="https://wordpress.org/support/plugin/wp-post-comment-rating/reviews/?filter=5" target="_blank">
<img src=" '.plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/five_stars_rating.png" style="width: 54px;vertical-align: top;"></a>';
 //$message = _e('<span>Thank you for using WP Post Rating. Please rate '.$rating_img.'</span>', 'wp-post-comment-rating');
 printf( esc_html__( 'Thank you for using WP Post Rating. Please rate %s', 'wp-post-comment-rating' ), $rating_img );?>
  </div>
  </div>
  
</div>
<?php }