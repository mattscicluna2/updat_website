<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Twitter_Feed;

if (!defined('ABSPATH')) {exit;}

class Twitter_Feed_Module{
    
    public static function get_name() {
        return 'droit-twitter_Feed';
    }
    
    public static function get_title() {
        return esc_html__( 'Twitter Feed', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-social-share addons-icon';
    }

    public static function get_keywords() {
        return [
            'Twitter',
            'Twitter form',
            'dl twitter',
            'social media',
            'twitter embed',
            'twitter field',
            'feedback',
            'social',
            'form',
            'dl',
            'droit'
        ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}