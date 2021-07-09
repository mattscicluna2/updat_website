<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Iconbox\Iconbox_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Iconbox\Iconbox_Module as Module;
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Control_Media;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Iconbox extends Control
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
        parent::_register_controls();
        $this->_droit_register_iconbox_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

//Html render
      protected function render(){
        $settings = $this->get_settings_for_display();

        $_iconbox_skin  = !empty($this->get_iconbox_settings('_iconbox_skin')) ? $this->get_iconbox_settings('_iconbox_skin') : '_skin_1';
   
        switch ($_iconbox_skin) {
            case '_skin_1':
                 $this->_icon_box_one();
                break;
            case '_skin_2':
                 $this->_icon_box_two();
                break;
            case '_skin_3':
                 $this->_icon_box_three();
                break;
            case '_skin_4':
                 $this->_icon_box_four();
                break;
            case '_skin_5':
                 $this->_icon_box_five();
                break;
            default:
                $this->_icon_box_one();
                break;
        }
    }
   
    // Style One
    protected function _icon_box_one()
    {
       
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_iconbox_icon', 'class', [ 'droit-icon', 'elementor-animation-' . $settings['_iconbox_hover_animation'] ] );

        $link_tag = 'span';

        if ( ! isset( $settings['_iconbox_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['_iconbox_icon'] = 'fa fa-star';
        }

        $has_icon = ! empty( $settings['_iconbox_icon'] );

        if ( ! empty( $settings['_iconbox_link']['url'] ) ) {
            $link_tag = 'a';

            $this->add_link_attributes( '_iconbox_link', $settings['_iconbox_link'] );
        }

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['_iconbox_icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $icon_attributes = $this->get_render_attribute_string( '_iconbox_icon' );
        $link_attributes = $this->get_render_attribute_string( '_iconbox_link' );

        $this->add_render_attribute( '_iconbox_description_text', 'class', 'dl_desc droit-icon-description' );

        $this->add_inline_editing_attributes( '_iconbox_title_text', 'none' );
        $this->add_inline_editing_attributes( '_iconbox_description_text' );
        if ( ! $has_icon && ! empty( $settings['_iconbox_selected_icon']['value'] ) ) {
            $has_icon = true;
        }
        $migrated = isset( $settings['__fa4_migrated']['_iconbox_selected_icon'] );
        $is_new = ! isset( $settings['_iconbox_icon'] ) && Icons_Manager::is_migration_allowed();
        ?>
        <div class="droit-icon-box-wrapper">
            <div class="dl_icon_box_colum">
                <div class="dl_icon_box_wrapper dl_style_01">
                    <div class="dl_icon_wrapper">
                        <?php if ( $has_icon ) : ?>
                        <div class="dl_icon dl_color_1">
                            <?php
                            if ( $is_new || $migrated ) {
                                Icons_Manager::render_icon( $settings['_iconbox_selected_icon'], [ 'aria-hidden' => 'true' ] );
                            } elseif ( ! empty( $settings['_iconbox_icon'] ) ) {
                                ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                        <?php if ( ! Utils::is_empty( $this->get_iconbox_settings('_iconbox_description_text') ) ) : ?>
                        <h4 <?php echo $this->get_render_attribute_string( '_iconbox_description_text' ); ?>>
                        <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                            <?php echo $this->get_iconbox_settings('_iconbox_description_text'); ?>
                        </<?php echo esc_html( $link_tag ); ?>>
                        </h4>
                        <?php endif; ?>
                    
                </div>
            </div>
        </div>
    <?php }
    // Style Two
    protected function _icon_box_two(){

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_iconbox_icon', 'class', [ 'droit-icon', 'elementor-animation-' . $settings['_iconbox_hover_animation'] ] );

        $link_tag = 'span';

        if ( ! isset( $settings['_iconbox_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['_iconbox_icon'] = 'fa fa-star';
        }

        $has_icon = ! empty( $settings['_iconbox_icon'] );

        if ( ! empty( $settings['_iconbox_link']['url'] ) ) {
            $link_tag = 'a';

            $this->add_link_attributes( '_iconbox_link', $settings['_iconbox_link'] );
        }

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['_iconbox_icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $icon_attributes = $this->get_render_attribute_string( '_iconbox_icon' );
        $link_attributes = $this->get_render_attribute_string( '_iconbox_link' );

        $this->add_render_attribute( '_iconbox_title_text', 'class', 'dl_title droit-icon-title' );
        $this->add_render_attribute( '_iconbox_description_text', 'class', 'dl_sub_title droit-icon-description' );

        $this->add_inline_editing_attributes( '_iconbox_title_text', 'none' );
        $this->add_inline_editing_attributes( '_iconbox_description_text' );
        if ( ! $has_icon && ! empty( $settings['_iconbox_selected_icon']['value'] ) ) {
            $has_icon = true;
        }
        $migrated = isset( $settings['__fa4_migrated']['_iconbox_selected_icon'] );
        $is_new = ! isset( $settings['_iconbox_icon'] ) && Icons_Manager::is_migration_allowed();
        ?>
        <div class="droit-icon-box-wrapper">
            <div class="dl_icon_box_colum">
                <div class="dl_icon_box_wrapper dl_style_03">
                    <div class="dl_icon_wrapper">
                        <?php if ( $has_icon ) : ?>
                        <div class="dl_icon">
                            <?php
                            if ( $is_new || $migrated ) {
                                Icons_Manager::render_icon( $settings['_iconbox_selected_icon'], [ 'aria-hidden' => 'true' ] );
                            } elseif ( ! empty( $settings['_iconbox_icon'] ) ) {
                                ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                        <div class="dl_icon_box_content">
                            <?php if ( ! Utils::is_empty( $this->get_iconbox_settings('_iconbox_description_text') ) ) : ?>
                            <h5 <?php echo $this->get_render_attribute_string( '_iconbox_description_text' ); ?>><?php echo $this->get_iconbox_settings('_iconbox_description_text'); ?></h5>
                            <?php endif; ?>
                             <<?php echo esc_html( droit_title_tag($this->get_iconbox_settings('_iconbox_title_size')) ); ?> 
                             <?php echo $this->get_render_attribute_string( '_iconbox_title_text' ); ?>>
                                <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                                <?php echo $this->get_iconbox_settings('_iconbox_title_text'); ?>
                                </<?php echo esc_html( $link_tag ); ?>>
                            </<?php echo esc_html( droit_title_tag($this->get_iconbox_settings('_iconbox_title_size')) ); ?>>
                    </div>
                </div>
            </div>
        </div>
    <?php }

    // Style Three
    protected function _icon_box_three(){
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_iconbox_icon', 'class', [ 'droit-icon', 'elementor-animation-' . $settings['_iconbox_hover_animation'] ] );

        $link_tag = 'span';

        if ( ! isset( $settings['_iconbox_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['_iconbox_icon'] = 'fa fa-star';
        }

        $has_icon = ! empty( $settings['_iconbox_icon'] );

        if ( ! empty( $settings['_iconbox_link']['url'] ) ) {
            $link_tag = 'a';

            $this->add_link_attributes( '_iconbox_link', $settings['_iconbox_link'] );
        }

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['_iconbox_icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $icon_attributes = $this->get_render_attribute_string( '_iconbox_icon' );
        $link_attributes = $this->get_render_attribute_string( '_iconbox_link' );

        $this->add_render_attribute( '_iconbox_title_text', 'class', 'dl_title droit-icon-title' );
        $this->add_render_attribute( '_iconbox_description_text', 'class', 'dl_desc droit-icon-description' );

        $this->add_inline_editing_attributes( '_iconbox_title_text', 'none' );
        $this->add_inline_editing_attributes( '_iconbox_description_text' );
        if ( ! $has_icon && ! empty( $settings['_iconbox_selected_icon']['value'] ) ) {
            $has_icon = true;
        }
        $migrated = isset( $settings['__fa4_migrated']['_iconbox_selected_icon'] );
        $is_new = ! isset( $settings['_iconbox_icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div class="droit-icon-box-wrapper">
            <div class="dl_icon_box_colum">
                <div class="dl_icon_box_wrapper dl_style_04">
                    <div class="dl_icon_wrapper">
                        <?php if ( $has_icon ) : ?>
                        <div class="dl_icon">
                            <?php
                            if ( $is_new || $migrated ) {
                                Icons_Manager::render_icon( $settings['_iconbox_selected_icon'], [ 'aria-hidden' => 'true' ] );
                            } elseif ( ! empty( $settings['_iconbox_icon'] ) ) {
                                ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                            }
                            ?>
                            <?php if ( ! empty( $this->get_iconbox_settings('_iconbox_shape_image')['url'] ) ): ?>
                                <img src="<?php echo $this->get_iconbox_settings('_iconbox_shape_image')['url']; ?>" alt="BG Shape" class="dl_icon_box_shape">
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                        <<?php echo esc_html( droit_title_tag($this->get_iconbox_settings('_iconbox_title_size')) ); ?> <?php echo $this->get_render_attribute_string( '_iconbox_title_text' ); ?>>
                            <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                                <?php echo esc_html( $this->get_iconbox_settings('_iconbox_title_text') ); ?>
                            </<?php echo esc_html( $link_tag ); ?>>
                        </<?php echo esc_html( droit_title_tag($this->get_iconbox_settings('_iconbox_title_size')) ); ?>>
                        <?php if ( ! Utils::is_empty( $this->get_iconbox_settings('_iconbox_description_text') ) ) : ?>
                        <p <?php echo $this->get_render_attribute_string( '_iconbox_description_text' ); ?>><?php echo esc_html( $this->get_iconbox_settings('_iconbox_description_text') ); ?></p>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    <?php }

    // Style Four
    protected function _icon_box_four(){
         $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_iconbox_icon', 'class', [ 'droit-icon', 'elementor-animation-' . $settings['_iconbox_hover_animation'] ] );

        $link_tag = 'span';

        if ( ! isset( $settings['_iconbox_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['_iconbox_icon'] = 'fa fa-star';
        }

        $has_icon = ! empty( $settings['_iconbox_icon'] );

        if ( ! empty( $settings['_iconbox_link']['url'] ) ) {
            $link_tag = 'a';

            $this->add_link_attributes( '_iconbox_link', $settings['_iconbox_link'] );
        }

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['_iconbox_icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $icon_attributes = $this->get_render_attribute_string( '_iconbox_icon' );
        $link_attributes = $this->get_render_attribute_string( '_iconbox_link' );

        $this->add_render_attribute( '_iconbox_description_text', 'class', 'dl_desc droit-icon-description' );

        $this->add_inline_editing_attributes( '_iconbox_title_text', 'none' );
        $this->add_inline_editing_attributes( '_iconbox_description_text' );
        if ( ! $has_icon && ! empty( $settings['_iconbox_selected_icon']['value'] ) ) {
            $has_icon = true;
        }
        $migrated = isset( $settings['__fa4_migrated']['_iconbox_selected_icon'] );
        $is_new = ! isset( $settings['_iconbox_icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div class="droit-icon-box-wrapper">
            <div class="dl_icon_box_colum">
                <div class="dl_icon_box_wrapper dl_style_06 droit-bg_color">
                    <div class="dl_icon_wrapper">
                        <?php if ( $has_icon ) : ?>
                        <div class="dl_icon">
                            <?php
                            if ( $is_new || $migrated ) {
                                Icons_Manager::render_icon( $settings['_iconbox_selected_icon'], [ 'aria-hidden' => 'true' ] );
                            } elseif ( ! empty( $settings['_iconbox_icon'] ) ) {
                                ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                        <?php if ( ! Utils::is_empty( $this->get_iconbox_settings('_iconbox_description_text') ) ) : ?>
                        <h4 <?php echo $this->get_render_attribute_string( '_iconbox_description_text' ); ?>>
                            <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                            <?php echo $this->get_iconbox_settings('_iconbox_description_text'); ?>
                            </<?php echo esc_html( $link_tag ); ?>>
                        </h4>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    <?php }

    // Style Five
    protected function _icon_box_five(){
         $settings = $this->get_settings_for_display();

        $this->add_render_attribute( '_iconbox_icon', 'class', [ 'droit-icon', 'elementor-animation-' . $settings['_iconbox_hover_animation'] ] );

        $link_tag = 'span';

        if ( ! isset( $settings['_iconbox_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['_iconbox_icon'] = 'fa fa-star';
        }

        $has_icon = ! empty( $settings['_iconbox_icon'] );

        if ( ! empty( $settings['_iconbox_link']['url'] ) ) {
            $link_tag = 'a';

            $this->add_link_attributes( '_iconbox_link', $settings['_iconbox_link'] );
        }

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['_iconbox_icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $icon_attributes = $this->get_render_attribute_string( '_iconbox_icon' );
        $link_attributes = $this->get_render_attribute_string( '_iconbox_link' );

        $this->add_render_attribute( '_iconbox_description_text', 'class', 'dl_desc droit-icon-description' );

        $this->add_inline_editing_attributes( '_iconbox_title_text', 'none' );
        $this->add_inline_editing_attributes( '_iconbox_description_text' );
        if ( ! $has_icon && ! empty( $settings['_iconbox_selected_icon']['value'] ) ) {
            $has_icon = true;
        }
        $migrated = isset( $settings['__fa4_migrated']['_iconbox_selected_icon'] );
        $is_new = ! isset( $settings['_iconbox_icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div class="droit-icon-box-wrapper">
            <div class="dl_icon_box_colum">
                <div class="dl_icon_box_wrapper dl_style_07 droit-bg_color">
                    <div class="dl_icon_wrapper">
                        <?php if ( $has_icon ) : ?>
                        <div class="dl_icon">
                            <?php
                            if ( $is_new || $migrated ) {
                                Icons_Manager::render_icon( $settings['_iconbox_selected_icon'], [ 'aria-hidden' => 'true' ] );
                            } elseif ( ! empty( $settings['_iconbox_icon'] ) ) {
                                ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                        <?php if ( ! Utils::is_empty( $this->get_iconbox_settings('_iconbox_description_text') ) ) : ?>
                        <h4 <?php echo $this->get_render_attribute_string( '_iconbox_description_text' ); ?>>
                            <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                            <?php echo $this->get_iconbox_settings('_iconbox_description_text'); ?>
                                </<?php echo esc_html( $link_tag ); ?>>
                            </h4>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    <?php }
    protected function content_template()
    {}
}
