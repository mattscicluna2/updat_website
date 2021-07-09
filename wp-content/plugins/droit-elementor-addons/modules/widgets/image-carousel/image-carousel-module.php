<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Image_Carousel;

if (!defined('ABSPATH')) {exit;}

class Image_Carousel_Module{
    
    public static function get_name() {
        return 'droit-image_Carousel';
    }
    
    public static function get_title() {
        return esc_html__( 'Image Carousel', 'droit-elementor-addons' );
    }

    public static function get_icon() {
        return 'dlicons-image-carosel addons-icon';
    }

    public static function get_keywords() {
        return [
            'Image Carousel',
            'image carousel',
            'Image Slider',
            'Droit Image Slider',
            'dl Image Slider',
            'droit image carousel',
            'droit-image carousel',
            'dl image carousel',
            'dl-image carousel',
            'Images',
            'images',
            'Carousel',
            'carousel',
            'Slider',
            'Sliders',
            'slider',
            'sliders',
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