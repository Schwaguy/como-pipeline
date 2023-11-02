<?php
/**
 * Provides the markup for any textarea field
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Como_Pipeline
 * @subpackage Como_Pipeline/admin/partials
 */
?><span class="como-field-wrap"><?php
if ( ! empty( $atts['label'] ) ) {
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>" class="comometa-row-title"><?php esc_html_e( $atts['label'], 'como-pipeline' ); ?>: </label><?php
}
?><span class="comometa-row-content"><?php
?><textarea
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	cols="<?php echo esc_attr( $atts['cols'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>" 
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"		
	rows="<?php echo esc_attr( $atts['rows'] ); ?>"><?php
	echo esc_textarea( $atts['value'] );
?></textarea><?php
if ( ! empty( $atts['description'] ) ) {
	?><div class="description"><?php esc_html_e( $atts['description'], 'como-pipeline' ); ?></div><?php
}
	?>
</span></span>