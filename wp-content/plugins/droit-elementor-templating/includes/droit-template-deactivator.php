<?php 
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR_TEMPLATE;

if ( ! defined( 'ABSPATH' ) ) {exit;}

class Droit_El_Template_Deactivator{
    
    public static function droit_el_template_deactivate() {
		flush_rewrite_rules();
	}
}