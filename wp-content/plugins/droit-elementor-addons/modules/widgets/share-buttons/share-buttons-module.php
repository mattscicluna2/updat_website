<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Share_Buttons;

if (!defined('ABSPATH')) {exit;}

class Share_Buttons_Module{
    
    public static function get_name() {
        return 'droit-share_Buttons';
    }
    
    public static function get_title() {
        return esc_html__( 'Share Buttons', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-social-share addons-icon';
    }

    public static function get_keywords() {
        return [
            'sharing',
            'social',
            'icon',
            'button',
            'like',
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