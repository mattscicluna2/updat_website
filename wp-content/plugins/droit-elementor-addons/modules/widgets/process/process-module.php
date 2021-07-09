<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Process;

if (!defined('ABSPATH')) {exit;}

class Process_Module{
    
    public static function get_name() {
        return 'droit-process';
    }
    
    public static function get_title() {
        return esc_html__( 'Process', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-process addons-icon';
    }

    public static function get_keywords() {
        return [
            'progress',
            'bar',
            'step',
            'process',
            'dl-process',
            'dl-progress',
            'droit-process',
            'droit-progress',
            'dlprocess',
            'dlprogress',
            'droitprocess',
            'droit progress',
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