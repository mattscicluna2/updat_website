<?php 
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR_TEMPLATE\Core;

if ( ! defined( 'ABSPATH' ) ) {exit;}

class Utils{

    /**
     * Protocol
     * @since 1.0.0
     * @access public
     * Feature added by : DroitLab Team
     */
    public static function droit_el_template_protocol( $path = '' ) {
        $url = plugins_url( $path, DROIT_EL_TEMPLATE_FILE );

        if ( is_ssl()
        and 'http:' == substr( $url, 0, 5 ) ) {
          $url = 'https:' . substr( $url, 5 );
        }
        return $url;
    }
}