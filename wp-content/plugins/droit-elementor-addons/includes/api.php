<?php
namespace DROIT_ELEMENTOR\Manager;
defined( 'ABSPATH' ) || exit;

class Api{

    private static $instance;

    public function init(){
        // load modules control
        $data = drdt_manager()->api->api_data();
        
    }

    public function api_data(){
        $save_options = get_option( drdt_manager()->ajax::$option_keys, true);
        return isset($save_options['api']) ? $save_options['api'] : [];
    }

    public static function api_map(){
        return apply_filters('dlAddons/api/mapping', [
            'mailchimp' => [
                'title' => __('Mailchimp', 'droit-elementor-addons'),
                'is_pro' => false,
            ],
            'response' => [
                'title' => __('Get Response', 'droit-elementor-addons'),
                'is_pro' => false,
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