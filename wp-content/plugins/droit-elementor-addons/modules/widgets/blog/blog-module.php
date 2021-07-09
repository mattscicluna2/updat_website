<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Blog;

if (!defined('ABSPATH')) { exit;}

class Blog_Module{
    
    public static function get_name() {
        return 'droit-blog';
    }
 
    public static function get_title() {
        return __( 'Blog', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-blog-post addons-icon';
    }

    public static function get_keywords() {
        return [
            'blog',
            'blogs',
            'post',
            'posts',
            'cpt',
            'item',
            'loop',
            'query',
            'cards',
            'post type',
            'custom post type',
            'droit blog',
            'droit blogs',
            'droit post',
            'droit posts',
            'dl blog',
            'dl blogs',
            'dl post',
            'dl posts',
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