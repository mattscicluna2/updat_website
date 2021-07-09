<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Title;

if (!defined('ABSPATH')) {exit;}

class Title_Module{
    
    public static function get_name() {
        return 'droit-title';
    }
    
    public static function get_title() {
        return esc_html__( 'Title', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'addons-icon eicon-post-title';
    }

    public static function get_keywords() {
        return [
            'Title heading',
            'heading',
            'Title title',
            'Title text',
            'toggle',
            'droit Title',
            'dl Title',
            'dl advanced Title',
            'panel',
            'navigation',
            'group',
            'Title content',
            'product Title',
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