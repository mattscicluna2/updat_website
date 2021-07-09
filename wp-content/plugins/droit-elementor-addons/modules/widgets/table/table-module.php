<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Table;

if (!defined('ABSPATH')) {exit;}

class Table_Module{
    
    public static function get_name() {
        return 'droit-table';
    }
    
    public static function get_title() {
        return esc_html__( 'Table', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-table addons-icon';
    }

    public static function get_keywords() {
        return [
            'table',
            'dl table',
            'droit table',
            'data table',
            'table styler',
            'elementor table',
            'dl',
            'droit'
        ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}