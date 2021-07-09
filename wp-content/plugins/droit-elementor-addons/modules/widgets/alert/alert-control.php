<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Alert;

use DROIT_ELEMENTOR\Utils as Droit_Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Core\Schemes;
use \Elementor\Widget_Base;

if (!defined('ABSPATH')) {exit;}

abstract class Alert_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_alert_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
	//Preset
   public function _droit_register_dl_alert_preset_controls() {
		$this->start_controls_section(
			'_dl_alert_preset_section',
			[
				'label' => __( 'Preset', 'droit-elementor-addons' ),
			]
        );
        $this->add_control(
			'_dl_alert_skin',
			[
				'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options'   => [
					'_skin_1' => 'Style 01',
				],
				'default' => '_skin_1'
			]
		);
		$this->add_control(
			'_dl_alert_design_format',
			[
				'label' => esc_html__( 'Alert Design', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options'   => [
					'dl_notice_alert'  => 'Notice Alert',
					'dl_info_alert'    => 'Info Alert',
                    'dl_error_alert'   => 'Error Alert',
					'dl_success_alert' => 'Success Alert',
					'dl_warning_alert' => 'Warning Alert',
					'dl_default_alert' => 'Default Alert',
				],
				'default' => 'dl_notice_alert'
			]
		);
		        
		$this->end_controls_section();
	}

	//Content
   public function _droit_register_dl_alert_content_controls(){
		$this->start_controls_section(
			'_dl_alert_content_section',
			[
				'label' => __( 'Alert Content', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_dl_alert_title',
			[
				'label' => __( 'Alert Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'The quickest & easiest service provider', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'_dl_alert_show_as_default',
			[
                'label' => __('Set as Default', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
			]
        );
        
        $this->add_control(
            '_dl_alert_title_size',
            [
                'label' => __( 'Title HTML Tag', 'droit-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'h1'  => [
                        'title' => __( 'H1', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h1'
                    ],
                    'h2'  => [
                        'title' => __( 'H2', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h2'
                    ],
                    'h3'  => [
                        'title' => __( 'H3', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h3'
                    ],
                    'h4'  => [
                        'title' => __( 'H4', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h4'
                    ],
                    'h5'  => [
                        'title' => __( 'H5', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h5'
                    ],
                    'h6'  => [
                        'title' => __( 'H6', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-h6'
                    ],
                    'p'  => [
                        'title' => __( 'P', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-paragraph'
                    ],
                ],
                'default' => 'p',
                'toggle' => false,
                
            ]
		);
		$this->add_control(
			'_dl_alert_icon_show',
			[
				'label' => __( 'Alert Icon', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'droit-elementor-addons' ),
				'label_off' => __( 'NO', 'droit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'_dl_alert_icon',
			[
				'label' => __( 'Alert Icon', 'droit-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-volume-up',
                    'library' => 'fa-solid',
                ],
			]
		);
		$this->add_control(
			'_dl_alert_cross_icon_show',
			[
				'label' => __( 'Alert Cross Icon', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'droit-elementor-addons' ),
				'label_off' => __( 'NO', 'droit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'_dl_alert_cross_icon',
			[
				'label' => __( 'Alert Cross Icon', 'droit-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'dlicon dlicon-cross',
                    'library' => 'fa-solid',
                ],
			]
		);
        $this->end_controls_section();

	}

	//General
	public function _droit_register_dl_alert_general_style_controls(){
		$this->start_controls_section(
            '_dl_alert_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'alert_background',
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01',
            ]
		);

		$this->add_control(
            '_dl_alert_box_border',
            [
                'label' => esc_html__('Border Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01' => 'border-color: {{VALUE}};',
                ],
            ]
		);
		$this->add_control(
			'_dl_alert_box_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
            '_dl_alert_box_margin',
            [
                'label' => esc_html__('Box Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		
		$this->add_responsive_control(
            '_dl_alert_box_padding',
            [
                'label' => esc_html__('Box Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		
        $this->end_controls_section();
	}

	//alert Title Style
	public function _droit_register_dl_alert_title_style_controls() {
		$this->start_controls_section(
            '_dl_alert_title_style_settings',
            [
                'label' => esc_html__('Alert Title', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_alert_title_typography',
                'selector' => '{{WRAPPER}} .dl_alert_box .dl_alert_desc',
            ]
        );
        $this->add_control(
            '_dl_alert_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box .dl_alert_desc' => 'color: {{VALUE}};',
                ],
            ]
		);
		$this->add_control(
			'_alert_title_opacity',
			[
				'label'     => __('Opacity', 'droit-elementor-addons'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 10,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_alert_box .dl_alert_desc' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->add_responsive_control(
			'_alert_title_padding',
			[
				'label'      => __('Padding', 'droit-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .dl_alert_box .dl_alert_desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            '_dl_alert_icon_style_settings',
            [
                'label' => esc_html__('Alert Icon', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
		);
		$this->add_control(
            '_dl_alert_icon_bg_color',
            [
                'label' => esc_html__('Icon Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_desc i' => 'background-color: {{VALUE}};',
                ],
            ]
		);
		$this->add_control(
            '_dl_alert_icon_color',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_desc i' => 'color: {{VALUE}};',
                ],
            ]
		);
		$this->add_responsive_control(
			'_dl_alert_icon_size',
			[
				'label' => __( 'Icon Size', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_desc i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_desc svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'_alert_icon_padding',
			[
				'label'      => __('Padding', 'droit-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_desc i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            '_dl_alert_cross_icon_style_settings',
            [
                'label' => esc_html__('Cross Icon', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
		);
		$this->add_control(
            '_dl_alert_cross_icon_bg_color',
            [
                'label' => esc_html__('Icon Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_close i' => 'background-color: {{VALUE}};',
                ],
            ]
		);
		$this->add_control(
            '_dl_alert_cross_icon_color',
            [
                'label' => esc_html__('Icon Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_close i' => 'color: {{VALUE}};',
                ],
            ]
		);
		$this->add_responsive_control(
			'_dl_alert_cross_icon_size',
			[
				'label' => __( 'Icon Size', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_close i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_close svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'_alert_cross_icon_padding',
			[
				'label'      => __('Padding', 'droit-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .dl_alert_box.dl_alert_box_style_01 .dl_alert_close i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->end_controls_section();
	}

}

