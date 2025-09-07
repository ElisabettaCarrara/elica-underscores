<?php
/**
 * Elica Underscores Theme Customizer
 *
 * @package Elica_Underscores
 */

/**
 * Add postMessage support for site title, description, and header text color.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function elica_underscores_customize_register( WP_Customize_Manager $wp_customize ) : void {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			[
				'selector'        => '.site-title a',
				'render_callback' => 'elica_underscores_customize_partial_blogname',
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			[
				'selector'        => '.site-description',
				'render_callback' => 'elica_underscores_customize_partial_blogdescription',
			]
		);
	}
}
add_action( 'customize_register', 'elica_underscores_customize_register' );

/**
 * Render the site title for Selective Refresh.
 */
function elica_underscores_customize_partial_blogname() : void {
	bloginfo( 'name' );
}

/**
 * Render the site description/tagline for Selective Refresh.
 */
function elica_underscores_customize_partial_blogdescription() : void {
	bloginfo( 'description' );
}

/**
 * Enqueue JS handlers for Theme Customizer preview reload.
 */
function elica_underscores_customize_preview_js() : void {
	wp_enqueue_script(
		'elica-underscores-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		[ 'customize-preview' ],
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_preview_init', 'elica_underscores_customize_preview_js' );
