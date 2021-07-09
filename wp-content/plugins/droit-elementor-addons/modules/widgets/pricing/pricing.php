<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Pricing\Pricing_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Pricing\Pricing_Module as Module;
use \Elementor\Icons_Manager;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Pricing extends Control
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
      $this->register_pricing_table_preset_controls();
      $this->register_pricing_table_general_controls();
      $this->register_pricing_header_control();
      $this->register_pricing_currency_control();
      $this->register_pricing_feature_control();
      $this->register_pricing_feature_layout_second_control();
      $this->register_pricing_feature_layout_third_control();
      $this->register_pricing_populated_control();
      $this->register_pricing_button_control();
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
        
        $_dl_pricing_skin  = !empty($this->get_pricing_settings('_dl_pricing_table_skin')) ? $this->get_pricing_settings('_dl_pricing_table_skin') : '_skin_1';

            switch ($_dl_pricing_skin) {
                case '_skin_1':
                    $this->_first_pricing_table_layout();
                    break; 
                case '_skin_2':
                    $this->_second_pricing_table_layout();
                    break;
                case '_skin_3':
                    $this->_third_pricing_table_layout();
                    break;
                default:
                    $this->_first_pricing_table_layout();
                    break;
            }
    }

    // First Layout
    protected function _first_pricing_table_layout(){
        $settings = $this->get_settings_for_display();
        
        // Heading
        $this->add_render_attribute( '_dl_pricing_heading_text', 'class', 'dl_title droit-pricing-heading' );
        $heading_attributes = $this->get_render_attribute_string( '_dl_pricing_heading_text' );

        // Link
        $icon_tag = '';

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_link')['url'] ) ) {
            $icon_tag = 'a';

            $this->add_link_attributes( '_dl_pricing_link', $this->get_pricing_settings('_dl_pricing_link') );
        }
        $link_attributes = $this->get_render_attribute_string( '_dl_pricing_link' );

        //Check Popular price
        $populated_class = 'dl_normal_package';
        if($this->get_pricing_settings('_dl_pricing_enable_as_active') == 'yes'){
            $populated_class = 'dl_popular_package';
        }

        //Pricing Wrapper
        $this->add_render_attribute( '_dl_pricing_wrapper', [
            'class' => [ "dl_pricing_plan", 'dl_style_02', "droit-pricing-plan", "{$populated_class}" ],
        ] );

        $_dl_pricing_wrapper = $this->get_render_attribute_string( '_dl_pricing_wrapper' );

        // Populated
        $this->add_render_attribute( '_dl_pricing_populated_text', 'class', 'dl_text droit-pricing-populated-text' );
        $populated_attributes = $this->get_render_attribute_string( '_dl_pricing_populated_text' );

        
        $this->add_render_attribute( '_dl_populated_position', [
            'class' => [ "dl_popular_tricker", "droit-popular-tricker", "droit-popular-tricker-{$this->get_pricing_settings('_dl_populated_position')}" ],
        ] );
        $populated_position_attributes = $this->get_render_attribute_string( '_dl_populated_position' );


        //Pricing
        $symbol = '';

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_currency_symbol') ) ) {
            if ( '_dl_pricing_custom' !== $this->get_pricing_settings('_dl_pricing_currency_symbol') ) {
                $symbol = $this->droit_get_currency_symbol( $this->get_pricing_settings('_dl_pricing_currency_symbol') );
            } else {
                $symbol = $this->get_pricing_settings('_dl_pricing_currency_symbol_custom');
            }
        }
        $currency_format = empty( $this->get_pricing_settings('_dl_pricing_currency_format') ) ? '.' : $this->get_pricing_settings('_dl_pricing_currency_format');
        $price = explode( $currency_format, $this->get_pricing_settings('_dl_pricing_price_text') );
        $intpart = $price[0];
        $fraction = '';
        if ( 2 === count( $price ) ) {
            $fraction = $price[1];
        }

        $period_position = $this->get_pricing_settings('_dl_pricing_period_position');
        $period_element = '<span class="dl_price_duration droit-price-period " ' . $this->get_render_attribute_string( '_dl_pricing_period' ) . '>' . $this->get_pricing_settings('_dl_pricing_period') . '</span>';
       
        $migration_allowed = Icons_Manager::is_migration_allowed();


        //Button
        
        $this->add_render_attribute( 'button_text', 'class', [
            'dl_cu_btn btn_4',
            'droit-price-button',
        ] );

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_link')['url'] ) ) {
            $this->add_link_attributes( 'button_text', $this->get_pricing_settings('_dl_pricing_button_link') );
        }

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_hover_animation') ) ) {
            $this->add_render_attribute( 'button_text', 'class', 'elementor-animation-' . $this->get_pricing_settings('_dl_pricing_button_hover_animation') );
        }
        ?>
       <div <?php echo $_dl_pricing_wrapper; ?>>
            <?php if ($this->get_pricing_settings('_dl_pricing_enable_as_populated') == 'yes'): ?>
                <div <?php echo $populated_position_attributes; ?>>
                    <<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_populated_tag')) ); ?> <?php echo $populated_attributes; ?>><?php echo esc_html($this->get_pricing_settings('_dl_pricing_populated_text')); ?></<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_populated_tag')) ); ?>>
                </div>
            <?php endif; ?>
            <?php if ($this->get_pricing_settings('_dl_pricing_enable_currency_price') == 'yes'): ?>  
                <div class="dl_top_pricing_title">
                    <div class="dl_price droit-price <?php echo $period_position;?>">
                        <?php if ( 'yes' === $this->get_pricing_settings('_dl_pricing_sale') && ! empty( $this->get_pricing_settings('_dl_pricing_original_price') ) ) : ?>
                            <span class="dl_regular_price dl-regular-price"><?php echo esc_html($symbol . $this->get_pricing_settings('_dl_pricing_original_price')); ?></span>
                        <?php endif; ?>
                        <?php $this->droit_render_currency_symbol( $symbol, 'before' ); ?>

                        <?php if ( ! empty( $intpart ) || 0 <= $intpart ) : ?>
                            <span class="droit-price-integer"><?php echo $intpart; ?></span>
                        <?php endif; ?>

                        <?php if ( '' !== $fraction || ( ! empty( $this->get_pricing_settings('_dl_pricing_period') ) && 'beside' === $period_position ) ) : ?>
                        <div class="droit-price-price-after">
                            <span class="droit-price-floating"><?php echo $fraction; ?></span>
                        </div>
                    <?php endif; ?>

                    
                     <?php if ( ! empty( $this->get_pricing_settings('_dl_pricing_period') )  ) : ?>
                        <?php echo $period_element; ?>
                    <?php endif; ?>
                    </div>
                </div>
               
            <?php endif; ?>
            <<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_title_tag')) ); ?> <?php echo $heading_attributes ?>>
                <?php if (!empty($icon_tag)): ?>
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>>
                <?php endif; ?>
                <?php echo esc_html($this->get_pricing_settings('_dl_pricing_heading_text')); ?>
                <?php if (!empty($icon_tag)): ?>
                    </<?php echo $icon_tag; ?>>
                <?php endif; ?>

            </<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_title_tag')) ); ?>>
            <?php if ( ! empty( $settings['_dl_pricing_features_list'] ) ) : ?>
            <ul class="dl_pricing_list droit-pricing-feature">
                <?php
                    foreach ( $settings['_dl_pricing_features_list'] as $index => $item ) :
                        $repeater_setting_key = $this->get_repeater_setting_key( '_dl_pricing_item_text', '_dl_pricing_features_list', $index );
                        $this->add_inline_editing_attributes( $repeater_setting_key );

                        $migrated = isset( $item['__fa4_migrated']['_dl_pricing_selected_item_icon'] );
                        // add old default
                        if ( ! isset( $item['_dl_pricing_item_icon'] ) && ! $migration_allowed ) {
                            $item['_dl_pricing_item_icon'] = 'fa fa-check-circle';
                        }
                        $is_new = ! isset( $item['_dl_pricing_item_icon'] ) && $migration_allowed;
                        ?>
                        <li class="elementor-repeater-item-<?php echo $item['_id']; ?>">
                            
                                <?php if ( ! empty( $item['_dl_pricing_item_icon'] ) || ! empty( $item['_dl_pricing_selected_item_icon'] ) ) :
                                    if ( $is_new || $migrated ) :
                                        Icons_Manager::render_icon( $item['_dl_pricing_selected_item_icon'], [ 'aria-hidden' => 'true' ] );
                                    else : ?>
                                        <i class="<?php echo esc_attr( $item['_dl_pricing_item_icon'] ); ?>" aria-hidden="true"></i>
                                        <?php
                                    endif;
                                endif; ?>
                                <?php if ( ! empty( $item['_dl_pricing_item_text'] ) ) : ?>
                                    <span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>>
                                        <?php echo $item['_dl_pricing_item_text']; ?>
                                    </span>
                                    <?php
                                else :
                                    echo '&nbsp;';
                                endif;
                                ?>
                        </li>
                    <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <?php if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_text') )) : ?> 
                <a <?php echo $this->get_render_attribute_string( 'button_text' ); ?>><?php echo esc_html($this->get_pricing_settings('_dl_pricing_button_text')); ?></a>
            <?php endif; ?>
        </div>
    <?php }

    // Second Layout
    protected function _second_pricing_table_layout(){
        $settings = $this->get_settings_for_display();

        // Heading
        $this->add_render_attribute( '_dl_pricing_heading_text', 'class', 'dl_title droit-pricing-heading' );
        $heading_attributes = $this->get_render_attribute_string( '_dl_pricing_heading_text' );

        // Link
        $icon_tag = '';

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_link')['url'] ) ) {
            $icon_tag = 'a';

            $this->add_link_attributes( '_dl_pricing_link', $this->get_pricing_settings('_dl_pricing_link') );
        }
        $link_attributes = $this->get_render_attribute_string( '_dl_pricing_link' );

        //Check Popular price
        $populated_class = 'dl_normal_package';
        if($this->get_pricing_settings('_dl_pricing_enable_as_active') == 'yes'){
            $populated_class = 'dl_popular_package';
        }


        //Pricing Wrapper
        $this->add_render_attribute( '_dl_pricing_wrapper', [
            'class' => [ "dl_pricing_plan_wrapper", "droit-pricing-plan", "{$populated_class}" ],
        ] );

        $_dl_pricing_wrapper = $this->get_render_attribute_string( '_dl_pricing_wrapper' );

       
        //Pricing
        $symbol = '';

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_currency_symbol') ) ) {
            if ( '_dl_pricing_custom' !== $this->get_pricing_settings('_dl_pricing_currency_symbol') ) {
                $symbol = $this->droit_get_currency_symbol( $this->get_pricing_settings('_dl_pricing_currency_symbol') );
            } else {
                $symbol = $this->get_pricing_settings('_dl_pricing_currency_symbol_custom');
            }
        }
        $currency_format = empty( $this->get_pricing_settings('_dl_pricing_currency_format') ) ? '.' : $this->get_pricing_settings('_dl_pricing_currency_format');
        $price = explode( $currency_format, $this->get_pricing_settings('_dl_pricing_price_text') );
        $intpart = $price[0];
        $fraction = '';
        if ( 2 === count( $price ) ) {
            $fraction = $price[1];
        }

        //Button
        $populated_class_btn = '';
        if($this->get_pricing_settings('_dl_pricing_enable_as_active') == 'yes'){
            $populated_class_btn = 'white_bg';
        }
        $this->add_render_attribute( 'button_text', 'class', [
            'dl_cu_btn btn_4 xl_btn',
            'droit-price-button',
            $populated_class_btn
        ] );

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_link')['url'] ) ) {
            $this->add_link_attributes( 'button_text', $this->get_pricing_settings('_dl_pricing_button_link') );
        }

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_hover_animation') ) ) {
            $this->add_render_attribute( 'button_text', 'class', 'dl_cu_btn white_bg xl_btn elementor-animation-' . $this->get_pricing_settings('_dl_pricing_button_hover_animation') );
        }
        ?>
       <div <?php echo $_dl_pricing_wrapper; ?>>

            <?php if ($this->get_pricing_settings('_dl_pricing_enable_currency_price') == 'yes'): ?>  
                <div class="dl_top_pricing_title">
                    <div class="dl_price droit-price">
                        <?php if ( 'yes' === $this->get_pricing_settings('_dl_pricing_sale') && ! empty( $this->get_pricing_settings('_dl_pricing_original_price') ) ) : ?>
                            <span class="dl_regular_price dl-regular-price"><?php echo esc_html($symbol . $this->get_pricing_settings('_dl_pricing_original_price')); ?></span>
                        <?php endif; ?>
                        <?php $this->droit_render_currency_symbol( $symbol, 'before' ); ?>
                        <?php if ( ! empty( $intpart ) || 0 <= $intpart ) : ?>
                            <span class="droit-price-integer"><?php echo $intpart; ?></span>
                        <?php endif; ?>                
                    </div>
                </div>
               
            <?php endif; ?>
            <<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_title_tag')) ); ?> <?php echo $heading_attributes ?>>
                <?php if (!empty($icon_tag)): ?>
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>>
                <?php endif; ?>
                <?php echo esc_html($this->get_pricing_settings('_dl_pricing_heading_text')); ?>
                <?php if (!empty($icon_tag)): ?>
                    </<?php echo $icon_tag; ?>>
                <?php endif; ?>

            </<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_title_tag')) ); ?>>
            
            <?php if ( ! empty( $this->get_pricing_settings('_dl_pricing_description_text') )) : ?> 
                <p class="droit-pricing-desc"><?php echo esc_html($this->get_pricing_settings('_dl_pricing_description_text')); ?></p>
            <?php endif; ?>
            
            <?php if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_text') )) : ?> 
                <a <?php echo $this->get_render_attribute_string( 'button_text' ); ?>><?php echo esc_html($this->get_pricing_settings('_dl_pricing_button_text')); ?></a>
            <?php endif; ?>
        </div>
    <?php }

    // Third Layout
    protected function _third_pricing_table_layout(){
        $settings = $this->get_settings_for_display();
        
        // Heading
        $this->add_render_attribute( '_dl_pricing_heading_text', 'class', 'dl_pricing_title droit-pricing-heading' );
        $heading_attributes = $this->get_render_attribute_string( '_dl_pricing_heading_text' );

        // Link
        $icon_tag = '';

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_link')['url'] ) ) {
            $icon_tag = 'a';

            $this->add_link_attributes( '_dl_pricing_link', $this->get_pricing_settings('_dl_pricing_link') );
        }
        $link_attributes = $this->get_render_attribute_string( '_dl_pricing_link' );

        //Check Popular price
        $populated_class = 'dl_normal_package';
        if($this->get_pricing_settings('_dl_pricing_enable_as_active') == 'yes'){
            $populated_class = 'dl_popular_package';
        }

        //Pricing Wrapper
        $this->add_render_attribute( '_dl_pricing_wrapper', [
            'class' => [ "dl_pricing_plan", 'dl_style_01', 'dl_text_center', "droit-pricing-plan", "{$populated_class}" ],
        ] );

        $_dl_pricing_wrapper = $this->get_render_attribute_string( '_dl_pricing_wrapper' );

        // Populated
        $this->add_render_attribute( '_dl_pricing_populated_text', 'class', 'dl_text droit-pricing-populated-text' );
        $populated_attributes = $this->get_render_attribute_string( '_dl_pricing_populated_text' );

        
        $this->add_render_attribute( '_dl_populated_position', [
            'class' => [ "dl_popular_tricker", "droit-popular-tricker", "droit-popular-tricker-{$this->get_pricing_settings('_dl_populated_position')}" ],
        ] );
        $populated_position_attributes = $this->get_render_attribute_string( '_dl_populated_position' );


        //Pricing
        $symbol = '';

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_currency_symbol') ) ) {
            if ( '_dl_pricing_custom' !== $this->get_pricing_settings('_dl_pricing_currency_symbol') ) {
                $symbol = $this->droit_get_currency_symbol( $this->get_pricing_settings('_dl_pricing_currency_symbol') );
            } else {
                $symbol = $this->get_pricing_settings('_dl_pricing_currency_symbol_custom');
            }
        }
        $currency_format = empty( $this->get_pricing_settings('_dl_pricing_currency_format') ) ? '.' : $this->get_pricing_settings('_dl_pricing_currency_format');
        $price = explode( $currency_format, $this->get_pricing_settings('_dl_pricing_price_text') );
        $intpart = $price[0];
        $fraction = '';
        if ( 2 === count( $price ) ) {
            $fraction = $price[1];
        }

        $period_position = $this->get_pricing_settings('_dl_pricing_period_position');
        $period_element = '<span class="dl_price_duration droit-price-period " ' . $this->get_render_attribute_string( '_dl_pricing_period' ) . '>' . $this->get_pricing_settings('_dl_pricing_period') . '</span>';


        //Button
        
        $this->add_render_attribute( 'button_text', 'class', [
            'dl_cu_btn btn_2',
            'droit-price-button',
        ] );

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_link')['url'] ) ) {
            $this->add_link_attributes( 'button_text', $this->get_pricing_settings('_dl_pricing_button_link') );
        }

        if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_hover_animation') ) ) {
            $this->add_render_attribute( 'button_text', 'class', 'elementor-animation-' . $this->get_pricing_settings('_dl_pricing_button_hover_animation') );
        }
        ?>
       <div <?php echo $_dl_pricing_wrapper; ?>>
            <?php if ($this->get_pricing_settings('_dl_pricing_enable_as_populated') == 'yes'): ?>
                <div <?php echo $populated_position_attributes; ?>>
                    <?php if (!empty($this->get_pricing_settings('_dl_pricing_populated_image')['url'])): ?>
                        <img src="<?php echo esc_url($this->get_pricing_settings('_dl_pricing_populated_image')['url']); ?>" alt="<?php echo esc_attr( get_post_meta($this->get_pricing_settings('_dl_pricing_populated_image')['id'], '_wp_attachment_image_alt', true) ); ?>">
                    <?php endif; ?>
                    <<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_populated_tag')) ); ?> <?php echo $populated_attributes; ?>><?php echo esc_html($this->get_pricing_settings('_dl_pricing_populated_text')); ?></<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_populated_tag')) ); ?>>
                </div>
            <?php endif; ?>
            <<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_title_tag')) ); ?> <?php echo $heading_attributes ?>>
                <?php if (!empty($icon_tag)): ?>
                        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>>
                <?php endif; ?>
                <?php echo esc_html($this->get_pricing_settings('_dl_pricing_heading_text')); ?>
                <?php if (!empty($icon_tag)): ?>
                    </<?php echo $icon_tag; ?>>
                <?php endif; ?>

            </<?php echo esc_html( droit_title_tag($this->get_pricing_settings('_dl_pricing_title_tag')) ); ?>>
            <?php if (!empty($this->get_pricing_settings('_dl_pricing_heading_desc'))): ?>
                <p class="dl_desc heading-desc"><?php echo esc_html($this->get_pricing_settings('_dl_pricing_heading_desc')); ?></p>
            <?php endif; ?>
            <?php if (!empty($this->get_pricing_settings('_dl_pricing_heading_image')['url'])): ?>
                <div class="dl_pricing_img droit-pricing-img">
                    <img src="<?php echo esc_url($this->get_pricing_settings('_dl_pricing_heading_image')['url']) ?>" alt="<?php echo esc_attr( get_post_meta($this->get_pricing_settings('_dl_pricing_heading_image')['id'], '_wp_attachment_image_alt', true) ); ?>">
                </div>
            <?php endif; ?>
            <?php if ($this->get_pricing_settings('_dl_pricing_enable_currency_price') == 'yes'): ?>  
                
                <div class="dl_top_pricing_title">
                    <div class="dl_price droit-price <?php echo $period_position;?>">
                    <?php if ( 'yes' === $this->get_pricing_settings('_dl_pricing_sale') && ! empty( $this->get_pricing_settings('_dl_pricing_original_price') ) ) : ?>
                        <span class="dl_regular_price dl-regular-price"><?php echo esc_html($symbol . $this->get_pricing_settings('_dl_pricing_original_price')); ?></span>
                    <?php endif; ?>
                    <?php $this->droit_render_currency_symbol( $symbol, 'before' ); ?>

                    <?php if ( ! empty( $intpart ) || 0 <= $intpart ) : ?>
                        <span class="dl_prices droit-price-integer"><?php echo $intpart; ?></span>
                    <?php endif; ?>

                    <?php if ( '' !== $fraction || ( ! empty( $this->get_pricing_settings('_dl_pricing_period') ) && 'beside' === $period_position ) ) : ?>
                    <div class="droit-price-price-after">
                        <span class="dl_prices droit-price-floating"><?php echo $fraction; ?></span>
                    </div>
                <?php endif; ?>
                 <?php if ( ! empty( $this->get_pricing_settings('_dl_pricing_period') ) ) : ?>
                    <?php echo $period_element; ?>
                <?php endif; ?>
                </div>
                </div>
               
            <?php endif; ?>
            
            <?php if ( ! empty( $settings['_dl_pricing_features_third_list'] ) ) : ?>
            <ul class="dl_pricing_list droit-pricing-feature">
                <?php
                    foreach ( $settings['_dl_pricing_features_third_list'] as $index => $item ) :
                        $repeater_setting_key = $this->get_repeater_setting_key( '_dl_pricing_item_text', '_dl_pricing_features_third_list', $index );
                        $this->add_inline_editing_attributes( $repeater_setting_key );

                        ?>
                        <li class="elementor-repeater-item-<?php echo $item['_id']; ?>">
                            <?php if ( ! empty( $item['_dl_pricing_item_text'] ) ) : ?>
                                <span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>>
                                    <?php echo $item['_dl_pricing_item_text']; ?>
                                </span>
                                <?php
                            else :
                                echo '&nbsp;';
                            endif;
                            ?>
                        </li>
                    <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <?php if ( ! empty( $this->get_pricing_settings('_dl_pricing_button_text') )) : ?> 
                <a <?php echo $this->get_render_attribute_string( 'button_text' ); ?>><?php echo esc_html($this->get_pricing_settings('_dl_pricing_button_text')); ?></a>
            <?php endif; ?>
        </div>
    <?php }

  private function droit_render_currency_symbol( $symbol, $location ) {
        $currency_position = $this->get_settings( '_dl_pricing_currency_position' );
        $location_setting = ! empty( $currency_position ) ? $currency_position : 'before';
        if ( ! empty( $symbol ) && $location === $location_setting ) {
    echo '<span class="dl_currancy droit_currency_symbol droit-currency-symbol droit-currency--' . $location . '">'. $symbol .' </span>';
        }
    }
    private function droit_get_currency_symbol( $symbol_name ) {
        $symbols = [
            'dollar' => '&#36;',
            'euro' => '&#128;',
            'franc' => '&#8355;',
            'pound' => '&#163;',
            'ruble' => '&#8381;',
            'shekel' => '&#8362;',
            'baht' => '&#3647;',
            'yen' => '&#165;',
            'won' => '&#8361;',
            'guilder' => '&fnof;',
            'peso' => '&#8369;',
            'peseta' => '&#8359',
            'lira' => '&#8356;',
            'rupee' => '&#8360;',
            'indian_rupee' => '&#8377;',
            'real' => 'R$',
            'krona' => 'kr',
        ];
        return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
    }
    protected function content_template()
    {}
}
