<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Animated_Text\Animated_Text_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Animated_Text\Animated_Text_Module as Module;
use \ELEMENTOR\Icons_Manager;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Animated_Text extends Control
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

        $this->_droit_register_dl_animated_text_preset_controls();
        $this->_droit_register_dl_animated_text_general_style_controls();
        $this->_droit_register_dl_animatedtitle_content_controls();
        $this->_droit_register_dl_animated_text_title_style_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

//Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_dl_animatedtitle_skin  = !empty($this->get_animated_text_settings('_dl_animated_text_skin')) ? $this->get_animated_text_settings('_dl_animated_text_skin') : '_skin_1';

        switch ($_dl_animatedtitle_skin) {
            case '_skin_1':
                 $this->_dl_animated_heading_style_one();
                break;
            default:
                $this->_dl_animated_heading_style_one();
                break;
        } 
    }

    //Layout One
    protected function _dl_animated_heading_style_one(){
        $settings = $this->get_settings_for_display();
        $_dl_animatedtitle_before_text      =  $this->get_animated_text_settings('_dl_animatedtitle_before_text');
        $_dl_animatedtitl_animation_type    =  $this->get_animated_text_settings('_dl_animatedtitl_animation_type');
    ?>
    <div class="dl_animated_title_section">
        <div class="dl_animated_title_list dl_cd_intro dl_animated_title_style_01">
            <h3 class="dl_animated_headline <?php echo $_dl_animatedtitl_animation_type; ?>" data-animation-delay="2500">
                <span><?php echo $_dl_animatedtitle_before_text; ?></span>
                <span class="dl_words_wrapper">
                    <?php foreach ($this->get_animated_text_settings('_dl_animated_heading_repeater') as $index => $item): 
                    $item_count = $index + 1;
                    $is_visible = 1 === $item_count ? 'is-visible' : '';

                    $tab_heading_setting_key = $this->get_repeater_setting_key( '_dl_animated_heading_repeater_text', '_dl_animated_heading_repeater', $index );
                    $this->add_render_attribute( $tab_heading_setting_key, [
                        'class' => [ 'dl_animated_heading_color',  $is_visible, "elementor-repeater-item-{$item['_id']}" ],
                        'data-item' => $item_count,
                    ] );
                    ?>
                    <b <?php echo $this->get_render_attribute_string( $tab_heading_setting_key ); ?> ><?php echo $item['_dl_animated_heading_repeater_text']; ?></b>
                <?php endforeach; ?>
                </span>
            </h3>
        </div>
    </div>
        
    <?php }
  
    protected function content_template(){}
}
