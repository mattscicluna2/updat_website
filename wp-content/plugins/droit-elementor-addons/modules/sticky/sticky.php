<?php
namespace DROIT_ELEMENTOR;

use \Elementor\Controls_Manager;

defined('ABSPATH') || die();

if (!class_exists('DL_Sticky')) {
    class DL_Sticky
    {
        private static $instance = null;

        public static function url(){
            if (defined('DROIT_ADDONS_FILE_')) {
                $file = trailingslashit(plugin_dir_url( DROIT_ADDONS_FILE_ )). 'modules/sticky/';
            } else {
                $file = trailingslashit(plugin_dir_url( __FILE__ ));
            }
            return $file;
        }
    
        public static function dir(){
            if (defined('DROIT_ADDONS_FILE_')) {
                $file = trailingslashit(plugin_dir_path( DROIT_ADDONS_FILE_ )). 'modules/sticky/';
            } else {
                $file = trailingslashit(plugin_dir_path( __FILE__ ));
            }
            return $file;
        }
    
        public static function version(){
            if( defined('DROIT_ADDONS_VERSION_') ){
                return DROIT_ADDONS_VERSION_;
            } else {
                return apply_filters('dladdons_pro_version', '1.0.0');
            }
            
        }

        public function init()
        {
            add_action( 'wp_enqueue_scripts', function() {       
                wp_enqueue_style( "dl-sticky-css", self::url() . 'js/sticky.css' , null, self::version() );  
                wp_enqueue_script("dl-sticky-js", self::url() . 'js/sticky.js', ['jquery'], self::version(), true); 
             } 
            );
            add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'sticky_option'], 99, 1);
            add_action('elementor/frontend/section/before_render', [ $this, 'sticky_render'], 1 );

        }


        public function sticky_option($el){
            if ( 'section' === $el->get_name()) {
                $el->start_controls_section(
                    'dl_sticky_section',
                    [
                        'label' => __( 'Droit Sticky', 'droit-elementor-addons-pro' ) . _droit_get_icon(),
                        'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
                    ]
                );
    
                $el->add_control(
                    'dl_sticky_section_enable',
                    [
                        'label' => __( 'Enable', 'droit-elementor-addons-pro' ),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => __( 'Yes', 'droit-elementor-addons-pro' ),
                        'label_off' => __( 'No', 'droit-elementor-addons-pro' ),
                        'return_value' => 'yes',
                        'default' => 'no',
                    ]
                );
    
                $el->end_controls_section();
            }
        }
    
        public function sticky_render( $el ){
            if ( 'section' === $el->get_name() ) {
                $settings = $el->get_settings_for_display();
                $id = $el->get_id();
                $sctionEnable = isset($settings['dl_sticky_section_enable']) ? $settings['dl_sticky_section_enable'] : 'no';
                if($sctionEnable == 'yes'){
                    $attr['class'] = 'drdt_sticky_section';
                    $el->add_render_attribute(
                        '_wrapper',
                        $attr
                    );
                }
            }
    
        }

        public static function instance(){
            if( is_null(self::$instance) ){
                self::$instance = new self();
            }
            return self::$instance;
        }
    }
}
