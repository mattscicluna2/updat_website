<?php
namespace SaaslandCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor icon widget.
 *
 * Elementor widget that displays an icon from over 600+ icons.
 *
 * @since 1.0.0
 */
class Animated_icon extends Widget_Base {


    public function get_name() {
        return 'saasnald_animated_icon';
    }

    public function get_title() {
        return __( 'Animated Icon', 'saasland-core' );
    }

    public function get_icon() {
        return 'eicon-favorite';
    }

    public function get_categories() {
        return [ 'saasland-elements' ];
    }

    public function get_keywords() {
        return [ 'icon', 'animate' ];
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __( 'Icon', 'saasland-core' ),
            ]
        );
        $this->add_control(
            'lordicons',
            [
                'label'      => __( 'LordIcon', 'saasland-core' ),
                'type'       => Controls_Manager::SELECT,
                'options'    => saasland_lordicon_lists(),
                'default'    => '20-love-heart-solid',
                'label_block'=> true,

            ]
        );
        $this->add_control(
            'icon_animation',
            [
                'label'      => __( 'Animation', 'saasland-core' ),
                'type'       => Controls_Manager::SELECT,
                'options'    => saasland_lord_icon_animation(),
                'label_block'=> true,
                'default'    => 'auto',

            ]
        );
        
        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'saasland-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'saasland-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'saasland-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'saasland-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .lordicon_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'lordicon_style',
            [
                'label' => __( 'Style', 'saasland-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'saasland-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ]
            ]
        );
        $this->add_control(
            'lord_icon_color1',
            [
                'label' => __( 'Icon Color One', 'saasland-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );
        $this->add_control(
            'lord_icon_color2',
            [
                'label' => __( 'Icon Color Two', 'saasland-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );
        $this->add_control(
            'lord_icon_bg',
            [
                'label' => __( 'Icon Background', 'saasland-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} lord-icon' => 'background: {{VALUE}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'lordicon_border',
                'label' => __( 'Border', 'saasland-core' ),
                'selector' => '{{WRAPPER}} lord-icon',
            ]
        );
        $this->add_control(
            'lordicon_border_radius',
            [
                'label' => __( 'Border Radius', 'saasland-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} lord-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'lordicon_box_shadow',
                'label' => __( 'Box Shadow', 'saasland-core' ),
                'selector' => '{{WRAPPER}} lord-icon',
            ]
        );
        $this->add_control(
            'lordicon_margin',
            [
                'label' => __( 'Margin', 'saasland-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} lord-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'lordicon_padding',
            [
                'label' => __( 'Padding', 'saasland-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} lord-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();


    }

    /**
     * Render icon widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();


        $icon       = !empty( $settings['lordicons'] ) ? $settings['lordicons'] : '248-smartphone-rotate-arrow-outline';
        $icon_size  = !empty( $settings['icon_size']['size'] ) ? $settings['icon_size']['size'] : '';
        $animation  = !empty( $settings['icon_animation'] ) ? $settings['icon_animation'] : 'auto';
        $palette1  = !empty( $settings['lord_icon_color1'] ) ? $settings['lord_icon_color1'].';' : '';
        $palette2  = !empty( $settings['lord_icon_color2'] ) ? $settings['lord_icon_color2'].';' : ''; ?>

        <div class="lordicon_wrap">
            <?php echo saasland_render_lordicon( ['icon' => $icon, 'size' => $icon_size, 'animation' => $animation, 'palette' => $palette1.$palette2 ]); ?>
        </div>
        <?php
    }
}
