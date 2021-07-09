<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Contact_Form_7\Contact_Form_7_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Contact_Form_7\Contact_Form_7_Module as Module;
use \Elementor\Group_Control_Image_Size;
use \DROIT_ELEMENTOR\Utils as Droit_Utils;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Contact_Form_7 extends Control
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

    protected function _register_controls(){
      $this->register_cf7_preset_controls();
      $this->register_general_style_section();
      $this->register_label_style_section();
      $this->register_field_style_section();
      $this->register_placeholder_style_section();
      $this->register_button_style_section();
      $this->register_feedback_style_section();
      $this->register_error_style_section();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        if ( ! Droit_Utils::droit_addons_contact7_activated() ) {
            return;
        }

        $settings = $this->get_settings_for_display();

         $_dl_cf7_skin  =  !empty($this->get_cf7_settings('_dl_cf7_skin')) ? $this->get_cf7_settings('_dl_cf7_skin') : '';

        switch ($_dl_cf7_skin) {
            case '_skin_1':
                 $this->_second_cf7_layout();
                break;
            case '_skin_2':
                 $this->_third_cf7_layout();
                break;
            default:
                $this->_default_cf7_layout();
                break;
        } 
    }

   protected function _default_cf7_layout(){
    $settings = $this->get_settings_for_display();

    $this->add_render_attribute('cf7-form', 'class', [
        'dl_contact_form_wrapper',
        'wpcf7_default',
        'dl-contact-form-7',
        'droit-contact-form-7',
        'droit-contact-form-' . esc_attr($this->get_id()),
    ]);
    $cf7_form_wrapper = $this->get_render_attribute_string('cf7-form');
    ?>
   <div <?php echo $cf7_form_wrapper; ?>>
        <?php echo do_shortcode('[contact-form-7 id="'.$this->get_cf7_settings('_dl_cf7_form_id').'"]' ); ?>
    </div>
   
  <?php }

   protected function _second_cf7_layout(){
    $settings = $this->get_settings_for_display();

    $this->add_render_attribute('cf7-form', 'class', [
        'dl_contact_form_wrapper',
        'wpcf7_default',
        'dl_cf7_form_02',
        'dl-contact-form-7',
        'droit-contact-form-7',
        'droit-contact-form-' . esc_attr($this->get_id()),
    ]);
    $cf7_form_wrapper = $this->get_render_attribute_string('cf7-form');
    ?>
    <div <?php echo $cf7_form_wrapper; ?>>
        <?php echo do_shortcode('[contact-form-7 id="'.$this->get_cf7_settings('_dl_cf7_form_id').'"]' ); ?>
    </div>
   
  <?php }

   protected function _third_cf7_layout(){
    $settings = $this->get_settings_for_display();

    $this->add_render_attribute('cf7-form', 'class', [
        'dl_contact_form_wrapper',
        'wpcf7_default',
        'dl_cf7_form_03',
        'dl-contact-form-7',
        'droit-contact-form-7',
        'droit-contact-form-' . esc_attr($this->get_id()),
    ]);
    $cf7_form_wrapper = $this->get_render_attribute_string('cf7-form');
    ?>
   <div <?php echo $cf7_form_wrapper; ?>>
        <?php echo do_shortcode('[contact-form-7 id="'.$this->get_cf7_settings('_dl_cf7_form_id').'"]' ); ?>
    </div>
   
  <?php }
    
    protected function content_template()
    {}
}
