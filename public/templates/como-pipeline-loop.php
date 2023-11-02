<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the archive loop.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Como_Pipeline
 * @subpackage Como_Pipeline/public/partials
 */
if (isset($items)) {
	/**
	 * como-pipeline-before-loop hook
	 *
	 * @hooked 		table_wrap_start 		10
	 */
	do_action( 'como-pipeline-before-loop' );
	foreach ( $items as $item ) {
		$meta = get_post_custom( $item->ID );
		/**
		 * como-pipeline-before-loop-content hook
		 *
		 * @param 		object  	$item 		The post object
		 *
		 * @hooked 		table_row_start 		10
		 */
		do_action( 'como-pipeline-before-loop-content', $item, $meta );
			/**
			 * como-pipeline-loop-content hook
			 *
			 * @param 		object  	$item 		The post object
			 *
			 * @hooked 		content_candidate_row 		10
			 * @hooked 		content_candidate_location 	15
			 */
			do_action( 'como-pipeline-loop-content', $item, $meta );
		/**
		 * como-pipeline-after-loop-content hook
		 *
		 * @param 		object  	$item 		The post object
		 *
		 * @hooked 		content_link_end 		10
		 * @hooked 		table_row_end 		90
		 */
		do_action( 'como-pipeline-after-loop-content', $item, $meta );
	} // foreach
	/**
	 * como-pipeline-after-loop hook
	 *
	 * @hooked 		table_wrap_end 			10
	 */
	do_action( 'como-pipeline-after-loop' );
}