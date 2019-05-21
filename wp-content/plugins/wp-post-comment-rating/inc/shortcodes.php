<?php
	/**
	*** Average Rating Shortcode
	**/
add_shortcode( 'wppr_avg_rating', 'wpcr_avg_rating');
function wpcr_avg_rating($atts ) {
	$a = shortcode_atts( array(
		'title' => 'Rating',
		), $atts );
		
	global $post;
	$args = array('post_id' => $post->ID);
	wpc_avg_rating_custom($a, $args);
}


function wpc_avg_rating_custom($atts, $args) {	
	global $wpdb;
	
	$comments = get_comments($args);
	//var_dump($comments);
	
	$sum = 0;
	$count=0;
	
foreach($comments as $comment) :
	
	 $approvedComment = $comment->comment_approved; 
	
	 if($approvedComment > 0){  
	 $rates = get_comment_meta( $comment->comment_ID, 'rating', true );
	 }
	 if($rates){
		 $sum = $sum + (int)$rates;
		 $count++;
 	}
    
	endforeach;
		if($count != 0){ 
			$result=   $sum/$count;
		}else {
			$result= 0;
		}
	
	$chkresults = $wpdb->get_results( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'wpcr_settings'");
	$check2 = unserialize($chkresults[0]->option_value);
	$check_val = $check2['checkbox2'];
	$tooltip_inline = $check2['tooltip_inline'];
	$avgrating_text = $check2['wpcravg_text'];
		if($avgrating_text == ''){
			$avg_text = __( 'Average', 'wp-post-comment-rating' );
		}else{
			$avg_text = $avgrating_text;
		}
			
			$avgText = __('average', 'wp-post-comment-rating');
			$outOf   = __('out of 5. Total', 'wp-post-comment-rating');
				
			
			if($count > 0){ 
				if($tooltip_inline == 1){
					$output = '<div class="wpcr_aggregate"><a class="wpcr_tooltip" title="'.$avgText.': '.round($result,2).' '.$outOf.': '.$count.'"><span class="wpcr_stars" title="">'.$avg_text.':</span>';
					$output .= '<span class="wpcr_averageStars" id="'.$result.'"></span></a></div>';
				}
				if($tooltip_inline == 0){
					$output = '<div class="wpcr_aggregate"><a class="wpcr_inline" title=""><span class="wpcr_stars" title="">'.$avg_text.':</span>';
					$output .= '<span class="wpcr_averageStars" id="'.$result.'"></span></a><span class="avg-inline">('.$avgText.': <strong> '.round($result, 2).'</strong> '.$outOf.': '.$count.')</span></div>';
				}
					
				 
                return $output;
			}else{
				return '';
			}
	}
