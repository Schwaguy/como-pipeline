<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/admin
 */
/**
 * The metabox-specific functionality of the plugin.
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/admin
 * @author 		Slushman <chris@slushman.com>
 */
class Como_Pipeline_Admin_Metaboxes {
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
		$this->set_meta();
	}
	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_metaboxes() {
		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
		add_meta_box(
			'como_pipeline_candidate_pipeline_info',
			apply_filters( $this->plugin_name . '-metabox-title-pipeline-info', esc_html__( 'Candidate Details', 'como-pipeline' ) ),
			array( $this, 'metabox' ),
			'candidate',
			'after_title',
			'high',
			array(
				'file' => 'candidate-pipeline-info'
			)
		);
		
		add_meta_box(
			'como_pipeline_candidate_trials',
			apply_filters( $this->plugin_name . '-metabox-title-candidate-pipeline-trials', esc_html__( 'Candidate Trials', 'como-pipeline' ) ),
			array( $this, 'metabox' ),
			'candidate',
			'after_title',
			'high',
			array(
				'file' => 'candidate-pipeline-trials'
			)
		);
	} // add_metaboxes()
	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		int 		The value of $nonce_check
	 */
	private function check_nonces( $posted ) {
		$nonces 		= array();
		$nonce_check 	= 0;
		$nonces[] 		= 'candidate_pipeline_info';
		$nonces[] 		= 'candidate_pipeline_trials';
		foreach ( $nonces as $nonce ) {
			if ( ! isset( $posted[$nonce] ) ) { $nonce_check++; }
			if ( isset( $posted[$nonce] ) && ! wp_verify_nonce( $posted[$nonce], $this->plugin_name ) ) { $nonce_check++; }
		}
		return $nonce_check;
	} // check_nonces()
	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		array 		Metabox fields and types
	 */
	private function get_metabox_fields() {
		$fields = array();
		$fields[] = array('candidate-subtitle', 'text');
		$fields[] = array('candidate-color', 'text');
		$fields[] = array('candidate-progress', 'number');
		$fields[] = array('candidate-class', 'text');
		$fields[] = array('candidate-link', 'text');
		$fields[] = array('candidate-link-text', 'text');
		$fields[] = array('candidate-progress-text', 'text');
		$fields[] = array('candidate-progress-text-abbrev', 'text');
		$fields[] = array('candidate-textarea', 'text');
		//$fields[] = array('candidate-disease', 'text');
		$fields[] = array(
			'candidate-trials', 
			'repeater', 
			getTrialFields()
		);
		$fields = getCustomFields($fields);
		return $fields;
	} // get_metabox_fields()
	
	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function metabox( $post, $params ) {
		if ( ! is_admin() ) { return; }
		if ( 'candidate' !== $post->post_type ) { return; }
		if ( ! empty( $params['args']['classes'] ) ) {
			$classes = 'repeater ' . $params['args']['classes'];
		}
		include( plugin_dir_path( __FILE__ ) . 'partials/como-pipeline-admin-metabox-' . $params['args']['file'] . '.php' );
	} // metabox()
	
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
	 * Saves button order when buttons are sorted.
	 */
	public function save_trials_order() {
		check_ajax_referer( 'como-pipeline-trial-order-nonce', 'trialordernonce' );
		$order 						= $this->meta['trial-order'];
		$new_order 					= implode( ',', $_POST['trial-order'] );
		$this->meta['trial-order'] 	= $new_order;
		$update 					= update_post_meta( 'trial-order', $new_order );
		esc_html_e( 'Trial order saved.', 'como-pipeline' );
		die();
	} // save_trials_order()
	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {
		global $post;
		if ( empty( $post ) ) { return; }
		if ( 'candidate' != $post->post_type ) { return; }
		//wp_die( '<pre>' . print_r( $post->ID ) . '</pre>' );
		$this->meta = get_post_custom( $post->ID );
	} // set_meta()
	/**
	 * Saves metabox data
	 *
	 * Repeater section works like this:
	 *  	Loops through meta fields
	 *  		Loops through submitted data
	 *  		Sanitizes each field into $clean array
	 *   	Gets max of $clean to use in FOR loop
	 *   	FOR loops through $clean, adding each value to $new_value as an array
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @param 	int 		$post_id 		The post ID
	 * @param 	object 		$object 		The post object
	 * @return 	void
	 */
	public function validate_meta( $post_id, $object ) {
		//wp_die( '<pre>' . print_r( $_POST ) . '</pre>' );
		
		//echo 'OBJECT: ';
		//print_r( $_POST );
		//echo '<br>'; 
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return $post_id; }
		if ( 'candidate' !== $object->post_type ) { return $post_id; }
		$nonce_check = $this->check_nonces( $_POST );
		if ( 0 < $nonce_check ) { return $post_id; }
		$metas = $this->get_metabox_fields();
		
		foreach ( $metas as $meta ) {
			$name = $meta[0];
			$type = $meta[1];
			
			//echo 'TYPE: '. $type .'<br>';
			
			/*
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
			}*/
			
			if ( 'repeater' === $type && is_array( $meta[2] ) ) {
				unset($clean);
				unset($valid);
				$clean = array();
				$valid = array();
				//echo '<p>';
				//print_r($meta[2]);
				//echo '</p>';
				foreach ( $meta[2] as $field ) {
					//echo '<p>';
					//print_r($field);
					//echo '</p>';
					foreach ( $_POST[$field[0]] as $data ) {
						//if ( empty( $data ) ) { continue; }
						//echo $field[1] .' : '. $data .'<br>';
						if ($field[1] == 'image') {
							if (!empty($data)) {
								$clean[$field[0]][] = $data;
							}
						} else {
							$clean[$field[0]][] = $this->sanitizer( $field[1], $data );
						}
					} // foreach
				} // foreach
				$count = como_pipeline_get_max( $clean );
				//echo '<p>';
				//print_r($clean);
				//echo '</p>';
				//echo '<p>COUNT: '. $count .'</p>'; 
				for ( $i = 0; $i < $count; $i++ ) {
					foreach ( $clean as $field_name => $field ) {
						//echo $field_name .' : '. implode(' | ', $field) .'<br>'; 
						if (isset($field[$i])) {
							$valid[$meta[0]][$i][$field_name] = $field[$i];
						}
					} // foreach $clean
				} // for
				//echo 'VALID: '; 
				//print_r($valid);
				//echo '<br>'; 
				
				if (is_array($valid)) {
					$new_value 	= array();
					//echo 'IS ARRAY!!<br>'; 
					$count 		= como_pipeline_get_max( $valid );
					//$count 		= count($valid);
					//echo 'COUNT: '. $count .'<br>'; 
					foreach ($valid as $k => $v) {
						//echo $k .' : '. $v .'<br>';
						$new_value = $v;
					}
					/*
					$new_value 	= array();
					for ( $i = 0; $i < $count; $i++ ) {
						
						echo ''. $valid[$i] .': <br>'; 
						
						
						/*foreach ( $valid as $field_name => $field ) {
							//echo $field_name .': ';
							//print_r($field);
							//echo '<br>'; 
							
							if (isset($field[$i])) {
								$new_value[$i][$field_name] = $field[$i];
							}
						}*/ // foreach $clean
					//} // for
				} else {
					$new_value = $valid; 
				}
				//echo '<br>update_post_meta( '. $post_id .', '. $name .', '. ((is_array($new_value)) ? 'ARRAY: '. print_r($new_value) : 'NOT ARRAY: '. $new_value) .')<br>'; 
				update_post_meta( $post_id, $name, $new_value );
				
				/*
				unset($repTest);
				unset($clean);
				$clean = array();
				$mCount = count($meta[2]);
				
				foreach ( $meta[2] as $field ) {
					$fCount = count($field);
					foreach ($_POST as $k=>$v) {
						if (is_array($v)) {
							if(empty($v[count($v)-1])) {
								unset($v[count($v)-1]); // Remove last empty array item
							}
						}
						$clean[$k] = $v;
					}
				}
				
				
				//echo '<p>IMPLODE: ';
				//print_r($clean);
				//echo '</p>';
				
				//$empty = ((empty(implode(',',$clean))) ? true : false);
				
				//if ($empty) {
				if (empty($clean)) {
					// Remove Empty Meta Values From Database
					foreach ( $meta[2] as $field ) {
						delete_post_meta( $post_id, $name );
					}
					continue;
				} else {
					foreach ( $meta[2] as $field ) {
						////// Fix for Empty Repeater Fields
						$fCount = count($field);
						
						
						echo $field[0] .': '; 
						//echo 'VALUE: ';
						//print_r(($clean[$field[0]]));
						//echo '<br>';
						
						echo implode(', ', $clean[$field[0]]) .'<br>'; 
						
						
						/*
						for ($f=0;$f<$fCount;$f++) {
							$data = $_POST[$field[0]][$f];
							
							echo '$data-'. $f .': '. $data .'<br>';
							
							
							if ($field[1] === 'image') {
								$clean[$field[0]][] = $data; 
							} else {
								$clean[$field[0]][] = $this->sanitizer( $field[1], $data );
							}
						} // foreach*/
					/*} // foreach
					
					//echo '<p>CLEAN: ';
					//print_r($clean);
					//echo '</p>'; 
					
					if (is_array($clean)) {
						//echo $field[0] .' IS ARRAY!!<br>'; 
						//$count 		= como_pipeline_get_max( $clean );
						$count 		= count($clean);
						$new_value 	= array();
						for ( $i = 0; $i < $count; $i++ ) {
							foreach ( $clean as $field_name => $field ) {
								if (isset($field[$i])) {
									$new_value[$i][$field_name] = $field[$i];
								}
							} // foreach $clean
						} // for
					} else {
						$new_value = $clean; 
					}*/
					
					//echo 'NEW VALUE: '. ((is_array($new_value)) ? print_r($new_value) : $new_value) .'<br>'; 
					
					//echo 'update_post_meta( '. $post_id .', '. $name .', '. ((is_array($new_value)) ? print_r($new_value) : $new_value) .')<br>'; 
					
					
					//update_post_meta( $post_id, $name, $new_value );
				/*}
				*/
			} elseif ($type === 'image') {
				$new_value = $_POST[$name];
				update_post_meta( $post_id, $name, $new_value );
			} else {
				if (isset($_POST[$name])) {
					$new_value = $this->sanitizer( $type, $_POST[$name] );
				} else {
					$new_value = ''; 
				}
				update_post_meta( $post_id, $name, $new_value );
			}
		} // foreach
		//exit;
	} // validate_meta()
} // class