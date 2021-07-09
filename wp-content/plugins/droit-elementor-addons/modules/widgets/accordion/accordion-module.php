<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Accordion;

if (!defined('ABSPATH')) {exit;}

class Accordion_Module{
    
    public static function get_name() {
        return 'droit-accordion';
    }
    
    public static function get_title() {
        return esc_html__( 'Accordion', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-accordian addons-icon';
    }

    public static function get_keywords() {
       return [ 'Accordions', 'accordion', 'toggle', 'droit Accordion', 'dl Accordions', 'dl advanced Accordions', 'panel', 'navigation', 'group', 'Accordions content', 'product Accordions', 'droit', 'dl', 'addons', 'addon' ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}