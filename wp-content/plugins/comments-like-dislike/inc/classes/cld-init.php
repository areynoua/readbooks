<?php

if(!class_exists('CLD_Init')){
	class CLD_Init{
		function __construct(){
			add_action('init',array($this,'cld_init'));
		}
		
		function cld_init(){
			load_plugin_textdomain( 'comments-like-dislike', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
			/**
			 * Fires when Init hook is fired through plugin
			 * 
			 * @since 1.0.0
			 */
			do_action('cld_init');
		}
	}
	
	new CLD_Init();
}