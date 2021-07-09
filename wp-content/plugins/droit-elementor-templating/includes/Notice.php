<?php 
namespace DROIT_ELEMENTOR_TEMPLATE;
/**
 * summary
 */
class Notice
{
    /**
     * Constructor
     * @since 1.0.0
     * @access private
     * Feature added by : DroitLab Team
     */
    public function __construct(){
        
    }

    public function droit_el_template_notice_minimum_php_version(){

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(__("Your current PHP version is <strong> " . PHP_VERSION . " </strong>. You need to upgrade your PHP version to <strong> " . DROIT_EL_TEMPLATE_PHP_VERSION . " or later</strong> to run droit elementor addons plugin.", "droit-elementor-addons"));

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Check if a plugin is installed or Not
     * @access public
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    private function is_elementor_installed_or_not($basename) {
        if (!function_exists('get_plugins')) {
            include_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        $is_installed_plugins = get_plugins();

        return isset($is_installed_plugins[$basename]);
    }
    /**
     * Check Droit Elementor Addons Installed and Activated or Not
     * Warning when the site doesn't have Droit Elementor Addons installed or activated.
     * @access public
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    public function is_missing_elementor_plugin(){
        
        if (!current_user_can('activate_plugins')) {
            return;
        }

        $elementor = 'elementor/elementor.php';

        $droit_template_name = 'Droit Elementor Template';

        if ($this->is_elementor_installed_or_not($elementor)) {
            $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor);

            $message = __('<strong>'.$droit_template_name.'</strong> requires <strong>Elementor</strong> plugin to be active. Please activate to continue.', 'droit-el-template-lite');
            
            $_button_text = __('Activate Elementor', 'droit-el-template-lite');
        } else {
            $activation_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');

            $message = sprintf(__('<strong>'.$droit_template_name.'</strong> requires <strong>Elementor</strong> plugin to be installed and activated. Please install Elementor to continue.', 'droit-el-template-lite'), '<strong>', '</strong>');
            $_button_text = __('Install Elementor', 'droit-el-template-lite');
        }

        $_button = '<p><a href="' . $activation_url . '" class="button-primary">' . $_button_text . '</a></p>';

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p>%2$s</div>', __($message), $_button); 
    }
}