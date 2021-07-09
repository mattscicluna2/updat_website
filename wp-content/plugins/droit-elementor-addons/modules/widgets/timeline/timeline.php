<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Timeline\Timeline_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Timeline\Timeline_Module as Module;
use \ELEMENTOR\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Timeline extends Control
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
      $this->register_timeline_preset_controls();
      $this->register_timeline_content_skin_1_controls();
      $this->register_timeline_content_skin_2_controls();
      $this->register_timeline_options_controls();
      $this->register_timeline_general_style_controls();
      $this->register_timeline_icon_style_controls();
      $this->register_timeline_border_line_style_controls();
      $this->register_timeline_content_style_control();
      $this->register_timeline_option_section_controls();
      $this->register_timeline_navigation_controls();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
         $_dl_timeline_skin  = !empty($this->get_timeline_settings('_dl_timeline_skin')) ? $this->get_timeline_settings('_dl_timeline_skin') : '_skin_1';

            switch ($_dl_timeline_skin) {
                case '_skin_1':
                    $this->_first_timeline_layout();
                    break; 
                case '_skin_2':
                    $this->_second_timeline_layout();
                    break;
                case '_skin_3':
                    $this->_third_timeline_layout();
                    break;
                default:
                    $this->_first_timeline_layout();
                    break;
            }
    }

   protected function _first_timeline_layout(){
    $settings = $this->get_settings_for_display();
    ?>
   <div class="dl_timeline_section dl_timeline_default_style droit-timeline-section droit-timeline-default-style">
        <div class="dl_timeline_section_inner droit-timeline-section-inner">
            <?php if ($this->get_timeline_settings('_dl_timeline_items')):
                foreach ( $this->get_timeline_settings('_dl_timeline_items') as $index => $item ):

                    $item_count = $index + 1;
                    
                    /*Inner Wrapper*/
                    $timeline_id_key = $this->get_repeater_setting_key( '_id', '_dl_timeline_items', $index );
                    $this->add_render_attribute( $timeline_id_key, [
                        'id' => 'timeline-' . $item['_id'],
                        'class' => [ "dl_limeline_section_inner_wrapper", "elementor-repeater-item-{$item['_id']}", "droit-timeline-inner-wraper" ],
                        'data-item' => $item_count,
                    ] );
                    $timeline_inner_wraper = $this->get_render_attribute_string( $timeline_id_key );

                    /*Title*/
                    $timeline_title_key = $this->get_repeater_setting_key( '_dl_timeline_title', '_dl_timeline_items', $index );
                    
                    $this->add_render_attribute( $timeline_title_key, [
                        'class' => [ "dl_title", "droit-timeline-title" ],
                    ] );

                    $timeline_title_class = $this->get_render_attribute_string( $timeline_title_key );
                    $has_title_text = ! empty( $item['_dl_timeline_title'] );

                    /*Content*/
                    $timeline_content_key = $this->get_repeater_setting_key( '_dl_timeline_desc', '_dl_timeline_items', $index );
                    
                    $this->add_render_attribute( $timeline_content_key, [
                        'class' => [ "dl_desc", "droit-timeline-content" ],
                    ] );

                    $timeline_content_class = $this->get_render_attribute_string( $timeline_content_key );
                    $has_timeline_text = ! empty( $item['_dl_timeline_desc'] );

                    /*Date*/
                    $date_format = !empty($this->get_timeline_settings('date_format')) ? $this->get_timeline_settings('date_format') : 'F j, Y';
                    $date = date( $date_format, strtotime($item['_dl_timeline_time']));
                    if('timeline_text' == $item['_dl_timeline_style']){
                        $date = $item['_dl_timeline_time_text'];
                    }
                    $time_format = !empty($this->get_timeline_settings('time_format')) ? $this->get_timeline_settings('time_format') : 'g:i a';
                    $time = 'timeline_calender' == $item['_dl_timeline_style'] ? date($time_format, strtotime($item['_dl_timeline_time'])) : '';

                    ?>
                <div <?php echo $timeline_inner_wraper; ?>>
                    <div class="dl_limeline_counter droit-timeline-counter"></div>
                    <div class="dl_timeline_main_coutent_inner droit-timeline-content-inner">
                        <?php if ($this->get_timeline_settings('show_title') == 'yes'): ?>
                            <?php if ($has_title_text): ?>  
                                <<?php echo droit_title_tag($item['_dl_timeline_title_size']); ?> <?php echo $timeline_title_class; ?>><?php echo esc_html($item['_dl_timeline_title']); ?></<?php echo droit_title_tag($item['_dl_timeline_title_size']); ?>>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($this->get_timeline_settings('show_desc') == 'yes'): ?>
                            <?php if ($has_timeline_text): ?>
                                <p <?php echo $timeline_content_class; ?>>
                                    <?php echo droit_parse_text_editor($item['_dl_timeline_desc']); ?>
                                </p>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if ($this->get_timeline_settings('show_date_time') == 'yes'): ?>
                            <div class="dl_timeline_coutent_inner droit-timeline-date-time">
                                <p class="dl_date droit-date-time">
                                    <?php
                                        if ($date && $this->get_timeline_settings('show_date')) {
                                            printf('<span class="date">%s</span>', esc_html($date));
                                        }
                                        if ($time && $this->get_timeline_settings('show_time')) {
                                            printf('<span class="time">%s</span>', esc_html($time));
                                        }
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        <?php endforeach; endif; ?>
        </div>
    </div>
  <?php }

   protected function _second_timeline_layout(){
    $settings = $this->get_settings_for_display();
    ?>
   <div class="dl_timeline_section dl_timeline_default_style dl_style_01 droit-timeline-section droit-timeline-default-style">
        <div class="dl_timeline_section_inner droit-timeline-section-inner">
            <?php if ($this->get_timeline_settings('_dl_timeline_items_skin_second')):
                foreach ( $this->get_timeline_settings('_dl_timeline_items_skin_second') as $index => $item ):

                    $item_count = $index + 1;

                    /*Inner Wrapper*/
                    $timeline_id_key = $this->get_repeater_setting_key( '_id', '_dl_timeline_items_skin_second', $index );
                    $this->add_render_attribute( $timeline_id_key, [
                        'id' => 'timeline-' . $item['_id'],
                        'class' => [ "dl_limeline_section_inner_wrapper", "elementor-repeater-item-{$item['_id']}", "droit-timeline-inner-wraper" ],
                        'data-item' => $item_count,
                    ] );
                    $timeline_inner_wraper = $this->get_render_attribute_string( $timeline_id_key );

                    /*Title*/
                    $timeline_title_key = $this->get_repeater_setting_key( '_dl_timeline_title', '_dl_timeline_items_skin_second', $index );
                    
                    $this->add_render_attribute( $timeline_title_key, [
                        'class' => [ "dl_title", "droit-timeline-title" ],
                    ] );

                    $timeline_title_class = $this->get_render_attribute_string( $timeline_title_key );
                    $has_title_text = ! empty( $item['_dl_timeline_title'] );

                    /*Content*/
                    $timeline_content_key = $this->get_repeater_setting_key( '_dl_timeline_desc', '_dl_timeline_items_skin_second', $index );
                    
                    $this->add_render_attribute( $timeline_content_key, [
                        'class' => [ "dl_desc", "droit-timeline-content" ],
                    ] );

                    $timeline_content_class = $this->get_render_attribute_string( $timeline_content_key );
                    $has_timeline_text = ! empty( $item['_dl_timeline_desc'] );

                    /*Date*/
                    $date_format = !empty($this->get_timeline_settings('date_format')) ? $this->get_timeline_settings('date_format') : 'F j, Y';
                    $date = date( $date_format, strtotime($item['_dl_timeline_time']));
                    if('timeline_text' == $item['_dl_timeline_style']){
                        $date = $item['_dl_timeline_time_text'];
                    }
                    $time_format = !empty($this->get_timeline_settings('time_format')) ? $this->get_timeline_settings('time_format') : 'g:i a';
                    $time = 'timeline_calender' == $item['_dl_timeline_style'] ? date($time_format, strtotime($item['_dl_timeline_time'])) : '';

                    /*Icon*/

                    $migrated = isset( $item['__fa4_migrated']['_dl_timeline_selected_icon'] );

                    if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                        $item['icon'] = 'fas fa-check';
                    }
                    $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
                    $has_icon = ( ! $is_new || ! empty( $item['_dl_timeline_selected_icon']['value'] ) );

                    ?>
                <div <?php echo $timeline_inner_wraper; ?>>
                    <?php if ( $item['_dl_timeline_icon_show'] === 'yes' ): ?>
                        <div class="dl_limeline_counter dl_single_limeline_icon droit-timeline-counter">
                            <?php
                                if($item['_dl_timeline_icon_type'] == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                       <?php Icons_Manager::render_icon( $item['_dl_timeline_selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                   <?php }
                                }elseif( $item['_dl_timeline_icon_type'] == 'image' ){ ?>
                                    <img src="<?php echo esc_url($item['_dl_timeline_icon_image']['url']); ?>" alt="<?php echo esc_attr( get_post_meta($item['_dl_timeline_icon_image']['id'], '_wp_attachment_image_alt', true) ); ?>">
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                    <div class="dl_timeline_main_coutent_inner droit-timeline-content-inner">
                        <?php if ($this->get_timeline_settings('show_title') == 'yes'): ?>
                            <?php if ($has_title_text): ?>  
                                <<?php echo droit_title_tag($item['_dl_timeline_title_size']); ?> <?php echo $timeline_title_class; ?>><?php echo esc_html($item['_dl_timeline_title']); ?></<?php echo droit_title_tag($item['_dl_timeline_title_size']); ?>>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($this->get_timeline_settings('show_desc') == 'yes'): ?>
                            <?php if ($has_timeline_text): ?>
                                <p <?php echo $timeline_content_class; ?>>
                                    <?php echo droit_parse_text_editor($item['_dl_timeline_desc']); ?>
                                </p>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if ($this->get_timeline_settings('show_date_time') == 'yes'): ?>
                            <div class="dl_timeline_coutent_inner droit-timeline-date-time">
                                <p class="dl_date droit-date-time">
                                    <?php
                                        if ($date && $this->get_timeline_settings('show_date')) {
                                            printf('<span class="date">%s</span>', esc_html($date));
                                        }
                                        if ($time && $this->get_timeline_settings('show_time')) {
                                            printf('<span class="time">%s</span>', esc_html($time));
                                        }
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
        <?php endforeach; endif; ?>
        </div>
    </div>
  <?php }

   protected function _third_timeline_layout(){
    $settings = $this->get_settings_for_display();

    $show_slider                    = $this->get_timeline_settings('_dl_timeline_slider_nav_show');
    $slider_autoplay                = $this->get_timeline_settings('_dl_timeline_slider_autoplay');
    $slider_speed                   = $this->get_timeline_settings('_dl_timeline_slider_speed');
    $slider_loop                    = $this->get_timeline_settings('_dl_timeline_slider_loop');
    $slider_space                   = $this->get_timeline_settings('_dl_timeline_slider_space');
    $slider_item                    = $this->get_timeline_settings('_dl_timeline_slider_perpage');
    $slider_center                  = $this->get_timeline_settings('_dl_timeline_slider_center');
    $slider_drag                    = $this->get_timeline_settings('_dl_timeline_slider_drag');
    $slider_pagi_type               = $this->get_timeline_settings('_dl_pagination_type');
    $slider_next_icon               = $this->get_timeline_settings('_dl_timeline_nav_next_icon');
    $slider_prev_icon               = $this->get_timeline_settings('_dl_timeline_nav_prev_icon');

    $slide_controls = [
        'show_slider'                   => $show_slider,
        'slide_autoplay'                => $slider_autoplay,
        'slider_speed'                  => $slider_speed,
        'slider_loop'                   => $slider_loop,
        'slider_space'                  => $slider_space,
        'slider_item'                   => $slider_item,
        'slider_drag'                   => $slider_drag,
        'slider_center'                 => $slider_center,
        'slider_pagi_type'              => $slider_pagi_type,
        'next_icon'                     => $slider_next_icon,
        'prev_icon'                     => $slider_prev_icon,
    ];
    $slide_controls = \json_encode($slide_controls);
    ?> 
   <div class="dl_horizontal_container droit-timeline-section droit-timeline-default-style">
        <div class="dl_timeline_inner droit-timeline-section-inner owl-carousel droit-top-border" data-controls="<?php echo esc_attr($slide_controls); ?>">
            <?php if ($this->get_timeline_settings('_dl_timeline_items')):
                foreach ( $this->get_timeline_settings('_dl_timeline_items') as $index => $item ):

                    $item_count = $index + 1;

                    /*Inner Wrapper*/
                    $timeline_id_key = $this->get_repeater_setting_key( '_id', '_dl_timeline_items', $index );
                    $this->add_render_attribute( $timeline_id_key, [
                        'id' => 'timeline-inner-' . $item['_id'],
                        'class' => [ "horizontal_content_wrapper", "elementor-repeater-item-{$item['_id']}", "droit-timeline-inner-wraper" ],
                        'data-item' => $item_count,
                    ] );
                    $timeline_inner_wraper = $this->get_render_attribute_string( $timeline_id_key );

                    /*Title*/
                    $timeline_title_key = $this->get_repeater_setting_key( '_dl_timeline_title', '_dl_timeline_items', $index );
                    
                    $this->add_render_attribute( $timeline_title_key, [
                        'class' => [ "dl_title", "droit-timeline-title" ],
                    ] );

                    $timeline_title_class = $this->get_render_attribute_string( $timeline_title_key );
                    $has_title_text = ! empty( $item['_dl_timeline_title'] );

                    /*Content*/
                    $timeline_content_key = $this->get_repeater_setting_key( '_dl_timeline_desc', '_dl_timeline_items', $index );
                    
                    $this->add_render_attribute( $timeline_content_key, [
                        'class' => [ "dl_desc", "droit-timeline-content" ],
                    ] );

                    $timeline_content_class = $this->get_render_attribute_string( $timeline_content_key );
                    $has_timeline_text = ! empty( $item['_dl_timeline_desc'] );

                    /*Date*/
                    $date_format = !empty($this->get_timeline_settings('date_format')) ? $this->get_timeline_settings('date_format') : 'F j, Y';
                    $date = date( $date_format, strtotime($item['_dl_timeline_time']));
                    if('timeline_text' == $item['_dl_timeline_style']){
                        $date = $item['_dl_timeline_time_text'];
                    }
                    $time_format = !empty($this->get_timeline_settings('time_format')) ? $this->get_timeline_settings('time_format') : 'g:i a';
                    $time = 'timeline_calender' == $item['_dl_timeline_style'] ? date($time_format, strtotime($item['_dl_timeline_time'])) : '';

                    /*Icon*/

                    $migrated = isset( $item['__fa4_migrated']['_dl_timeline_selected_icon'] );

                    if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                        $item['icon'] = 'fas fa-check';
                    }
                    $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
                    $has_icon = ( ! $is_new || ! empty( $item['_dl_timeline_selected_icon']['value'] ) );

                    ?>
                <div <?php echo $timeline_inner_wraper; ?>>
                    <?php if ($this->get_timeline_settings('show_date_time') == 'yes'): ?>
                            <div class="dl_img_handler_top dl_style_2 droit-timeline-date-time">
                                <div class="dl_date droit-date-time">
                                    <?php
                                        if ($date && $this->get_timeline_settings('show_date')) {
                                            printf('<p class="date">%s</p>', esc_html($date));
                                        }
                                        if ($time && $this->get_timeline_settings('show_time')) {
                                            printf('<p class="time">%s</p>', esc_html($time));
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="dl_content_inner_bottom droit-timeline-content-inner">
                            <?php if ($this->get_timeline_settings('show_title') == 'yes'): ?>
                            <?php if ($has_title_text): ?>  
                                <<?php echo droit_title_tag($item['_dl_timeline_title_size']); ?> <?php echo $timeline_title_class; ?>><?php echo esc_html($item['_dl_timeline_title']); ?></<?php echo droit_title_tag($item['_dl_timeline_title_size']); ?>>
                            <?php endif; ?>
                        <?php endif; ?>
                            <?php if ($this->get_timeline_settings('show_desc') == 'yes'): ?>
                            <?php if ($has_timeline_text): ?>
                                <p <?php echo $timeline_content_class; ?>>
                                    <?php echo droit_parse_text_editor($item['_dl_timeline_desc']); ?>
                                </p>
                            <?php endif ?>
                        <?php endif ?>
                        </div>
                        <span class="dl_bullet_top droit-bullet-top"></span>
                </div>
        <?php endforeach; endif; ?>
        </div>
    </div>
  <?php }

    protected function content_template()
    {}
}
