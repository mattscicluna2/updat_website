<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Iconbox;
if (!defined('ABSPATH')) {exit;}
class Iconbox_Module{
    
    public static function get_name() {
        return 'droit-iconbox';
    }
    
    public static function get_title() {
        return esc_html__( 'Icon Box', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-iconbox addons-icon';
    }

    public static function get_keywords() {
        return [ 'icon box', 'icon', 'icon list', 'list', 'droit icon box', 'droit icon', 'droit icon list', 'droit list', 'dl icon box', 'drdloit icon', 'dl icon list', 'dl list', 'droit', 'dl', 'addons', 'addon' ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}