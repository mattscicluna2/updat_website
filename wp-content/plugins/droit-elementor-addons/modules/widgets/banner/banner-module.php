<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Banner;

if (!defined('ABSPATH')) {exit;}

class Banner_Module{
    
    public static function get_name() {
        return 'droit-banner';
    }
    
    public static function get_title() {
        return esc_html__( 'Banner', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-banner addons-icon';
    }

    public static function get_keywords() {
        return [ 'banner',
            'dl banner',
            'droit banner',
            'data banner',
            'banner styler',
            'elementor banner',
            'dl',
            'droit'
        ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}