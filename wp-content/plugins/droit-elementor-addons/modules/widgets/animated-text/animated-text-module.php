<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Animated_Text;

if (!defined('ABSPATH')) {exit;}

class Animated_Text_Module{
    
    public static function get_name() {
        return 'droit-animated_text';
    }
    
    public static function get_title() {
        return esc_html__( 'Animated Text', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-animated-title addons-icon';
    }

    public static function get_keywords() {
       return [ 
            'animated heading',
            'heading',
            'animatedtitle',
            'animated text',
            'toggle',
            'droit animatedtitle',
            'dl animatedtitle',
            'dl advanced animatedtitle',
            'panel',
            'navigation',
            'group', 'Animated title content',
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