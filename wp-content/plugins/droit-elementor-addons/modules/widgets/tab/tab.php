<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Tab\Tab_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Tab\Tab_Module as Module;
use \Elementor\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Tab extends Control
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
        $this->_droit_register_dl_tabs_preset_controls();
        $this->_droit_register_dl_tabs_content_controls();
        $this->_droit_register_dl_tabs_content_four_controls();
        $this->_droit_register_dl_tabs_general_style_controls();
        $this->_droit_register_dl_tabs_title_style_controls();
        $this->_droit_register_dl_tabs_title_border_style_controls();
        $this->_droit_register_dl_tabs_title_caret_style_controls();
        $this->_droit_register_dl_tabs_content_style_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

//Html render
    protected function render(){
         $settings = $this->get_settings_for_display();

        $_dl_tabs_skin  = !empty($this->get_tab_settings('_dl_tabs_skin')) ? $this->get_tab_settings('_dl_tabs_skin') : '_skin_1';

        switch ($_dl_tabs_skin) {
            case '_skin_1':
                 $this->_dl_tabs_one();
                break;
            case '_skin_2':
                 $this->_dl_tabs_two();
                break;
            case '_skin_3':
                 $this->_dl_tabs_three();
                break;
            case '_skin_4':
                 $this->_dl_tabs_four();
                break;
            default:
                $this->_dl_tabs_one();
                break;
        } 
    }

    //Layout One
    protected function _dl_tabs_one(){
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'dl_tab_wrapper',
            [
                'id' => "droit-advance-tabs-{$this->get_id()}",
                'class' => ['droit-advance-tabs dl_tab_container dl_style_01', $this->get_tab_settings('_dl_tabs_skin')],
                'data-tabid' => $this->get_id(),
            ]
        );
        $this->add_render_attribute( '_dl_tab_title_attr', 'class', 'dl_title droit-tab-title' );
        $this->add_render_attribute( '_dl_tab_description_attr', 'class', 'dl_desc droit-tab-text' );
        $has_tabs = ! empty( $this->get_tab_settings('_dl_tabs_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_tabs): ?>
         <div <?php echo $this->get_render_attribute_string('dl_tab_wrapper'); ?>>
            <div class="droit-tabs-nav droit-advance-tabs-navs">
                <ul class="dl_tab_menu droit-advance-navs">
                    <?php foreach ($this->get_tab_settings('_dl_tabs_list') as $index => $tab): 
                        $tab_count = $index + 1;
                        $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_tabs_title', '_dl_tabs_list', $index );
                        
                        $this->add_render_attribute( $tab_title_setting_key, [
                            'id' => 'droit-tab-title-' . $id_int . $tab_count,
                            'class' => [ 'dl_tab_menu_item droit-tab-nav-items' ],
                            'data-tab' => $tab_count,
                        ] );

                        $this->add_render_attribute($tab_title_setting_key, 'class', $tab['_dl_tabs_show_as_default']);

                        if (!empty($this->get_tab_settings('_dl_tabs_border_bottom_none'))) {
                            $this->add_render_attribute($tab_title_setting_key, 'class', $this->get_tab_settings('_dl_tabs_border_bottom_none'));
                        }
                      
                        ?>
                        <li <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> ><span class="droit-tab-title"><?php echo $tab['_dl_tabs_title'] ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab_container droit-tab-content-wrapper">
                <?php foreach ($this->get_tab_settings('_dl_tabs_list') as $index => $tab):
                    $tab_count = $index + 1;
                    $has_title_text = ! empty( $tab['_dl_tabs_title_text'] );
                    $has_description_text = ! empty( $tab['_dl_tabs_description_text'] );
                    $tab_link_setting_key = $this->get_repeater_setting_key( '_dl_tabs_link', '_dl_tabs_list', $index );
                    $icon_tag = 'span';
                    if ( ! empty( $tab['_dl_tabs_link']['url'] ) ) {
                        $icon_tag = 'a';
                        $this->add_link_attributes( $tab_link_setting_key, $tab['_dl_tabs_link'] );
                    }
                    $link_attributes = $this->get_render_attribute_string( $tab_link_setting_key );

                    $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_tabs_description_text', '_dl_tabs_list', $index );
                        
                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'droit-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'dl_tab_content_wrapper' ],
                        'data-tab' => $tab_count,
                    ] );
                    $this->add_render_attribute($tab_content_setting_key, 'class', $tab['_dl_tabs_show_as_default']);
                 ?>
                <div class="dl_tab_content_wrapper <?php echo esc_attr($tab['_dl_tabs_show_as_default']); ?>">
                    
                    <?php if ( $has_title_text ) : ?>
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>>
                            <<?php echo $tab['_dl_tabs_title_size']; ?> <?php echo $this->get_render_attribute_string('_dl_tab_title_attr'); ?>><?php echo droit_addons_kses($tab['_dl_tabs_title_text']); ?></<?php echo $tab['_dl_tabs_title_size']; ?>>
                    </<?php echo $icon_tag; ?>>
                    <?php endif; ?>
                    <?php if ( $has_description_text ) : ?>
                        <div <?php echo $this->get_render_attribute_string('_dl_tab_description_attr'); ?>>
                            <?php echo do_shortcode($tab['_dl_tabs_description_text']); ?>       
                        </div>
                    <?php endif; ?>
                     <?php if ( 'yes' == $tab['_dl_tabs_button_show'] ) : ?> 
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?> class="dl_cu_btn btn_4 dl_round_50 droit-tab-button">
                            <?php echo droit_addons_kses($tab['_dl_tabs_button_text']); ?>
                        </<?php echo $icon_tag; ?>>
                     <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }

    //Layout Two
    protected function _dl_tabs_two(){
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'dl_tab_wrapper',
            [
                'id' => "droit-advance-tabs-{$this->get_id()}",
                'class' => ['droit-advance-tabs dl_tab_container dl_style_02', $this->get_tab_settings('_dl_tabs_skin')],
                'data-tabid' => $this->get_id(),
            ]
        );
        if ($this->get_tab_settings('_dl_tabs_tab_caret_show') == 'yes') {
            $this->add_render_attribute('dl_tab_wrapper', 'class', 'dl_caret');
        }
        $this->add_render_attribute( '_dl_tab_title_attr', 'class', 'dl_title droit-tab-title' );
        $this->add_render_attribute( '_dl_tab_description_attr', 'class', 'dl_desc droit-tab-text' );
        $has_tabs = ! empty( $this->get_tab_settings('_dl_tabs_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_tabs): ?>
         <div <?php echo $this->get_render_attribute_string('dl_tab_wrapper'); ?>>
            <div class="droit-tabs-nav droit-advance-tabs-navs">
                <ul class="dl_tab_menu droit-advance-navs">
                    <?php foreach ($this->get_tab_settings('_dl_tabs_list') as $index => $tab): 
                        $tab_count = $index + 1;
                        $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_tabs_title', '_dl_tabs_list', $index );
                        
                        $this->add_render_attribute( $tab_title_setting_key, [
                            'id' => 'droit-tab-title-' . $id_int . $tab_count,
                            'class' => [ 'dl_tab_menu_item droit-tab-nav-items' ],
                            'data-tab' => $tab_count,
                        ] );

                        $this->add_render_attribute($tab_title_setting_key, 'class', $tab['_dl_tabs_show_as_default']);

                        if (!empty($this->get_tab_settings('_dl_tabs_border_bottom_none'))) {
                            $this->add_render_attribute($tab_title_setting_key, 'class', $this->get_tab_settings('_dl_tabs_border_bottom_none'));
                        }
                      
                        ?>
                        <li <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> ><span class="droit-tab-title"><?php echo $tab['_dl_tabs_title'] ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab_container droit-tab-content-wrapper">
                <?php foreach ($this->get_tab_settings('_dl_tabs_list') as $index => $tab):
                    $tab_count = $index + 1;
                    $has_title_text = ! empty( $tab['_dl_tabs_title_text'] );
                    $has_description_text = ! empty( $tab['_dl_tabs_description_text'] );
                    $tab_link_setting_key = $this->get_repeater_setting_key( '_dl_tabs_link', '_dl_tabs_list', $index );
                    $icon_tag = 'span';
                    if ( ! empty( $tab['_dl_tabs_link']['url'] ) ) {
                        $icon_tag = 'a';
                        $this->add_link_attributes( $tab_link_setting_key, $tab['_dl_tabs_link'] );
                    }
                    $link_attributes = $this->get_render_attribute_string( $tab_link_setting_key );

                    $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_tabs_description_text', '_dl_tabs_list', $index );
                        
                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'droit-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'dl_tab_content_wrapper' ],
                        'data-tab' => $tab_count,
                    ] );
                    $this->add_render_attribute($tab_content_setting_key, 'class', $tab['_dl_tabs_show_as_default']);

                 ?>
                <div class="dl_tab_content_wrapper <?php echo esc_attr($tab['_dl_tabs_show_as_default']); ?>">
                    
                   <?php if ( $has_title_text ) : ?>
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>>
                            <<?php echo $tab['_dl_tabs_title_size']; ?> <?php echo $this->get_render_attribute_string('_dl_tab_title_attr'); ?>><?php echo droit_addons_kses($tab['_dl_tabs_title_text']); ?></<?php echo $tab['_dl_tabs_title_size']; ?>>
                    </<?php echo $icon_tag; ?>>
                    <?php endif; ?>
                    <?php if ( $has_description_text ) : ?>
                        <div <?php echo $this->get_render_attribute_string('_dl_tab_description_attr'); ?>>
                            <?php echo do_shortcode($tab['_dl_tabs_description_text']); ?>       
                        </div>
                    <?php endif; ?>
                     <?php if ( 'yes' == $tab['_dl_tabs_button_show'] ) : ?>
                            <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?> class="dl_cu_btn btn_4 dl_round_50 droit-tab-button">
                            <?php echo droit_addons_kses($tab['_dl_tabs_button_text']); ?>
                        </<?php echo $icon_tag; ?>>
                     <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }

    //Layout Three
    protected function _dl_tabs_three(){
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'dl_tab_wrapper',
            [
                'id' => "droit-advance-tabs-{$this->get_id()}",
                'class' => ['droit-advance-tabs dl_tab_container dl_style_03', $this->get_tab_settings('_dl_tabs_skin')],
                'data-tabid' => $this->get_id(),
            ]
        );
        if ($this->get_tab_settings('_dl_tabs_tab_caret_show') == 'yes') {
            $this->add_render_attribute('dl_tab_wrapper', 'class', 'dl_caret');
        }
        $this->add_render_attribute( '_dl_tab_title_attr', 'class', 'dl_title droit-tab-title' );
        $this->add_render_attribute( '_dl_tab_description_attr', 'class', 'dl_desc droit-tab-text' );
        $has_tabs = ! empty( $this->get_tab_settings('_dl_tabs_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        ?>
        <?php if ($has_tabs): ?>
         <div <?php echo $this->get_render_attribute_string('dl_tab_wrapper'); ?>>
            <div class="droit-tabs-nav droit-advance-tabs-navs">
                <ul class="dl_tab_menu droit-advance-navs">
                    <?php foreach ($this->get_tab_settings('_dl_tabs_list') as $index => $tab): 
                        $tab_count = $index + 1;
                        $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_tabs_title', '_dl_tabs_list', $index );
                        
                        $this->add_render_attribute( $tab_title_setting_key, [
                            'id' => 'droit-tab-title-' . $id_int . $tab_count,
                            'class' => [ 'dl_tab_menu_item droit-tab-nav-items' ],
                            'data-tab' => $tab_count,
                        ] );

                        $this->add_render_attribute($tab_title_setting_key, 'class', $tab['_dl_tabs_show_as_default']);

                        if (!empty($this->get_tab_settings('_dl_tabs_border_bottom_none'))) {
                            $this->add_render_attribute($tab_title_setting_key, 'class', $this->get_tab_settings('_dl_tabs_border_bottom_none'));
                        }
                      
                        ?>
                        <li <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> ><span class="droit-tab-title"><?php echo $tab['_dl_tabs_title'] ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab_container droit-tab-content-wrapper">
                <?php foreach ($this->get_tab_settings('_dl_tabs_list') as $index => $tab):
                    $tab_count = $index + 1;
                    $has_title_text = ! empty( $tab['_dl_tabs_title_text'] );
                    $has_description_text = ! empty( $tab['_dl_tabs_description_text'] );
                    $tab_link_setting_key = $this->get_repeater_setting_key( '_dl_tabs_link', '_dl_tabs_list', $index );
                    $icon_tag = 'span';
                    if ( ! empty( $tab['_dl_tabs_link']['url'] ) ) {
                        $icon_tag = 'a';
                        $this->add_link_attributes( $tab_link_setting_key, $tab['_dl_tabs_link'] );
                    }
                    $link_attributes = $this->get_render_attribute_string( $tab_link_setting_key );

                    $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_tabs_description_text', '_dl_tabs_list', $index );
                        
                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'droit-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'dl_tab_content_wrapper' ],
                        'data-tab' => $tab_count,
                    ] );
                    $this->add_render_attribute($tab_content_setting_key, 'class', $tab['_dl_tabs_show_as_default']);

                 ?>
                <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                    
                    <?php if ( $has_title_text ) : ?>
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>>
                            <<?php echo $tab['_dl_tabs_title_size']; ?> <?php echo $this->get_render_attribute_string('_dl_tab_title_attr'); ?>><?php echo droit_addons_kses($tab['_dl_tabs_title_text']); ?></<?php echo $tab['_dl_tabs_title_size']; ?>>
                    </<?php echo $icon_tag; ?>>
                    <?php endif; ?>
                    <?php if ( $has_description_text ) : ?>
                        <div <?php echo $this->get_render_attribute_string('_dl_tab_description_attr'); ?>>
                            <?php echo do_shortcode($tab['_dl_tabs_description_text']); ?>       
                        </div>
                    <?php endif; ?>
                      <?php if ( 'yes' == $tab['_dl_tabs_button_show'] ) : ?>
                            <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?> class="dl_cu_btn btn_4 dl_round_50 droit-tab-button">
                            <?php echo droit_addons_kses($tab['_dl_tabs_button_text']); ?>
                        </<?php echo $icon_tag; ?>>
                     <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }

    //Layout Four
    protected function _dl_tabs_four(){
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'dl_tab_wrapper',
            [
                'id' => "droit-advance-tabs-{$this->get_id()}",
                'class' => ['droit-advance-tabs dl_tab_container dl_style_06', $this->get_tab_settings('_dl_tabs_skin')],
                'data-tabid' => $this->get_id(),
            ]
        );
        if ($this->get_tab_settings('_dl_tabs_tab_caret_show') == 'yes') {
            $this->add_render_attribute('dl_tab_wrapper', 'class', 'dl_caret');
        }
        $this->add_render_attribute( '_dl_tab_title_attr', 'class', 'dl_title droit-tab-title' );
        $this->add_render_attribute( '_dl_tab_description_attr', 'class', 'dl_desc droit-tab-text' );
        $has_tabs = ! empty( $this->get_tab_settings('_dl_tabs_list') );
        $id_int = substr( $this->get_id_int(), 0, 4 );


        $tab_icon_migrated = isset($this->get_tab_settings('__fa4_migrated')['_dl_tabs_tab_title_icon_new']);
        $tab_icon_is_new = empty($this->get_tab_settings('_dl_tabs_tab_title_icon'));
        ?>
        <?php if ($has_tabs): ?>
         <div <?php echo $this->get_render_attribute_string('dl_tab_wrapper'); ?>>
            <div class="droit-tabs-nav droit-advance-tabs-navs">
                <ul class="dl_tab_menu droit-advance-navs">
                    <?php foreach ($this->get_tab_settings('_dl_tabs_lists') as $index => $tab): 
                        $tab_count = $index + 1;
                        $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_tabs_title', '_dl_tabs_lists', $index );
                        
                        $this->add_render_attribute( $tab_title_setting_key, [
                            'id' => 'droit-tab-title-' . $id_int . $tab_count,
                            'class' => [ 'dl_tab_menu_item droit-tab-nav-items' ],
                            'data-tab' => $tab_count,
                        ] );

                        $this->add_render_attribute($tab_title_setting_key, 'class', $tab['_dl_tabs_show_as_default']);

                        if (!empty($this->get_tab_settings('_dl_tabs_border_bottom_none'))) {
                            $this->add_render_attribute($tab_title_setting_key, 'class', $this->get_tab_settings('_dl_tabs_border_bottom_none'));
                        }
                      
                        ?>
                        <li <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> ><span class="droit-tab-title">

                            

                            <?php if ($tab['_dl_tabs_icon_type'] === 'icon'): ?>
                            <?php if ($tab_icon_is_new || $tab_icon_migrated) {
                                Icons_Manager::render_icon( $tab['_dl_tabs_tab_title_icon_new'], [ 'aria-hidden' => 'true' ] );
                            } ?>
                            <?php elseif ($tab['_dl_tabs_icon_type'] === 'image'): ?>
                        <img src="<?php echo esc_attr($tab['_dl_tabs_tab_title_image']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($tab['_dl_tabs_tab_title_image']['id'], '_wp_attachment_image_alt', true)); ?>">
                    <?php endif;?>
                    <?php echo $tab['_dl_tabs_title'] ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab_container droit-tab-content-wrapper">
                <?php foreach ($this->get_tab_settings('_dl_tabs_lists') as $index => $tab):
                    $tab_count = $index + 1;
                    $has_title_text = ! empty( $tab['_dl_tabs_title_text'] );
                    $has_description_text = ! empty( $tab['_dl_tabs_description_text'] );
                    $tab_link_setting_key = $this->get_repeater_setting_key( '_dl_tabs_link', '_dl_tabs_lists', $index );
                    $icon_tag = 'span';
                    if ( ! empty( $tab['_dl_tabs_link']['url'] ) ) {
                        $icon_tag = 'a';
                        $this->add_link_attributes( $tab_link_setting_key, $tab['_dl_tabs_link'] );
                    }
                    $link_attributes = $this->get_render_attribute_string( $tab_link_setting_key );

                    $tab_content_setting_key = $this->get_repeater_setting_key( '_dl_tabs_description_text', '_dl_tabs_lists', $index );
                        
                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'droit-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'dl_tab_content_wrapper' ],
                        'data-tab' => $tab_count,
                    ] );
                    $this->add_render_attribute($tab_content_setting_key, 'class', $tab['_dl_tabs_show_as_default']);

                 ?>
                <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                    
                    <?php if ( $has_title_text ) : ?>
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>>
                            <<?php echo $tab['_dl_tabs_title_size']; ?> <?php echo $this->get_render_attribute_string('_dl_tab_title_attr'); ?>><?php echo droit_addons_kses($tab['_dl_tabs_title_text']); ?></<?php echo $tab['_dl_tabs_title_size']; ?>>
                    </<?php echo $icon_tag; ?>>
                    <?php endif; ?>
                    <?php if ( $has_description_text ) : ?>
                        <div <?php echo $this->get_render_attribute_string('_dl_tab_description_attr'); ?>>
                            <?php echo do_shortcode($tab['_dl_tabs_description_text']); ?>       
                        </div>
                    <?php endif; ?>
                    <?php if ( 'yes' == $tab['_dl_tabs_button_show'] ) : ?>
                            <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?> class="dl_cu_btn btn_4 dl_round_50 droit-tab-button">
                            <?php echo droit_addons_kses($tab['_dl_tabs_button_text']); ?>
                            </<?php echo $icon_tag; ?>>
                     <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
         <?php endif; ?>  
    <?php }
    
    protected function content_template()
    {}
}
