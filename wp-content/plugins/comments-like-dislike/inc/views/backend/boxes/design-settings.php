<div class="cld-settings-section" data-settings-ref="design" style="display:none;">
			<div class="cld-field-wrap">
				<label><?php _e( 'Choose Template', CLD_TD ); ?></label>
				<div class="cld-field">
					<select name="cld_settings[design_settings][template]" class="cld-form-field cld-template-dropdown">
						<?php
						/**
						 * Filters total number or templates
						 * 
						 * @param int 
						 * 
						 * @since 1.0.0
						 */
						$cld_total_templates = apply_filters( 'cld_total_templates', 4 );
						for ( $i = 1; $i <= $cld_total_templates; $i++ ) {
							?>
							<option value="template-<?php echo $i; ?>" <?php selected( $cld_settings['design_settings']['template'], 'template-' . $i ); ?>><?php echo __( 'Template ', CLD_TD ) . $i; ?></option>
							<?php
						}
						?>
						<option value="custom" <?php selected( $cld_settings['design_settings']['template'], 'custom' ); ?>><?php _e( 'Custom Template', CLD_TD ); ?></option>
					</select>
					<div class="cld-template-previews-wrap">
						<?php for ( $i = 1; $i <= 4; $i++ ) {
							?>
							<div class="cld-each-template-preview" <?php if ( 'template-' . $i != $cld_settings['design_settings']['template'] ) { ?>style="display:none"<?php } ?> data-template-ref="template-<?php echo $i; ?>"><img src="<?php echo CLD_IMG_DIR . '/template-previews/template-' . $i . '.jpeg'; ?>"/></div>
							<?php
						}

						/**
						 * Fires on backend template preview
						 * 
						 * Useful to add additional templates in backend
						 * 
						 * @param array $cld_settings
						 * 
						 * @since 1.0.0
						 * 
						 */
						do_action( 'cld_template_previews',$cld_settings );
						?>

					</div>
				</div>
			</div>
			<div class="cld-custom-ref" <?php if ( $cld_settings['design_settings']['template'] != 'custom' ) { ?>style="display:none"<?php } ?>>
				<div class="cld-field-wrap">
					<label><?php _e( 'Like Icon', CLD_TD ); ?></label>
					<div class="cld-field">
						<input type="text" name="cld_settings[design_settings][like_icon]" class="cld-form-field" value="<?php echo esc_url( $cld_settings['design_settings']['like_icon'] ) ?>"/>
						<input type="button" class="button-primary cld-file-uploader" value="<?php _e( 'Upload Icon', CLD_TD ); ?>"/>
						<span class="cld-preview-holder">
							<?php if ( $cld_settings['design_settings']['dislike_icon'] != '' ) { ?>
								<img src="<?php echo esc_url( $cld_settings['design_settings']['like_icon'] ); ?>"/>
							<?php } ?>
						</span>
					</div>
				</div>
				<div class="cld-field-wrap">
					<label><?php _e( 'Dislike Icon', CLD_TD ); ?></label>
					<div class="cld-field">
						<input type="text" name="cld_settings[design_settings][dislike_icon]" class="cld-form-field" value="<?php echo esc_url( $cld_settings['design_settings']['dislike_icon'] ) ?>"/>
						<input type="button" class="button-primary cld-file-uploader" value="<?php _e( 'Upload Icon', CLD_TD ); ?>"/>
						<span class="cld-preview-holder"><?php if ( $cld_settings['design_settings']['dislike_icon'] != '' ) { ?><img src="<?php echo esc_url( $cld_settings['design_settings']['dislike_icon'] ); ?>"/><?php } ?></span>
					</div>
				</div>
			</div>
			<div class="cld-field-wrap cld-template-ref"  <?php if ( $cld_settings['design_settings']['template'] == 'custom' ) { ?>style="display:none"<?php } ?>>
				<label><?php _e( 'Icon Color', CLD_TD ); ?></label>
				<div class="cld-field">
					<input type="text" name="cld_settings[design_settings][icon_color]" class="cld-form-field cld-colorpicker" value="<?php echo esc_attr( $cld_settings['design_settings']['icon_color'] ) ?>"/>
				</div>
			</div>
			<div class="cld-field-wrap">
				<label><?php _e( 'Count Color', CLD_TD ); ?></label>
				<div class="cld-field">
					<input type="text" name="cld_settings[design_settings][count_color]" class="cld-form-field cld-colorpicker" value="<?php echo esc_attr( $cld_settings['design_settings']['count_color'] ) ?>"/>
				</div>
			</div>
		</div>