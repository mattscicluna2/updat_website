<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Process\Process_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Process\Process_Module as Module;
use \Elementor\Group_Control_Image_Size;
use \ELEMENTOR\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Process extends Control
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
      $this->register_process_preset_controls();
      $this->register_process_content_skin_1_control();
      $this->register_process_content_skin_2_control();
      $this->register_process_content_skin_3_control();
      $this->register_process_content_skin_4_control();
      $this->_droit_register_process_general_style_controls();
      $this->_droit_register_process_icon_style_controls();
      $this->register_process_content_style_control();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_process_skin  = !empty($this->get_process_settings('_process_skin')) ? $this->get_process_settings('_process_skin') : '_skin_1';

        switch ($_process_skin) {
            case '_skin_1':
                $this->_first_process_layout();
                break; 
            case '_skin_2':
                $this->_second_process_layout();
                break;
            case '_skin_3':
                $this->_third_process_layout();
                break;
            case '_skin_4':
                $this->_four_process_layout();
                break;
            default:
                $this->_first_process_layout();
                break;

        }
    }

    // process first
    protected function _first_process_layout(){
        $settings = $this->get_settings_for_display();

    ?>
    <div class="dl_row droit-process-wrapper">
        <?php foreach ($this->get_process_settings('_dl_process_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_process_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_process_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_process_title'] );
            $has_dec_text = ! empty( $item['_dl_process_description_text'] );
            $has_image = ! empty( $item['_dl_process_image']['url'] );

            $columns = !empty($this->get_process_settings('_process_columns')) ? $this->get_process_settings('_process_columns') : 3;
            $process_link_setting_key = $this->get_repeater_setting_key( '_dl_process_link', '_dl_process_lists', $index );
            $link_tag = 'span';

            if ( ! empty( $item['_dl_process_link']['url'] ) ) {
                $link_tag = 'a';
                $this->add_link_attributes( $process_link_setting_key, $item['_dl_process_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( $process_link_setting_key );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_process_title', '_dl_process_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                'id' => 'process-' . $item['_id'],
                'class' => [ "dl_col_lg_{$columns}", 'dl_col_sm_6', 'droit-process-items', "elementor-repeater-item-{$item['_id']}" ],
                'data-item' => $item_count,
            ] );
         ?>
        <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
            <div class="dl_single_process_box dl_style_01 droit-process-box">
                <div class="dl_process_box_icon droit-process-box-icon">
                    <div class="dl_process_icon_inner dl_color_01 droit-process-box-icon-inner">
                        <?php 
                            if ($item['_dl_process_icon_show'] === 'yes' ) {
                                if($item['_dl_process_icon_type'] == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                       <?php Icons_Manager::render_icon( $item['_dl_process_selected_icon'] ); ?>
                                   <?php }
                                }elseif( $item['_dl_process_icon_type'] == 'image' ){ ?>
                                    <img src="<?php echo esc_url($item['_dl_process_icon_image']['url']); ?>" alt="<?php echo esc_attr( get_post_meta($item['_dl_process_icon_image']['id'], '_wp_attachment_image_alt', true) ); ?>">
                               <?php }  
                            }
                        ?>
                    </div>
                    <?php if ( $has_image ): ?>
                        <img src="<?php echo $item['_dl_process_image']['url']; ?>" alt="<?php echo esc_attr( get_post_meta($item['_dl_process_image']['id'], '_wp_attachment_image_alt', true) ); ?>" class="dl_arrow_img">
                    <?php endif ?>
                </div>
                <?php if ( $has_title_text ) : ?>
                    <<?php echo droit_title_tag($item['_dl_process_title_size']); ?> class="dl_title droit-process-title">
                    <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                    <?php echo do_shortcode($item['_dl_process_title']); ?>
                     </<?php echo esc_html( $link_tag ); ?>>
                    </<?php echo droit_title_tag($item['_dl_process_title_size']); ?>>
                <?php endif; ?>
                <?php if ($has_dec_text): ?>
                    <p class="dl_desc droit-process-desc">
                        <?php echo do_shortcode($item['_dl_process_description_text']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
  <?php }
    
    // process second
    protected function _second_process_layout(){
        $settings = $this->get_settings_for_display();
    ?>
    <div class="dl_process_box_container dl_process_box_container_border droit-process-wrapper droit-process-box-container-border">
        <?php foreach ($this->get_process_settings('_dl_process_skin_second_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_process_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_process_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_process_title'] );
            $process_link_setting_key = $this->get_repeater_setting_key( '_dl_process_link', '_dl_process_lists', $index );
            $link_tag = 'span';
            if ( ! empty( $item['_dl_process_link']['url'] ) ) {
                $link_tag = 'a';
                $this->add_link_attributes( $process_link_setting_key, $item['_dl_process_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( $process_link_setting_key );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_process_title', '_dl_process_skin_second_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                'id' => 'process-' . $item['_id'],
                'class' => [ 'dl_process_box_colum', 'droit-process-items' ],
                'data-item' => $item_count,
            ] );
         ?>
        <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
            <div class="dl_single_process_box dl_style_02 droit-process-box">
                <div class="dl_icon droit-process-box-icon">
                    <?php 
                        if ($item['_dl_process_icon_show'] === 'yes' ) {
                            if($item['_dl_process_icon_type'] == 'icon'){
                                if ( $is_new || $migrated ) { ?>
                                   <?php Icons_Manager::render_icon( $item['_dl_process_selected_icon'] ); ?>
                               <?php }
                            }elseif( $item['_dl_process_icon_type'] == 'image' ){ ?>
                                <img src="<?php echo esc_url($item['_dl_process_icon_image']['url']); ?>" alt="<?php echo esc_attr( get_post_meta($item['_dl_process_icon_image']['id'], '_wp_attachment_image_alt', true) ); ?>">
                           <?php }  
                        }
                    ?>
                </div>
                <div class="dl_separator_pointer droit-process-separator"></div>
                <?php if ( $has_title_text ) : ?>
                    <<?php echo droit_title_tag($item['_dl_process_title_size']); ?> class="dl_title droit-process-title">
                     <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                     <?php echo do_shortcode($item['_dl_process_title']); ?>
                  </<?php echo esc_html( $link_tag ); ?>>
                    </<?php echo droit_title_tag($item['_dl_process_title_size']); ?>>
                <?php endif; ?>
               
            </div>
        </div>
        <?php endforeach; ?>
    </div>
  <?php }
    

    // process third
    protected function _third_process_layout(){
        $settings = $this->get_settings_for_display();
    ?>
    <div class="dl_row dl_process_box_container_border dl_dash_style_2 droit-process-wrapper droit-process-box-container-border">
        <?php foreach ($this->get_process_settings('_dl_process_skin_three_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_process_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_process_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_process_title'] );
            $has_dec_text = ! empty( $item['_dl_process_description_text'] );

            $columns = !empty($this->get_process_settings('_process_columns')) ? $this->get_process_settings('_process_columns') : 3;
            $process_link_setting_key = $this->get_repeater_setting_key( '_dl_process_link', '_dl_process_skin_three_lists', $index );
            $link_tag = 'span';

            if ( ! empty( $item['_dl_process_link']['url'] ) ) {
                $link_tag = 'a';
                $this->add_link_attributes( $process_link_setting_key, $item['_dl_process_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( $process_link_setting_key );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_process_title', '_dl_process_skin_three_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                'id' => 'process-' . $item['_id'],
                'class' => [ "dl_col_lg_{$columns}", 'dl_col_sm_6', 'droit-process-items', "elementor-repeater-item-{$item['_id']}" ],
                'data-item' => $item_count,
            ] );
         ?>
        <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
            <div class="dl_single_process_box dl_style_04 droit-process-box">
                <div class="dl_process_box_icon droit-process-box-icon">
                    <div class="dl_process_icon_inner dl_color_01 droit-process-box-icon-inner">
                        <?php 
                            if ($item['_dl_process_icon_show'] === 'yes' ) {
                                if($item['_dl_process_icon_type'] == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                       <?php Icons_Manager::render_icon( $item['_dl_process_selected_icon'] ); ?>
                                   <?php }
                                }elseif( $item['_dl_process_icon_type'] == 'image' ){ ?>
                                    <img src="<?php echo esc_url($item['_dl_process_icon_image']['url']); ?>" alt="<?php echo esc_attr( get_post_meta($item['_dl_process_icon_image']['id'], '_wp_attachment_image_alt', true) ); ?>">
                               <?php }  
                            }
                        ?>
                    </div>
                    
                </div>
                <?php if ( $has_title_text ) : ?>
                    <<?php echo droit_title_tag($item['_dl_process_title_size']); ?> class="dl_title droit-process-title">
                    <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                    <?php echo do_shortcode($item['_dl_process_title']); ?>
                </<?php echo esc_html( $link_tag ); ?>>
                    </<?php echo droit_title_tag($item['_dl_process_title_size']); ?>>
                <?php endif; ?>
                <?php if ($has_dec_text): ?>
                    <p class="dl_desc droit-process-desc">
                        <?php echo do_shortcode($item['_dl_process_description_text']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
  <?php }

  // process fout
    protected function _four_process_layout(){
        $settings = $this->get_settings_for_display();

    ?>
    <div class="dl_row droit-process-wrapper">
        <?php foreach ($this->get_process_settings('_dl_process_skin_four_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_process_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_process_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_process_title'] );
            $has_dec_text = ! empty( $item['_dl_process_description_text'] );
            $has_image = ! empty( $item['_dl_process_image']['url'] );

            $columns = !empty($this->get_process_settings('_process_columns')) ? $this->get_process_settings('_process_columns') : 3;

            $process_link_setting_key = $this->get_repeater_setting_key( '_dl_process_link', '_dl_process_skin_four_lists', $index );
            $link_tag = 'span';
            if ( ! empty( $item['_dl_process_link']['url'] ) ) {
                $link_tag = 'a';
                $this->add_link_attributes( $process_link_setting_key, $item['_dl_process_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( $process_link_setting_key );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_process_title', '_dl_process_skin_four_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                'id' => 'process-' . $item['_id'],
                'class' => [ "dl_col_lg_{$columns}", 'dl_col_sm_6', 'droit-process-items', "elementor-repeater-item-{$item['_id']}" ],
                'data-item' => $item_count,
            ] );
            $process_active_class = '';
            if($item['_dl_process_as_default_active_show'] == 'yes'){
                $process_active_class = 'process-default-active';
            }
         ?>
        <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
            <div class="dl_single_process_box dl_hover_addclass dl_style_05 droit-process-box droit-process-box-hover <?php echo $process_active_class; ?>">
                <div class="dl_process_box_icon droit-process-box-icon">
                    <div class="dl_process_icon_inner droit-process-box-icon-inner">
                        <?php 
                            if ($item['_dl_process_icon_show'] === 'yes' ) {
                                if($item['_dl_process_icon_type'] == 'icon'){
                                    if ( $is_new || $migrated ) { ?>
                                       <?php Icons_Manager::render_icon( $item['_dl_process_selected_icon'] ); ?>
                                   <?php }
                                }elseif( $item['_dl_process_icon_type'] == 'image' ){ ?>
                                    <img src="<?php echo esc_url($item['_dl_process_icon_image']['url']); ?>" alt="<?php echo esc_attr( get_post_meta($item['_dl_process_icon_image']['id'], '_wp_attachment_image_alt', true) ); ?>">
                               <?php }  
                            }
                        ?>
                    </div>
                    <?php if ( $has_image ): ?>
                        <img src="<?php echo $item['_dl_process_image']['url']; ?>" alt="<?php echo esc_attr( get_post_meta($item['_dl_process_image']['id'], '_wp_attachment_image_alt', true) ); ?>" class="dl_arrow_img droit-arrow-img">
                    <?php endif ?>
                </div>
                <?php if ( $has_title_text ) : ?>
                    <<?php echo droit_title_tag($item['_dl_process_title_size']); ?> class="dl_title droit-process-title">
                    <<?php echo implode( ' ', [ $link_tag, $link_attributes ] ); ?>>
                    <?php echo do_shortcode($item['_dl_process_title']); ?>
                     </<?php echo esc_html( $link_tag ); ?>>
                    </<?php echo droit_title_tag($item['_dl_process_title_size']); ?>>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
  <?php }

    protected function content_template()
    {}
}
