<?php
add_action('wp_head', 'wpcr_style_options'); 

/////// change rating stars ///////
function wpcr_style_options() { 
	global $check;
	global $wpdb;
    
	$results = $wpdb->get_results( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'wpcr_settings'");
	$val = unserialize($results[0]->option_value);
	$label_color = $val['txtcolor'];
	$ratingimage = $val['rateimage'];
	$floatinglinks_pos = $val['navpos'];
	$tooltip_bg = $val['tltpbgcolor'];
	$tooltip_txtcolor = $val['tiptxtcolor'];
	$tooltip_txtsize = $val['tiptxtsize'];
	
	$stars_emptycolor = $val['stremptycolor'];
	$stars_filledcolor = $val['strfillcolor'];
	$stars_selectdcolor = $val['strselectedcolor'];
	$stars_Size = $val['starsize'];
	
	if($ratingimage == "grateimg"){
		$ratingimg = 'stars';
	}elseif($ratingimage == "orateimg"){
		$ratingimg = 'stars-orange';
	}elseif($ratingimage == "ylrateimg"){
		$ratingimg = 'yelstars';
	}else{
		$ratingimg = 'stars';
	}
	
	if($floatinglinks_pos == 0){
		$nav_pos_right = '0';
		$nav_pos_left = 'auto';
	}elseif($floatinglinks_pos == 1){
		$nav_pos_right = 'auto';
		$nav_pos_left = '0';
	}else{
		$nav_pos_right = 'auto';
		$nav_pos_left = '0';
	}
	
	// tooltip BG 
	if(!empty($tooltip_bg)){
		$tooltip_bg = $tooltip_bg;
	}else{
		$tooltip_bg = 'rgba(0,0,0,.8)';
	}
	
	// tooltip Text color 
	if(!empty($tooltip_txtcolor)){
		$tooltip_txtcolor = $tooltip_txtcolor;
	}else{
		$tooltip_txtcolor = '#fff';
	}
	// tooltip Text size 
	if(!empty($tooltip_txtsize)){
		$tooltip_txtsize = $tooltip_txtsize;
	}else{
		$tooltip_txtsize = '12';
	}
	
	// stars empty color 
	if(!empty($stars_emptycolor)){
		$stars_emptycolor = $stars_emptycolor;
	}else{
		$stars_emptycolor = '#ddd';
	}
	// stars filled color 
	if(!empty($stars_filledcolor)){
		$stars_filledcolor = $stars_filledcolor;
	}else{
		$stars_filledcolor = '#ffd700';
	}
	// stars selected color 
	if(!empty($stars_selectdcolor)){
		$stars_selectdcolor = $stars_selectdcolor;
	}else{
		$stars_selectdcolor = '#ea0';
	}
	// tooltip Text size 
	if(!empty($stars_Size)){
		$stars_Size = $stars_Size;
	}else{
		$stars_Size = '22';
	}
	
	?>
	<style type="text/css">
		fieldset.rating > legend{
			color:<?php echo $label_color;?>
		}

		.comment-form-comment, .comment-notes {clear:both;}
		.rating {
			float:left;
		}

		/* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
		   follow these rules. Every browser that supports :checked also supports :not(), so
		   it doesn’t make the test unnecessarily selective */
		.rating:not(:checked) > input {
			position:absolute;
			/*top:-9999px;*/
			clip:rect(0,0,0,0);
		}

		.rating:not(:checked) > label {
			float:right;
			width:1em;
			padding:0 .1em;
			overflow:hidden;
			white-space:nowrap;
			cursor:pointer;
			font-size:<?php echo $stars_Size?>px;
			line-height:1.2;
			color:<?php echo $stars_emptycolor?> !important;
			text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
		}

		.rating:not(:checked) > label:before {
			content: '★ ';
		}

		.rating > input:checked ~ label {
			color: <?php echo $stars_selectdcolor?> !important;
			text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
		}

		.rating:not(:checked) > label:hover,
		.rating:not(:checked) > label:hover ~ label {
			color: <?php echo $stars_filledcolor?> !important;
			text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
		}

		.rating > input:checked + label:hover,
		.rating > input:checked + label:hover ~ label,
		.rating > input:checked ~ label:hover,
		.rating > input:checked ~ label:hover ~ label,
		.rating > label:hover ~ input:checked ~ label {
			color: #ea0 !important;
			text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
		}

		.rating > label:active {
			position:relative;
			top:2px;
			left:2px;
		}
		p.logged-in-as {clear:both;}
		span.wpcr_author_stars, span.wpcr_author_stars span {
			display: block;
			background: url(<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/'.$ratingimg.'.png'?>) 0 -16px repeat-x;
			width: 80px;
			height: 16px;
		}

		span.wpcr_author_stars span {
			background-position: 0 0;
		}
		span.wpcr_averageStars, span.wpcr_averageStars span {
			display: block;
			background: url(<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/'.$ratingimg.'.png'?>) 0 -16px repeat-x;
			width: 80px;
			height: 16px;
		}

		span.wpcr_averageStars span {
			background-position: 0 0;
		}

		/*for tooltip*/
		.wpcr_tooltip, .wpcr_inline{
			display: inline;
			position: relative;
			width:auto;
			float:left;
			font-size: <?php echo $tooltip_txtsize?>px;
		}
		a.wpcr_tooltip span.wpcr_stars, .wpcr_inline span.wpcr_stars{float:left;font-size: 14px;}
		a.wpcr_tooltip span.wpcr_averageStars, a.wpcr_inline span.wpcr_averageStars {float:left; margin:2px 5px 0px 5px;}
		
		.wpcr_tooltip:hover:after{
			background-color: <?php echo $tooltip_bg?>;
			border-radius: 5px;
			bottom: 26px;
			color: <?php echo $tooltip_txtcolor?>;
			content: attr(title);
			left: 20%;
			padding: 5px 10px;
			position: absolute;
			z-index: 98;
			width: 205px;
			border-radius: 7px;
			font-size: 13px;
		}
		.wpcr_tooltip:hover:before{
			border: solid;
			border-color: <?php echo $tooltip_bg?> transparent;
			border-width: 6px 6px 0 6px;
			bottom: 20px;
			content: "";
			left: 50%;
			position: absolute;
			z-index: 99;
		}
		.wpcr_aggregate{float: left;display: inline-block;width: 100%;line-height: 20px;}
		#hide-stars {display:none;}
		#review_form .rating {display:none;}
		#reviews .wpcr_author_stars {display:none;}
		.col-2 .aggr_options {
			margin-bottom: 5px;
			display: inline-block;
		}
		.wpcr_floating_links{position: fixed;left: <?php echo $nav_pos_left?>;right:<?php echo $nav_pos_right?>;top:40%;z-index: 99999;}
		.wpcr_floating_links ul{list-style: none;margin: 0px;padding: 0;}
		.wpcr_floating_links li{
			padding: 5px 11px;
			background-color: #fff;
			box-shadow: 1px 1px 2px 2px #ccc;
			text-align: center;
		}
		
	</style>
<?php
}