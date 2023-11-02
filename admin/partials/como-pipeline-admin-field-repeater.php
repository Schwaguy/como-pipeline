<?php
/**
 * Provides the markup for a repeater field
 *
 * Must include an multi-dimensional array with each field in it. The
 * field type should be the key for the field's attribute array.
 *
 * $fields['file-type']['all-the-field-attributes'] = 'Data for the attribute';
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Como_Pipeline
 * @subpackage Como_Pipeline/admin/partials
 */
//echo '<pre>Repeater: '; print_r( $repeater ); echo '</pre>';
$colCount = (($setatts['columns']) ? $setatts['columns'] : 1);
$cols = (($setatts['columns'] > 1) ? 'col col-12 col-xl-'. (12/$setatts['columns']) : '');
?><ul class="repeaters"><?php
	$options = get_option( $this->plugin_name . '-options' );
	if (isset($options[$setatts['id']])) {
		//echo '<p>Options: '. $options[$setatts['id']] .'</p>'; 
		$repeater = array();
		$repFields = $options[$setatts['id']];
		$c = 0;
		foreach ($repFields as $repField) {
			if (!isArrayEmpty($repField)) {
				$repeater[$c] = $repField;
				$c++;
			}
		}
		$count = count($repeater);
	} 
	//echo '<p>COUNT: '. $count .'</p>'; 
	for ( $i = 0; $i < $count; $i++ ) {
		
		
		//if ( $i === $count ) {
			//$setatts['class'] .= ' hidden';
		//}
		
		if ( ! empty( $repeater[$i][$setatts['title-field']] ) ) {
			$setatts['label-header'] = $repeater[$i][$setatts['title-field']];
		}
		?><li class="<?php echo esc_attr( $setatts['class'] ); ?>">
			<div class="handle">
				<span class="title-repeater"><?php echo esc_html( $setatts['label-header'], 'como-pipeline' ); ?></span>
				<button aria-expanded="true" class="btn-edit" type="button">
					<span class="screen-reader-text"><?php echo esc_html( $setatts['label-edit'], 'como-pipeline' ); ?></span>
					<span class="toggle-arrow"></span>
				</button>
			</div><!-- .handle -->
			<div class="repeater-content">
				<div class="wrap-fields <?=(($colCount>1) ? 'row repeater-row' : '')?>">
				<?php
					foreach ( $setatts['fields'] as $fieldcount => $field ) {
						
						
						//secho '<p>-- '. $fieldcount .' : '. print_r($field) .'</p>'; 
						
						
						foreach ( $field as $type => $atts ) {
							//echo '<p>TYPE: '. $type .' : '. $atts['id'] .' : '. $repeater[$i][$atts['id']] .'</p>'; 
							if ( !empty( $repeater ) && !empty( $repeater[$i][$atts['id']] ) ) {	
								//echo '<p>REPEATER: '; 
								//print_r($repeater[$i][$atts['id']]);
								//echo '</p>';
								$atts['value'] = $repeater[$i][$atts['id']];
							}
							//$atts['id'] 	.= '[]';
							$atts['name'] 	.= '[]';
							
							//$type = (($atts['type'] == 'hidden') ? 'image-upload' : ((isset($atts['type'])) ? $atts['type'] : $type));
							$type = ((isset($atts['type'])) ? (($atts['type'] == 'hidden') ? 'image-upload' : $atts['type']) : $type);
							
							?><div class="wrap-field <?=$cols?>"><?php
							include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-' . $type . '.php' );
							?></div><?php
						} 
					} // $fieldset foreach
					?>
					</div>
					<div>
						<a class="link-remove" href="#">
							<span><?= esc_html( apply_filters( $this->plugin_name . '-repeater-remove-link-label', $setatts['label-remove'] ), 'como-pipeline' )?></span>
						</a>
					</div>
				</div>
			</li><!-- .repeater --><?php
		//}
	} // for
	
	?>
	<li class="<?php echo esc_attr( $setatts['class'] ); ?> hidden">
			<div class="handle">
				<span class="title-repeater"></span>
				<button aria-expanded="true" class="btn-edit" type="button">
					<span class="screen-reader-text">TEST<?php echo esc_html( $setatts['label-edit'], 'como-pipeline' ); ?></span>
					<span class="toggle-arrow"></span>
				</button>
			</div>
			<div class="repeater-content">
				<div class="wrap-fields <?=(($colCount>1) ? 'row repeater-row' : '')?>">
				<?php
					foreach ( $setatts['fields'] as $fieldcount => $field ) {
						foreach ( $field as $type => $atts ) {
							if (isset($dbValues)) {
								if (!empty($dbValues[$i][$atts['id']])) {	
									$atts['value'] = $dbValues[$i][$atts['id']];
								}
							} elseif ( ! empty( $repeater ) && ! empty( $repeater[$i][$atts['id']] ) ) {	
								$atts['value'] = $repeater[$i][$atts['id']];
							} else {
							}
							//$atts['id'] 	.= '[]';
							$atts['name'] 	.= '[]';
							?><div class="wrap-field <?=$cols?>"><?php
							include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-' . $type . '.php' );
							?></div><?php
						} 
					} // $fieldset foreach
				?>
				</div>
			<div>
					<a class="link-remove" href="#">
						<span><?php
							echo esc_html( apply_filters( $this->plugin_name . '-repeater-remove-link-label', $setatts['label-remove'] ), 'como-pipeline' );
						?></span>
					</a>
				</div>
			</div>
		</li><!-- .repeater -->
	</ul><!-- repeater -->
	<div class="repeater-more">
		<span id="status"></span>
		<a class="button" href="#" id="add-repeater"><?php
			echo esc_html( apply_filters( $this->plugin_name . '-repeater-more-link-label', $setatts['label-add'] ), 'como-pipeline' );
		?></a>
	</div><!-- .repeater-more -->