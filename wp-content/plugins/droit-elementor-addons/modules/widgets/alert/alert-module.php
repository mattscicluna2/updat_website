<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Alert;

if (!defined('ABSPATH')) {exit;}

class Alert_Module{
    
    public static function get_name() {
        return 'droit-alert';
    }
    
    public static function get_title() {
        return esc_html__( 'Alert', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-alert addons-icon';
    }

    public static function get_keywords() {
        return [ 'alert', 'dl alert', 'droit alert',  'data alert', 'alert styler', 'elementor alert', 'dl', 'droit' ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}