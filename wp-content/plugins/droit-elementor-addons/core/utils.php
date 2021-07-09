<?php
namespace DROIT_ELEMENTOR;
defined( 'ABSPATH' ) || exit;

class Utils{
    private static $instance;

    public static function droit_addons_pro_link()
    {
        return droit_addons_pro_link();
    }

    public static function droit_addons_demo_link()
    {
        return droit_addons_demo_link();
    }

    public static function droit_addons_doc_link()
    {
        return droit_addons_doc_link();
    }

    public static function droit_addons_site_link()
    {
        return droit_addons_site_link();
    }

    public static function droit_addons_setting_link()
    {
        return droit_addons_setting_link();
    }

    public static function droit_addons_has_pro()
    {
        $is_pro = 'stayhere';
        if (did_action('droit_elementor_addons/pro')) {
            $is_pro = get_option('_validation_auth_');
        }
        
        $has_pro = isset($is_pro) && !empty($is_pro) && $is_pro == 'go_in_front' && defined('DROIT_EL_PRO');

        return $has_pro;

    }


    public static function droit_placeholder_image_src()
    {
        return droit_placeholder_image_src();
    }
    
    public static function droit_default_image_src()
    {
        return drdt_core()->images . 'placeholder.png';
    }

    public static function droit_get_post_types($args = [], $array_diff_key = []){
        $post_type_args = [
            'public' => true,
            'show_in_nav_menus' => true
        ];

        if (!empty($args['post_type'])) {
            $post_type_args['name'] = $args['post_type'];
            unset($args['post_type']);
        }

        $post_type_args = wp_parse_args($post_type_args, $args);
        $_post_types = get_post_types($post_type_args, 'objects');

        $post_types = array(
            'by_id'    => __('Manual Selection', 'droit-elementor-addons'),
            'category' => __('Category', 'droit-elementor-addons'),
        );

        foreach ($_post_types as $post_type => $object) {
            $post_types[$post_type] = $object->label;
        }
        if( !empty( $array_diff_key ) ){
            $post_types = array_diff_key( $post_types, $array_diff_key );
        }
        return $post_types;
    }
    
    public static function droit_get_all_posts($args = [], $array_diff_key = []){
        $post_args = get_posts(
            array(
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            )
        );
       $_posts = get_posts($post_args);
       $posts_list = [];
       foreach ($_posts as $_key => $object) {
           $posts_list[$object->ID] = $object->post_title;
       }
       return $posts_list;
   }

   public static function get_grid_metro_size() {
       return [
           '1:1'   => esc_html__( 'Width 1 - Height 1', 'droit-elementor-addons' ),
           '1:2'   => esc_html__( 'Width 1 - Height 2', 'droit-elementor-addons' ),
           '1:0.7' => esc_html__( 'Width 1 - Height 70%', 'droit-elementor-addons' ),
           '1:1.3' => esc_html__( 'Width 1 - Height 130%', 'droit-elementor-addons' ),
           '2:1'   => esc_html__( 'Width 2 - Height 1', 'droit-elementor-addons' ),
           '2:2'   => esc_html__( 'Width 2 - Height 2', 'droit-elementor-addons' ),
       ];
   }

   public static function droit_css_minify($css){
       // Remove comments
       $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
       // Remove remaining whitespace
       $css = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '), '', $css);
       return $css;
   }

   public static function droit_addons_contact7_activated()
    {
        return class_exists('\WPCF7');
    }
    
    public static function droit_addons_cf7_list(){
        $cf7_form = array();
        if (self::droit_addons_contact7_activated()) {
            $cf7_form_list = get_posts(array(
                'post_type' => 'wpcf7_contact_form',
                'showposts' => 999,
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ));
            
            $cf7_form[0] = esc_html__('Select a Contact Form', 'droit-elementor-addons');

            if (!empty($cf7_form_list) && !is_wp_error($cf7_form_list)) {
                foreach ($cf7_form_list as $post) {
                    $cf7_form[$post->ID] = $post->post_title;
                }
            } else {
                $cf7_form[0] = esc_html__('Create a Form First', 'droit-elementor-addons');
            }
        }
        return $cf7_form;
    }

    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }
}