<?php
/**
 * Globally-accessible functions
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package		Como_Pipeline
 * @subpackage 	Como_Pipeline/includes
 */
/**
 * Returns the result of the get_max global function
 */
function como_pipeline_get_max( $array ) {
	return Como_Pipeline_Globals::get_max( $array );
}
/**
 * Returns the result of the get_svg global function
 */
function como_pipeline_get_svg( $svg ) {
	return Como_Pipeline_Globals::get_svg( $svg );
}
/**
 * Returns the result of the get_template global function
 */
function como_pipeline_get_template( $name ) {
	return Como_Pipeline_Globals::get_template( $name );
}
// Change Title Placeholder Text
function candidate_title_text( $title, $post ) {
    if ( 'candidate' == $post->post_type ) {
        $title = 'Candidate Name';
    }
    return $title;
}
add_filter( 'enter_title_here', 'candidate_title_text', 10, 2 );
// Get Custom Column Fields to Field Definitions
function getCustomFields($fields = array()) {
	$options = get_option('como-pipeline-options');
	$columns = $options['pipeline-columns'];
	foreach ($columns as $column) {
		if ($column['column-type'] == 'image-column') {
			$fields[] = array(
				((isset($column['column-id'])) ? $column['column-id'] : ''), 
				'image', 
				((isset($column['column-name'])) ? $column['column-name'] : ''), 
				((isset($column['column-type'])) ? $column['column-type'] : ''), 
				((isset($column['column-width'])) ? $column['column-width'] : ''), 
				((isset($column['column-abbreviation'])) ? $column['column-abbreviation'] : ''),
				((isset($column['column-alt-name'])) ? $column['column-alt-name'] : ''), 
				((isset($column['column-alt-abbreviation'])) ? $column['column-alt-abbreviation'] : '')
			);
		} else {
			$fields[] = array(
				((isset($column['column-id'])) ? $column['column-id'] : ''), 
				'text', 
				((isset($column['column-name'])) ? $column['column-name'] : ''), 
				((isset($column['column-type'])) ? $column['column-type'] : ''), 
				((isset($column['column-width'])) ? $column['column-width'] : ''), 
				((isset($column['column-abbreviation'])) ? $column['column-abbreviation'] : ''),
				((isset($column['column-alt-name'])) ? $column['column-alt-name'] : ''), 
				((isset($column['column-alt-abbreviation'])) ? $column['column-alt-abbreviation'] : '')
			);
		}
	}
	return $fields;
}
// Get Trial Fields
function getTrialFields($fields = array()) {
	$options = get_option('como-pipeline-options');
	$columns = $options['pipeline-columns'];
	$ignoreArray = array('title-column','progress-column','type-column','indication-column');
	$trialFields = array(
		array('trial-name', 'text'), 
		array('trial-abbreviation', 'text'), 
		array('trial-class', 'text'), 
		array('trial-link', 'text'), 
		array('trial-link-text', 'text'), 
		array('trial-color', 'text'), 
		array('trial-progress', 'number'), 
		array('trial-progress-text', 'text'), 
		array('trial-progress-text-abbreviation', 'text'), 
		array('trial-indication', 'int'),
		array('trial-type', 'int'),
		array('trial-textarea', 'textarea'),
		array('trial-logo', 'int')
	);
	foreach ($columns as $column) {
		if (in_array($column['column-type'],$ignoreArray)) {
			// Dont Include
		} else {
			if ($column['column-type'] == 'image-column') {
				$trialFields[] = array('trial-'. $column['column-id'], 'image');
			} else {
				$trialFields[] = array('trial-'. $column['column-id'], 'text');
			}
		}
	}
	return $trialFields;
}
// Get Custom Column Fields to Field Definitions
function getCustomFieldsLimited($fields = array()) {
	$options = get_option('como-pipeline-options');
	$columns = $options['pipeline-columns'];
	$ignoreArray = array('title-column','progress-column','type-column','indication-column');
	foreach ($columns as $column) {
		if (in_array($column['column-type'],$ignoreArray)) {
			// Dont Include
		} else {
			if ($column['column-type'] == 'image-column') {
				$fields[] = array('trial-'. $column['column-id'], 'image');
			} else {
				$fields[] = array('trial-'. $column['column-id'], 'text');
			}
		}
	}
	return $fields;
}
// Allow fields to be added below the title and above the editor
if (!function_exists('ai_edit_form_after_title')) {
	function ai_edit_form_after_title() {
		global $post, $wp_meta_boxes;
		do_meta_boxes( get_current_screen(), 'after_title', $post );
		unset( $wp_meta_boxes['post']['after_title'] );
	}
	add_action( 'edit_form_after_title', 'ai_edit_form_after_title' );
}
if (!function_exists('isArrayEmpty')) {
	function isArrayEmpty($array) {
		foreach($array as $key => $val) {
			if ($val !== '') { return false; }
		}
		return true;
	}
}
// Custom Image Sizes
add_action( 'after_setup_theme', 'pipeline_img_sizes' );
function pipeline_img_sizes() {
	add_image_size( 'pipeline-logo-image', 150, 150, false); // (not cropped)
	//add_image_size( 'profile-image-bod', 212, 244, array( 'center', 'center' ) ); // (cropped)
}
class Como_Pipeline_Globals {
	/**
	 * Returns the count of the largest arrays
	 *
	 * @param 		array 		$array 		An array of arrays to count
	 * @return 		int 					The count of the largest array
	 */
 	public static function get_max( $array ) {
 		if ( empty( $array ) ) { return '$array is empty!'; }
 		$count = array();
		foreach ( $array as $name => $field ) {
			$count[$name] = count( $field );
		} //
		$count = max( $count );
		return $count;
 	} // get_max()
 	/**
 	 * Returns the requested SVG.
 	 *
 	 * @param 		string 		$svg 		The name of an SVG
 	 * @return 		mixed 					The SVG code
 	 */
 	public static function get_svg( $svg ) {
 		$return = '';
		switch ( $svg ) {
			case 'drag': $return = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag" height="20px" width="20px"><path d="M19.7 10.5l-2.8 2.8c-.1.1-.3.2-.5.2-.4 0-.7-.3-.7-.7v-1.4h-4.3v4.3h1.4c.4 0 .7.3.7.7 0 .2-.1.4-.2.5l-2.8 2.8c-.1.1-.3.2-.5.2s-.4-.1-.5-.2l-2.8-2.8c-.1-.1-.2-.3-.2-.5 0-.4.3-.7.7-.7h1.4v-4.3H4.3v1.4c0 .4-.3.7-.7.7-.2 0-.4-.1-.5-.2L.3 10.5c-.1-.1-.2-.3-.2-.5s.1-.4.2-.5l2.8-2.8c.1-.1.3-.2.5-.2.4 0 .7.3.7.7v1.4h4.3V4.3H7.2c-.4 0-.7-.3-.7-.7 0-.2.1-.4.2-.5L9.5.3c.1-.1.3-.2.5-.2s.4.1.5.2l2.8 2.8c.1.1.2.3.2.5 0 .4-.3.7-.7.7h-1.4v4.3h4.3V7.2c0-.4.3-.7.7-.7.2 0 .4.1.5.2l2.8 2.8c.1.1.2.3.2.5s0 .4-.2.5z"/></svg>'; break;
		} // switch
		return $return;
 	} // get_svg()
 	/**
	 * Returns the path to a template file
	 *
	 * Looks for the file in these directories, in this order:
	 * 		Current theme
	 * 		Parent theme
	 * 		Current theme templates folder
	 * 		Parent theme templates folder
	 * 		This plugin
	 *
	 * To use a custom list template in a theme, copy the
	 * file from public/templates into a templates folder in your
	 * theme. Customize as needed, but keep the file name as-is. The
	 * plugin will automatically use your custom template file instead
	 * of the ones included in the plugin.
	 *
	 * @param 	string 		$name 			The name of a template file
	 * @return 	string 						The path to the template
	 */
 	public static function get_template( $name ) {
 		$template = '';
		$locations[] = "{$name}.php";
		$locations[] = "/como-pipeline/{$name}.php";
		/**
		 * Filter the locations to search for a template file
		 *
		 * @param 	array 		$locations 			File names and/or paths to check
		 */
		apply_filters( 'como-pipeline-template-paths', $locations );
		$template = locate_template( $locations, TRUE );
		if ( empty( $template ) ) {
			$template = plugin_dir_path( dirname( __FILE__ ) ) . 'public/templates/' . $name . '.php';
		}
		return $template;
 	} // get_template()
} // class
add_action('admin_enqueue_scripts', 'check_bootstrap', 99999);
function check_bootstrap() {
	global $wp_styles;
	$srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
	if ( in_array('bootstrap.css', $srcs) || in_array('bootstrap.min.css', $srcs) || in_array('style.combined.min.css', $srcs) || in_array('bootstrap-grid.min.css', $srcs) ) {
		/* 'BOOTSTRAP registered' */ 
	} else {
		//wp_enqueue_style('bootstrap', plugin_dir_url( __FILE__ ) . 'admin/css/bootstrap-grid.min.css');
		wp_enqueue_style('bootstrap', '/wp-content/plugins/como-pipeline/admin/css/bootstrap-grid.min.css');
	}
}