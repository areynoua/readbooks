<?php
$cld_settings = $this->cld_settings;
//$this->print_array($this->cld_settings);
?>
<div class="wrap cld-wrap">
	<div class="cld-header"><h3><?php _e( 'Comments Like Dislike', 'comments-like-dislike' ); ?><span class="cld-avatar-holder"><img src="<?php echo CLD_IMG_DIR . '/avatar.jpeg'; ?>"/></span></h3></div>
	<div class="cld-clear"></div>
	<h2 class="nav-tab-wrapper wp-clearfix">
		<?php
		$cld_tabs = array(
			'basic' => array( 'label' => __( 'Basic Settings', CLD_TD ) ),
			'design' => array( 'label' => __( 'Design Settings', CLD_TD ) ),
			'help' => array( 'label' => __( 'Help', CLD_TD ) ),
			'about' => array( 'label' => __( 'About Us', CLD_TD ) )
		);
		/**
		 * Filters the tabs
		 *
		 * @since 1.0.0
		 *
		 * @param array $cld_tabs 
		 */
		$cld_tabs = apply_filters( 'cld_admin_tabs', $cld_tabs );
		$cld_tab_counter = 0;
		foreach ( $cld_tabs as $cld_tab => $cld_tab_detail ) {
			$cld_tab_counter++;
			?>
			<a href="javascript:void(0);" class="nav-tab <?php echo ($cld_tab_counter == 1) ? 'nav-tab-active' : ''; ?> cld-tab-trigger" data-settings-ref="<?php echo $cld_tab; ?>"><?php echo $cld_tab_detail['label']; ?></a>
			<?php
		}
		?>

	</h2>
	<div class="cld-settings-section-wrap">

		<?php include(CLD_PATH . 'inc/views/backend/boxes/basic-settings.php'); ?>
		<?php include(CLD_PATH . 'inc/views/backend/boxes/design-settings.php'); ?>
		<?php include(CLD_PATH . 'inc/views/backend/boxes/help.php'); ?>
		<?php include(CLD_PATH . 'inc/views/backend/boxes/about-us.php'); ?>



		<?php
		/**
		 * Fires when displaying the tabs section
		 * 
		 * @param array $cld_settings
		 * 
		 * @since 1.0.0
		 */
		do_action( 'cld_admin_tab_section', $cld_settings );
		?>
		<div class="cld-field-wrap cld-settings-action">
			<label></label>
			<div class="cld-field">
				<input type="button" class="cld-settings-save-trigger button-primary" value="<?php _e( 'Save settings', CLD_TD ); ?>"/>
				<input type="button" class="cld-settings-restore-trigger button-primary" value="<?php _e( 'Restore settings', CLD_TD ); ?>"/>
			</div>
		</div>
	</div>
	<div class="cld-info-wrap" style="display:none;">
		<img src="<?php echo CLD_IMG_DIR . '/ajax-loader.gif'; ?>" class="cld-loader"/>
		<span class="cld-info"><?php _e( 'Please wait.', CLD_TD ); ?></span>
		<span class="dashicons dashicons-dismiss cld-close-info"></span>
	</div>
</div>