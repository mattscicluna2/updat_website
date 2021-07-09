<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Infobox;

if (!defined('ABSPATH')) { exit;}

class Infobox_Module{
    
    public static function get_name() {
        return 'droit-infobox';
    }
    
    public static function get_title() {
        return esc_html__( 'Info Box', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-inforbox addons-icon';
    }

    public static function get_keywords() {
         return [
            'infobox',
            'info',
            'box',
            'droit infobox',
            'droit info',
            'droit box',
            'dl infobox',
            'dl info',
            'dl box',
            'droit',
            'dl',
            'addons',
            'addon'
        ];
    }
    public static function get_custom_help_url() {
         return '';
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}