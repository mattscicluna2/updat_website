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

class Import_Template{

    /**
     * @static
     */
    protected static $template = null;

    /**
     * Constructor
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    public function __construct(){
        add_action( 'elementor/ajax/register_actions', array(__CLASS__, 'register_ajax_actions' ) );
    }

    /**
     * @return Library_Api
     * @since 1.0.0
     * Feature added by : DroitLab Team
     */
    public static function template_library() {
        if ( is_null( self::$template ) ) {
            self::$template = new Library_Api();
        }

        return self::$template;
    }
     public static function register_ajax_actions( Ajax $ajax ) {

        $ajax->register_ajax_action( 'get_lite_template_data', function( $data ) {
            if ( ! current_user_can( 'edit_posts' ) ) {
                throw new \Exception( 'Access Denied' );
            }

            if ( ! empty( $data['editor_post_id'] ) ) {
                $editor_post_id = absint( $data['editor_post_id'] );

                if ( ! get_post( $editor_post_id ) ) {
                    throw new \Exception( __( 'Post not found', 'droit-el-template-lite' ) );
                }
                Plugin::$instance->db->switch_to_post( $editor_post_id );
            }

            if ( empty( $data['template_id'] ) ) {
                throw new \Exception( __( 'Template id missing', 'droit-el-template-lite' ) );
            }

            $result = self::get_template_data( $data );
            return $result;
        } );
    }
    public static function get_template_data( array $args ) {
        $template = self::template_library();
        $data = $template->get_data( $args );
        return $data;
    }

}