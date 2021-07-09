<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Share_Buttons\Share_Buttons_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Share_Buttons\Share_Buttons_Module as Module;
use \Elementor\Group_Control_Image_Size;
use \ELEMENTOR\Icons_Manager;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Share_Buttons extends Control
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
      $this->register_share_buttons_preset_controls();
      $this->register_share_icons_buttons_skin_one_control();
      $this->register_share_icons_buttons_skin_all_control();
      $this->_droit_register_share_buttons_icon_style_controls();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();

        $_share_buttons_skin  = !empty($this->get_share_settings('_share_buttons_skin')) ? $this->get_share_settings('_share_buttons_skin') : '_skin_1';

        switch ($_share_buttons_skin) {
            case '_skin_1':
                $this->_first_share_buttons_layout();
                break; 
            case '_skin_2':
                $this->_second_share_buttons_layout();
                break;
            case '_skin_3':
                $this->_third_share_buttons_layout();
                break;
            case '_skin_4':
                $this->_four_share_buttons_layout();
                break;
            default:
                $this->_first_share_buttons_layout();
                break;

        }
    }

    // share_buttons first
    protected function _first_share_buttons_layout(){
        $settings = $this->get_settings_for_display();
    ?>
    <div class="dl_social_icon dl_social_ixon_style_1 droit-share-buttons-wrapper">
        <?php foreach ($this->get_share_settings('_dl_share_buttons_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_share_buttons_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_share_buttons_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_share_buttons_title'] );
            $has_dec_text = ! empty( $item['_dl_share_buttons_description_text'] );
            $has_image = ! empty( $item['_dl_share_buttons_image']['url'] );

            $columns = !empty($this->get_share_settings('_share_buttons_columns')) ? $this->get_share_settings('_share_buttons_columns') : 3;


            if ( ! empty( $item['_dl_share_buttons_link']['url'] ) ) {
                $this->add_link_attributes( '_dl_share_buttons_link', $item['_dl_share_buttons_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( '_dl_share_buttons_link' );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_list', '_dl_share_buttons_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                
                'class' => [ "dl_social_btn", "droit-share-icon", "elementor-repeater-item-{$item['_id']}", esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network'])))) ],
                'data-item' => $item_count,
            ] );
         ?>
         <a <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> data-social="<?php echo  esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network']))))?>" href="#"> 
            <?php Icons_Manager::render_icon( $item['_dl_share_buttons_selected_icon'] ); ?> 
            <?php if (!empty($item['_dl_share_buttons_label'])): ?>
                <?php echo esc_html($item['_dl_share_buttons_label']); ?>
            <?php endif; ?>
        </a>
            
        <?php endforeach; ?>
    </div>
  <?php }

    // share_buttons Second
    protected function _second_share_buttons_layout(){
        $settings = $this->get_settings_for_display();
    ?>
    <div class="dl_social_icon dl_social_ixon_style_2 droit-share-buttons-wrapper">
        <?php foreach ($this->get_share_settings('_dl_share_buttons_other_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_share_buttons_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_share_buttons_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_share_buttons_title'] );
            $has_dec_text = ! empty( $item['_dl_share_buttons_description_text'] );
            $has_image = ! empty( $item['_dl_share_buttons_image']['url'] );

            $columns = !empty($this->get_share_settings('_share_buttons_columns')) ? $this->get_share_settings('_share_buttons_columns') : 3;


            if ( ! empty( $item['_dl_share_buttons_link']['url'] ) ) {
                $this->add_link_attributes( '_dl_share_buttons_link', $item['_dl_share_buttons_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( '_dl_share_buttons_link' );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_list', '_dl_share_buttons_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                
                'class' => [ "dl_social_btn", "droit-share-icon", "elementor-repeater-item-{$item['_id']}", esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network'])))) ],
                'data-item' => $item_count,
            ] );
         ?>
         <a <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> data-social="<?php echo  esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network']))))?>" href="#">
            <?php Icons_Manager::render_icon( $item['_dl_share_buttons_selected_icon'] ); ?> 
         </a>
        <?php endforeach; ?>
    </div>
  <?php }
    

    // share_buttons Third
    protected function _third_share_buttons_layout(){
        $settings = $this->get_settings_for_display();
    ?>
    <div class="dl_social_icon dl_social_ixon_style_3 droit-share-buttons-wrapper">
        <?php foreach ($this->get_share_settings('_dl_share_buttons_other_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_share_buttons_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_share_buttons_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_share_buttons_title'] );
            $has_dec_text = ! empty( $item['_dl_share_buttons_description_text'] );
            $has_image = ! empty( $item['_dl_share_buttons_image']['url'] );

            $columns = !empty($this->get_share_settings('_share_buttons_columns')) ? $this->get_share_settings('_share_buttons_columns') : 3;


            if ( ! empty( $item['_dl_share_buttons_link']['url'] ) ) {
                $this->add_link_attributes( '_dl_share_buttons_link', $item['_dl_share_buttons_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( '_dl_share_buttons_link' );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_list', '_dl_share_buttons_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                
                'class' => [ "dl_social_btn", "droit-share-icon", "elementor-repeater-item-{$item['_id']}", esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network'])))) ],
                'data-item' => $item_count,
            ] );
         ?>
         <a <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> data-social="<?php echo  esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network']))))?>" href="#">
            <?php Icons_Manager::render_icon( $item['_dl_share_buttons_selected_icon'] ); ?>
         </a>
        <?php endforeach; ?>
    </div>
  <?php }
    

    // share_buttons Third
    protected function _four_share_buttons_layout(){
        $settings = $this->get_settings_for_display();
    ?>
    <div class="dl_social_icon dl_social_ixon_style_4 droit-share-buttons-wrapper">
        <?php foreach ($this->get_share_settings('_dl_share_buttons_other_lists') as $index => $item):
            $item_count = $index + 1;
            $migrated = isset( $item['__fa4_migrated']['_dl_share_buttons_selected_icon'] );

            if ( ! isset( $item['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                $item['icon'] = 'fas fa-check';
            }

            $is_new = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $item['_dl_share_buttons_selected_icon']['value'] ) );

            $has_title_text = ! empty( $item['_dl_share_buttons_title'] );
            $has_dec_text = ! empty( $item['_dl_share_buttons_description_text'] );
            $has_image = ! empty( $item['_dl_share_buttons_image']['url'] );

            $columns = !empty($this->get_share_settings('_share_buttons_columns')) ? $this->get_share_settings('_share_buttons_columns') : 3;


            if ( ! empty( $item['_dl_share_buttons_link']['url'] ) ) {
                $this->add_link_attributes( '_dl_share_buttons_link', $item['_dl_share_buttons_link'] );
            }
            $link_attributes = $this->get_render_attribute_string( '_dl_share_buttons_link' );
            $tab_title_setting_key = $this->get_repeater_setting_key( '_dl_faq_list', '_dl_share_buttons_lists', $index );
            $this->add_render_attribute( $tab_title_setting_key, [
                
                'class' => [ "dl_social_btn", "droit-share-icon", "elementor-repeater-item-{$item['_id']}", esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network'])))) ],
                'data-item' => $item_count,
            ] );
         ?>
         <a <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?> data-social="<?php echo  esc_attr((preg_replace('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\ ]/', '', strtolower($item['_dl_share_buttons_network']))))?>" href="#">
            <?php Icons_Manager::render_icon( $item['_dl_share_buttons_selected_icon'] ); ?>
         </a>
        <?php endforeach; ?>
    </div>
  <?php }
    

    protected function content_template(){}
}
