<?php
namespace DroitDark\Includes\Widgets;
defined( 'ABSPATH' ) || exit;

use \DroitDark\Dtdr_Controller as Contr;

class Widget_Loader{

    private static $instance;

    private static $elementor;

    private $widgets = [];

    private $option_keys;

    public function __construct(){

        $this->option_keys = \DroitDark\Includes\Dtdr_Load::_instance()->option_keys;

        $this->widgets = apply_filters('drdt_dark_widgets', [
            'switcher' => 'Dark Switcher',
        ]);

        // elementor widgets
        if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( '\Elementor\Plugin::instance' ) ) {
            self::$elementor = \Elementor\Plugin::instance();
            add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widgets_elementor' ] );
        }

        // guttenbureg block
        add_action( 'enqueue_block_editor_assets', [ $this, 'drdt_form_block' ], 10 );
        add_action('init', [ $this, 'render_block'], 10);
    }

    /**
    * Name: register_widgets_elementor
    * Desc: Register Elementor Widgets  for Dark mode
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function register_widgets_elementor(){
        if( !empty($this->widgets) ){
            foreach($this->widgets as $k=>$v){

                $files = __DIR__ . '/elementor/'.$k.'.php';
                if( !is_readable($files) || !is_file($files) ){
                    continue;
                }
                require_once( $files );
                $clsssName = str_replace([' ', '-', ''], '_', ucwords(str_replace([' ', '-', ''], ' ', $k)) );
                $class = "\Elementor\DRDTD_".$clsssName;
                if( class_exists($class) ){
                    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class() );
                }
            }
        }
    }

    /**
    * Name: drdt_form_block
    * Desc: Register Gutenberg Block for Dark Mode
    * Params: no params
    * Return: @void
    * version: 1.0.0
    * Package: @droitedd
    * Author: DroitThemes
    * Developer: Hazi
    */

    public function drdt_form_block(){

        // register block js
        wp_enqueue_script( 
            'drdt-dark-block',
            Contr::dtdr_url() . 'includes/widgets/gutenberg/gutenblock.js',
            [ 'wp-blocks', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-element', 'underscore' ]
        );

        wp_localize_script( 'drdt-dark-block', 'drdt_dark', [
            'style'          => $this->switcher(),
            'siteUrl'        => get_home_url()
        ] );



    }

    public function render_block(){
        $data = get_option($this->option_keys, true);
        register_block_type( 'drdt/darkmode', array(
            'render_callback' => [ $this, 'set_attribute'],
            'attributes' => array(
                'styleId' => array(
                    'type' => 'integer',
                    'default' => isset($data['button_style']) ? $data['button_style'] : 1,
                )
            ),
            'editor_script' => 'drdt-dark-block',
        ));
    }

    public function set_attribute( $attributes ){
        $styleId = ($attributes['styleId']) ?? 1;
        ob_start();
        echo do_shortcode('[drdt_dark_mode style='.$styleId.' position=no]');
        return ob_get_clean();
    }

    public function switcher(){
        $switch = \DroitDark\Includes\Dtdr_Load::_instance()->switcher_button();
        $style = [];
        if( !empty($switch) ){
          foreach( $switch as $k=>$v){
              $is_pro = ($v['is_pro']) ?? false;
              if( empty($k) || $is_pro){
                  continue;
              }
              $name = ($v['name']) ?? '';
              $style[$k] = $name;
          }
  
        }
        return $style;
      }

    public static function _instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

}