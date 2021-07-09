<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Tab;

if (!defined('ABSPATH')) {exit;}

class Tab_Module{
    
    public static function get_name() {
        return 'droit-tab';
    }
    
    public static function get_title() {
        return esc_html__( 'Tab', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-Tab addons-icon';
    }

    public static function get_keywords() {
        return [
            'tabs',
            'accordion',
            'toggle',
            'droit tab',
            'dl tabs',
            'dl advanced tabs',
            'panel',
            'navigation',
            'group',
            'tabs content',
            'product tabs'
        ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}