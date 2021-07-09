<?php
namespace DROIT_ELEMENTOR\Manager;
defined( 'ABSPATH' ) || exit;

class Modules{

    private static $instance;

    public function init(){
        // load modules control
        $data = drdt_manager()->modules->modules_data();

        do_action('dlAddons/modules/before', $data);

        // load sticky 
        if( in_array('sticky', $data) ){
            \DROIT_ELEMENTOR\DL_Sticky::instance()->init();
        }
        
         // icons loading
         if( in_array('droit_icons', $data) ){
            \DROIT_ELEMENTOR\Module\Controls\Icons\Droit_Icons::instance()->load();
        }

        //common sections
        if( in_array('droit_section', $data) ){
            \DROIT_ELEMENTOR\Module\Extention\Common_Section::instance()->load();
        }

        //custom column
        if( in_array('custom_column', $data) ){
            \DROIT_ELEMENTOR\Module\Extention\Custom_Column::instance()->load();
        }

        // generate font
        if(current_user_can('manage_options') && DROIT_ADDONS_ICON_RENDER){
           \DROIT_ELEMENTOR\Module\Controls\Icons\Droit_Icons::instance()->generate_font();
        }

        // templates
        \DROIT_ELEMENTOR\Templates\DL_Import::instance()->load();
        \DROIT_ELEMENTOR\Templates\Dl_Load::instance()->load();
        \DROIT_ELEMENTOR\Templates\DL_Templates::instance()->init();
        
        do_action('dlAddons/modules/after', $data);
        
    }

    public function modules_data(){
        $save_options = get_option( drdt_manager()->ajax::$option_keys, true);
        return isset($save_options['modules']) ? $save_options['modules'] : [
            'droit_icons', 'droit_section', 'custom_column', 'sticky'
        ];
    }

    public static function modules_map(){
        return apply_filters('dlAddons/modules/mapping', [
            'sticky' => [
                'title' => __('Sticky Section', 'droit-elementor-addons'),
                'is_pro' => false,
            ],
            'droit_icons' => [
                'title' => __('Icons', 'droit-elementor-addons'),
                'is_pro' => false,
            ],

            'droit_section' => [
                'title' => __('Common Section', 'droit-elementor-addons'),
                'is_pro' => false,
            ],

            'custom_column' => [
                'title' => __('Custom Column', 'droit-elementor-addons'),
                'is_pro' => false,
            ],
            'parallax' => [
                'title' => __('Parallax', 'droit-elementor-addons'),
                'is_pro' => true,
            ],
            'lottie' => [
                'title' => __('Lottie', 'droit-elementor-addons'),
                'is_pro' => true,
            ],
            'one_page_scroll' => [
                'title' => __('One/Full Page Scroll', 'droit-elementor-addons'),
                'is_pro' => true,
            ],
            'dl_effect' => [
                'title' => __('CSS Effect', 'droit-elementor-addons'),
                'is_pro' => true,
            ],
            'dl_transform' => [
                'title' => __('CSS Transform', 'droit-elementor-addons'),
                'is_pro' => true,
            ],
            'dl_breakpoints' => [
                'title' => __('Breakpoints', 'droit-elementor-addons'),
                'is_pro' => true,
            ],
            'dl_custom_css' => [
                'title' => __('Custom Css', 'droit-elementor-addons'),
                'is_pro' => true,
            ],
        ]);
    }

    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

}