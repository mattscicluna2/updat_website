<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Infobox\Infobox_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Infobox\Infobox_Module as Module;
use \Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) { exit;}

class Droit_Addons_Infobox extends Control
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
        return [];
    }
    public function get_custom_help_url()
    {
        return Module::get_custom_help_url();
    }

    protected function _register_controls()
    {
        parent::_register_controls();
        $this->register_infobox_skin_section_controls();
        $this->register_infobox_image_icon_section_controls();
        $this->register_infobox_content_section_controls();
        $this->_droit_register_dl_infobox_general_style_controls();
        $this->register_infobox_image_style_section_controls();
        $this->register_style_infobox_title_section_controls();
        $this->register_style_infobox_content_section_controls();
        $this->register_style_infobox_button_section_controls();
        $this->register_style_infobox_box_shadow_section_controls();
        $this->register_style_infobox_animation_section_controls();
        $this->register_infobox_alignment_section_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }
    protected function _free_infobox_header_link()
    {
        $settings = $this->get_settings_for_display();

        if (!$this->get_infobox_settings('_infobox_link')['url']) {
            return;
        }
        printf('<a %1$s>', droit_addons_link($this->get_infobox_settings('_infobox_link'), false));
    }
    protected function _free_infobox_footer_link()
    {
        $settings = $this->get_settings_for_display();

        if (!$this->get_infobox_settings('_infobox_link')['url']) {
            return;
        }
        printf('</a>');
    }
//Image/Icon
    protected function _free_infobox_image_icon()
    {
        $settings = $this->get_settings_for_display();
       $_infobox_skin  = !empty($this->get_infobox_settings('_infobox_skin')) ? $this->get_infobox_settings('_infobox_skin') : '_skin_1';
        $_shape_class =  $_infobox_skin == ' _skin_1 ' ? ' shape_1 ' : '';
        $_bg_color_2 =  '';
        switch ($_infobox_skin) {
            case '_skin_3':
                 $_bg_color_2 =  ' layout_three';
                break;
        }

        ?>
        <?php if ($this->get_infobox_settings('_free_media_type') === '_free_image' && ($this->get_infobox_settings('_free_info_image')['url'] || $this->get_infobox_settings('_free_info_image')['id'])): ?>
            <div class="info_box_icon_wrap">
                    <div class="info_box_icon <?php echo $_shape_class . $_bg_color_2; ?>">
                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'full', '_free_info_image'); ?>
                    <?php if ( $_infobox_skin == '_skin_4'): ?>
                    <img src="<?php echo drdt_core()->images . 'info_box_shape_1.png'; ?>" alt="info_box_shape_1" class="info_box_shape">
                    <?php endif; ?>
               </div>
           </div>
       <?php endif;?>

   <?php }
    //tittle
   protected function _free_infobox_title()
   {
    $settings = $this->get_settings_for_display();
    if (!$this->get_infobox_settings('_infobox_title')) {
        return;
    }
    $_infobox_title_tag = $this->get_infobox_settings('_infobox_title_tag')
    ?>
    <<?php echo esc_attr($_infobox_title_tag); ?> class="dl_title droit-infobox-title <?php echo $this->get_infobox_settings('_infobox_animation'); ?>"> <?php echo esc_html__($this->get_infobox_settings('_infobox_title'), 'droit-elementor-addons'); ?></<?php echo esc_attr($_infobox_title_tag); ?>>
<?php }
    //Content
protected function _free_infobox_content()
{
    $settings = $this->get_settings_for_display();
    if (!$this->get_infobox_settings('_infobox_content')) {
        return;
    }
    ?>
    <p class="dl_description droit-infobox-description"> <?php echo wp_kses_post(nl2br($this->get_infobox_settings('_infobox_content'))); ?></p>
<?php }
    //btn
protected function _free_infobox_btn()
{
    $settings = $this->get_settings_for_display();
    $settings       = $this->get_settings_for_display();
    $_infobox_skin  = !empty($this->get_infobox_settings('_infobox_skin')) ? $this->get_infobox_settings('_infobox_skin') : '_skin_1';
    $_btn_class =  '';
    $_btn_icon =  '';
    
    switch ($_infobox_skin) {
        case '_skin_2':
             $_btn_class = 'dl_cu_btn btn_2';
            break;
        case '_skin_3':
             $_btn_class = 'read_more_btn';
            break;
    }

    if (!$this->get_infobox_settings('_infobox_btn')) {
        return;
    }
    printf('<a %1$s class="%3$s droit-infobox-button"> %2$s  %4$s  </a>', droit_addons_link($this->get_infobox_settings('_infobox_link'), false), $this->get_infobox_settings('_infobox_btn'), $_btn_class, $_btn_icon);
    ?>
    
<?php }
//Html render
protected function render()
{
    $settings       = $this->get_settings_for_display();
    $_infobox_skin  = !empty($this->get_infobox_settings('_infobox_skin')) ? $this->get_infobox_settings('_infobox_skin') : '_skin_1';
   
    switch ($_infobox_skin) {
        case '_skin_1':
             $this->_incobox_skin_one();
            break;
        case '_skin_2':
             $this->_incobox_skin_two();
            break;
        case '_skin_3':
             $this->_incobox_skin_three();
            break;
        default:
            $this->_incobox_skin_one();
            break;
    }
 }


/*Layout Skin*/

protected function _incobox_skin_one()
{
    $settings = $this->get_settings_for_display();
    $_container_class       = '';
    $_free_image_icon_align = $this->get_infobox_settings('_free_image_icon_align');

    switch ($_free_image_icon_align) {
        case 'left':
        $_container_class = 'container-left';
        break;

        case 'center':
        $_container_class = 'container-center';
        break;
        case 'right':
        $_container_class = 'container-right';
        break;
    }
    ?>
    <div class="infobox-container dl_single_info_box style_1 <?php echo esc_attr($_container_class); ?>">
        <?php
            $this->_free_infobox_header_link();
            $this->_free_infobox_image_icon();
        ?>
        <div class="dl-infobox-content-area">
             <?php $this->_free_infobox_title();?>
             <?php $this->_free_infobox_content();?>
        </div>
     <?php $this->_free_infobox_footer_link();?>
     </div>
<?php }

protected function _incobox_skin_two()
{
    $settings = $this->get_settings_for_display();
    $_container_class       = '';
    $_free_image_icon_align = $this->get_infobox_settings('_free_image_icon_align');

    switch ($_free_image_icon_align) {
        case 'left':
        $_container_class = 'container-left';
        break;

        case 'center':
        $_container_class = 'container-center';
        break;
        case 'right':
        $_container_class = 'container-right';
        break;
    }
    ?>
    <div class="infobox-container dl_single_info_box style_2 <?php echo esc_attr($_container_class); ?>">
        <?php
            $this->_free_infobox_image_icon();
         ?>
         <div class="dl-infobox-content-area">
            <?php 
                $this->_free_infobox_title();
                $this->_free_infobox_content();
                $this->_free_infobox_btn();
             ?>
        </div>
        
     </div>
<?php }

protected function _incobox_skin_three()
{
    $settings = $this->get_settings_for_display();
    $_container_class       = '';
    $_free_image_icon_align = $this->get_infobox_settings('_free_image_icon_align');

    switch ($_free_image_icon_align) {
        case 'left':
        $_container_class = ' container-left';
        break;

        case 'center':
        $_container_class = ' container-center';
        break;
        case 'right':
        $_container_class = ' container-right';
        break;
    }
    ?>
    <div class="infobox-container dl_single_info_box style_5 <?php echo $_container_class; ?>">
            <?php $this->_free_infobox_image_icon(); ?>
        <div class="dl-infobox-content-area dl_single_info_box_content">
            <?php 
                $this->_free_infobox_title();
                $this->_free_infobox_content();
                $this->_free_infobox_btn();
             ?>
        </div>
     </div>
<?php }


protected function content_template()
{}
}
