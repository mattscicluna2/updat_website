<?php
/**
 * saasland functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package saasland
 */


if ( ! function_exists( 'saasland_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function saasland_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on gull, use a find and replace
	 * to change 'gull' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'saasland', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Enable excerpt support for page
    add_post_type_support( 'page', 'excerpt' );

    // Enable WooCommerce Support
    add_theme_support( 'woocommerce' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
    add_theme_support( 'post-formats', array( 'audio', 'video', 'quote', 'link' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'main_menu'   => esc_html__( 'Main menu', 'saasland' ),
		'overlay_menu'   => esc_html__( 'Overlay menu', 'saasland' ),
	));

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));

    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'style-editor.css' );
    add_theme_support( 'responsive-embeds' );

    if (!defined("SAASLAND_LICENCE_STATUS")) {
        define("SAASLAND_LICENCE_STATUS", 'valid');
    }

}
endif;
add_action( 'after_setup_theme', 'saasland_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function saasland_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'saasland_content_width', 1170 );
}
add_action( 'after_setup_theme', 'saasland_content_width', 0 );


/**
 * Constants
 * Defining default asset paths
 */
define( 'SAASLAND_DIR_CSS', get_template_directory_uri().'/assets/css' );
define( 'SAASLAND_DIR_JS', get_template_directory_uri().'/assets/js' );
define( 'SAASLAND_DIR_VEND', get_template_directory_uri().'/assets/vendors' );
define( 'SAASLAND_DIR_IMG', get_template_directory_uri().'/assets/img' );
define( 'SAASLAND_DIR_FONT', get_template_directory_uri().'/assets/fonts' );


/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';


/**
 * Theme's helper functions
 */
require get_template_directory() . '/inc/saasland_functions.php';

/**
 * Theme's filters and actions
 */
require get_template_directory() . '/inc/filter_actions.php';

/**
 * Classes
 */
require get_template_directory() . '/inc/classes/Saasland_helper.php';
require get_template_directory() . '/inc/classes/Saasland_base.php';
require get_template_directory() . '/inc/classes/Saasland_register_theme.php';
require get_template_directory() . '/inc/classes/Saasland_admin_page.php';
require get_template_directory() . '/inc/classes/Saasland_admin_settings.php';
require get_template_directory() . '/inc/admin/dashboard/Saasland_admin_dashboard.php';

/**
 * WooCommerce Configurations
 */
require get_template_directory() . '/inc/woo_config.php';

/**
 * Theme settings
 */
require get_template_directory() . '/options/opt-config.php';

/**
 * Configure one click demo
 */
require get_template_directory() . '/inc/demo_config.php';

/**
 * Required plugins activation
 */
require get_template_directory() . '/inc/plugin_activation.php';

/**
 * Require the classes
 * Bootstrap Nav Walker
 * Saasland_Overlay_Nav
 */
require get_template_directory() . '/inc/navwalker.php';
require get_template_directory() . '/inc/classes/Saasland_Overlay_Nav.php';
//Initialize the update checker.
require get_template_directory() . '/inc/classes/Saasland_update_checker.php';

/**
 * Comment Walker Class
 */
require get_template_directory() . '/inc/classes/Saasland_Walker_Comment.php';

/**
 * Register Sidebar Areas
 */
require get_template_directory() . '/inc/sidebars.php';