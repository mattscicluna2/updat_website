<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Testimonial;

if (!defined('ABSPATH')) { exit;}

class Testimonial_Module{
    
    public static function get_name() {
        return 'droit-testimonial';
    }
    
    public static function get_title() {
        return esc_html__( 'Testimonial', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-quote addons-icon';
    }

    public static function get_keywords() {
        return [
            'testimonial',
            'team',
            'blockquote',
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