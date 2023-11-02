<?php
/**
 * Provide the view for a metabox
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package 	Como_Pipeline
 * @subpackage 	Como_Pipeline/admin/partials
 */
?>
<div class="pipeline-details">
	<div class="row">
		<div class="col-12">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-subtitle';
				$atts['label'] 			= 'Subtitle';
				$atts['name'] 			= 'candidate-subtitle';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php'); ?></p>
		</div>
		<div class="col-12 col-md-6 col-xl-2">
			<?php
				wp_nonce_field( $this->plugin_name, 'candidate_pipeline_info' );
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-color';
				$atts['label'] 			= 'Color';
				$atts['name'] 			= 'candidate-color';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-colorpicker.php'); ?></p>
		</div>
		<div class="col-12 col-md-6 col-xl-5">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-class';
				$atts['label'] 			= 'Class';
				$atts['name'] 			= 'candidate-class';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php'); ?></p>
		</div>
		<div class="col-12 col-md-6 col-xl-5">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= 'Percentage of Development Process Completed';
				$atts['id'] 			= 'candidate-progress';
				$atts['label'] 			= 'Progress';
				$atts['name'] 			= 'candidate-progress';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'number';
				$atts['value'] 			= '';
				$atts['min'] 			= '0';
				$atts['max'] 			= '100';
				$atts['step'] 			= '0.01';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-number.php'); ?></p>
		</div>
		<div class="col-12 col-md-4 col-xl-4">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-link';
				$atts['label'] 			= 'Link';
				$atts['name'] 			= 'candidate-link';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php'); ?></p>
		</div>
		<div class="col-12 col-md-4 col-xl-4">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-link-text';
				$atts['label'] 			= 'Link Text';
				$atts['name'] 			= 'candidate-link-text';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php'); ?></p>
		</div>
		<!--<div class="col-12 col-md-4 col-xl-4">
			<?php
				/*$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-disease';
				$atts['label'] 			= 'Indication';
				$atts['name'] 			= 'candidate-disease';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );*/
			?>
			<p><?php /*include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php');*/ ?></p>
		</div>-->
		<div class="col-12 col-md-4 col-xl-4">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-progress-text';
				$atts['label'] 			= 'Progress Text';
				$atts['name'] 			= 'candidate-progress-text';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php'); ?></p>
		</div>
		<div class="col-12 col-md-8 col-xl-8">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-textarea';
				$atts['label'] 			= 'Candidate Textarea';
				$atts['name'] 			= 'candidate-textarea';
				$atts['placeholder'] 	= 'may be used for additional information';
				$atts['type'] 			= 'textrea';
				$atts['cols'] 			= 50;
				$atts['rows'] 			= 5;
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-textarea.php'); ?></p>
		</div>
		<div class="col-12 col-md-4 col-xl-4">
			<?php
				$atts 					= array();
				$atts['class'] 			= '';
				$atts['description'] 	= '';
				$atts['id'] 			= 'candidate-progress-text-abbrev';
				$atts['label'] 			= 'Progress Text Appreviation';
				$atts['name'] 			= 'candidate-progress-text-abbrev';
				$atts['placeholder'] 	= '';
				$atts['type'] 			= 'text';
				$atts['value'] 			= '';
				if ( ! empty( $this->meta[$atts['id']][0] ) ) {
					$atts['value'] = $this->meta[$atts['id']][0];
				}
				apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
			?>
			<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php'); ?></p>
		</div>
	</div>
	<div class="row">
		<?php
			$options = get_option('como-pipeline-options');
			$columns = $options['pipeline-columns'];
			$ignoreArray = array('title-column','progress-column','type-column','indication-column','readonly-column');
			foreach ($columns as $column) {
				
				if (!in_array($column['column-type'], $ignoreArray)) {
					
					?><div class="col-12 col-md-4"><?php
					//if (($column['column-type'] == 'type-column') || ($column['column-type'] == 'indication-column') ) {
						// Do not show in admin - Controlled By Custom Post Terms
					if ($column['column-type'] == 'image-column') {
						$atts 						= array();
						$atts['class'] 				= 'widefat url-file';
						$atts['id'] 				= $column['column-id'];
						$atts['label'] 				= $column['column-name'];
						$atts['label-add'] 			= 'Add Image';
						$atts['label-edit'] 		= 'Edit Image';
						$atts['label-header'] 		= 'Image Name';
						$atts['label-remove'] 		= 'Remove Image';
						$atts['label-upload'] 		= 'Choose/Upload Image';
						//$atts['name'] 				= "candidate-columns['". $column['column-id'] ."]";
						$atts['name'] 				= $column['column-id'];
						$atts['placeholder'] 		= '';
						$atts['type'] 				= 'hidden';
						$atts['value'] 				= '';
						if ( ! empty( $this->meta[$atts['id']][0] ) ) {
							$atts['value'] = $this->meta[$atts['id']][0];
						}
						apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
						include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-image-upload.php' ); 
					} elseif ($column['column-type'] == 'textarea-column') {
						$atts 					= array();
						$atts['class'] 			= '';
						$atts['description'] 	= '';
						$atts['id'] 			= $column['column-id'];
						$atts['label'] 			= $column['column-name'];
						$atts['name'] 			= $column['column-id'];
						$atts['placeholder'] 	= $column['column-name'];
						$atts['type'] 			= 'textrea';
						$atts['cols'] 			= 50;
						$atts['rows'] 			= 5;
						$atts['value'] 			= '';
						if ( ! empty( $this->meta[$atts['id']][0] ) ) {
							$atts['value'] = $this->meta[$atts['id']][0];
						}
						apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
						?><p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-textarea.php'); ?></p><?php
					} else {
						$atts 					= array();
						$atts['class'] 			= '';
						$atts['description'] 	= '';
						$atts['id'] 			= $column['column-id'];
						$atts['label'] 			= $column['column-name'];
						//$atts['name'] 			= "candidate-columns['". $column['column-id'] ."]";
						$atts['name'] 			= $column['column-id'];
						$atts['placeholder'] 	= $column['column-name'];
						$atts['type'] 			= 'text';
						$atts['value'] 			= '';
						if ( ! empty( $this->meta[$atts['id']][0] ) ) {
							$atts['value'] = $this->meta[$atts['id']][0];
						}
						apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
						?><p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php'); ?></p><?php
					}
					?></div><?php
					
					/*?><div class="col-12 col-md-8">
						<?php
							$atts 					= array();
							$atts['class'] 			= '';
							$atts['description'] 	= '';
							$atts['id'] 			= 'candidate-textarea';
							$atts['label'] 			= 'Candidate Textarea';
							$atts['name'] 			= 'candidate-textarea';
							$atts['placeholder'] 	= 'may be used for additional information';
							$atts['type'] 			= 'textrea';
							$atts['value'] 			= '';
							if ( ! empty( $this->meta[$atts['id']][0] ) ) {
								$atts['value'] = $this->meta[$atts['id']][0];
							}
							apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );
						?>
						<p><?php include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-textarea.php'); ?></p>
					</div><?php*/
					
				}
			}
		?>
	</div>
</div><!-- pipeline-details -->