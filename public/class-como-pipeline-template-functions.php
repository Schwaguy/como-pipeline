<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Como_Pipeline
 * @subpackage Como_Pipeline/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package    Como_Pipeline
 * @subpackage Como_Pipeline/public
 *
 */
class Como_Pipeline_Template_Functions {
	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;
	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		self::$_this = $this;
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	} // __construct()
	/**
	 * Includes the como-pipeline-candidate-title template
	 *
	 * @hooked 		como-pipeline-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function content_candidate_row( $item, $meta ) {
		$GLOBALS['itemID'] = $item->ID;
		include como_pipeline_get_template( 'como-pipeline-candidate-row' );
	} // content_candidate_row()
	/**
	 * Includes the content wrap end template file
	 *
	 * @hooked 		como-pipeline-after-loop-content 		90
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function table_row_end( $item, $meta ) {
		include como_pipeline_get_template( 'como-pipeline-table-row-end' );
	} // table_row_end()
	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		como-pipeline-before-loop-content 		10
	 */
	public function table_row_start( $item, $meta ) {
		include como_pipeline_get_template( 'como-pipeline-table-row-start' );
	} // table_row_start()
	/**
	 * Returns an array of the featured image details
	 *
	 * @param 	int 	$postID 		The post ID
	 * @return 	array 					Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {
		if ( empty( $postID ) ) { return FALSE; }
		$imageID = get_post_thumbnail_id( $postID );
		if ( empty( $imageID ) ) { return FALSE; }
		return wp_prepare_attachment_for_js( $imageID );
	} // get_featured_images()
	/**
	 * Includes the list wrap end template file
	 *
	 * @hooked 		como-pipeline-after-loop 		10
	 */
	public function table_wrap_end() {
		include como_pipeline_get_template( 'como-pipeline-table-wrap-end' );
	} // table_wrap_end()
	/**
	 * Includes the list wrap start template file
	 *
	 * @hooked 		como-pipeline-before-loop 		10
	 */
	public function table_wrap_start() {
		include como_pipeline_get_template( 'como-pipeline-table-wrap-start' );
	} // table_wrap_start()
	/**
	 * Includes the single candidate post content
	 *
	 * @hooked 		como-pipeline-single-content 	15
	 */
	public function single_post_content() {
		include como_pipeline_get_template( 'single-candidate-post-content' );
	} // single_post_content()
	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared using an object of this class.
	 *
	 * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {
		return self::$_this;
	} // this()
} // class