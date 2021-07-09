<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Contact_Form_7;

if (!defined('ABSPATH')) {exit;}

class Contact_Form_7_Module{
    
    public static function get_name() {
        return 'droit-contact_Form_7';
    }
    
    public static function get_title() {
        return esc_html__( 'Contact form 7', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-contact-form addons-icon';
    }

    public static function get_keywords() {
        return [ 
            'contact form', 
            'dl contact form', 
            'droit contact form', 
            'form styler', 
            'elementor form', 
            'feedback', 
            'cf7', 
            'form', 
            'dl', 
            'droit' 
        ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}