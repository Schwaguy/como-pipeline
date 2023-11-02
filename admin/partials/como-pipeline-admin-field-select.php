<?php
/**
 * Provides the markup for a select field
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Como_Pipeline
 * @subpackage Como_Pipeline/admin/partials
 */
?><span class="como-field-wrap"><?php
if ( ! empty( $atts['label'] ) ) {
	?><label for="<?php echo esc_attr( $atts['id'] ); ?>" class="comometa-row-title"><?php esc_html_e( $atts['label'], 'employees' ); ?>: </label><?php
}
?><span class="comometa-row-content"><?php
?><select
	aria-label="<?php esc_attr( _e( $atts['aria'], 'como-pipeline' ) ); ?>"
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"><?php
if ( ! empty( $atts['blank'] ) ) {
	?><option value><?php esc_html_e( $atts['blank'], 'como-pipeline' ); ?></option><?php
}
foreach ( $atts['selections'] as $selection ) {
	if ( is_array( $selection ) ) {
		$label = $selection['label'];
		$value = $selection['value'];
	} else {
		$label = strtolower( $selection );
		$value = strtolower( $selection );
	}
	?><option
		value="<?php echo esc_attr( $value ); ?>" <?php
		selected( $atts['value'], $value ); ?>><?php
		esc_html_e( $label, 'como-pipeline' );
	?></option><?php
} // foreach
?></select>
<span class="description"><?php esc_html_e( $atts['description'], 'como-pipeline' ); ?></span>
</label>
</span></span>