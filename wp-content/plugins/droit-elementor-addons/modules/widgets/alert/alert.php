<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Alert\Alert_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Alert\Alert_Module as Module;
use \ELEMENTOR\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Alert extends Control
{

    public function get_name()
    {
        return Module::get_name();
    }

    public function get_title()
    {
        return Module::get_title();
    }

    public function get_icon()
    {
        return Module::get_icon();
    }

    public function get_categories()
    {
        return Module::get_categories();
    }

    public function get_keywords()
    {
        return Module::get_keywords();
    }

    public function get_script_depends()
    {
        return ['script-name'];
    }

    protected function _register_controls()
    {
        $this->_droit_register_dl_alert_preset_controls();
        $this->_droit_register_dl_alert_content_controls();
        $this->_droit_register_dl_alert_general_style_controls();
        $this->_droit_register_dl_alert_title_style_controls();
        do_action('dl_widget/section/style/custom_css', $this);
       
    }

//Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_dl_alert_skin  = !empty($this->get_alert_settings('_dl_alert_skin')) ? $this->get_alert_settings('_dl_alert_skin') : '_skin_1';

        switch ($_dl_alert_skin) {
            case '_skin_1':
                 $this->_dl_alert_style_one();
                break;            
            default:
                $this->_dl_alert_style_one();
            break;
        } 
    }

    //Layout One
    protected function _dl_alert_style_one(){
        $settings = $this->get_settings_for_display();
        $alert_style =  ! empty($this->get_alert_settings('_dl_alert_design_format'));
        $_dl_alert_title_size =  $this->get_alert_settings('_dl_alert_title_size');
        $alert_show_icon =  ! empty($this->get_alert_settings('_dl_alert_icon_show'));
        $alert_cross_show =  ! empty($this->get_alert_settings('_dl_alert_cross_icon_show'));
        ?>
         <div class="dl_alert_box dl_alert_box_style_01 <?php echo esc_html($this->get_alert_settings('_dl_alert_design_format')); ?>">
            <<?php echo $_dl_alert_title_size; ?> class="dl_alert_desc">
                <?php if($alert_show_icon): ?><?php Icons_Manager::render_icon( $this->get_alert_settings('_dl_alert_icon') ); ?><?php endif; ?>
                <?php echo wp_kses_post($this->get_alert_settings('_dl_alert_title')); ?>
            </<?php echo $_dl_alert_title_size; ?>>
            <?php if($alert_cross_show): ?>
            <button type="button" class="dl_alert_close">
                <?php Icons_Manager::render_icon( $this->get_alert_settings('_dl_alert_cross_icon') ); ?>
            </button>
            <?php endif; ?>
        </div>
    <?php }
    protected function content_template()
    {}
}
