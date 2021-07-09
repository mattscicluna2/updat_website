<?php
/**
 * @package droitElementorTemplate
 * @developer DroitLab Team
 *
 */

namespace DROIT_ELEMENTOR_TEMPLATE\Templates;

use Elementor\TemplateLibrary\Source_Base;
use Elementor\TemplateLibrary\Source_Remote;
use Elementor\TemplateLibrary\Classes\Images;
use Elementor\Api;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {exit;}

/**
 * Elementor template library remote source.
 * 
 */
class Library_Api extends Source_Base {
	
	/**
	 * New library option key.
	 * @since 1.0.0
	 */
	const LIBRARY_OPTION_KEY = 'saasland_library_info';

	/**
	 * Timestamp cache key to trigger library sync.
	 * @since 1.0.0
	 */
	const LIBRARY_TIMESTAMP_CACHE_KEY = 'saasland_remote_update_timestamp';

	/**
	 * API info URL.
	 * Holds the URL of the info API.
	 * @access public
	 * @static
	 * @var string API info URL.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	const API_INFO_URL = 'https://templates.droitthemes.com/wp-json/saasland/v1/templates-info.json';

	/**
	 * API get template content URL.
	 *
	 * Holds the URL of the template content API.
	 * @access private
	 * @static
	 * @var string API get template content URL.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	const API_DATA_URL = 'https://templates.droitthemes.com/wp-json/saasland/templates/%d.json';

	/**
	 * Get remote template ID.
	 *
	 * Retrieve the remote template ID.
     * @access public
	 * @return string The remote template ID.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	public function get_id() {
		return 'saasland-library';
	}

	/**
	 * Get remote template title.
	 *
	 * Retrieve the remote template title.
     * @access public
     * @return string The remote template title.
     * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function get_title() {
		return __( 'Saasland Library', 'droit-el-template-lite' );
	}

	/**
	 * Register remote template data.
	 *
	 * Used to register custom template data like a post type, a taxonomy or any
	 * other data.
	 *
	 * @access public
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function register_data() {}

	

	/**
	 * Get remote templates.
	 *
	 * Retrieve remote templates from servers.
	 *
	 * @access public
	 *
	 * @param array $args Optional. Now used in remote source.
	 *
	 * @return array Remote templates.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function get_items( $args = [] ) {
		$library_data = self::get_library_data();

		$templates = [];

		if ( ! empty( $library_data['templates'] ) ) {
			foreach ( $library_data['templates'] as $template_data ) {
				$templates[] = $this->prepare_template( $template_data );
			}
		}

		return $templates;
	}

	/**
	 * Get template Tags
	 * @access public
	 * @return array Remote templates.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function get_tags() {
		$library_data = self::get_library_data();

		return ( ! empty( $library_data['tags'] ) ? $library_data['tags'] : [] );
	}

	/**
	 * Get template Tags Type
	 * @access public
	 * @return array Remote templates.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function get_type_tags() {
		$library_data = self::get_library_data();

		return ( ! empty( $library_data['type_tags'] ) ? $library_data['type_tags'] : [] );
	}

	/**
	 * repare template items to match model
	 * @access private
	 * @return array Remote templates.
	 * @param array $template_data
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	private function prepare_template( array $template_data ) {
		return [
			'template_id' => $template_data['id'],
			'title'       => $template_data['title'],
			'type'        => $template_data['type'],
			'thumbnail'   => $template_data['thumbnail'],
			'date'        => $template_data['created_at'],
			'tags'        => $template_data['tags'],
			'isPro'       => $template_data['is_pro'],
			'url'         => $template_data['url'],
			'liveurl'     => $template_data['liveurl'],
			'favorite' 	  => ! empty( $template_data['id'] ),
		];
	}

	/**
	 * Get template library content.
	 *
	 * Retrieve the templates content received from a remote server.
	 * @access private
	 * @return array Remote templates.
	 * @param array $template_data
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	private static function request_library_data( $force_update = false ) {
		$data = get_option( self::LIBRARY_OPTION_KEY );

		$elementor_update_timestamp = get_option( '_transient_timeout_elementor_remote_info_api_data_' . ELEMENTOR_VERSION );
		$update_timestamp = get_transient( self::LIBRARY_TIMESTAMP_CACHE_KEY );

		if ( $force_update || false === $data || ! $update_timestamp || $update_timestamp != $elementor_update_timestamp ) {
			$timeout = ( $force_update ) ? 25 : 8;

			$response = wp_remote_get( self::API_INFO_URL, [
				'timeout' => $timeout,
			] );

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				update_option( self::LIBRARY_OPTION_KEY, [] );
				return false;
			}

			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $data ) || ! is_array( $data ) ) {
				update_option( self::LIBRARY_OPTION_KEY, [] );
				set_transient( self::LIBRARY_TIMESTAMP_CACHE_KEY, [], 2 * HOUR_IN_SECONDS );
				return false;
			}

			update_option( self::LIBRARY_OPTION_KEY, $data, 'no' );

		}

		return $data;
	}

	/**
	 * Get template library data.
	 *
	 * Retrieve the templates content received from a remote server.
	 * @access private
	 * @return array Remote templates.
	 * @param array $template_data
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	public static function get_library_data( $force_update = false ) {
		self::request_library_data( $force_update );

		$library_data = get_option( self::LIBRARY_OPTION_KEY );

		if ( empty( $library_data ) ) {
			return [];
		}

		return $library_data;
	}

	/**
	 * Get template item.
	 *
	 * Retrieve remote templates from servers.
	 * @access private
	 * @return array Remote templates.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}
	/**
	 * Save remote template.
	 *
	 * Remote template from servers cannot be saved on the
	 * database as they are retrieved from remote servers.
	 *
	 * @access public
	 *
	 * @param array $template_data Remote template data.
	 *
	 * @return \WP_Error
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a saasland library' );
	}
	/**
	 * Update remote template.
	 *
	 * Remote template from servers cannot be updated on the
	 * database as they are retrieved from remote servers.
	 *
	 * @access public
	 *
	 * @param array $new_data New template data.
	 *
	 * @return \WP_Error
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a saasland library' );
	}

	/**
	 * Delete remote template.
	 *
	 * Remote template from servers cannot be deleted from the
	 * database as they are retrieved from remote servers.
	 *
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a saasland library' );
	}

	/**
	 * Export remote template.
	 *
	 * Remote template from servers cannot be exported from the
	 * database as they are retrieved from remote servers.
	 *
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	
	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a saasland library' );
	}
	/**
	 * Get template data.
	 *
	 * Retrieve remote templates from servers.
	 * @access private
	 * @return array Remote templates.
	 * @param array $template_id
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	public static function request_template_data( $template_id ) {
		if ( empty( $template_id ) ) {
			return;
		}

		$body = [
			'site_lang' => get_bloginfo( 'language' ),
			'home_url' => trailingslashit( home_url() ),
			'template_version' => DROIT_EL_TEMPLATE_VERSION,
		];
		$body_args = apply_filters( 'elementor/api/get_templates/body_args', $body );
		$url = sprintf( self::API_DATA_URL, $template_id );
		$response = wp_remote_get(
			$url,
			[
				'body' => $body_args,
				'timeout' => 10
			]
		);

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Get remote template data.
	 * 
	 * Retrieve the data of a single remote template from servers.
	 * @return array|\WP_Error Remote Template data.
	 * @since 1.0.0
     * Feature added by : DroitLab Team
	 */
	public function get_data( array $args, $context = 'display' ) {
		$data = self::request_template_data( $args['template_id'] );

		
		$data = json_decode( $data, true );
		if ( empty( $data ) || empty( $data['content'] ) ) {
			throw new \Exception( __( 'Template does not have any content', 'droit-el-template-lite' ) );
		}

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id = $args['editor_post_id'];
		$document = Plugin::$instance->documents->get( $post_id );
		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}
}
