<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Bloglist;

if (!defined('ABSPATH')) {exit;}

class Bloglist_Module{
    
    public static function get_name() {
        return 'droit-bloglist';
    }
    
    public static function get_title() {
        return esc_html__( 'Blog List', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-blog addons-icon';
    }

    public static function get_keywords() {
        return [ 'blog', 'blogs', 'post', 'posts', 'blogs list', 'blog list', 'droit blogs list', 'droit blog list', 'dl blogs list', 'dl blog list', 'list blog', 'posts', 'post', 'posts list', 'post list', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type', 'droit blog', 'droit blogs', 'droit post', 'droit posts', 'dl blog', 'dl blogs', 'dl post', 'dl posts', 'addons', 'addon'  ];
    }
    
    public static function get_categories() {
        return ['droit_addons'];
    }
 
}