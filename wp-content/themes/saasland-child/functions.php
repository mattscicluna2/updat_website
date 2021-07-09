<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function saasland_child_theme_setup() {
    load_child_theme_textdomain( 'saasland-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'saasland_child_theme_setup' );


// BEGIN ENQUEUE PARENT ACTION
if ( !function_exists( 'saasland_child_thm_parent_css' ) ):
    function saasland_child_thm_parent_css() {
        wp_enqueue_style (
            'saasland-child-parent-root',
            trailingslashit ( get_template_directory_uri() ) . 'style.css',
            array ( 'saasland-root', 'saasland-elements', 'saasland-fonts', 'bootstrap', 'eleganticons', 'themify-icon', 'saasland-main', 'saasland-wpd', 'saasland-gutenberg' )
        );
    }
endif;
add_action( 'wp_enqueue_scripts', 'saasland_child_thm_parent_css', 10 );

// END ENQUEUE PARENT ACTION
