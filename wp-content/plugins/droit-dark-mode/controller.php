<?php
namespace DroitDark;
defined( 'ABSPATH' ) || exit;

final class Dtdr_Controller{

    private static $instance;

    public function __construct(){
        self::_run(); 
    }
    
    public static function version(){
        return '1.0.4';
    }
 
    public static function php_version(){
        return '5.7.2';
    }

	public static function dtdr_file(){
		return  DROIT_DARK_FILE_;
	}
  
	public static function dtdr_url(){
		return trailingslashit(plugin_dir_url( self::dtdr_file() ));
	}

	public static function dtdr_dir(){
		return trailingslashit(plugin_dir_path( self::dtdr_file() ));
    }

 
    public function load(){  
        
        if ( version_compare( PHP_VERSION, self::php_version(), '<' ) ) {
			add_action( 'admin_notices', function(){
                $class = 'notice notice-error';
                $message = sprintf( __( '<b>Droit dark</b> requires PHP version %1$s+, which is currently NOT RUNNING on this server.', 'droit-dark' ), '5.6' );
                printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message); 
            } );
			return;
		}   
        
        // add action for cron job 
        register_deactivation_hook( DROIT_DARK_FILE_, [ $this, 'drdt_deactivate'] ); 

        // added setting link
        add_filter("plugin_action_links_" . plugin_basename(DROIT_DARK_FILE_), [$this, 'add_settings_link']);
        // add row 
        add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 2 );

    }

    public static function _run() {
		spl_autoload_register( [ __CLASS__, 'autoloading' ] );
    }

    private static function autoloading( $ld ) {
        if ( 0 !== strpos( $ld, __NAMESPACE__ ) ) {
            return;
        }
        // get map setup data
        $map = self::class_map();
        $relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $ld );
        if( isset( $map[ $relative_class_name ] ) ){
            $name = $map[ $relative_class_name ];
        } else {
            $name = strtolower(preg_replace([ '/\b'.__NAMESPACE__.'\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ], [ '', '$1-$2', '-', DIRECTORY_SEPARATOR], $ld) );
            $name = str_replace('dtdr-', '', $name). '.php';    
        }
        $filename = self::dtdr_dir() . $name;
        if ( is_readable( $filename ) ) {
           require_once( $filename );
        }
    }

     // class map
     public static function class_map(){
        return [
            'Includes\Dtdr_Load' => 'includes/load.php',
        ];
    } 

    public function drdt_deactivate(){
        $timestamp = wp_next_scheduled( 'drdl_cron_hook' );
        wp_unschedule_event( $timestamp, 'drdl_cron_hook' );
    }

    public function add_settings_link( $link ){
        $settings[] = '<a href="' . admin_url( 'admin.php?page=droit-dark-settings' ) . '" class="drdt-settings-plugin"> '.esc_html__('Settings', 'droit-dark').'</a>';
        
        if( class_exists('\DroitDarkPro\Includes\Dtdr_Features') ){
            $settings[] = '<a href="' . admin_url( 'admin.php?page=droit-dark-settings#droit_license' ) . '" class="drdt-settings-plugin"> '.esc_html__('License', 'droit-dark').'</a>';
        }
        $link = array_merge( $link, $settings );
        return $link;
    }

    public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( plugin_basename(DROIT_DARK_FILE_) === $plugin_file ) {
			$row_meta = [
				'docs' => '<a href="https://demos.droitthemes.com/droit-dark-mode/" aria-label="' . esc_attr( __( 'View Demo for Dark Mode', 'droit-dark' ) ) . '" target="_blank">' . __( 'View Demo', 'droit-dark' ) . '</a>',
				'support' => '<a href="https://droitthemes2.ticksy.com/submit/" aria-label="' . esc_attr( __( 'Support', 'droit-dark' ) ) . '" target="_blank">' . __( 'Get Support', 'droit-dark' ) . '</a>',
                'getpro' => '<a href="https://droitthemes.com/droit-dark-mode/" aria-label="' . esc_attr( __( 'Get Dark Mode PRO', 'droit-dark' ) ) . '" target="_blank">' . __( 'Get Pro', 'droit-dark' ) . '</a>',
			];

			$plugin_meta = array_merge( $plugin_meta, $row_meta );
		}

		return $plugin_meta;
	}

    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
            do_action( 'droitDark/loaded' );
        }
        return self::$instance;
    }

}