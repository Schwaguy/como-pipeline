<?php
/**
 * The template for displaying all single candidates posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Como_Pipeline
 */
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly
/**
 * Get a custom header-employee.php file, if it exists.
 * Otherwise, get default header.
 */
get_header( 'candidate' );
if ( have_posts() ) :
	/**
	 * como-pipeline-single-before-loop hook
	 *
	 * @hooked 		candidate_single_table_row_start 		10
	 */
	do_action( 'como-pipeline-single-before-loop' );
	while ( have_posts() ) : the_post();
		include como_pipeline_get_template( 'single-content' );
	endwhile;
	/**
	 * como-pipeline-single-after-loop hook
	 *
	 * @hooked 		candidate_single_table_row_end 		90
	 */
	do_action( 'como-pipeline-single-after-loop' );
endif;
get_footer( 'candidate' );