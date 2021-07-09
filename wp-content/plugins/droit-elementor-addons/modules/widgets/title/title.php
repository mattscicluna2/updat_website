<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Title\Title_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Title\Title_Module as Module;
use \ELEMENTOR\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Title extends Control
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
     	$this->_droit_register_dl_title_preset_controls();
        $this->_droit_register_dl_dtitle_content_controls();
        $this->_droit_register_dl_sub_dtitle_content_controls();
        $this->_droit_register_dl_tcontent_content_controls();
        $this->_droit_register_dl_title_text_style_controls();
        $this->_droit_register_dl_sub_title_text_style_controls();
        $this->_droit_register_dl_title_contnet_style_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }
    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_dl_title_skin  = !empty($this->get_title_settings('_dl_title_skin')) ? $this->get_title_settings('_dl_title_skin') : '_skin_1';

        switch ($_dl_title_skin) {
            case '_skin_1':
                 $this->_dl_title_heading_style_one();
                break;
            default:
                $this->_dl_title_heading_style_one();
                break;
        } 
    }
    //Layout One
    protected function _dl_title_heading_style_one(){
        $settings = $this->get_settings_for_display();

        // for Data Showing
        $has_title      = ! empty( $this->get_title_settings('show_dl_title') );
        $has_sub_title  = ! empty( $this->get_title_settings('show_dl_sub_title') );
        $has_content    = ! empty( $this->get_title_settings('show_dl_tcontent') );
        //$show_dl_revars = ! empty( $this->get_title_settings('show_dl_title_sub_revars') );

        // For Title
        $dl_title_tags = $this->get_title_settings('dl_title_tag');
        $dl_title_text = $this->get_title_settings('_dl_title_text');
        $show_dl_revars = $this->get_title_settings('show_dl_title_sub_revars');
    
        // For sub Title
        $dl_subtitle_tags = $this->get_title_settings('dl_sub_title_tag');
        $dl_subtitle_text = $this->get_title_settings('_dl_sub_title_text');

        // For Content Title
        $dl_content_text = $this->get_title_settings('_dl_tcontent_text');
    ?>
	    <div class="dl_title_section">
	        <?php if($has_title): ?>
	            <<?php echo $dl_title_tags; ?> class="dl_title_text" <?php if($show_dl_revars =='yes'): ?> style="order:2;" <?php endif; ?>> <?php echo str_replace(['{', '}'], ['<span>', '</span>'],  $dl_title_text); ?> </<?php echo $dl_title_tags; ?>>
	        <?php endif; ?>

	        <?php if($has_sub_title): ?>
	        <<?php echo $dl_subtitle_tags; ?> class="dl_sub_title_text" <?php if($show_dl_revars=='yes'): ?> style="order:1;" <?php endif; ?>> <?php echo wp_kses_post( $dl_subtitle_text ); ?></<?php echo $dl_subtitle_tags; ?>>
	        <?php endif; ?>

	        <?php if($has_content): ?>
	            <div class="dl_content_text" <?php if($show_dl_revars=='yes'): ?> style="order:3;" <?php endif ?>><?php echo wp_kses_post( $dl_content_text ); ?></div>
	        <?php endif; ?>
	    </div>    
	    <?php }
  
    protected function content_template(){}
}
