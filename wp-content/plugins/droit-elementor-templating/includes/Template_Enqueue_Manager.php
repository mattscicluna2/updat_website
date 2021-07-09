<?php
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 *
 */

namespace DROIT_ELEMENTOR_TEMPLATE;
use DROIT_ELEMENTOR_TEMPLATE\Core\Utils;

if ( ! defined( 'ABSPATH' ) ) {exit;}

class Template_Enqueue_Manager{
    public $notice;
    /**
     * Constructor
     * @since 1.0.0
     * @access private
     * Feature added by : DroitLab Team
     */
    public function __construct(){
        $this->init_hooks();
    }

    /**
     * Action hooks
     * @since 1.0.0
     * @access private
     * Feature added by : DroitLab Team
     */
    public function init_hooks(){
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'dl_template_front_script_load' ] );
        add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'dl_template_script_load' ] );
        add_action( 'elementor/preview/enqueue_styles', [ __CLASS__, 'enqueue_preview_styles' ] );
    }
    public static function dl_template_front_script_load() {
        
        //editor
        wp_register_style(
            'droit-el-template-front',
             Utils::droit_el_template_protocol( '/assets/css/template-frontend.min.css' ),
            ['elementor-frontend'],
            DROIT_EL_TEMPLATE_VERSION
        );
        wp_enqueue_style( 'droit-el-template-front' );  
    }

     public static function dl_template_script_load() {
        
        //editor
        wp_register_style(
            'droit-el-template-editor',
             Utils::droit_el_template_protocol( '/assets/css/template-library.min.css' ),
            ['elementor-editor'],
            DROIT_EL_TEMPLATE_VERSION
        );
        
        wp_enqueue_style( 'droit-el-template-editor' );  

        wp_enqueue_script(
            'droit-el-template-editor',
             Utils::droit_el_template_protocol( '/assets/js/template-library.min.js' ),
            ['elementor-editor'],
            DROIT_EL_TEMPLATE_VERSION,
            true
        );
       

        $localize_data = [
            'hasPro'                    => false,
            'templateLogo'                    => DROIT_EL_TEMPLATE_IMAGE . 'saasland.svg',
            'i18n' => [
                'templatesEmptyTitle'       => esc_html__( 'No Templates Found', 'droit-el-template-lite' ),
                'templatesEmptyMessage'     => esc_html__( 'Try different category or sync for new templates.', 'droit-el-template-lite' ),
                'templatesNoResultsTitle'   => esc_html__( 'No Results Found', 'droit-el-template-lite' ),
                'templatesNoResultsMessage' => esc_html__( 'Please make sure your search is spelled correctly or try a different words.', 'droit-el-template-lite' ),
            ],
        ];
        wp_localize_script(
            'droit-el-template-editor',
            'templateEditor',
            $localize_data
        );
    }

    public static function enqueue_preview_styles() {
        $data = '
        .elementor-add-new-section .elementor-add-lite-button {
            background-color: #6045bc;
            margin-left: 5px;
            font-size: 18px;
            vertical-align: bottom;
        }
        ';
        wp_add_inline_style( 'droit-el-template-front', $data );

    }
}