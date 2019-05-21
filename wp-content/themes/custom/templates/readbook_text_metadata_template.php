<!-- templates/readbook_text_metadata_template.php-->
<?php /*
       * tmt: (required) the document to display
       * link_to_book: (default: false) whether the title is a link to the page of the document
       * tmt_points_preview: (default: false) wether to give a previes of the points of the document
       * tmt_cover_placeholder: (default: false) wether to display a placeholder when there is no cover preview
       * TODO: tmt_columns: to have a fixed width for the preview (to align many of them)
       */ ?>
<?php
$link_to_book = isset($link_to_book) && $link_to_book;
$tmt_points_preview = isset($tmt_points_preview) && $tmt_points_preview;
$tmt_cover_placeholder = isset($tmt_cover_placeholder) && $tmt_cover_placeholder;

$tmt_title = $tmt->post_title;
if($link_to_book) {
	$link_to_book = '<a href="' . get_site_url() . '/index.php?p=' . $tmt->ID . '">';
	$tmt_title = $link_to_book . $tmt_title . '</a>';
}
$tmt_points = get_children(array(
	'post_parent' => $tmt->ID,
	'post_type'   => 'document_point', 
	'numberposts' => -1, 
	'post_status' => 'any'
));
$authorName = get_post_meta($tmt->ID, 'text_author', true);
?>
<h1 class="title pre-title document-title"><?php echo $tmt_title; ?></h1>
<?php if($link_to_book) echo $link_to_book; ?>
<?php if(get_post_meta($tmt->ID, 'text_img', true) != "") : ?>
	<img class="text-img" src="<?php echo get_post_meta($tmt->ID, 'text_img', true); ?>" />
<?php else : if ($tmt_cover_placeholder) : ?>
	<div class="no-img"><p>No preview</p></div>
<?php endif; endif; ?>
<?php if($link_to_book) echo '</a>'; ?>

<h1 class="title document-title"><?php echo $tmt_title;?></h1>

<div class="meta col-items">
	<!-- TODO make clickable (category and theme) to make automaticaly a research -->
	<div class="author">
		<span><i class="fa fa-pencil"></i> <span>Author:</span></span>
		<span><a href="<?php echo get_site_url() . "/?s=" . $authorName; ?>"><?php echo $authorName; ?></a></span>
	</div>
	<div class="date">
		<span><i class="fa fa-calendar"></i> <span>Publication date:</span></span>
		<span><?php echo get_post_meta($tmt->ID, 'text_date', true); ?></span>
	</div>
	<div class="category">
		<span><i class="fa fa-list"></i> <span>Category:</span></span>
		<span><?php echo listTermsToText(wp_get_post_terms($tmt->ID, 'PublicationTypes')); ?></span>
	</div>
	<div class="theme">
		<span><i class="fa fa-tags"></i> <span>Theme:</span></span>
		<span><?php echo listTermsToText(
			wp_get_post_terms($tmt->ID, 'Theme'),
			'<a href="' . get_site_url() . '/theme/%term%/">',
			'</a>'); ?></span>
	</div>
	<div class="poi-count">
		<span><i class="fa fa-comment"></i> <span>Points of interest:</span></span>
		<span><?php echo count($tmt_points) ?></span>
	</div>
<?php if(get_post_meta($tmt->ID, 'text_link', true) != "") { ?>
	<div class="get-text">
		<span class="link"><a target="_blank" href="<?php echo get_post_meta($tmt->ID, 'text_link', true); ?>"><i class="fa fa-external-link"></i> Get the Text</a></span>
	</div>
<?php } ?>
</div>
<?php if($tmt_points_preview) : ?>
<ul class="POI-previews">
	<?php $i = 1; foreach ($tmt_points as $tmt_point) : ?>
		<li><a href="<?php echo $tmt_point->guid; ?>" class="title point-title"><?php echo $tmt_point->post_title; ?></a></li>
	<?php if (++$i > 2 && $i < count($tmt_points)) { echo "<li>...</li>"; break; } endforeach; ?>
</ul>
<?php endif; ?>
<div></div>
