<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Newstricker;

if (!defined('ABSPATH')) {exit;}

class Newstricker_Module{
    
    public static function get_name() {
        return 'droit-newstricker';
    }
    
    public static function get_title() {
        return esc_html__( 'News Stricker', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-newsticky addons-icon';
    }

    public static function get_keywords() {
       return [
            'news tricker',
            'news tricker',
            'toggle',
            'droit news tricker',
            'dl newstricker',
            'dl advanced newstricker',
            'panel',
            'navigation',
            'group',
            'Animated title content',
            'product Animated title',
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