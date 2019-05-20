<!-- templates/readbook_text_metadata_template.php-->
<?php $tmt_title = $tmt->post_title; ?>
<h1 class="title pre-title"><?php echo $tmt_title; ?></h1>

<?php if(get_post_meta($tmt->ID, 'text_img', true) != "") : ?>
	<img class="text-img" src="<?php echo get_post_meta($tmt->ID, 'text_img', true); ?>" />
<?php endif; ?>

<h1 class="title"><?php echo $tmt_title; ?></h1>

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
</div>
	<?php if(get_post_meta($tmt->ID, 'text_link', true) != "") { ?>
		<span class="link"><a target="_blank" href="<?php echo get_post_meta($tmt->ID, 'text_link', true); ?>"><i class="fa fa-external-link"></i> Get the Text</a></span>
	<?php } ?>
<div></div>
