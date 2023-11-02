<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/admin
 */
/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/admin
 * @author 		Slushman <chris@slushman.com>
 */
class Como_Pipeline_Admin {
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
	 * @param 		string 			$Como_Pipeline 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->set_options();
	}
	/**
     * Adds notices for the admin to display.
     * Saves them in a temporary plugin option.
     * This method is called on plugin activation, so its needs to be static.
     */
    public static function add_admin_notices() {
    	$notices 	= get_option( 'como_pipeline_deferred_admin_notices', array() );
  		//$notices[] 	= array( 'class' => 'updated', 'notice' => esc_html__( 'Como Pipeline: Custom Activation Message', 'como-pipeline' ) );
  		//$notices[] 	= array( 'class' => 'error', 'notice' => esc_html__( 'Como Pipeline: Problem Activation Message', 'como-pipeline' ) );
  		apply_filters( 'como_pipeline_admin_notices', $notices );
  		update_option( 'como_pipeline_deferred_admin_notices', $notices );
    } // add_admin_notices
	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {
		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		// Submenu Page
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		add_submenu_page(
			'edit.php?post_type=candidate',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Como Pipeline Settings', 'como-pipeline' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Settings', 'como-pipeline' ) ),
			'manage_options',
			$this->plugin_name . '-settings',
			array( $this, 'page_options' )
		);
		add_submenu_page(
			'edit.php?post_type=candidate',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Como Pipeline Help', 'como-pipeline' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Help', 'como-pipeline' ) ),
			'manage_options',
			$this->plugin_name . '-help',
			array( $this, 'page_help' )
		);
	} // add_menu()
	/**
     * Manages any updates or upgrades needed before displaying notices.
     * Checks plugin version against version required for displaying
     * notices.
     */
	public function admin_notices_init() {
		$current_version = '1.0.0';
		if ( $this->version !== $current_version ) {
			// Do whatever upgrades needed here.
			update_option('my_plugin_version', $current_version);
			$this->add_notice();
		}
	} // admin_notices_init()
	/**
	 * Displays admin notices
	 *
	 * @return 	string 			Admin notices
	 */
	public function display_admin_notices() {
		$notices = get_option( 'como_pipeline_deferred_admin_notices' );
		if ( empty( $notices ) ) { return; }
		foreach ( $notices as $notice ) {
			echo '<div class="' . esc_attr( $notice['class'] ) . '"><p>' . $notice['notice'] . '</p></div>';
		}
		delete_option( 'como_pipeline_deferred_admin_notices' );
    } // display_admin_notices()
	
	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/como-pipeline-admin.css', array(), $this->version, 'all' );
	} // enqueue_styles()
	
	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {
		global $post_type;
		$screen = get_current_screen();
		if ( 'candidate' === $post_type || $screen->id === $hook_suffix ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-admin.min.js', array( 'jquery' ), $this->version, true );
			
			//wp_enqueue_script( $this->plugin_name . '-repeater', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-repeater.min.js', array( 'jquery' ), $this->version, true );
			
			//wp_enqueue_script( 'jquery-ui-datepicker' );
			$localize['repeatertitle'] = __( 'Trial Name', 'como-pipeline' );
			wp_localize_script( 'como-pipeline', 'nhdata', $localize );
		}
	} // enqueue_scripts()
	/**
	 * Creates a checkbox field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_checkbox( $args ) {
		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;
		apply_filters( $this->plugin_name . '-field-checkbox-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-checkbox.php' );
	} // field_checkbox()
	/**
	 * Creates an editor field
	 *
	 * NOTE: ID must only be lowercase letter, no spaces, dashes, or underscores.
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_editor( $args ) {
		$defaults['description'] 	= '';
		$defaults['settings'] 		= array( 'textarea_name' => $this->plugin_name . '-options[' . $args['id'] . ']' );
		$defaults['value'] 			= '';
		apply_filters( $this->plugin_name . '-field-editor-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-editor.php' );
	} // field_editor()
	/**
	 * Creates a set of radios field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_radios( $args ) {
		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;
		apply_filters( $this->plugin_name . '-field-radios-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-radios.php' );
	} // field_radios()
	public function field_repeater( $args ) {
		$defaults['class'] 			= 'repeater';
		$defaults['fields'] 		= array();
		$defaults['id'] 			= '';
		$defaults['label-add'] 		= 'Add Item';
		$defaults['label-edit'] 	= 'Edit Item';
		$defaults['label-header'] 	= 'Item Name';
		$defaults['label-remove'] 	= 'Remove Item';
		$defaults['title-field'] 	= '';
		$defaults['columns'] 		= 1;
/*
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
*/
		apply_filters( $this->plugin_name . '-field-repeater-options-defaults', $defaults );
		$setatts 	= wp_parse_args( $args, $defaults );
		$count 		= 1;
		$repeater 	= array();
		if ( ! empty( $this->options[$setatts['id']] ) ) {
			$repeater = maybe_unserialize( $this->options[$setatts['id']][0] );
		}
		if ( ! empty( $repeater ) ) {
			$count = count( $repeater );
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-repeater.php' );
	} // field_repeater()
	/**
	 * Creates a select field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_select( $args ) {
		
		$defaults = array();
		$defaults['aria'] 			= '';
		$defaults['blank'] 			= '';
		$defaults['class'] 			= 'widefat';
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['selections'] 	= array();
		$defaults['value'] 			= '';
		
		if(!is_array($defaults)) $defaults = [];
		apply_filters( $this->plugin_name . '-field-select-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {
			$atts['aria'] = $atts['description'];
		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {
			$atts['aria'] = $atts['label'];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-select.php' );
	} // field_select()
	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_text( $args ) {
		$defaults['class'] 			= 'text widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';
		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-text.php' );
	} // field_text()
	
	/**
	 * Creates a readonly text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_readonly( $args ) {
		$defaults['class'] 			= 'text widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= 'Placeholder Field - Cannot Be Edited';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';
		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-readonly.php' );
	} // field_readonly()
	
	/**
	 * Creates a number field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_number( $args ) {
		$defaults['class'] 			= 'number';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'number';
		$defaults['min'] 			= '0';
		$defaults['max'] 			= 'max';
		$defaults['step'] 			= '0.01';
		$defaults['value'] 			= '';
		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-number.php' );
	} // field_text()
	
	/**
	 * Creates a Color Picker field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_colorpicker( $args ) {
		$defaults['class'] 			= 'text colorpicker';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';
		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-colorpicker.php' );
	} // field_text()
	/**
	 * Creates a textarea field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_textarea( $args ) {
		$defaults['class'] 			= 'large-text';
		$defaults['cols'] 			= 50;
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['rows'] 			= 10;
		$defaults['value'] 			= '';
		apply_filters( $this->plugin_name . '-field-textarea-options-defaults', $defaults );
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-textarea.php' );
	} // field_textarea()
	
	/**
	 * Creates a Image Upload field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_image_upload( $args ) {
		$defaults['class'] 				= 'widefat url-file';
		//$defaults['id'] 				= '';
		$defaults['label-add'] 			= 'Add Image';
		$defaults['label-edit'] 		= 'Edit Image';
		$defaults['label-header'] 		= 'Image Name';
		$defaults['label-remove'] 		= 'Remove Image';
		$defaults['label-upload'] 		= 'Choose/Upload Image';
		$defaults['name'] 				= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 		= '';
		$defaults['type'] 				= 'hidden';
		$defaults['value'] 				= '';
		
		//echo '<p>DEFAULTS: ';
		//print_r($defaults);
		//echo '</p>';
		
		
		apply_filters( $this->plugin_name . '-field-image-options-defaults', $defaults );
		
		$atts = wp_parse_args( $args, $defaults );
		if ( ! empty( $this->options[$atts['id']] ) ) {
			$atts['value'] = $this->options[$atts['id']];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-image-upload.php' );
	} // field_image_upload()
	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {
		$options = array();
		$options[] = array( 'message-no-candidates', 'text', 'Thank you for your interest! There are no candidate openings at this time.' );
		$options[] = array('pipeline-columns','repeater', array(array('column-name','text'), array('column-abbreviation','text'), array('column-alt-name','text'), array('column-alt-abbreviation','text'), array('column-id','text'), array('column-width','number'), array('column-type','select') ) );
		return $options;
	} // get_options_list()
	/**
	 * Adds links to the plugin links row
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of row links
	 * @param 		string 		$file 		The name of the file
	 * @return 		array 					The modified array of row links
	 */
	public function link_row( $links, $file ) {
		if ( COMO_PIPELINE_FILE === $file ) {
			$links[] = '<a href="https://twitter.com/comocreative">Twitter</a>';
		}
		return $links;
	} // link_row()
	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of links
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {
		$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'edit.php?post_type=candidate&page=' . $this->plugin_name . '-settings' ) ), esc_html__( 'Settings', 'como-pipeline' ) );
		return $links;
	} // link_settings()
	/**
	 * Creates a new custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt_candidate() {
		$cap_type 	= 'post';
		$plural 	= 'Candidates';
		$single 	= 'Candidate';
		$cpt_name 	= 'candidate';
		//if(!is_array(EP_PERMALINK)) EP_PERMALINK = [];
		$opts = array();
		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']							= FALSE;
		$opts['hierarchical']							= TRUE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 'dashicons-chart-bar';
		$opts['menu_position']							= 25;
		$opts['public']									= TRUE;
		$opts['publicly_querable']						= FALSE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array('title','editor','excerpt','page-attributes','revisions');
		$opts['taxonomies']								= array();
		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";
		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'como-pipeline' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'como-pipeline' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'como-pipeline' );
		$opts['labels']['menu_name']					= esc_html__( 'Pipeline', 'como-pipeline' );
		$opts['labels']['name']							= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'como-pipeline' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'como-pipeline' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'como-pipeline' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'como-pipeline' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'como-pipeline' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'como-pipeline' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'como-pipeline' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'como-pipeline' );
		if (!is_array($opts['rewrite'])) { $opts['rewrite'] = array(); }
		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $plural ), 'como-pipeline' );
		$opts['rewrite']['with_front']					= FALSE;
		$opts = apply_filters( 'como-pipeline-cpt-options', $opts );
		register_post_type( strtolower( $cpt_name ), $opts );
		
		
		// Add Columns to Pipeline Admin Screen
		add_filter( 'manage_'. $cpt_name .'_posts_columns', 'set_custom_edit_pipeline_columns', 1);
		function set_custom_edit_pipeline_columns($columns) {
			unset($columns['title']);
			unset($columns['date']);
			unset($columns['wps_post_thumbs']);
			unset($columns['taxonomy-candidate_category']);
			unset($columns['taxonomy-candidate_type']);
			unset($columns['taxonomy-candidate_method']);
			$columns['title'] = __('Candidate', 'como-pipeline');
			$columns['candidate-progress'] = __('Progress', 'como-pipeline');
			$columns['taxonomy-candidate_category'] = __('Category', 'como-pipeline');
			$columns['taxonomy-candidate_type'] = __('Type', 'como-pipeline');
			$columns['taxonomy-candidate_method'] = __('Method', 'como-pipeline');
			//$columns['candidate-class'] = __('Class', 'como-pipeline');
			//$columns['candidate-link'] = __('Link', 'como-pipeline');
			//$columns['candidate-progress-text'] = __('Progress Text', 'como-pipeline');
			//$columns['candidate-disease'] = __('Disease', 'como-pipeline');
			
			$custCols = getCustomFields();
			$custCount = ((is_array($custCols)) ? count($custCols) : 0);
			
			if ($custCount > 0) {
				for ($c=0;$c<$custCount;$c++) {
					if (($custCols[$c][3] != 'title-column') && ($custCols[$c][3] != 'progress-column')) {
						if ($custCols[$c][1] != 'title') {
							$columns[$custCols[$c][0]] = __($custCols[$c][2], 'como-pipeline');
						} 
					}
					
				}
			}
			$columns['date'] = __( 'Date Published', 'como-pipeline' ); 
			unset($columns['wpseo-score']);
			unset($columns['wpseo-score-readability']);
			unset($columns['wpseo-title']);
			unset($columns['wpseo-metadesc']);
			unset($columns['wpseo-focuskw']);
			unset($columns['wpseo-links']);
			unset($columns['wpseo-linked']);
			return $columns;
		}
		// Add the data to the custom columns for the post type:
		add_action( 'manage_'. $cpt_name .'_posts_custom_column' , 'custom_pipeline_column', 1, 2 );
		function custom_pipeline_column( $column, $post_id ) {
			
			$custCols = array();
			$custCols[] = array('candidate-progress','number','Progress','text-column'); 
			$custCols[] = array('candidate-class','text','Class','text-column'); 
			$custCols[] = array('candidate-type','text','Type','text-column'); 
			//$custCols[] = array('candidate-link','text','Link','text-column'); 
			//$custCols[] = array('candidate-progress-text','text','Progress Text','text-column'); 
			//$custCols[] = array('candidate-disease','text','Disease','text-column'); 
 			$custCols = getCustomFields($custCols);
			$custCount = ((is_array($custCols)) ? count($custCols) : 0);
			
			if ($custCount > 0) {
				for ($c=0; $c<$custCount; $c++) {
					$key = true;
					do {
						if ($column == $custCols[$c][0]) {
							if ($custCols[$c][3] == 'title-column') {
								echo 'title'; 
								$key = false;
							} elseif ($custCols[$c][3] == 'indication-column') {
								if ($terms = get_the_terms($post_id,'indication')) {
									$term_string = join(', ', wp_list_pluck($terms, 'name'));
									echo $term_string;
								}
								$key = false;
							} elseif ($custCols[$c][3] == 'progress-column') {
								echo 'progress'; 
								$key = false;
							} elseif ($custCols[$c][0] == 'candidate-progress') {
								echo '<div class="progress"><div class="progress-bar" role="progressbar" style="width: '. get_post_meta($post_id ,$custCols[$c][0], true) .'%" aria-valuenow="'. get_post_meta($post_id ,$custCols[$c][0], true) .'" aria-valuemin="0" aria-valuemax="100">'. get_post_meta($post_id ,$custCols[$c][0], true) .'%</div></div>'; 
								$key = false;
							} elseif ($custCols[$c][1] == 'image') {
								if (!empty($custCols[$c][0])) {
									$imgID = get_post_meta($post_id ,$custCols[$c][0], true);
									echo wp_get_attachment_image($imgID, 'thumbnail', '', array('class'=>'img-responsive img-fluid'));
								}
								$key = false;
							} else {
								echo get_post_meta($post_id ,$custCols[$c][0], true);
								$key = false; 						
							}
						} else {
							$key = false;
						}
					 } while ($key);
				}
			}
		}
	} // new_cpt_candidate()
	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_category() {
		$plural 	= 'Categories';
		$single 	= 'Category';
		$tax_name 	= 'candidate_category';
		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= TRUE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['publicly_queryable']						= FALSE;
		$opts['exclude_from_search']					= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		$opts['has_archive'] 							= FALSE;
		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';
		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'como-pipeline' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'como-pipeline' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'como-pipeline' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'como-pipeline');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'como-pipeline' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'como-pipeline' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'como-pipeline' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'como-pipeline' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'como-pipeline' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'como-pipeline' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'como-pipeline' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'como-pipeline' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'como-pipeline' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'como-pipeline' );
		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'como-pipeline' );
		$opts['rewrite']['with_front']					= FALSE;
		$opts = apply_filters( 'como-pipeline-taxonomy-options', $opts );
		register_taxonomy( $tax_name, 'candidate', $opts );
	} // new_taxonomy_category()	
	
	public static function new_taxonomy_type() {
		$plural 	= 'Types';
		$single 	= 'Type';
		$tax_name 	= 'candidate_type';
		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= TRUE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['publicly_queryable']						= FALSE;
		$opts['exclude_from_search']					= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		$opts['has_archive'] 							= FALSE;
		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';
		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'como-pipeline' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'como-pipeline' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'como-pipeline' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'como-pipeline');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'como-pipeline' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'como-pipeline' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'como-pipeline' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'como-pipeline' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'como-pipeline' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'como-pipeline' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'como-pipeline' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'como-pipeline' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'como-pipeline' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'como-pipeline' );
		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'como-pipeline' );
		$opts['rewrite']['with_front']					= FALSE;
		$opts = apply_filters( 'como-pipeline-taxonomy-options', $opts );
		register_taxonomy( $tax_name, 'candidate', $opts );
	} // new_taxonomy_type()
	
	public static function new_taxonomy_method() {
		$plural 	= 'Methods';
		$single 	= 'method';
		$tax_name 	= 'candidate_method';
		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= TRUE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['publicly_queryable']						= FALSE;
		$opts['exclude_from_search']					= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		$opts['has_archive'] 							= FALSE;
		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';
		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'como-pipeline' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'como-pipeline' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'como-pipeline' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'como-pipeline');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'como-pipeline' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'como-pipeline' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'como-pipeline' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'como-pipeline' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'como-pipeline' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'como-pipeline' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'como-pipeline' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'como-pipeline' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'como-pipeline' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'como-pipeline' );
		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'como-pipeline' );
		$opts['rewrite']['with_front']					= FALSE;
		$opts = apply_filters( 'como-pipeline-taxonomy-options', $opts );
		register_taxonomy( $tax_name, 'candidate', $opts );
	} // new_taxonomy_method()
	
	public static function indication_taxonomy_type() {
		$plural 	= 'Indications';
		$single 	= 'Indication';
		$tax_name 	= 'indication';
		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';
		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';
		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'como-pipeline' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'como-pipeline' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'como-pipeline' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'como-pipeline');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'como-pipeline' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'como-pipeline' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'como-pipeline' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'como-pipeline' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'como-pipeline' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'como-pipeline' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'como-pipeline' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'como-pipeline' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'como-pipeline' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'como-pipeline' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'como-pipeline' );
		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'como-pipeline' );
		$opts['rewrite']['with_front']					= FALSE;
		$opts = apply_filters( 'como-pipeline-taxonomy-options', $opts );
		register_taxonomy( $tax_name, 'candidate', $opts );
	} // indication_taxonomy_type()
	
	
	
	
	
	/**
	 * Creates the help page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_help() {
		include( plugin_dir_path( __FILE__ ) . 'partials/como-pipeline-admin-page-help.php' );
	} // page_help()
	/**
	 * Creates the options page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_options() {
		include( plugin_dir_path( __FILE__ ) . 'partials/como-pipeline-admin-page-settings.php' );
	} // page_options()
	/**
	 * Registers settings fields with WordPress
	 */
	public function register_fields() {
		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		add_settings_field(
			'message-no-candidates',
			apply_filters( $this->plugin_name . 'label-message-no-candidates', esc_html__( 'No Pipeline Message', 'como-pipeline' ) ),
			array( $this, 'field_textarea' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'This message displays on the page if no candidates are found.',
				'id' 			=> 'message-no-candidates',
				'value' 		=> 'Thank you for your interest! There are no candidate openings at this time.',
				'placeholder' 		=> 'Thank you for your interest! There are no candidate openings at this time.',
			)
		);
		add_settings_field(
			'pipeline-columns',
			apply_filters( $this->plugin_name . 'label-pipeline-columns', esc_html__( 'Pipeline Columns', 'como-pipeline' ) ),
			array( $this, 'field_repeater' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> '',
				'fields' 		=> array(
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'column-name',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[column-name]',
							'placeholder' 	=> 'Column Name',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'column-abbreviation',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[column-abbreviation]',
							'placeholder' 	=> 'Column Abbreviation',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'column-alt-name',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[column-alt-name]',
							'placeholder' 	=> 'Column Alternate Name',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'column-alt-abbreviation',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[column-alt-abbreviation]',
							'placeholder' 	=> 'Column Alternate Abbreviation',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
					array(
						'text' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'column-id',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[column-id]',
							'placeholder' 	=> 'Column ID',
							'type' 			=> 'text',
							'value' 		=> ''
						),
					),
					array(
						'number' => array(
							'class' 		=> '',
							'description' 	=> '',
							'id' 			=> 'column-width',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[column-width]',
							'placeholder' 	=> 'Column Width',
							'type' 			=> 'number',
							'value' 		=> '',
							'min' 		    => '0',
							'max' 			=> '100',
							'step'			=> '0.01'
						),
					),
					array(
						'select' => array(
							'aria'			=> '',
							'blank'			=> '< select column type >',
							'class' 		=> '',
							'context' 		=> '',
							'description' 	=> '',
							'id' 			=> 'column-type',
							'label' 		=> '',
							'name' 			=> $this->plugin_name . '-options[column-type]',
							'selections' 	=> array(
								array('label'=>'Text Column','value'=>'text-column'),
								array('label'=>'Title Column','value'=>'title-column'),
								array('label'=>'Progress Column','value'=>'progress-column'),
								array('label'=>'Image Column','value'=>'image-column'),
								array('label'=>'Type Column','value'=>'type-column'),
								array('label'=>'Indication Column','value'=>'indication-column'),
								array('label'=>'Textarea Column','value'=>'textarea-column'),
								array('label'=>'Read-Only Column','value'=>'readonly-column')
							),
							'value' 		=> ''
						),
					),
				),
				'id' 			=> 'pipeline-columns',
				'label-add' 	=> 'Add Column',
				'label-edit' 	=> 'Edit Column',
				'label-header' 	=> 'Column',
				'label-remove' 	=> 'Remove Column',
				'title-field' 	=> 'column-name'
			)
		);
	} // register_fields()
	
	
	
	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->plugin_name . '-messages',
			apply_filters( $this->plugin_name . 'section-title-messages', esc_html__( 'Messages', 'como-pipeline' ) ),
			array( $this, 'section_messages' ),
			$this->plugin_name
		);
	} // register_sections()
	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function register_settings() {
		// register_setting( $option_group, $option_name, $sanitize_callback );
		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);
	} // register_settings()
	private function sanitizer( $type, $data ) {
		if ( empty( $type ) ) { return; }
		if ( empty( $data ) ) { return; }
		$return 	= '';
		$sanitizer 	= new Como_Pipeline_Sanitize();
		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );
		$return = $sanitizer->clean();
		unset( $sanitizer );
		return $return;
	} // sanitizer()
	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function section_messages( $params ) {
		include( plugin_dir_path( __FILE__ ) . 'partials/como-pipeline-admin-section-messages.php' );
	} // section_messages()
	/**
	 * Sets the class variable $options
	 */
	private function set_options() {
		$this->options = get_option( $this->plugin_name . '-options' );
	} // set_options()
	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin options
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {
		//wp_die( print_r( $input ) );
		$valid 		= array();
		$options 	= $this->get_options_list();
		//foreach ($_POST as $k=>$v) { echo $k .' : '. $v .'<br>'; }
		
		foreach ( $options as $option ) {
			$name = $option[0];
			$type = $option[1];
			
			//if (isset($_POST[$name])) {
				if ( 'repeater' === $type && is_array( $option[2] ) ) {
					$clean = array();
					foreach ( $option[2] as $field ) {
						foreach ( $input[$field[0]] as $data ) {
							//if ( empty( $data ) ) { continue; }
							$clean[$field[0]][] = $this->sanitizer( $field[1], $data );
						} // foreach
					} // foreach
					$count = como_pipeline_get_max( $clean );
					for ( $i = 0; $i < $count; $i++ ) {
						foreach ( $clean as $field_name => $field ) {
							//echo $field_name .' : '. implode(' - ',$field) .'<br>'; 
							if (isset($field[$i])) {
								$valid[$option[0]][$i][$field_name] = $field[$i];
							}
						} // foreach $clean
					} // for
				} else {
					if (isset($input[$name])) {
						$valid[$option[0]] = $this->sanitizer( $type, $input[$name] );
					}
				}
			//}
				/*if ( ! isset( $input[$option[0]] ) ) { continue; }
				$sanitizer = new Como_Pipeline_Sanitize();
				$sanitizer->set_data( $input[$option[0]] );
				$sanitizer->set_type( $option[1] );
				$valid[$option[0]] = $sanitizer->clean();
				if ( $valid[$option[0]] != $input[$option[0]] ) {
					add_settings_error( $option[0], $option[0] . '_error', esc_html__( $option[0] . ' error.', 'como-pipeline' ), 'error' );
				}
				unset( $sanitizer );*/
		}
		return $valid;
	} // validate_options()
} // class
/********* TinyMCE Button Add-On ***********/
// Get Candidate Categories
if (!function_exists('comopipeline_get_categories')) {
	function comopipeline_get_categories() {
		$taxArr = array();
		$terms = get_terms( array(
			'taxonomy' => 'candidate_category',
			'hide_empty' => true
		) );
		if (count($terms) > 0) {
			$taxArr[] = array('value'=>'','text'=>'All');
			foreach ($terms as $term) {
				$taxArr[] = array('value'=>$term->slug,'text'=>$term->name);
			}
		}
		$taxArr = json_encode($taxArr);
		return $taxArr;
	}
}
// Get Candidate Types
if (!function_exists('comopipeline_get_types')) {
	function comopipeline_get_types() {
		$taxArr = array();
		$terms = get_terms( array(
			'taxonomy' => 'candidate_type',
			'hide_empty' => true
		) );
		if (count($terms) > 0) {
			$taxArr[] = array('value'=>'','text'=>'All');
			foreach ($terms as $term) {
				$taxArr[] = array('value'=>$term->slug,'text'=>$term->name);
			}
		}
		$taxArr = json_encode($taxArr);
		return $taxArr;
	}
}
// Get Candidate Methods
if (!function_exists('comopipeline_get_methods')) {
	function comopipeline_get_methods() {
		$taxArr = array();
		$terms = get_terms( array(
			'taxonomy' => 'candidate_method',
			'hide_empty' => true
		) );
		if (count($terms) > 0) {
			$taxArr[] = array('value'=>'','text'=>'All');
			foreach ($terms as $term) {
				$taxArr[] = array('value'=>$term->slug,'text'=>$term->name);
			}
		}
		$taxArr = json_encode($taxArr);
		return $taxArr;
	}
}
// Get Candidate Indications
if (!function_exists('comopipeline_get_indications')) {
	function comopipeline_get_indications() {
		$taxArr = array();
		$terms = get_terms( array(
			'taxonomy' => 'indication',
			'hide_empty' => true
		) );
		if (count($terms) > 0) {
			$taxArr[] = array('value'=>'','text'=>'All');
			foreach ($terms as $term) {
				$taxArr[] = array('value'=>$term->slug,'text'=>$term->name);
			}
		}
		$taxArr = json_encode($taxArr);
		return $taxArr;
	}
}
add_action( 'after_setup_theme', 'comopipeline_button_setup' );
if (!function_exists('comopipeline_button_setup')) {
    function comopipeline_button_setup() {
        add_action( 'init', 'comopipeline_button' );
    }
}
if ( ! function_exists( 'comopipeline_button' ) ) {
    function comopipeline_button() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }
        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }
        add_filter( 'mce_external_plugins', 'comopipeline_add_buttons' );
        add_filter( 'mce_buttons', 'comopipeline_register_buttons' );
    }
}
if ( ! function_exists( 'comopipeline_add_buttons' ) ) {
    function comopipeline_add_buttons( $plugin_array ) {
        $plugin_array['comoPipelineButton'] = plugin_dir_url( __FILE__ ) .'js/tinymce_pipeline_button.js';
        return $plugin_array;
    }
}
if ( ! function_exists( 'comopipeline_register_buttons' ) ) {
    function comopipeline_register_buttons( $buttons ) {
        array_push( $buttons, 'comoPipelineButton' );
        return $buttons;
    }
}
add_action ( 'after_wp_tiny_mce', 'comopipeline_tinymce_extra_vars' );
if ( !function_exists( 'comopipeline_tinymce_extra_vars' ) ) {
	function comopipeline_tinymce_extra_vars() { 
		$candidateCats = comopipeline_get_categories();
		$candidateTypes = comopipeline_get_types();
		$candidateMethods = comopipeline_get_methods();
		?>
		<script type="text/javascript">
			var tinyMCE_pipeline = <?php echo json_encode(
				array(
					'button_name' => esc_html__('Embed Pipeline', 'como-pipeline'),
					'button_title' => esc_html__('Embed Pipeline', 'como-pipeline'),
					'candidate_category_select_options' => $candidateCats,
					'candidate_type_select_options' => $candidateTypes,
					'candidate_method_select_options' => $candidateMethods,
				)
			);
			?>;
		</script><?php
	} 	
}
/**
 * Taxonomy Image Plugin class
 * @since 1.0.2
 **/
// Candidate Category Extra Fields
if( ! class_exists( 'Add_candidate_category_Images' ) ) {
	  class Add_candidate_category_Images {
		public function __construct() {
		 //
		}
		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		 public function init() {
		 // Image actions
		 add_action( 'candidate_category_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
		 add_action( 'created_candidate_category', array( $this, 'save_category_image' ), 10, 2 );
		 add_action( 'candidate_category_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
		 add_action( 'edited_candidate_category', array( $this, 'updated_category_image' ), 10, 2 );
		 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
		 add_action( 'admin_footer', array( $this, 'add_script' ) );
	   }
	   public function load_media() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_category' ) {
		   return;
		 }
		 wp_enqueue_media();
	   }
	   /**
		* Add a form field in the new category page
		*/
	   public function add_category_image( $taxonomy ) { ?>
		 <div class="form-field term-group">
		   <label for="candidate-category-image"><?php _e( 'Image', 'como-pipeline' ); ?></label>
		   <input type="hidden" id="candidate-category-image" name="candidate-category-image" class="custom_media_url" value="">
		   <div id="category-image-wrapper"></div>
		   <p>
			 <input type="button" class="button button-secondary candidate_category_tax_media_button" id="candidate_category_tax_media_button" name="candidate_category_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
			 <input type="button" class="button button-secondary candidate_category_tax_media_remove" id="candidate_category_tax_media_remove" name="candidate_category_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
		   </p>
		 </div>
	   <?php }
	   /**
		* Save the form field
		*/
	   public function save_category_image( $term_id, $tt_id ) {
		 if( isset( $_POST['candidate-category-image'] ) && '' !== $_POST['candidate-category-image'] ){
		   add_term_meta( $term_id, 'candidate-category-image', absint( $_POST['candidate-category-image'] ), true );
		 }
		}
		/**
		 * Edit the form field
		 */
		public function update_category_image( $term, $taxonomy ) { ?>
		  <tr class="form-field term-group-wrap">
			<th scope="row">
			  <label for="candidate-category-image"><?php _e( 'Image', 'como-pipeline' ); ?></label>
			</th>
			<td>
			  <?php $image_id = get_term_meta( $term->term_id, 'candidate-category-image', true ); ?>
			  <input type="hidden" id="candidate-category-image" name="candidate-category-image" value="<?php echo esc_attr( $image_id ); ?>">
			  <div id="category-image-wrapper">
				<?php if( $image_id ) { ?>
				  <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
				<?php } ?>
			  </div>
			  <p>
				<input type="button" class="button button-secondary candidate_category_tax_media_button" id="candidate_category_tax_media_button" name="candidate_category_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
				<input type="button" class="button button-secondary candidate_category_tax_media_remove" id="candidate_category_tax_media_remove" name="candidate_category_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
			  </p>
			</td>
		  </tr>
	   <?php }
	   /**
		* Update the form field value
		*/
	   public function updated_category_image( $term_id, $tt_id ) {
		 if( isset( $_POST['candidate-category-image'] ) && '' !== $_POST['candidate-category-image'] ){
		   update_term_meta( $term_id, 'candidate-category-image', absint( $_POST['candidate-category-image'] ) );
		 } else {
		   update_term_meta( $term_id, 'candidate-category-image', '' );
		 }
	   }
	   /**
		* Enqueue styles and scripts
		*/
	   public function add_script() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_category' ) {
		   return;
		 } ?>
		 <script> jQuery(document).ready( function($) {
		   _wpMediaViewsL10n.insertIntoPost = '<?php _e( "Insert", "como-pipeline" ); ?>';
		   function ct_media_upload(button_class) {
			 var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
			 $('body').on('click', button_class, function(e) {
			   var button_id = '#'+$(this).attr('id');
			   var send_attachment_bkp = wp.media.editor.send.attachment;
			   var button = $(button_id);
			   _custom_media = true;
			   wp.media.editor.send.attachment = function(props, attachment){
				 if( _custom_media ) {
				   $('#candidate-category-image').val(attachment.id);
				   $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
				   $( '#category-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
				 } else {
				   return _orig_send_attachment.apply( button_id, [props, attachment] );
				 }
			   }
			   wp.media.editor.open(button); return false;
			 });
		   }
		   ct_media_upload('.candidate_category_tax_media_button.button');
		   $('body').on('click','.candidate_category_tax_media_remove',function(){
			 $('#candidate-category-image').val('');
			 $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
		   });
			$(document).ajaxComplete(function(event, xhr, settings) {
			 var queryStringArr = settings.data.split('&');
			 if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
			   var xml = xhr.responseXML;
			   $response = $(xml).find('term_id').text();
			   if($response!=""){
				 // Clear the thumb image
				 $('#category-image-wrapper').html('');
			   }
			  }
			});
		  });
		</script>
	   <?php }
	  }
	$Add_candidate_category_Images = new Add_candidate_category_Images();
	$Add_candidate_category_Images->init(); 
}
if( ! class_exists( 'Add_candidate_category_Extra_Fields' ) ) {
	  class Add_candidate_category_Extra_Fields {
		public function __construct() {
		 //
		}
		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		 public function init() {
		 // Image actions
		 add_action( 'candidate_category_add_form_fields', array( $this, 'add_candidate_category_fields' ), 10, 2 );
		 add_action( 'created_candidate_category', array( $this, 'save_candidate_category_extra_fields' ), 10, 2 );
		 add_action( 'candidate_category_edit_form_fields', array( $this, 'update_candidate_category_fields' ), 10, 2 );
		 add_action( 'edited_candidate_category', array( $this, 'update_candidatetype_fields' ), 10, 2 );
		 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
		 //add_action( 'admin_footer', array( $this, 'add_script' ) );
	   }
	   public function load_media() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_category' ) {
		   return;
		 }
		 wp_enqueue_media();
	   }
	   /**
		* Add a form field in the new category page
		*/
	   public function add_candidate_category_fields( $taxonomy ) { ?>
		 <div class="form-field term-group">
		   <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
		   <input type="text" id="abbreviation" name="abbreviation" value="">
		 </div>
	   <?php }
	   /**
		* Save the form field
		*/
	   public function save_candidate_category_extra_fields( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   add_term_meta( $term_id, 'abbreviation', wp_kses_post( $_POST['abbreviation'] ), true );
		 }
		}
		/**
		 * Edit the form field
		 */
		public function update_candidate_category_fields( $term, $taxonomy ) { ?>
		  <tr class="form-field term-group-wrap">
			<th scope="row">
			  <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
			</th>
			<td>
			  <?php $abbrev = get_term_meta( $term->term_id, 'abbreviation', true ); ?>
			  <input type="text" id="abbreviation" name="abbreviation" value="<?php echo esc_attr($abbrev); ?>">
			</td>
		  </tr>
	   <?php }
	   /**
		* Update the form field value
		*/
	   public function update_candidatetype_fields( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   update_term_meta( $term_id, 'abbreviation', wp_kses_post( $_POST['abbreviation'] ) );
		 } else {
		   update_term_meta( $term_id, 'abbreviation', '' );
		 }
	   }
	  }
	$Add_candidate_category_Extra_Fields = new Add_candidate_category_Extra_Fields();
	$Add_candidate_category_Extra_Fields->init(); 
}
// Candidate Type Extra Fields
if( ! class_exists( 'Add_Candidate_type_Images' ) ) {
	  class Add_Candidate_type_Images {
		public function __construct() {
		 //
		}
		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		 public function init() {
		 // Image actions
		 add_action( 'candidate_type_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
		 add_action( 'created_candidate_type', array( $this, 'save_category_image' ), 10, 2 );
		 add_action( 'candidate_type_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
		 add_action( 'edited_candidate_type', array( $this, 'updated_category_image' ), 10, 2 );
		 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
		 add_action( 'admin_footer', array( $this, 'add_script' ) );
	   }
	   public function load_media() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_type' ) {
		   return;
		 }
		 wp_enqueue_media();
	   }
	   /**
		* Add a form field in the new category page
		*/
	   public function add_category_image( $taxonomy ) { ?>
		 <div class="form-field term-group">
		   <label for="candidate-type-image"><?php _e( 'Image', 'como-pipeline' ); ?></label>
		   <input type="hidden" id="candidate-type-image" name="candidate-type-image" class="custom_media_url" value="">
		   <div id="category-image-wrapper"></div>
		   <p>
			 <input type="button" class="button button-secondary candidate_type_tax_media_button" id="candidate_type_tax_media_button" name="candidate_type_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
			 <input type="button" class="button button-secondary candidate_type_tax_media_remove" id="candidate_type_tax_media_remove" name="candidate_type_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
		   </p>
		 </div>
	   <?php }
	   /**
		* Save the form field
		*/
	   public function save_category_image( $term_id, $tt_id ) {
		 if( isset( $_POST['candidate-type-image'] ) && '' !== $_POST['candidate-type-image'] ){
		   add_term_meta( $term_id, 'candidate-type-image', absint( $_POST['candidate-type-image'] ), true );
		 }
		}
		/**
		 * Edit the form field
		 */
		public function update_category_image( $term, $taxonomy ) { ?>
		  <tr class="form-field term-group-wrap">
			<th scope="row">
			  <label for="candidate-type-image"><?php _e( 'Image', 'como-pipeline' ); ?></label>
			</th>
			<td>
			  <?php $image_id = get_term_meta( $term->term_id, 'candidate-type-image', true ); ?>
			  <input type="hidden" id="candidate-type-image" name="candidate-type-image" value="<?php echo esc_attr( $image_id ); ?>">
			  <div id="category-image-wrapper">
				<?php if( $image_id ) { ?>
				  <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
				<?php } ?>
			  </div>
			  <p>
				<input type="button" class="button button-secondary candidate_type_tax_media_button" id="candidate_type_tax_media_button" name="candidate_type_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
				<input type="button" class="button button-secondary candidate_type_tax_media_remove" id="candidate_type_tax_media_remove" name="candidate_type_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
			  </p>
			</td>
		  </tr>
	   <?php }
	   /**
		* Update the form field value
		*/
	   public function updated_category_image( $term_id, $tt_id ) {
		 if( isset( $_POST['candidate-type-image'] ) && '' !== $_POST['candidate-type-image'] ){
		   update_term_meta( $term_id, 'candidate-type-image', absint( $_POST['candidate-type-image'] ) );
		 } else {
		   update_term_meta( $term_id, 'candidate-type-image', '' );
		 }
	   }
	   /**
		* Enqueue styles and scripts
		*/
	   public function add_script() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_type' ) {
		   return;
		 } ?>
		 <script> jQuery(document).ready( function($) {
		   _wpMediaViewsL10n.insertIntoPost = '<?php _e( "Insert", "como-pipeline" ); ?>';
		   function ct_media_upload(button_class) {
			 var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
			 $('body').on('click', button_class, function(e) {
			   var button_id = '#'+$(this).attr('id');
			   var send_attachment_bkp = wp.media.editor.send.attachment;
			   var button = $(button_id);
			   _custom_media = true;
			   wp.media.editor.send.attachment = function(props, attachment){
				 if( _custom_media ) {
				   $('#candidate-type-image').val(attachment.id);
				   $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
				   $( '#category-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
				 } else {
				   return _orig_send_attachment.apply( button_id, [props, attachment] );
				 }
			   }
			   wp.media.editor.open(button); return false;
			 });
		   }
		   ct_media_upload('.candidate_type_tax_media_button.button');
		   $('body').on('click','.candidate_type_tax_media_remove',function(){
			 $('#candidate-type-image').val('');
			 $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
		   });
			$(document).ajaxComplete(function(event, xhr, settings) {
			 var queryStringArr = settings.data.split('&');
			 if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
			   var xml = xhr.responseXML;
			   $response = $(xml).find('term_id').text();
			   if($response!=""){
				 // Clear the thumb image
				 $('#category-image-wrapper').html('');
			   }
			  }
			});
		  });
		</script>
	   <?php }
	  }
	$Add_Candidate_type_Images = new Add_Candidate_type_Images();
	$Add_Candidate_type_Images->init(); 
}
// Add Indication Fields
if( ! class_exists( 'Add_Indication_Extra_Fields' ) ) {
	  class Add_Indication_Extra_Fields {
		public function __construct() {
		 //
		}
		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		 public function init() {
		 // Image actions
		 add_action( 'indication_add_form_fields', array( $this, 'add_indication_fields' ), 10, 2 );
		 add_action( 'created_indication', array( $this, 'save_category_image' ), 10, 2 );
		 add_action( 'indication_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
		 add_action( 'edited_indication', array( $this, 'updated_indication_fields' ), 10, 2 );
		 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
		 //add_action( 'admin_footer', array( $this, 'add_script' ) );
	   }
	   public function load_media() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'indication' ) {
		   return;
		 }
		 wp_enqueue_media();
	   }
	   /**
		* Add a form field in the new category page
		*/
	   public function add_indication_fields( $taxonomy ) { ?>
		 <div class="form-field term-group">
		   <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
		   <input type="text" id="abbreviation" name="abbreviation" value="">
		 </div>
	   <?php }
	   /**
		* Save the form field
		*/
	   public function save_category_image( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   add_term_meta( $term_id, 'abbreviation', absint( $_POST['abbreviation'] ), true );
		 }
		}
		/**
		 * Edit the form field
		 */
		public function update_category_image( $term, $taxonomy ) { ?>
		  <tr class="form-field term-group-wrap">
			<th scope="row">
			  <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
			</th>
			<td>
			  <?php $abbrev = get_term_meta( $term->term_id, 'abbreviation', true ); ?>
			  <input type="text" id="abbreviation" name="abbreviation" value="<?php echo esc_attr($abbrev); ?>">
			</td>
		  </tr>
	   <?php }
	   /**
		* Update the form field value
		*/
	   public function updated_indication_fields( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   update_term_meta( $term_id, 'abbreviation', wp_kses_post( $_POST['abbreviation'] ) );
		 } else {
		   update_term_meta( $term_id, 'abbreviation', '' );
		 }
	   }
	  }
	$Add_Indication_Extra_Fields = new Add_Indication_Extra_Fields();
	$Add_Indication_Extra_Fields->init(); 
}
// Add Type Field
if( ! class_exists( 'Add_Candidate_Type_Extra_Fields' ) ) {
	  class Add_Candidate_Type_Extra_Fields {
		public function __construct() {
		 //
		}
		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		 public function init() {
		 // Image actions
		 add_action( 'candidate_type_add_form_fields', array( $this, 'add_candidate_type_fields' ), 10, 2 );
		 add_action( 'created_candidate_type', array( $this, 'save_candidate_type_extra_fields' ), 10, 2 );
		 add_action( 'candidate_type_edit_form_fields', array( $this, 'update_candidate_type_fields' ), 10, 2 );
		 add_action( 'edited_candidate_type', array( $this, 'update_candidatetype_fields' ), 10, 2 );
		 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
		 //add_action( 'admin_footer', array( $this, 'add_script' ) );
	   }
	   public function load_media() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_type' ) {
		   return;
		 }
		 wp_enqueue_media();
	   }
	   /**
		* Add a form field in the new category page
		*/
	   public function add_candidate_type_fields( $taxonomy ) { ?>
		 <div class="form-field term-group">
		   <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
		   <input type="text" id="abbreviation" name="abbreviation" value="">
		 </div>
	   <?php }
	   /**
		* Save the form field
		*/
	   public function save_candidate_type_extra_fields( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   add_term_meta( $term_id, 'abbreviation', wp_kses_post( $_POST['abbreviation'] ), true );
		 }
		}
		/**
		 * Edit the form field
		 */
		public function update_candidate_type_fields( $term, $taxonomy ) { ?>
		  <tr class="form-field term-group-wrap">
			<th scope="row">
			  <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
			</th>
			<td>
			  <?php $abbrev = get_term_meta( $term->term_id, 'abbreviation', true ); ?>
			  <input type="text" id="abbreviation" name="abbreviation" value="<?php echo esc_attr($abbrev); ?>">
			</td>
		  </tr>
	   <?php }
	   /**
		* Update the form field value
		*/
	   public function update_candidatetype_fields( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   update_term_meta( $term_id, 'abbreviation', wp_kses_post( $_POST['abbreviation'] ) );
		 } else {
		   update_term_meta( $term_id, 'abbreviation', '' );
		 }
	   }
	  }
	$Add_Candidate_Type_Extra_Fields = new Add_Candidate_Type_Extra_Fields();
	$Add_Candidate_Type_Extra_Fields->init(); 
}
// Candidate Method Extra Fields
if( ! class_exists( 'Add_candidate_method_Images' ) ) {
	  class Add_candidate_method_Images {
		public function __construct() {
		 //
		}
		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		 public function init() {
		 // Image actions
		 add_action( 'candidate_method_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
		 add_action( 'created_candidate_method', array( $this, 'save_category_image' ), 10, 2 );
		 add_action( 'candidate_method_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
		 add_action( 'edited_candidate_method', array( $this, 'updated_category_image' ), 10, 2 );
		 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
		 add_action( 'admin_footer', array( $this, 'add_script' ) );
	   }
	   public function load_media() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_method' ) {
		   return;
		 }
		 wp_enqueue_media();
	   }
	   /**
		* Add a form field in the new category page
		*/
	   public function add_category_image( $taxonomy ) { ?>
		 <div class="form-field term-group">
		   <label for="candidate-category-image"><?php _e( 'Image', 'como-pipeline' ); ?></label>
		   <input type="hidden" id="candidate-category-image" name="candidate-category-image" class="custom_media_url" value="">
		   <div id="category-image-wrapper"></div>
		   <p>
			 <input type="button" class="button button-secondary candidate_method_tax_media_button" id="candidate_method_tax_media_button" name="candidate_method_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
			 <input type="button" class="button button-secondary candidate_method_tax_media_remove" id="candidate_method_tax_media_remove" name="candidate_method_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
		   </p>
		 </div>
	   <?php }
	   /**
		* Save the form field
		*/
	   public function save_category_image( $term_id, $tt_id ) {
		 if( isset( $_POST['candidate-category-image'] ) && '' !== $_POST['candidate-category-image'] ){
		   add_term_meta( $term_id, 'candidate-category-image', absint( $_POST['candidate-category-image'] ), true );
		 }
		}
		/**
		 * Edit the form field
		 */
		public function update_category_image( $term, $taxonomy ) { ?>
		  <tr class="form-field term-group-wrap">
			<th scope="row">
			  <label for="candidate-category-image"><?php _e( 'Image', 'como-pipeline' ); ?></label>
			</th>
			<td>
			  <?php $image_id = get_term_meta( $term->term_id, 'candidate-category-image', true ); ?>
			  <input type="hidden" id="candidate-category-image" name="candidate-category-image" value="<?php echo esc_attr( $image_id ); ?>">
			  <div id="category-image-wrapper">
				<?php if( $image_id ) { ?>
				  <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
				<?php } ?>
			  </div>
			  <p>
				<input type="button" class="button button-secondary candidate_method_tax_media_button" id="candidate_method_tax_media_button" name="candidate_method_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
				<input type="button" class="button button-secondary candidate_method_tax_media_remove" id="candidate_method_tax_media_remove" name="candidate_method_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
			  </p>
			</td>
		  </tr>
	   <?php }
	   /**
		* Update the form field value
		*/
	   public function updated_category_image( $term_id, $tt_id ) {
		 if( isset( $_POST['candidate-category-image'] ) && '' !== $_POST['candidate-category-image'] ){
		   update_term_meta( $term_id, 'candidate-category-image', absint( $_POST['candidate-category-image'] ) );
		 } else {
		   update_term_meta( $term_id, 'candidate-category-image', '' );
		 }
	   }
	   /**
		* Enqueue styles and scripts
		*/
	   public function add_script() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_method' ) {
		   return;
		 } ?>
		 <script> jQuery(document).ready( function($) {
		   _wpMediaViewsL10n.insertIntoPost = '<?php _e( "Insert", "como-pipeline" ); ?>';
		   function ct_media_upload(button_class) {
			 var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
			 $('body').on('click', button_class, function(e) {
			   var button_id = '#'+$(this).attr('id');
			   var send_attachment_bkp = wp.media.editor.send.attachment;
			   var button = $(button_id);
			   _custom_media = true;
			   wp.media.editor.send.attachment = function(props, attachment){
				 if( _custom_media ) {
				   $('#candidate-category-image').val(attachment.id);
				   $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
				   $( '#category-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
				 } else {
				   return _orig_send_attachment.apply( button_id, [props, attachment] );
				 }
			   }
			   wp.media.editor.open(button); return false;
			 });
		   }
		   ct_media_upload('.candidate_method_tax_media_button.button');
		   $('body').on('click','.candidate_method_tax_media_remove',function(){
			 $('#candidate-category-image').val('');
			 $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
		   });
			$(document).ajaxComplete(function(event, xhr, settings) {
			 var queryStringArr = settings.data.split('&');
			 if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
			   var xml = xhr.responseXML;
			   $response = $(xml).find('term_id').text();
			   if($response!=""){
				 // Clear the thumb image
				 $('#category-image-wrapper').html('');
			   }
			  }
			});
		  });
		</script>
	   <?php }
	  }
	$Add_candidate_method_Images = new Add_candidate_method_Images();
	$Add_candidate_method_Images->init(); 
}
if( ! class_exists( 'Add_candidate_method_Extra_Fields' ) ) {
	  class Add_candidate_method_Extra_Fields {
		public function __construct() {
		 //
		}
		/**
		 * Initialize the class and start calling our hooks and filters
		 */
		 public function init() {
		 // Image actions
		 add_action( 'candidate_method_add_form_fields', array( $this, 'add_candidate_method_fields' ), 10, 2 );
		 add_action( 'created_candidate_method', array( $this, 'save_candidate_method_extra_fields' ), 10, 2 );
		 add_action( 'candidate_method_edit_form_fields', array( $this, 'update_candidate_method_fields' ), 10, 2 );
		 add_action( 'edited_candidate_method', array( $this, 'update_candidatetype_fields' ), 10, 2 );
		 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
		 //add_action( 'admin_footer', array( $this, 'add_script' ) );
	   }
	   public function load_media() {
		 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'candidate_method' ) {
		   return;
		 }
		 wp_enqueue_media();
	   }
	   /**
		* Add a form field in the new category page
		*/
	   public function add_candidate_method_fields( $taxonomy ) { ?>
		 <div class="form-field term-group">
		   <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
		   <input type="text" id="abbreviation" name="abbreviation" value="">
		 </div>
	   <?php }
	   /**
		* Save the form field
		*/
	   public function save_candidate_method_extra_fields( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   add_term_meta( $term_id, 'abbreviation', wp_kses_post( $_POST['abbreviation'] ), true );
		 }
		}
		/**
		 * Edit the form field
		 */
		public function update_candidate_method_fields( $term, $taxonomy ) { ?>
		  <tr class="form-field term-group-wrap">
			<th scope="row">
			  <label for="abbreviation"><?php _e( 'Abbreviation', 'como-pipeline' ); ?></label>
			</th>
			<td>
			  <?php $abbrev = get_term_meta( $term->term_id, 'abbreviation', true ); ?>
			  <input type="text" id="abbreviation" name="abbreviation" value="<?php echo esc_attr($abbrev); ?>">
			</td>
		  </tr>
	   <?php }
	   /**
		* Update the form field value
		*/
	   public function update_candidatetype_fields( $term_id, $tt_id ) {
		 if( isset( $_POST['abbreviation'] ) && '' !== $_POST['abbreviation'] ){
		   update_term_meta( $term_id, 'abbreviation', wp_kses_post( $_POST['abbreviation'] ) );
		 } else {
		   update_term_meta( $term_id, 'abbreviation', '' );
		 }
	   }
	  }
	$Add_candidate_method_Extra_Fields = new Add_candidate_method_Extra_Fields();
	$Add_candidate_method_Extra_Fields->init(); 
}