<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Card\Card_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Card\Card_Module as Module;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Control_Media;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Card extends Control
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
        $this->_droit_register_card_content_controls();
        $this->_droit_register_card_image_style_controls_first_layout();
        $this->_droit_register_card_image_style_controls_second_layout();
        $this->_droit_register_card_style_alignment_controls();
        $this->_droit_register_card_style_title_controls();
        $this->_droit_register_card_style_content_controls();
        $this->_droit_register_card_style_button_controls();
        $this->_droit_register_card_style_box_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

//Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_card_skin  = !empty($this->get_card_settings('_card_skin')) ? $this->get_card_settings('_card_skin') : '_skin_1';

        switch ($_card_skin) {
            case '_skin_1':
                 $this->_card_box_one();
                break;
            case '_skin_2':
                 $this->_card_box_two();
                break;
            case '_skin_3':
                 $this->_card_box_three();
                break;
            default:
                $this->_card_box_one();
                break;
        }  
    }
    
    //Layout One
    protected function _card_box_one(){
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_card_title_text', 'class', 'dl_title droit-card-title' );
        $this->add_render_attribute( '_card_description_text', 'class', 'dl_tag droit-card-tag droit-card-text' );
        $this->add_render_attribute( '_card_btn_text', 'class', 'droit-card-btn dl_cu_btn btn_4 dl_round_1 text_upper' );
         $link_tag = 'span';
        if ( ! empty( $this->get_card_settings('_card_link')['url'] ) ) {
            $link_tag = 'a';
            $this->add_link_attributes( '_card_link', $this->get_card_settings('_card_link') );
        }

        $has_image = ! empty( $this->get_card_settings('_card_image') );
        $has_title_text = ! empty( $this->get_card_settings('_card_title_text') );
        $has_description_text = ! empty( $this->get_card_settings('_card_description_text') );
        $has_btn_text = ! empty( $this->get_card_settings('_card_btn_text') );


        $link_attributes = $this->get_render_attribute_string( '_card_link' );


        $this->add_inline_editing_attributes( '_card_title_text', 'none' );
        $this->add_inline_editing_attributes( '_card_description_text', 'none' );
        $this->add_inline_editing_attributes( '_card_btn_text', 'none' );
        ?>
        <div class="dl_card_box dl_card_style_01 dl_text_center droit-card-box-wrapper">

            <?php if ( $has_image ) : ?>
                <?php 
                $this->add_render_attribute( '_card_image', 'class', 'droit-card-image dl_thumbnail_fluid' );
                if ( $this->get_card_settings('_card_hover_animation') ) {
                        $this->add_render_attribute( '_card_image', 'class', 'elementor-animation-' . $this->get_card_settings('_card_hover_animation') );
                    }
                 ?>
             <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?> <?php echo $this->get_render_attribute_string( '_card_image' ); ?>>
                <?php 
                if ( ! empty( $this->get_card_settings('_card_image')['url'] ) ) {
                    ?><?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_card_image' ); ?>
                <?php }

                 ?>
            </<?php echo esc_html($link_tag); ?>>
            <?php endif; ?>

            <div class="dl_single_info_box_content">

                <?php if ( $has_description_text ) : ?>
                <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?> <?php echo $this->get_render_attribute_string( '_card_description_text' ); ?>><?php echo $this->get_card_settings('_card_description_text'); ?>
                </<?php echo esc_html($link_tag); ?>>
                <?php endif; ?>
                 
                <?php if ( $has_title_text ) : ?>
                 <<?php echo esc_html( droit_title_tag($this->get_card_settings('_card_title_size')) ); ?> <?php echo $this->get_render_attribute_string( '_card_title_text' ); ?>>
                 <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                    <?php echo esc_html( $this->get_card_settings('_card_title_text') ); ?>
                  </<?php echo esc_html($link_tag); ?>>
                </<?php echo esc_html( droit_title_tag($this->get_card_settings('_card_title_size')) ); ?>>
                <?php endif; ?>

                <?php if ( $has_btn_text ) : ?>
                <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?> <?php echo $this->get_render_attribute_string( '_card_btn_text' ); ?>><?php echo $this->get_card_settings('_card_btn_text'); ?></<?php echo $link_tag; ?>>
                <?php endif; ?>
            </div>
        </div>  
    <?php }
    
    //Layout two
    protected function _card_box_two(){
          $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_card_title_text', 'class', 'dl_title droit-card-title' );
        $this->add_render_attribute( '_card_description_text', 'class', 'dl_desc droit-card-text' );
        $this->add_render_attribute( '_card_image', 'class', 'droit-card-image dl_card_thumb' );
         $link_tag = 'span';
        if ( ! empty( $this->get_card_settings('_card_link')['url'] ) ) {
            $link_tag = 'a';
            $this->add_link_attributes( '_card_link', $this->get_card_settings('_card_link') );
        }

        $has_image = ! empty( $this->get_card_settings('_card_image') );
        $has_title_text = ! empty( $this->get_card_settings('_card_title_text') );
        $has_description_text = ! empty( $this->get_card_settings('_card_description_text') );
        $link_attributes = $this->get_render_attribute_string( '_card_link' );


        $this->add_inline_editing_attributes( '_card_title_text', 'none' );
        $this->add_inline_editing_attributes( '_card_description_text', 'none' );
        ?>
        <div class="dl_card_box dl_card_style_04 dl_text_center droit-card-box-wrapper">

            <?php if ( $has_image ) : ?>
                <?php 
                $this->add_render_attribute( '_card_image', 'class', 'droit-card-image' );
                if ( $this->get_card_settings('_card_hover_animation') ) {
                        $this->add_render_attribute( '_card_image', 'class', 'elementor-animation-' . $this->get_card_settings('_card_hover_animation') );
                    }
                 ?>
             <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?> <?php echo $this->get_render_attribute_string( '_card_image' ); ?>>
                <?php 
                if ( ! empty( $this->get_card_settings('_card_image')['url'] ) ) {
                    ?><?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', '_card_image' ); ?>
                <?php }

                 ?>
            </<?php echo esc_html($link_tag); ?>>
            <?php endif; ?>

                <?php if ( $has_title_text ) : ?>
                 <<?php echo esc_html( droit_title_tag($this->get_card_settings('_card_title_size')) ); ?> <?php echo $this->get_render_attribute_string( '_card_title_text' ); ?>>
                 <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                    <?php echo esc_html( $this->get_card_settings('_card_title_text') ); ?>
                  </<?php echo esc_html($link_tag); ?>>
                </<?php echo esc_html( droit_title_tag($this->get_card_settings('_card_title_size')) ); ?>>
                <?php endif; ?>

                <?php if ( $has_description_text ) : ?>
                <p <?php echo $this->get_render_attribute_string( '_card_description_text' ); ?>><?php echo $settings['_card_description_text']; ?>
                </p>
                <?php endif; ?>
          
        </div>  
    <?php }
    
    //Layout Three
    protected function _card_box_three(){
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_card_title_text', 'class', 'dl_title droit-card-title' );
        $this->add_render_attribute( '_card_image', 'class', 'droit-card-image dl_card_thumb' );
         $link_tag = 'span';
        if ( ! empty( $this->get_card_settings('_card_link')['url'] ) ) {
            $link_tag = 'a';
            $this->add_link_attributes( '_card_link', $this->get_card_settings('_card_link') );
        }

        $has_image = ! empty( $this->get_card_settings('_card_shape_list') );
        $has_title_text = ! empty( $this->get_card_settings('_card_title_text') );
        $has_description_text = ! empty( $this->get_card_settings('_card_description_text') );

        $link_attributes = $this->get_render_attribute_string( '_card_link' );

        $this->add_inline_editing_attributes( '_card_title_text', 'none' );
        ?>
        <div class="dl_card_box dl_card_style_05 mouse_move_animation droit-card-box-wrapper">
            <?php if ( $has_image ) : ?>
                <div class="dl_card_box_shape <?php echo $this->get_card_settings('_shape_skin');?>">
                   <?php foreach ($this->get_card_settings('_card_shape_list') as $_shape_list): ?>

                        <div class="dl_parallax_img wow slideInUp" data-wow-delay="<?php echo $_shape_list['_card_shape_delay']['size'];?>s">
                            <div class="layer layer2" data-depth="<?php echo $_shape_list['_card_shape_depth'];?>"><img src="<?php echo esc_url($_shape_list['_card_shape_image']['url']);?>" alt="<?php echo $_shape_list['_card_shape_name'];?>"></div>
                        </div>

                    <?php endforeach; ?>
                   
                </div>
            <?php endif; ?>

                <?php if ( $has_title_text ) : ?>
                 <<?php echo esc_html( droit_title_tag($this->get_card_settings('_card_title_size')) ); ?> <?php echo $this->get_render_attribute_string( '_card_title_text' ); ?>>
                 <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                    <?php echo esc_html( $this->get_card_settings('_card_title_text') ); ?>
                  </<?php echo esc_html($link_tag); ?>>
                </<?php echo esc_html( droit_title_tag($this->get_card_settings('_card_title_size')) ); ?>>
                <?php endif; ?>
        </div>  
    <?php }
    
    protected function content_template()
    {}
}
