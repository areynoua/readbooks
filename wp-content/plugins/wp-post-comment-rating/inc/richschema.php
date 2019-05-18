<?php
	/** 
	** Enable google rich snippets
	**/
function wpcr_rich_snippets($content) {
	global $passedtext , $post;
	$args = array('post_id' => $post->ID);
	$comments = get_comments($args);
		
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
			global $wpdb;
			$chkresults = $wpdb->get_results( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'wpcr_settings'");
			$data = unserialize($chkresults[0]->option_value);
			$enable_snippets = $data['wpcrrichschema'];
						
			$link = get_permalink($post->ID);
			$name = get_the_title($post->ID);
			$author = get_the_author($post->ID);
			$image = get_the_post_thumbnail_url($post->ID);
            $result = round($result, 2);
			if($enable_snippets == 'yes'){
				if($count > 0){ 
					$output = '<script type="application/ld+json">
								{
								"@context": "http://schema.org",
								"@type": "CreativeWork",
								"aggregateRating": {
								"@type": "AggregateRating",
								"bestRating": "5",
								"ratingCount": "'.$count.'",
								"ratingValue": "'.$result.'"
								},
								"image": "'.$image.'",
								"name": "'.$name.'"
								}
								</script>';
					} 
				return $content.$output;
            }else{
				return $content;
			}
		}

add_filter('the_content', 'wpcr_rich_snippets', 30, 1);