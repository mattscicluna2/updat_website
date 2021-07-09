<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Iconbox;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}

abstract class Iconbox_Control extends Widget_Base
{
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_iconbox_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }

    public function _droit_register_iconbox_controls() {
		$this->start_controls_section(
			'_iconbox_section_icon',
			[
				'label' => __( 'Icon Box', 'droit-elementor-addons' ),
			]
		);
		$this->add_control(
			'_iconbox_skin',
			[
				'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => false,
				'options'   => [
					'_skin_1' => 'Style 01',
					'_skin_2' => 'Style 02',
                    '_skin_3' => 'Style 03',
					'_skin_4' => 'Style 04',
					'_skin_5' => 'Style 05',
				],
				'default' => '_skin_1'
			]
		);
		$this->add_control(
			'_iconbox_selected_icon',
			[
				'label' => __( 'Icon', 'droit-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);
		$this->add_control(
            '_iconbox_shape_image', [
                'label'      => __('Background Shape', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => '',
                ],
                'show_label' => true,
                'condition' => [
					$this->get_control_id('_iconbox_skin') => [ '_skin_3' ],
                ],
            ]
        );

		$this->add_control(
			'_iconbox_view',
			[
				'label' => __( 'View', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'droit-elementor-addons' ),
					'stacked' => __( 'Stacked', 'droit-elementor-addons' ),
					'framed' => __( 'Framed', 'droit-elementor-addons' ),
				],
				'default' => 'default',
				'prefix_class' => 'droit-iconbox-view-',
			]
		);

		$this->add_control(
			'_iconbox_shape',
			[
				'label' => __( 'Shape', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'droit-elementor-addons' ),
					'square' => __( 'Square', 'droit-elementor-addons' ),
				],
				'default' => 'circle',
				'condition' => [
					$this->get_control_id('_iconbox_view!') => [ 'default' ],
					$this->get_control_id('_iconbox_selected_icon[value]!') => '',
				],
				'prefix_class' => 'droit-icon-shape-',
			]
		);

		$this->add_control(
			'_iconbox_title_text',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				
				'default' => __( 'This is the heading', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
				'label_block' => true,
				'condition' => [
					$this->get_control_id('_iconbox_skin!') => [ '_skin_1', '_skin_4' ],
                ],
			]
		);

		$this->add_control(
			'_iconbox_description_text',
			[
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				
				'default' => __( 'Premium Chat Support', 'droit-elementor-addons' ),
				'placeholder' => __( 'Enter your description', 'droit-elementor-addons' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => true,
			]
		);

		$this->add_control(
			'_iconbox_link',
			[
				'label' => __( 'Link', 'droit-elementor-addons' ),
				'type' => Controls_Manager::URL,
				
				'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'_iconbox_position',
			[
				'label' => __( 'Icon Position', 'droit-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'droit-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Top', 'droit-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'flex-end' => [
						'title' => __( 'Right', 'droit-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor-position-',
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper .dl_icon_wrapper' => 'justify-content: {{VALUE}};',	
				],
				'toggle' => false,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => '_iconbox_selected_icon[value]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
            '_iconbox_title_size',
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
                'default' => 'h5',
                'toggle' => false,
                'condition' => [
					$this->get_control_id('_iconbox_skin!') => [ '_skin_1', '_skin_4' ],
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'_iconbox_section_style_icon',
			[
				'label' => __( 'Icon', 'droit-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => '_iconbox_selected_icon[value]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);
 
		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'_iconbox_icon_colors_normal',
			[
				'label' => __( 'Normal', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_iconbox_primary_color',
			[
				'label' => __( 'Icon Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.droit-iconbox-view-default .dl_icon i, {{WRAPPER}}.droit-iconbox-view-stacked .dl_icon i, {{WRAPPER}}.droit-iconbox-view-framed .dl_icon i' => 'color: {{VALUE}};',

					'{{WRAPPER}}.droit-iconbox-view-default .dl_icon svg path, {{WRAPPER}}.droit-iconbox-view-stacked .dl_icon svg path, {{WRAPPER}}.droit-iconbox-view-framed .dl_icon svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_iconbox_primary_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper .dl_icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_view!') => [ 'framed' ],
				],
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_iconbox_primary_border_color',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .dl_icon_box_wrapper .dl_icon',
                'condition' => [
					$this->get_control_id('_iconbox_view') => [ 'framed' ],
				],
            ]
        );

		$this->add_control(
			'_iconbox_primary_bg_color_div',
			[
				'label' => __( 'Div Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#5CE1DA',
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper.droit-bg_color' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_skin') => [ '_skin_4', '_skin_5' ],
                ],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'_iconbox_icon_colors_hover',
			[
				'label' => __( 'Hover', 'droit-elementor-addons' ),
			]
		);

		$this->add_control(
			'_iconbox_hover_primary_color',
			[
				
				'label' => __( 'Icon Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.droit-iconbox-view-stacked .dl_icon:hover i, {{WRAPPER}}.droit-iconbox-view-framed .dl_icon:hover i' => 'color: {{VALUE}};',

					'{{WRAPPER}}.droit-iconbox-view-stacked .dl_icon:hover svg path, {{WRAPPER}}.droit-iconbox-view-framed .dl_icon:hover svg path' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'_iconbox_hover_primary_bg_color',
			[
				'label' => __( 'Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper .dl_icon:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_view!') => [ 'framed' ],
				],
			]
		);
		$this->add_control(
			'_iconbox_hover_primary_bg_color_div',
			[
				'label' => __( 'Div Background Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper.droit-bg_color:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_skin') => [ '_skin_4', '_skin_5' ],
                ],
			]
		);

		$this->add_control(
			'_iconbox_hover_animation',
			[
				'label' => __( 'Hover Animation', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'_iconbox_icon_space',
			[
				'label' => __( 'Spacing', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_icon_wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dl_icon_wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dl_icon_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .dl_icon_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'_iconbox_icon_size',
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
					'{{WRAPPER}} .dl_icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dl_icon svg' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'_iconbox_icon_padding',
			[
				'label' => __( 'Padding', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dl_icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
				],
				'size_units' => ['px', 'em', '%'],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					$this->get_control_id('_iconbox_view!') => [ 'default' ],
				],
			]
		);

		$this->add_control(
			'_iconbox_rotate',
			[
				'label' => __( 'Rotate', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .dl_icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .dl_icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'_iconbox_border_width',
			[
				'label' => __( 'Border Width', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .dl_icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_view') => [ 'framed' ],
				],
			]
		);

		$this->add_control(
			'_iconbox_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dl_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_view!') => [ 'default' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_iconbox_section_style_content',
			[
				'label' => __( 'Content', 'droit-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'_iconbox_text_align',
			[
				'label' => __( 'Alignment', 'droit-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'droit-elementor-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .droit-icon-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_iconbox_content_vertical_alignment',
			[
				'label' => __( 'Vertical Alignment', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => __( 'Top', 'droit-elementor-addons' ),
					'middle' => __( 'Middle', 'droit-elementor-addons' ),
					'bottom' => __( 'Bottom', 'droit-elementor-addons' ),
				],
				'default' => 'top',
				'prefix_class' => 'elementor-vertical-align-',
			]
		);

		$this->add_control(
			'_iconbox_heading_title',
			[
				'label' => __( 'Title', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id('_iconbox_skin!') => [ '_skin_1', '_skin_4' ],
                ],
			]
		);

		$this->add_responsive_control(
			'_iconbox_title_bottom_space',
			[
				'label' => __( 'Spacing', 'droit-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper .droit-icon-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_skin!') => [ '_skin_1', '_skin_4' ],
                ],
			]
		);

		$this->add_control(
			'_iconbox_title_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper .droit-icon-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id('_iconbox_skin!') => [ '_skin_1', '_skin_4' ],
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_iconbox_title_typography',
				'selector' => '{{WRAPPER}} .dl_icon_box_wrapper .droit-icon-title',
				'condition' => [
					$this->get_control_id('_iconbox_skin!') => [ '_skin_1', '_skin_4' ],
                ],
			]
		);

		$this->add_control(
			'_iconbox_heading_description',
			[
				'label' => __( 'Description', 'droit-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'_iconbox_description_color',
			[
				'label' => __( 'Color', 'droit-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .dl_icon_box_wrapper .droit-icon-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_iconbox_description_typography',
				'selector' => '{{WRAPPER}} .dl_icon_box_wrapper .droit-icon-description',
			]
		);
		
		$this->end_controls_section();
	}
}
