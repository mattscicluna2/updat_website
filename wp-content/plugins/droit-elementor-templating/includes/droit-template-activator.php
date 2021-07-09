<?php 
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR_TEMPLATE;

if ( ! defined( 'ABSPATH' ) ) {exit;}

class Droit_El_Template_Activator{
    
    public static function droit_el_template_activate() {
		flush_rewrite_rules();
	}
}