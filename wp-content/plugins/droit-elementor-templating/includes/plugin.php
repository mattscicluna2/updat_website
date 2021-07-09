<?php
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 *
 */

namespace DROIT_ELEMENTOR_TEMPLATE;

if ( ! defined( 'ABSPATH' ) ) {exit;}

Final class Plugin {

     /**
     * Instance
     * @var core The single instance of the class.
     * @access private
     * @static
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    public static $instance = null;

     /**
     * Instance
     * Ensures only one instance of the class is loaded or can be loaded.
     * @since 1.0.0
     * @access public
     * Feature added by : DroitLab Team
     */
    public static function instance(){
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Instance
     * Ensures only one instance of the class is loaded or can be loaded.
     * @since 1.0.0
     * @access private
     * Feature added by : DroitLab Team
     */
    private function droit_el_template_register_autoloader(){
        require_once DROIT_EL_TEMPLATE_PATH . '/vendor/autoload.php';
    }

    /**
     * Init components.
     * Initialize Droit Pro components. Register actions, run setting manager,
     * @since 1.0.0
     * @access private
     * Feature added by : DroitLab Team
     */
    private function droit_el_template_init_components(){

        /*=====Includes=====*/
        new Template_Enqueue_Manager();
        new Templates\Load_Template();
        new Templates\Import_Template();
    }

    /**
     * Check if a plugin is installed or Not
     * @access public
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    private function droit_el_template_admin_notice() {
        require_once DROIT_EL_TEMPLATE_PATH . '/includes/Notice.php';
        $notice_obj = new Notice();
        return $notice_obj;
    }
    /**
     * Check Droit Elementor Addons Installed and Activated or Not
     * Warning when the site doesn't have Droit Elementor Addons installed or activated.
     * @access public
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    public function droit_el_template_notice_missing_elementor_plugin(){
         return $this->droit_el_template_admin_notice()->is_missing_elementor_plugin(); 
    }
    /**
     * Check Droit Elementor Addons Upgrade Notice
     * @access public
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    public function droit_el_template_php_version_notice(){
         return $this->droit_el_template_admin_notice()->droit_el_template_notice_minimum_php_version(); 
    }
    /**
     * Plugin dependancy
     * @access public
     * Feature added by : DroitLab Team
     * @since : 1.0.0
     */
    public function droit_el_template_dependancy_check(){
        // Check php version
        if (version_compare(PHP_VERSION, DROIT_EL_TEMPLATE_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'droit_el_template_php_version_notice']);
            return;
        }
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'droit_el_template_notice_missing_elementor_plugin']);
            return;
        }
        $this->droit_el_template_register_autoloader();
        $this->droit_el_template_init_components();
    }
    /**
     * Active Plugin
     * @access public
     * Feature added by : DroitLab Team
     * @since : 1.0.0
     */
    public function droit_el_template_activation(){
        require_once DROIT_EL_TEMPLATE_PATH . '/includes/droit-template-activator.php';
        Droit_El_Template_Activator::droit_el_template_activate();
    }
    /**
     * Deactive Plugin
     * @access public
     * Feature added by : DroitLab Team
     * @since : 1.0.0
     */
    public function droit_el_template_deactivation(){
        require_once DROIT_EL_TEMPLATE_PATH . '/includes/droit-template-deactivator.php';
        Droit_El_Template_Deactivator::droit_el_template_deactivate();
    }
    /**
     * Plugin Active Time
     * @access public
     * Feature added by : DroitLab Team
     * @since : 1.0.0
     */
    public function droit_el_template_installed_time() {
        $installed_time = get_option( '_droit_el_template_installed_time' );

        if ( ! $installed_time ) {
            $installed_time = time();

            update_option( '_droit_el_template_installed_time', $installed_time );
        }

        return $installed_time;
    }
    /**
     * Plugin Loaded
     * @access private
     * Feature added by : DroitLab Team
     * @since : 1.0.0
     */
    private function droit_el_template_loaded(){
        add_action('plugins_loaded', [$this, 'droit_el_template_dependancy_check']);
    }

    private function droit_el_template_hooks(){
        register_activation_hook(DROIT_EL_TEMPLATE_FILE, [$this, 'droit_el_template_activation']);
        register_deactivation_hook(DROIT_EL_TEMPLATE_FILE, [$this, 'droit_el_template_deactivation']);
        register_activation_hook(DROIT_EL_TEMPLATE_FILE, [$this, 'droit_el_template_installed_time']);
        $this->droit_el_template_loaded();
    }

    /**
     * Constructor
     * @since 1.0.0
     * @access private
     * Feature added by : DroitLab Team
     */
    private function __construct(){
        $this->droit_el_template_hooks();
    }

}

if (defined("DROIT_EL_TEMPLATE_PLUGIN_NAME")) {
    Plugin::instance();
}