<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/public
 * @author 		Slushman <chris@slushman.com>
 */
class Como_Pipeline_Public {
	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;
	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$Como_Pipeline 		The name of the plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->set_options();
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/como-pipeline-public.min.css', array(), $this->version, 'all' );
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/como-pipeline-public.min.js', array( 'jquery' ), $this->version, true );
	}
	/**
	 * Processes shortcode comopipeline
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function display_pipeline_chart( $atts = array() ) {
		
		if (!is_admin()) {
			ob_start();
			$defaults['loop-template'] 	= $this->plugin_name . '-loop';
			$defaults['order'] 			= 'menu_order';
			$defaults['quantity'] 		= 100;
			$defaults['type'] 			= null;
			$defaults['id'] 			= null;
			$defaults['class'] 			= null;
			$defaults['footnote'] 		= null;
			$args						= shortcode_atts( $defaults, $atts, 'como-pipeline' );
			//echo '<p>PASSED FROM SHORTCODE: ';
			//print_r($args);
			//echo '<p>';
			$instID = (isset($atts['id']) ? $atts['id'] : '');
			$shared 					= new Como_Pipeline_Shared( $this->plugin_name, $this->version );
			$items 						= $shared->get_candidates( $args, $instID );
			if ( is_array( $items ) || is_object( $items ) ) {
				include como_pipeline_get_template($args['loop-template']);
			} else {
				echo $items;
			}
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	} // display_pipeline_chart()
	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {
		add_shortcode( 'pipeline-chart', array( $this, 'display_pipeline_chart' ) );
	} // register_shortcodes()
	
	/**
	 * Adds a default single view template for a candidate opening
	 *
	 * @param 	string 		$template 		The name of the template
	 * @return 	mixed 						The single template
	 */
	public function single_cpt_template( $template ) {
		global $post;
		$return = $template;
	    if ( $post->post_type == 'candidate' ) {
			$return = como_pipeline_get_template( 'single-candidate' );
		}
		return $return;
	} // single_cpt_template()
	/**
	 * Sets the class variable $options
	 */
	private function set_options() {
		$this->options = get_option( $this->plugin_name . '-options' );
	} // set_options()
} // class