<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Team;

if (!defined('ABSPATH')) {exit;}

class Team_Module{
    
    public static function get_name() {
        return 'droit-team';
    }
    
    public static function get_title() {
        return esc_html__( 'Team Member', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-Team addons-icon';
    }

    public static function get_keywords() {
        return [
            'team',
            'member',
            'team member',
            'dl team member',
            'dl team members',
            'droit team member',
            'droit team members',
            'person',
            'card',
            'meet the team',
            'team builder',
            'our team',
            'droit',
            'dl',
            'droit elementor addons',
        ];
    }
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}