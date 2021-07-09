<?php
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 *
 */
 
namespace DROIT_ELEMENTOR_TEMPLATE\Templates;

use DROIT_ELEMENTOR_TEMPLATE\Templates\Library_Api;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {exit;}

class Load_Template{
    
    /**
     * @static
     */
    protected static $library_data = null;
    /**
     * Constructor
     * @since 1.0.0
     * @access private
     * Feature added by : DroitLab Team
     */
    public function __construct(){
        add_action( 'elementor/editor/footer', [ __CLASS__, 'load_template_views' ] );
        add_action( 'elementor/ajax/register_actions', [ __CLASS__, 'register_ajax_actions' ] );
    }

    /**
     * Import template ajax action
     */
 
    /**
     * Display template
     * @return
     * Feature added by : DroitLab Team
     * @since : 1.0.0
     */
    public static function load_template_views() {
        include_once DROIT_EL_TEMPLATE_PATH . '/templates/templates.php';
    }
    /**
     * Undocumented function
     *
     * @return Library_Api
     */
    public static function get_library() {
        if ( is_null( self::$library_data ) ) {
            self::$library_data = new Library_Api();
        }

        return self::$library_data;
    }
 
    public static function register_ajax_actions( Ajax $ajax ) {
        $ajax->register_ajax_action( 'get_lite_library_data', function( $data ) {
            if ( ! current_user_can( 'edit_posts' ) ) {
                throw new \Exception( 'Access Denied' );
            }

            if ( ! empty( $data['editor_post_id'] ) ) {
                $editor_post_id = absint( $data['editor_post_id'] );

                if ( ! get_post( $editor_post_id ) ) {
                    throw new \Exception( __( 'Post not found.', 'droit-el-template-lite' ) );
                }

                Plugin::$instance->db->switch_to_post( $editor_post_id );
            }

            $result = self::get_library_data( $data );

            return $result;
        } );
    }

    
    /**
     * Get library data from cache or remote
     *
     * type_tags has been added in version 2.15.0
     *
     * @param array $args
     *
     * @return array
     */
    public static function get_library_data( array $args ) {
        $library_data = self::get_library();

        if ( ! empty( $args['sync'] ) ) {
            $library_data::get_library_data( true );
        }

        return [
            'templates' => $library_data->get_items(),
            'tags'      => $library_data->get_tags(),
            'type_tags' => $library_data->get_type_tags(),
        ];
    }
}