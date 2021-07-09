<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Countdown;

if (!defined('ABSPATH')) {exit;}

class Countdown_Module{
    
    public static function get_name() {
        return 'droit-countdown';
    }
    
    public static function get_title() {
        return esc_html__( 'Countdown', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-countdown addons-icon';
    }

    public static function get_keywords() {
        return [ 'countdown', 'number', 'timer', 'time', 'date', 'evergreen', 'dl countdown', 'droit-countdown', 'droit countdown', 'count down', 'dr count down', 'droit', 'dl', 'addons', 'addon' ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}