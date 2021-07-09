<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Countdown\Countdown_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Countdown\Countdown_Module as Module;
use \Elementor\Group_Control_Image_Size;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Countdown extends Control
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
      $this->register_countdown_preset_controls();
      $this->register_countdown_time_controls();
      $this->register_countdown_time_settings_controls();
      $this->register_countdown_time_expire_controls();
      $this->register_countdown_time_general_style_controls();
      $this->register_countdown_time_digit_label_style_controls();
      $this->register_countdown_time_seperator_style_controls();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
   

            $_countdown_skin  = !empty($this->get_countdown_settings('_dl_countdown_skin')) ? $this->get_countdown_settings('_dl_countdown_skin') : '_skin_1';

            switch ($_countdown_skin) {
                case '_skin_1':
                    $this->_countdown_first_layout();
                    break; 
                case '_skin_2':
                    $this->_countdown_second_layout();
                    break;
                case '_skin_3':
                    $this->_countdown_three_layout();
                    break;
                default:
                    $this->_countdown_first_layout();
                    break;
            }
    }

    // First Layout
    protected function _countdown_first_layout(){
        $settings = $this->get_settings_for_display();
        $get_due_date_time = esc_attr( $this->get_countdown_settings('_dl_countdown_due_time') );
        $due_date_time = date( "M d Y G:i:s", strtotime( $get_due_date_time ) );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        

        $this->add_render_attribute( 'droit-countdown-wrapper', [
            'id' => 'countdown-' . $id_int,
            'class' => [ 'dl_countdown_wrapper', 'dl_style_01', 'droit-countdown-wrapper' ],
            'data-countdown-id' => esc_attr( $this->get_id() ),
            'data-end-type' => $this->get_countdown_settings('_dl_countdown_expire_type'),
            
        ] );

        if ( $this->get_countdown_settings('_dl_countdown_expire_type') == 'text' ) {
            if ( !empty( $this->get_countdown_settings('_dl_countdown_expiry_text') ) ) {
                $this->add_render_attribute( 'droit-countdown-wrapper', 'data-end-text', wp_kses_post( $this->get_countdown_settings('_dl_countdown_expiry_text') ) );
            }

            if ( !empty( $this->get_countdown_settings('_dl_countdown_expiry_text_title') ) ) {
                $this->add_render_attribute( 'droit-countdown-wrapper', 'data-end-title', wp_kses_post( $this->get_countdown_settings('countdown_expiry_text_title') ) );
            }
        } elseif ( $this->get_countdown_settings('_dl_countdown_expire_type') == 'url' ) {
            $this->add_render_attribute( 'droit-countdown-wrapper', 'data-redirect-url', $this->get_countdown_settings('_dl_countdown_expiry_redirection') );
        }else {
            //Nothing
        }
        ?>
        
        <div <?php echo $this->get_render_attribute_string( 'droit-countdown-wrapper' ); ?>>

            <div class="dl_countdown_content droit-countdown-content">
                <div id="droit-countdown-<?php echo esc_attr( $this->get_id() ); ?>" class="dl_countdown_running dl_colum_4" data-date="<?php echo esc_attr( $due_date_time ); ?>">
                    <div class="dl_countdown_inner droit-countdown-inner countdown-days">
                        <span data-days class="dl_days droit-countdown-digits"></span>
                            <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes'  ): ?>
                                <?php if ( $this->get_countdown_settings('_dl_show_days') == 'yes' ): ?>
                                    <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_days'); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>                
                    <div class="dl_countdown_inner droit-countdown-inner countdown-hours">
                        <span data-hours class="dl_hours dl_text_blue droit-countdown-digits"></span>
                            <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes'  ): ?>
                                <?php if ($this->get_countdown_settings('_dl_show_hours') == 'yes') : ?>
                                    <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_hours'); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>
                    <div class="dl_countdown_inner droit-countdown-inner countdown-minutes">
                        <span data-minutes class="dl_minutes dl_text_yellow droit-countdown-digits"></span>
                            <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes'  ): ?>
                                <?php if ($this->get_countdown_settings('_dl_show_minutes') == 'yes') : ?>
                                    <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_minutes'); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>              
                    <div class="dl_countdown_inner droit-countdown-inner countdown-seconds">
                        <span data-seconds class="dl_seconds dl_text_orange droit-countdown-digits"></span>
                            <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes'  ): ?>
                                <?php if ($this->get_countdown_settings('_dl_show_seconds') == 'yes') : ?>
                                    <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_seconds'); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        
        </div>
    <?php }

    // Second Layout
    protected function _countdown_second_layout(){
        $settings = $this->get_settings_for_display();
        $get_due_date_time = esc_attr( $this->get_countdown_settings('_dl_countdown_due_time') );
        $due_date_time = date( "M d Y G:i:s", strtotime( $get_due_date_time ) );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        

        $this->add_render_attribute( 'droit-countdown-wrapper', [
            'id' => 'countdown-' . $id_int,
            'class' => [ 'dl_countdown_wrapper', 'dl_style_04', 'droit-countdown-wrapper' ],
            'data-countdown-id' => esc_attr( $this->get_id() ),
            'data-end-type' => $this->get_countdown_settings('_dl_countdown_expire_type'),
            
        ] );

        if ( $this->get_countdown_settings('_dl_countdown_expire_type') == 'text' ) {
            if ( !empty( $this->get_countdown_settings('_dl_countdown_expiry_text') ) ) {
                $this->add_render_attribute( 'droit-countdown-wrapper', 'data-end-text', wp_kses_post( $this->get_countdown_settings('_dl_countdown_expiry_text') ) );
            }

            if ( !empty( $this->get_countdown_settings('_dl_countdown_expiry_text_title') ) ) {
                $this->add_render_attribute( 'droit-countdown-wrapper', 'data-end-title', wp_kses_post( $this->get_countdown_settings('countdown_expiry_text_title') ) );
            }
        } elseif ( $this->get_countdown_settings('_dl_countdown_expire_type') == 'url' ) {
            $this->add_render_attribute( 'droit-countdown-wrapper', 'data-redirect-url', $this->get_countdown_settings('_dl_countdown_expiry_redirection') );
        }else {
            //Nothing
        }
        ?>
        
        <div <?php echo $this->get_render_attribute_string( 'droit-countdown-wrapper' ); ?>>

            <div class="dl_countdown_content droit-countdown-content d_4">
                <div id="droit-countdown-<?php echo esc_attr( $this->get_id() ); ?>" class="dl_countdown_running dl_colum_4" data-date="<?php echo esc_attr( $due_date_time ); ?>">
                        <div class="dl_countdown_inner droit-countdown-inner countdown-days">
                            <div class="dl_countdown">
                                <span data-days class="dl_days droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ( $this->get_countdown_settings('_dl_show_days') == 'yes' ): ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_days'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>                
                    </div>
                        <div class="dl_countdown_inner droit-countdown-inner countdown-hours">
                            <div class="dl_countdown">
                                <span data-hours class="dl_hours dl_text_blue droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ($this->get_countdown_settings('_dl_show_hours') == 'yes') : ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_hours'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>
                    </div>
                        <div class="dl_countdown_inner droit-countdown-inner countdown-minutes">
                            <div class="dl_countdown">
                                <span data-minutes class="dl_minutes dl_text_yellow droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ($this->get_countdown_settings('_dl_show_minutes') == 'yes') : ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_minutes'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>              
                    </div>
                        <div class="dl_countdown_inner droit-countdown-inner countdown-seconds">
                            <div class="dl_countdown">
                                <span data-seconds class="dl_seconds dl_text_orange droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ($this->get_countdown_settings('_dl_show_seconds') == 'yes') : ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_seconds'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    <?php }

    // Three Layout
    protected function _countdown_three_layout(){
        $settings = $this->get_settings_for_display();
        $get_due_date_time = esc_attr( $this->get_countdown_settings('_dl_countdown_due_time') );
        $due_date_time = date( "M d Y G:i:s", strtotime( $get_due_date_time ) );
        $id_int = substr( $this->get_id_int(), 0, 4 );
        

        $this->add_render_attribute( 'droit-countdown-wrapper', [
            'id' => 'countdown-' . $id_int,
            'class' => [ 'dl_countdown_wrapper', 'dl_style_08', 'droit-countdown-wrapper' ],
            'data-countdown-id' => esc_attr( $this->get_id() ),
            'data-end-type' => $this->get_countdown_settings('_dl_countdown_expire_type'),
            
        ] );

        if ( $this->get_countdown_settings('_dl_countdown_expire_type') == 'text' ) {
            if ( !empty( $this->get_countdown_settings('_dl_countdown_expiry_text') ) ) {
                $this->add_render_attribute( 'droit-countdown-wrapper', 'data-end-text', wp_kses_post( $this->get_countdown_settings('_dl_countdown_expiry_text') ) );
            }

            if ( !empty( $this->get_countdown_settings('_dl_countdown_expiry_text_title') ) ) {
                $this->add_render_attribute( 'droit-countdown-wrapper', 'data-end-title', wp_kses_post( $this->get_countdown_settings('countdown_expiry_text_title') ) );
            }
        } elseif ( $this->get_countdown_settings('_dl_countdown_expire_type') == 'url' ) {
            $this->add_render_attribute( 'droit-countdown-wrapper', 'data-redirect-url', $this->get_countdown_settings('_dl_countdown_expiry_redirection') );
        }else {
            //Nothing
        }
        ?>
        
        <div <?php echo $this->get_render_attribute_string( 'droit-countdown-wrapper' ); ?>>

            <div class="dl_countdown_content droit-countdown-content d_8">
                <div id="droit-countdown-<?php echo esc_attr( $this->get_id() ); ?>" class="dl_countdown_running dl_colum_4" data-date="<?php echo esc_attr( $due_date_time ); ?>">
                        <div class="dl_countdown_inner droit-countdown-inner countdown-days">
                            <div class="dl_countdown">
                                <span data-days class="dl_days droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ( $this->get_countdown_settings('_dl_show_days') == 'yes' ): ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_days'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>                
                    </div>
                        <div class="dl_countdown_inner droit-countdown-inner countdown-hours">
                            <div class="dl_countdown">
                                <span data-hours class="dl_hours dl_text_blue droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ($this->get_countdown_settings('_dl_show_hours') == 'yes') : ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_hours'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>
                    </div>
                        <div class="dl_countdown_inner droit-countdown-inner countdown-minutes">
                            <div class="dl_countdown">
                                <span data-minutes class="dl_minutes dl_text_yellow droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ($this->get_countdown_settings('_dl_show_minutes') == 'yes') : ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_minutes'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>              
                    </div>
                        <div class="dl_countdown_inner droit-countdown-inner countdown-seconds">
                            <div class="dl_countdown">
                                <span data-seconds class="dl_seconds dl_text_orange droit-countdown-digits"></span>
                                <?php if ( $this->get_countdown_settings('_dl_custom_labels') == 'yes' ): ?>
                                        <?php if ($this->get_countdown_settings('_dl_show_seconds') == 'yes') : ?>
                                            <p class="dl_desc droit-countdown-labels"><?php echo $this->get_countdown_settings('_dl_label_seconds'); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    <?php }
    
    protected function content_template()
    {}
}
