<?php
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 */
/*
Plugin Name: Droit Elementor Templating
Plugin URI: https://droitthemes.com/
Description: Droit Elementor Template Lite is a bundle of super useful templates. This Elementor compatible plugin is easy to use and you can customize different features as you like. Just plug and play.
Version: 1.0.0
Author: DroitThemes
Author URI: https://droitthemes.com/
License: GPLv3
Text Domain: droit-el-template-lite
Domain Path: /languages
 */

// If this file is called firectly, abort!!!
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

/**
 * Constant
 * Feature added by : DroitLab Team
 * @since 1.0.0
 */

if (!defined("DROIT_EL_TEMPLATE_PLUGIN_NAME")) {
    define("DROIT_EL_TEMPLATE_PLUGIN_NAME", 'Droit El Template Lite');
}

if (!defined("DROIT_EL_TEMPLATE_VERSION")) {
    define("DROIT_EL_TEMPLATE_VERSION", '1.0.0');
}

if (!defined("DROIT_EL_TEMPLATE_WP_VERSION")) {
    define("DROIT_EL_TEMPLATE_WP_VERSION", '4.9');
}

if (!defined("DROIT_EL_TEMPLATE_PHP_VERSION")) {
    define("DROIT_EL_TEMPLATE_PHP_VERSION", '5.6');
}

if (!defined("DROIT_EL_TEMPLATE_FILE")) {
    define("DROIT_EL_TEMPLATE_FILE", __FILE__);
}

if (!defined("DROIT_EL_TEMPLATE_BASE")) {
    define("DROIT_EL_TEMPLATE_BASE", trailingslashit(plugin_basename(DROIT_EL_TEMPLATE_FILE)));
}

if (!defined("DROIT_EL_TEMPLATE_PATH")) {
    define("DROIT_EL_TEMPLATE_PATH", trailingslashit(plugin_dir_path(DROIT_EL_TEMPLATE_FILE)));
}

if (!defined("DROIT_EL_TEMPLATE_URL")) {
    define("DROIT_EL_TEMPLATE_URL", trailingslashit(plugin_dir_url(DROIT_EL_TEMPLATE_FILE)));
}
if (!defined("DROIT_EL_TEMPLATE_IMAGE")) {
    define("DROIT_EL_TEMPLATE_IMAGE", DROIT_EL_TEMPLATE_URL . '_images/');
}
require_once DROIT_EL_TEMPLATE_PATH . '/includes/plugin.php';
