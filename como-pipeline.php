<?php
/**
 * @author 				Como Creative LLC
 * @link 				https://comocreative.com
 * @since 				1.0.0
 * @package 			Como_Pipeline
 *
 * @wordpress-plugin
 * Plugin Name: 		Como Pipeline
 * Plugin URI: 			https://wordpress.comocreative.com/
 * Description: 		Used to add Pipeline Charts to websites
 * Version: 			1.3.7
 * Author: 				Como Creative LLC
 * Author URI: 			https://comocreative.com
 * License: 			GPL-2.0+
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 		como-pipeline
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Include plugin updater.
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/updater.php' );
// Used for referring to the plugin file or basename
if ( ! defined( 'COMO_PIPELINE_FILE' ) ) {
	define( 'COMO_PIPELINE_FILE', plugin_basename( __FILE__ ) );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-como-pipeline-activator.php
 */
function activate_Como_Pipeline() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-como-pipeline-activator.php';
	Como_Pipeline_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-como-pipeline-deactivator.php
 */
function deactivate_Como_Pipeline() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-como-pipeline-deactivator.php';
	Como_Pipeline_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_Como_Pipeline' );
register_deactivation_hook( __FILE__, 'deactivate_Como_Pipeline' );
/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-como-pipeline.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 		1.0.0
 */
function run_Como_Pipeline() {
	$plugin = new Como_Pipeline();
	$plugin->run();
}
run_Como_Pipeline();
