<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Card;

if (!defined('ABSPATH')) {exit;}

class Card_Module{
    
    public static function get_name() {
        return 'droit-card';
    }
    
    public static function get_title() {
        return esc_html__( 'Card', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-card addons-icon';
    }

    public static function get_keywords() {
        return [
            'cards',
            'card',
            'dl cards',
            'dl card',
            'droit cards',
            'droit card',
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