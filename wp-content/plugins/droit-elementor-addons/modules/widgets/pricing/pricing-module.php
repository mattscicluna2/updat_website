<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Pricing;

if (!defined('ABSPATH')) {exit;}

class Pricing_Module{
    
    public static function get_name() {
        return 'droit-pricing';
    }
    
    public static function get_title() {
        return esc_html__( 'Pricing Table', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-pricing-Table addons-icon';
    }
    
    public static function get_keywords() {
        return [
            'price',
            'pricing',
            'table',
            'product',
            'plan',
            'button',
            'droit-pricing',
            'droit-table',
            'droit-product',
            'droit-plan',
            'droit-button',
            'dl-pricing',
            'dl-table',
            'dl-product',
            'dl-plan',
            'dl-button',
            'droit',
            'dl',
            'addons',
            'addon'
        ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}