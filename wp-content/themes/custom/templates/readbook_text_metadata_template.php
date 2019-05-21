<!-- templates/readbook_text_metadata_template.php-->
<?php /*
       * tmt: (required) the document to display
       * link_to_book: (default: false) whether the title is a link to the page of the document
       * tmt_points_preview: (default: false) wether to give a previes of the points of the document
       * tmt_cover_placeholder: (default: false) wether to display a placeholder when there is no cover preview
       */ ?>
<?php
$link_to_book = isset($link_to_book) && $link_to_book;
$tmt_points_preview = isset($tmt_points_preview) && $tmt_points_preview;
$tmt_cover_placeholder = isset($tmt_cover_placeholder) && $tmt_cover_placeholder;

$tmt_title = $tmt->post_title;
if($link_to_book) {
	$tmt_title = '<a href="' . get_site_url() . '/index.php?p=' . $tmt->ID . '">' . $tmt_title . '</a>';
}
$tmt_points = get_children(array(
	'post_parent' => $tmt->ID,
	'post_type'   => 'document_point', 
	'numberposts' => -1, 
	'post_status' => 'any'
));
?>
<h1 class="title pre-title"><?php echo $tmt_title; ?></h1>

<?php if(get_post_meta($tmt->ID, 'text_img', true) != "") : ?>
	<img class="text-img" src="<?php echo get_post_meta($tmt->ID, 'text_img', true); ?>" />
<?php else : if ($tmt_cover_placeholder) : ?>
	<div class="no-img"><p>No preview</p></div>
<?php endif; endif; ?>

<h1 class="title"><?php echo $tmt_title;?></h1>

<div class="meta col-items">
	<!-- TODO make clickable (category and theme) to make automaticaly a research -->
	<div class="author">
		<span><i class="fa fa-pencil"></i> Author:</span>
		<span><a href="#"><?php echo get_post_meta($tmt->ID, 'text_author', true); ?></a></span>
	</div>
	<div class="date">
		<span><i class="fa fa-calendar"></i> Publication date:</span>
		<span><?php echo get_post_meta($tmt->ID, 'text_date', true); ?></span>
	</div>
	<div class="category">
		<span><i class="fa fa-list"></i> Category:</span>
		<span><?php echo listTermsToText(wp_get_post_terms($tmt->ID, 'PublicationTypes')); ?></span>
	</div>
	<div class="theme">
		<span><i class="fa fa-tags"></i> Theme:</span>
		<span><?php echo listTermsToText(
			wp_get_post_terms($tmt->ID, 'Theme'),
			'<a href="' . get_site_url() . '/theme/%term%/">',
			'</a>'); ?></span>
	</div>
	<div class="poi-count">
		<span><i class="fa fa-comment"></i> Points of interest:</span>
		<span><?php echo count($tmt_points) ?></span>
	</div>
</div>
<?php if($tmt_points_preview) : ?>
<ul class="POI-previews">
	<?php $i = 0; foreach ($tmt_points as $tmt_point) : if ($i > 3) { echo "<li>...</li>"; break; } ?>
		<li><a href="<?php echo $document_point->guid; ?>" class="title point-title"><?php echo $document_point->post_title; ?></a></li>
	<?php ++$i; endforeach; ?>
</ul>
<?php endif; ?>
<?php if(get_post_meta($tmt->ID, 'text_link', true) != "") { ?>
	<span class="link"><a target="_blank" href="<?php echo get_post_meta($tmt->ID, 'text_link', true); ?>"><i class="fa fa-external-link"></i> Get the Text</a></span>
<?php } ?>
<div></div>
