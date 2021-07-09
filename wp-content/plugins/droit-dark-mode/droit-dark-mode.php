<?php
/**
 * @package droitdark
 * @developer DroitLab Team
 */
/*
Plugin Name: Droit Dark Mode
Plugin URI: https://droitthemes.com/droit-dark-mode/
Description: Droit Dark Mode plugin to create dark version of your website base on your browser. 
Version: 1.0.5
Author: DroitThemes
Author URI: https://droitthemes.com/
License: GPLv3
Text Domain: droit-dark
*/

// define the main file 
define( 'DROIT_DARK_FILE_', __FILE__);
 
// controller page
include_once( __DIR__ .'/controller.php');

// load of controller files

// load plugin
add_action( 'plugins_loaded', function(){
	// load text domain
	load_plugin_textdomain( 'droit-dark', false, basename( dirname( __FILE__ ) ) . '/languages'  );
	// load plugin instance
    \DroitDark\Dtdr_Controller::instance()->load();

    // load include
    \DroitDark\Includes\Dtdr_Load::_instance()->_init();
    // load theme support
    \DroitDark\Includes\Dtdr_Themes::_instance();

}); 
