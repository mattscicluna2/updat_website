<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Accordion\Accordion_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Accordion\Accordion_Module as Module;
use \ELEMENTOR\Icons_Manager;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Accordion extends Control
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
        $this->_droit_register_dl_accordions_preset_controls();
        $this->_droit_register_dl_accordions_content_controls();
        $this->_droit_register_dl_accordions_general_style_controls();
        $this->_droit_register_dl_accordions_title_style_controls();
        $this->_droit_register_dl_accordions_content_style_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

//Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
        $_dl_accordions_skin  =  !empty($this->get_accordion_settings('_dl_accordions_skin')) ? $this->get_accordion_settings('_dl_accordions_skin') : '_skin_1';
        switch ($_dl_accordions_skin) {
            case '_skin_1':
                 $this->_dl_accordions_style_one();
                break;
            default:
                $this->_dl_accordions_style_one();
                break;
        }
    }

    //Layout One
    protected function _dl_accordions_style_one(){
        $settings = $this->get_settings_for_display();
        $migrated = isset( $this->get_accordion_settings('__fa4_migrated')['_dl_accordion_selected_icon'] );

        if (  !empty( $this->get_accordion_settings('icon') ) && ! Icons_Manager::is_migration_allowed() ) {
           
            $settings['icon'] = 'fas fa-angle-up';
            $settings['icon_active'] = 'fas fa-angle-down';
        }


        $is_new = empty( $this->get_accordion_settings('icon') ) && Icons_Manager::is_migration_allowed();
        $has_icon = ( ! $is_new || ! empty( $this->get_accordion_settings('_dl_accordion_selected_icon')['value'] ) );
        
        $this->add_render_attribute(
            'dl_accordion_wrapper',
            [
                'id' => "droit-advance-accordions-{$this->get_id()}",
                'class' => ['droit-advance-accordions dl_accordion_container', $this->get_accordion_settings('_dl_accordions_skin')],
                'data-Accordionid' => $this->get_id(),
            ]
        );
        
        $has_accordions = ! empty( $this->get_accordion_settings('_dl_accordions_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_accordions): ?>
        <div <?php echo $this->get_render_attribute_string('dl_accordion_wrapper'); ?> >
            <div class="dl_accordion">
                <?php
                $i = 1;
            foreach ( $this->get_accordion_settings('_dl_accordions_list') as $index => $item ) :
                
                $tab_count = $index + 1;

                
                $has_title_text = ! empty( $item['_dl_accordions_title'] );

                $has_description_text = ! empty( $item['_dl_accordions_description_text'] );

                $has_image = ! empty( $item['_dl_accordions_image']['url'] );

                $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_accordions_title', '_dl_accordions_list', $index );

                $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_accordions_description_text', '_dl_accordions_list', $index );

                $icon_tag = '';
                if ( ! empty( $item['_dl_accordions_link']['url'] ) ) {
                    $icon_tag = 'a';
                    $this->add_link_attributes( '_dl_accordions_link', $item['_dl_accordions_link'] );
                }
                $link_attributes = $this->get_render_attribute_string( '_dl_accordions_link' );


                $title_active_class = '';
                $content_active_class = '';

                if ($item['_dl_accordions_show_as_default'] == 'yes') {
                    $title_active_class = 'dl-active-default dl-active';
                    $content_active_class = 'dl-active-default dl-active';
                }

                $this->add_render_attribute( $tab_title_setting_key, [
                    'id' => 'accordion-tab-title-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_item_title droit-accordion-title', $title_active_class ],
                    'data-speed' => 400,
                ] );

                $this->add_render_attribute( $tab_content_setting_key, [
                    'id' => 'droit-tab-content-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_panel', 'droit-accordion-content-wrapper', $content_active_class ],
                ] );

                ?>
                    <div class="dl_accordion_item dl_accordion_style_08 droit-accordion-wrapper">
                    <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo esc_html( droit_title_tag($this->get_accordion_settings('_dl_accordions_title_size')) ); ?> class="dl_accordion_title droit-accordions-title">
                                <?php echo do_shortcode($item['_dl_accordions_title']); ?>
                            </<?php echo esc_html( droit_title_tag($this->get_accordion_settings('_dl_accordions_title_size')) ); ?>>
                        <?php endif; ?>
                        <div class="droit-icon">
                            <?php 
                            if ($this->get_accordion_settings('_dl_accordions_icon_show') === 'yes' ) {
                                if($this->get_accordion_settings('_dl_accordions_icon_type') == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                        <span class="droit-accordion_icon" aria-hidden="true">
                                            <span class="droit-accordion-icon-closed"><?php Icons_Manager::render_icon( $this->get_accordion_settings('_dl_accordion_selected_icon') ); ?></span>

                                            <span class="droit-accordion-icon-opend"><?php Icons_Manager::render_icon( $this->get_accordion_settings('selected_active_icon') ); ?></span>
                                        </span>
                                   <?php }
                                }elseif( $this->get_accordion_settings('_dl_accordions_icon_type') == 'image' ){ ?>
                                    <span class="droit-accordion_icon" aria-hidden="true">
                                        <span class="droit-accordion-icon-closed">
                                            <img src="<?php echo esc_url($this->get_accordion_settings('_dl_accordions_icon_image')['url']); ?>" alt="closed Icon">
                                        </span>
                                        <span class="droit-accordion-icon-opend">
                                            <img src="<?php echo esc_url($this->get_accordion_settings('_dl_accordions_active_image')['url']); ?>" alt="Opend Icon">
                                        </span>
                                    </span>

                               <?php }
                                
                            }

                             ?>
                        </div>
                    </div>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                        <div class="dl_accordion_inner">
                            <?php if ( 'yes' == $item['_dl_accordions_image_show'] ) : ?>
                                <?php if ( $has_image ): ?>
                                <div class="dl_accordion_thumb">
                                     <a <?php echo $link_attributes; ?> >
                                    <img src="<?php echo esc_url($item['_dl_accordions_image']['url']); ?>" alt="#" class="dl_img_res">
                                    </a>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="dl_accordion_inner_content">
                                <?php if ( $has_description_text ) : ?>
                                <p class="dl_desc">
                                    <?php echo do_shortcode($item['_dl_accordions_description_text']); ?>
                                </p>
                                <?php endif; ?>
                                
                                <?php if ( 'yes' == $item['_dl_accordions_button_show'] ) : ?>
                                    <a <?php echo $link_attributes; ?> class="dl_cu_btn btn_2 droit-accordion-button">
                                        <?php echo droit_addons_kses($item['_dl_accordions_button_text']); ?>
                                    </a>
                                 <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }

   
    protected function content_template()
    {}
}
