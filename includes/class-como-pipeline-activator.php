<?php
/**
 * Fired during plugin activation
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/includes
 */
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 		1.0.0
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/includes
 * @author 		Slushman <chris@slushman.com>
 */
class Como_Pipeline_Activator {
	/**
	 * Declare custom post types, taxonomies, and plugin settings
	 * Flushes rewrite rules afterwards
	 *
	 * @since 		1.0.0
	 */
	public static function activate() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-como-pipeline-admin.php';
		Como_Pipeline_Admin::new_cpt_candidate();
		Como_Pipeline_Admin::new_taxonomy_category();
		Como_Pipeline_Admin::indication_taxonomy_type();
		Como_Pipeline_Admin::new_taxonomy_type();
		
		flush_rewrite_rules();
		$opts 		= array();
		$options 	= Como_Pipeline_Admin::get_options_list();
		foreach ( $options as $option ) {
			$opts[ $option[0] ] = $option[2];
		}
		update_option( 'como-pipeline-options', $opts );
		Como_Pipeline_Admin::add_admin_notices();
	} // activate()
} // class
