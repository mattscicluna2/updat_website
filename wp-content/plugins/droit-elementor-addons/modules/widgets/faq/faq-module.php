<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Faq;

if (!defined('ABSPATH')) {exit;}

class Faq_Module{
    
    public static function get_name() {
        return 'droit-faq';
    }
    
    public static function get_title() {
        return esc_html__( 'Faq', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-faq addons-icon';
    }

    public static function get_keywords() {
       return [ 'Faq', 'faq', 'toggle', 'droit Faq', 'dl Faq', 'dl advanced Faq', 'panel', 'navigation', 'group', 'Faq content', 'product Faq', 'droit', 'dl', 'addons', 'addon' ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}