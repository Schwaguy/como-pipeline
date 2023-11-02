<?php
/**
 * Provides the markup for any Number field
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
?><input
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	min="<?php echo esc_attr( $atts['min'] ); ?>"
	max="<?php echo esc_attr( $atts['max'] ); ?>"
	step="<?php echo esc_attr( $atts['step'] ); ?>"	 
	value="<?php echo esc_attr( $atts['value'] ); ?>" /><?php
if ( ! empty( $atts['description'] ) ) {
	?> <span class="description"><?php esc_html_e( $atts['description'], 'como-pipeline' ); ?></span><?php
}
	?>
</span></span>	