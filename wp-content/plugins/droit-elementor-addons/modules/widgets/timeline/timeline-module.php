<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Timeline;

if (!defined('ABSPATH')) {exit;}

class Timeline_Module{
    
    public static function get_name() {
        return 'droit-timeline';
    }
    
    public static function get_title() {
        return esc_html__( 'Timeline', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-timeline addons-icon';
    }

    public static function get_keywords() {
        return [
            'timeline',
            'timelines',
            'droit timeline',
            'droit timelines',
            'dl timeline',
            'dl timelines',
            'content',
            'droit content',
            'dl content',
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