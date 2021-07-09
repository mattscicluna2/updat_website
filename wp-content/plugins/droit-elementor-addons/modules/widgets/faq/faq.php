<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Faq\Faq_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Faq\Faq_Module as Module;
use \ELEMENTOR\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Faq extends Control
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
        $this->_droit_register_dl_faq_preset_controls();
        $this->_droit_register_dl_faq_content_controls();
        $this->_droit_register_dl_faq_general_style_controls();
        $this->_droit_register_dl_faq_title_style_controls();
        $this->_droit_register_dl_faq_content_style_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

//Html render
    protected function render(){
         $settings = $this->get_settings_for_display();

        $_dl_faq_skin  = !empty($this->get_faq_settings('_dl_faq_skin')) ? $this->get_faq_settings('_dl_faq_skin') : '_skin_1';

        switch ($_dl_faq_skin) {
            case '_skin_1':
                 $this->_dl_faq_style_one();
                break;
            case '_skin_2':
                 $this->_dl_faq_style_two();
                break;
            case '_skin_3':
                 $this->_dl_faq_style_three();
                break;
            case '_skin_4':
                 $this->_dl_faq_style_four();
                break;
            default:
                $this->_dl_faq_style_one();
                break;
        } 
    }

    //Layout One
    protected function _dl_faq_style_one(){
        $settings = $this->get_settings_for_display();
        $migrated = isset( $settings['__fa4_migrated']['_dl_faq_selected_icon'] );

        if ( ! empty( $this->get_faq_settings('icon') ) && ! Icons_Manager::is_migration_allowed() ) {
           
            $settings['icon'] = 'fas fa-angle-up';
            $settings['icon_active'] = 'fas fa-angle-down';
        }

        $is_new = empty( $this->get_faq_settings('icon') ) && Icons_Manager::is_migration_allowed();
        $has_icon = ( ! $is_new || ! empty( $this->get_faq_settings('_dl_faq_selected_icon')['value'] ) );
        
        $this->add_render_attribute(
            'dl_faq_wrapper',
            [
                'id' => "droit-advance-faq-{$this->get_id()}",
                'class' => ['droit-advance-faq dl_accordion_container', $this->get_faq_settings('_dl_faq_skin')],
                'data-faqid' => $this->get_id(),
            ]
        );
        
        $has_faq = ! empty( $this->get_faq_settings('_dl_faq_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_faq): ?>
        <div <?php echo $this->get_render_attribute_string('dl_faq_wrapper'); ?> >
            <div class="dl_accordion">
                <?php
                $i = 1;
            foreach ( $this->get_faq_settings('_dl_faq_list') as $index => $item ) :
                
                $tab_count = $index + 1;

                
                $has_title_text = ! empty( $item['_dl_faq_title'] );

                $has_description_text = ! empty( $item['_dl_faq_description_text'] );

                $has_image = ! empty( $item['_dl_faq_image']['url'] );

                $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_title', '_dl_faq_list', $index );

                $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_faq_description_text', '_dl_faq_list', $index );

                $icon_tag = '';
                if ( ! empty( $item['_dl_faq_link']['url'] ) ) {
                    $icon_tag = 'a';
                    $this->add_link_attributes( '_dl_faq_link', $item['_dl_faq_link'] );
                }
                $link_attributes = $this->get_render_attribute_string( '_dl_faq_link' );

                $title_active_class = '';
                $content_active_class = '';

                if ($item['_dl_faq_show_as_default'] == 'yes') {
                    $title_active_class = 'dl-active-default';
                    $content_active_class = 'dl-active-default';
                }

                $this->add_render_attribute( $tab_title_setting_key, [
                    'id' => 'faq-tab-title-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_item_title droit-faq-title', $title_active_class ],
                    'data-speed' => 400,
                ] );

                $this->add_render_attribute( $tab_content_setting_key, [
                    'id' => 'faq-tab-content-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_panel', 'droit-faq-content-wrapper', $content_active_class ],
                ] );

                ?>
                    <div class="dl_accordion_item dl_accordion_style_02 droit-faq-wrapper">
                    <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo droit_title_tag($item['_dl_faq_title_size']); ?> class="dl_accordion_title droit-faq-title"><?php echo do_shortcode($item['_dl_faq_title']); ?></<?php echo droit_title_tag($item['_dl_faq_title_size']); ?>>
                        <?php endif; ?>
                        <div class="droit-icon">
                            <?php 
                            if ($this->get_faq_settings('_dl_faq_icon_show') === 'yes' ) {
                                if($this->get_faq_settings('_dl_faq_icon_type') == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                        
                                        <span class="droit-accordion-icon-closed"><?php Icons_Manager::render_icon( $this->get_faq_settings('_dl_faq_selected_icon') ); ?></span>

                                        <span class="droit-accordion-icon-opend"><?php Icons_Manager::render_icon( $this->get_faq_settings('selected_active_icon') ); ?></span>
                                        
                                   <?php }
                                }elseif( $this->get_faq_settings('_dl_faq_icon_type') == 'image' ){ ?>

                                    <span class="droit-accordion-icon-closed">
                                        <img src="<?php echo esc_url($this->get_faq_settings('_dl_faq_icon_image')['url']); ?>" alt="closed Icon">
                                    </span>
                                    <span class="droit-accordion-icon-opend">
                                        <img src="<?php echo esc_url($this->get_faq_settings('_dl_faq_active_image')['url']); ?>" alt="Opend Icon">
                                    </span>

                               <?php }
                                
                            }

                             ?>
                        </div>
                    </div>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                        <?php if ( $has_description_text ) : ?>
                            <p class="dl_desc">
                                <?php echo do_shortcode($item['_dl_faq_description_text']); ?>
                            </p>
                        <?php endif; ?>

                         <?php if ( 'yes' == $item['_dl_faq_button_show'] ) : ?>
                            <a <?php echo $link_attributes; ?> class="dl_cu_btn btn_2 droit-faq-button">
                                <?php echo droit_addons_kses($item['_dl_faq_button_text']); ?>
                            </a>
                         <?php endif; ?>
                    </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }

    //Layout Two
    protected function _dl_faq_style_two(){
        $settings = $this->get_settings_for_display();
        $migrated = isset( $this->get_faq_settings('__fa4_migrated')['_dl_faq_selected_icon'] );

        if ( ! empty( $this->get_faq_settings('icon') ) && ! Icons_Manager::is_migration_allowed() ) {
           
            $settings['icon'] = 'fas fa-angle-up';
            $settings['icon_active'] = 'fas fa-angle-down';
        }

        $is_new = empty( $this->get_faq_settings('icon') ) && Icons_Manager::is_migration_allowed();
        $has_icon = ( ! $is_new || ! empty( $this->get_faq_settings('_dl_faq_selected_icon')['value'] ) );
        
        $this->add_render_attribute(
            'dl_faq_wrapper',
            [
                'id' => "droit-advance-faq-{$this->get_id()}",
                'class' => ['droit-advance-faq dl_accordion_container', $this->get_faq_settings('_dl_faq_skin')],
                'data-faqid' => $this->get_id(),
            ]
        );
        
        $has_faq = ! empty( $this->get_faq_settings('_dl_faq_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_faq): ?>
        <div <?php echo $this->get_render_attribute_string('dl_faq_wrapper'); ?> >
            <div class="dl_accordion">
                <?php
                $i = 1;
            foreach ( $this->get_faq_settings('_dl_faq_list') as $index => $item ) :
                
                $tab_count = $index + 1;

                
                $has_title_text = ! empty( $item['_dl_faq_title'] );

                $has_description_text = ! empty( $item['_dl_faq_description_text'] );

                $has_image = ! empty( $item['_dl_faq_image']['url'] );

                $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_title', '_dl_faq_list', $index );

                $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_faq_description_text', '_dl_faq_list', $index );

                $icon_tag = '';
                if ( ! empty( $item['_dl_faq_link']['url'] ) ) {
                    $icon_tag = 'a';
                    $this->add_link_attributes( '_dl_faq_link', $item['_dl_faq_link'] );
                }
                $link_attributes = $this->get_render_attribute_string( '_dl_faq_link' );

                $title_active_class = '';
                $content_active_class = '';

                if ($item['_dl_faq_show_as_default'] == 'yes') {
                    $title_active_class = 'dl-active-default';
                    $content_active_class = 'dl-active-default';
                }

                $this->add_render_attribute( $tab_title_setting_key, [
                    'id' => 'faq-tab-title-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_item_title droit-faq-title', $title_active_class ],
                    'data-speed' => 400,
                ] );

                $this->add_render_attribute( $tab_content_setting_key, [
                    'id' => 'droit-tab-content-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_panel', 'droit-faq-content-wrapper', $content_active_class ],
                ] );

                ?>
                    <div class="dl_accordion_item dl_accordion_style_03 droit-faq-wrapper">
                    <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo droit_title_tag($item['_dl_faq_title_size']); ?> class="dl_accordion_title droit-faq-title"><?php echo do_shortcode($item['_dl_faq_title']); ?></<?php echo droit_title_tag($item['_dl_faq_title_size']); ?>>
                        <?php endif; ?>
                        <div class="droit-icon">
                            <?php 
                            if ($this->get_faq_settings('_dl_faq_icon_show') === 'yes' ) {
                                if($this->get_faq_settings('_dl_faq_icon_type') == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                        
                                        <span class="droit-accordion-icon-closed"><?php Icons_Manager::render_icon( $settings['_dl_faq_selected_icon'] ); ?></span>

                                        <span class="droit-accordion-icon-opend"><?php Icons_Manager::render_icon( $settings['selected_active_icon'] ); ?></span>
                                        
                                   <?php }
                                }elseif( $this->get_faq_settings('_dl_faq_icon_type') == 'image' ){ ?>

                                    <span class="droit-accordion-icon-closed">
                                        <img src="<?php echo esc_url($this->get_faq_settings('_dl_faq_icon_image')['url']); ?>" alt="closed Icon">
                                    </span>
                                    <span class="droit-accordion-icon-opend">
                                        <img src="<?php echo esc_url($this->get_faq_settings('_dl_faq_active_image')['url']); ?>" alt="Opend Icon">
                                    </span>

                               <?php }
                                
                            }

                             ?>
                        </div>
                    </div>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                        <?php if ( $has_description_text ) : ?>
                            <p class="dl_desc">
                                <?php echo do_shortcode($item['_dl_faq_description_text']); ?>
                            </p>
                        <?php endif; ?>

                         <?php if ( 'yes' == $item['_dl_faq_button_show'] ) : ?>
                            <a <?php echo $link_attributes; ?> class="dl_cu_btn btn_2 droit-faq-button">
                                <?php echo droit_addons_kses($item['_dl_faq_button_text']); ?>
                            </a>
                         <?php endif; ?>
                    </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }

    //Layout Three
    protected function _dl_faq_style_three(){
        $settings = $this->get_settings_for_display();
        $migrated = isset( $this->get_faq_settings('__fa4_migrated')['_dl_faq_selected_icon'] );

        if ( ! empty( $this->get_faq_settings('icon') ) && ! Icons_Manager::is_migration_allowed() ) {
           
            $settings['icon'] = 'fas fa-angle-up';
            $settings['icon_active'] = 'fas fa-angle-down';
        }

        $is_new = empty( $this->get_faq_settings('icon') ) && Icons_Manager::is_migration_allowed();
        $has_icon = ( ! $is_new || ! empty( $this->get_faq_settings('_dl_faq_selected_icon')['value'] ) );
        
        $this->add_render_attribute(
            'dl_faq_wrapper',
            [
                'id' => "droit-advance-faq-{$this->get_id()}",
                'class' => ['droit-advance-faq dl_accordion_container', $this->get_faq_settings('_dl_faq_skin')],
                'data-faqid' => $this->get_id(),
            ]
        );
        
        $has_faq = ! empty( $this->get_faq_settings('_dl_faq_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_faq): ?>
        <div <?php echo $this->get_render_attribute_string('dl_faq_wrapper'); ?> >
            <div class="dl_accordion dl_wrapper_style_2">
                <?php
                $i = 1;
            foreach ( $this->get_faq_settings('_dl_faq_list') as $index => $item ) :
                
                $tab_count = $index + 1;
                
                $has_title_text = ! empty( $item['_dl_faq_title'] );

                $has_description_text = ! empty( $item['_dl_faq_description_text'] );

                $has_image = ! empty( $item['_dl_faq_image']['url'] );

                $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_title', '_dl_faq_list', $index );

                $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_faq_description_text', '_dl_faq_list', $index );

                $icon_tag = '';
                if ( ! empty( $item['_dl_faq_link']['url'] ) ) {
                    $icon_tag = 'a';
                    $this->add_link_attributes( '_dl_faq_link', $item['_dl_faq_link'] );
                }
                $link_attributes = $this->get_render_attribute_string( '_dl_faq_link' );

                $title_active_class = '';
                $content_active_class = '';

                if ($item['_dl_faq_show_as_default'] == 'yes') {
                    $title_active_class = 'dl-active-default dl-active';
                    $content_active_class = 'dl-active-default dl-active';
                }

                $this->add_render_attribute( $tab_title_setting_key, [
                    'id' => 'faq-tab-title-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_item_title droit-faq-title', $title_active_class ],
                    'data-speed' => 400,
                ] );

                $this->add_render_attribute( $tab_content_setting_key, [
                    'id' => 'droit-tab-content-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_panel', 'droit-faq-content-wrapper', $content_active_class ],
                ] );

                ?>
                    <div class="dl_accordion_item dl_accordion_style_06 droit-faq-wrapper">
                    <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
                        <?php if ( $has_title_text ) : ?>
                            <<?php echo droit_title_tag($item['_dl_faq_title_size']); ?> class="dl_accordion_title droit-faq-title"><?php echo do_shortcode($item['_dl_faq_title']); ?></<?php echo droit_title_tag($item['_dl_faq_title_size']); ?>>
                        <?php endif; ?>
                        <div class="droit-icon">
                            <?php 
                            if ($this->get_faq_settings('_dl_faq_icon_show') === 'yes' ) {
                                if($this->get_faq_settings('_dl_faq_icon_type') == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                        
                                        <span class="droit-accordion-icon-closed"><?php Icons_Manager::render_icon( $this->get_faq_settings('_dl_faq_selected_icon') ); ?></span>

                                        <span class="droit-accordion-icon-opend"><?php Icons_Manager::render_icon( $this->get_faq_settings('selected_active_icon') ); ?></span>
                                        
                                   <?php }
                                }elseif( $this->get_faq_settings('_dl_faq_icon_type') == 'image' ){ ?>

                                    <span class="droit-accordion-icon-closed">
                                        <img src="<?php echo esc_url($this->get_faq_settings('_dl_faq_icon_image')['url']); ?>" alt="closed Icon">
                                    </span>
                                    <span class="droit-accordion-icon-opend">
                                        <img src="<?php echo esc_url($this->get_faq_settings('_dl_faq_active_image')['url']); ?>" alt="Opend Icon">
                                    </span>

                               <?php }
                                
                            }

                             ?>
                        </div>
                    </div>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                        <?php if ( $has_description_text ) : ?>
                            <p class="dl_desc">
                                <?php echo do_shortcode($item['_dl_faq_description_text']); ?>
                            </p>
                        <?php endif; ?>

                         <?php if ( 'yes' == $item['_dl_faq_button_show'] ) : ?>
                            <a <?php echo $link_attributes; ?> class="dl_cu_btn btn_2 droit-faq-button">
                                <?php echo droit_addons_kses($item['_dl_faq_button_text']); ?>
                            </a>
                         <?php endif; ?>
                    </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }

 //Layout One
    protected function _dl_faq_style_four(){
        $settings = $this->get_settings_for_display();
        $migrated = isset( $this->get_faq_settings('__fa4_migrated')['_dl_faq_selected_icon'] );

        if ( ! empty( $this->get_faq_settings('icon') ) && ! Icons_Manager::is_migration_allowed() ) {
           
            $settings['icon'] = 'fas fa-angle-up';
            $settings['icon_active'] = 'fas fa-angle-down';
        }

        $is_new = empty( $this->get_faq_settings('icon') ) && Icons_Manager::is_migration_allowed();
        $has_icon = ( ! $is_new || ! empty( $settings['_dl_faq_selected_icon']['value'] ) );
        
        $this->add_render_attribute(
            'dl_faq_wrapper',
            [
                'id' => "droit-advance-faq-{$this->get_id()}",
                'class' => ['droit-advance-faq dl_accordion_wrapper dl_accordion_wrapper_style_01', $settings['_dl_faq_skin']],
                'data-faqid' => $this->get_id(),
            ]
        );
        
        $has_faq = ! empty( $this->get_faq_settings('_dl_faq_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_faq): ?>
       <div <?php echo $this->get_render_attribute_string( 'dl_faq_wrapper' ); ?>>
            <?php
                $i = 1;
            foreach ( $this->get_faq_settings('_dl_faq_list') as $index => $item ) :
                
                $tab_count = $index + 1;

                $has_title_text = ! empty( $item['_dl_faq_title'] );

                $has_description_text = ! empty( $item['_dl_faq_description_text'] );

                $has_image = ! empty( $item['_dl_faq_image']['url'] );

                $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_title', '_dl_faq_list', $index );

                $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_faq_description_text', '_dl_faq_list', $index );

                $icon_tag = '';
                if ( ! empty( $item['_dl_faq_link']['url'] ) ) {
                    $icon_tag = 'a';
                    $this->add_link_attributes( '_dl_faq_link', $item['_dl_faq_link'] );
                }
                $link_attributes = $this->get_render_attribute_string( '_dl_faq_link' );

                $this->add_render_attribute( $tab_title_setting_key, [
                    'id' => 'faq-tab-title-' . $id_int . $tab_count,
                    'class' => [ 'droit-faq-title' ],
                    'data-speed' => 400,
                ] );

                $this->add_render_attribute( $tab_content_setting_key, [
                    'id' => 'droit-tab-content-' . $id_int . $tab_count,
                    'class' => [ 'dl_accordion_panel', 'droit-faq-content-wrapper' ],
                ] );

                ?>

                <div class="dl_accordion_inner droit-faq-wrapper">
                    <?php if ( $has_title_text ) : ?>
                        <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
                            <<?php echo droit_title_tag($item['_dl_faq_title_size']); ?> class="dl-title droit-faq-title"><?php echo do_shortcode($item['_dl_faq_title']); ?></<?php echo droit_title_tag($item['_dl_faq_title_size']); ?>>
                        </div>
                    <?php endif; ?>
               <?php if ( $has_description_text ) : ?>
                <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                    <p class="dl_desc">
                        <?php echo do_shortcode($item['_dl_faq_description_text']); ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <?php $i++; endforeach; ?>
        </div>
         <?php endif; ?>  
    <?php }
   
    protected function content_template()
    {}
}
