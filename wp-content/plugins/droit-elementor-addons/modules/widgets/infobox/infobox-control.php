<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Infobox;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Typography;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \DROIT_ELEMENTOR\Utils as Droit_Utils;

if (!defined('ABSPATH')) { exit;}

abstract class Infobox_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_infobox_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    // Skin
    public function register_infobox_skin_section_controls()
    {
        $this->start_controls_section(
            '_infobox_skin_section',
            [
                'label' => esc_html__('Skin', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            '_infobox_skin',
            [
                'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options'   => [
                    '_skin_1' => 'Style 01',
                    '_skin_2' => 'Style 02',
                    '_skin_3' => 'Style 03',
                ],
                'default' => '_skin_1'
            ]
        );

    $this->end_controls_section();
    }

    // Image/Icon
    public function register_infobox_image_icon_section_controls()
    {

        $this->start_controls_section(
            '_infobox_image_section',
            [
                'label' => esc_html__('Image/Icon', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

       
        $this->add_control(
            '_free_media_type',
            [
                'label'          => __('Media Type', 'droit-elementor-addons'),
                'type'           => Controls_Manager::CHOOSE,
                'label_block'    => false,
                'options'        => [
                    '_free_icon'  => [
                        'title' => __('Icon', 'droit-elementor-addons'),
                        'icon'  => 'fa fa-smile-o',
                    ],

                    '_free_image' => [
                        'title' => __('Image', 'droit-elementor-addons'),
                        'icon'  => 'fa fa-image',
                    ],
                ],
                'default'        => '_free_image',
                'toggle'         => false,
                'style_transfer' => true,
            ]
        );
        if (!did_action('droitPro/loaded')) {
             $this->add_control(
                '_free_info_icon',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw'  => Droit_Control_Manager::droit_information_control([
                        'icon'     => drdt_core()->images. "pro_icon.svg",
                        'title'    => __('Icon feature', 'droit-elementor-addons'),
                        'messages' => __('Coming...', 'droit-elementor-addons'),
                    ]),
                    'condition' => [
                        '_free_media_type' => '_free_icon',
                    ],
                ]
            );
        }
        $this->add_control(
            '_free_info_image',
            [
                'label'     => __('Image', 'droit-elementor-addons'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    '_free_media_type' => ['_free_image'],
                ],
                'dynamic'   => [
                    'active' => true,
                ],
            ]
        );
        $this->add_control(
            '_free_info_shape_bg',
            [
                'label'       => __('Shape Background', 'droit-elementor-addons'),
                'type'        => Controls_Manager::COLOR,
                
                'default'     => '#FFF5F8',
                'condition'   => [ 
                    '_infobox_skin' => ['_skin_1'],
                    '_free_media_type' => ['_free_image'],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .style_1 .info_box_icon_wrap .info_box_icon.shape_1:after' => 'background: {{VALUE}};',
                ],
                'description' => __('Change Shape Background Color', 'droit-elementor-addons'),

            ]
        );
        $this->add_control(
            '_free_info_gradian_color_a',
            [
                'label'       => __('Color', 'droit-elementor-addons'),
                'type'        => Controls_Manager::COLOR,
                
                'default'     => '#FF6685',
                'condition'   => [ 
                    '_infobox_skin' => ['_skin_3'],
                    '_free_media_type' => ['_free_image'],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .info_box_icon' => 'background-color: {{VALUE}};',
                ],
                'description' => __('Change Background Color', 'droit-elementor-addons'),

            ]
        );
        $this->add_control(
            '_free_info_color_stop_a',
            [
                'label' => esc_html__( 'Location', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'render_type' => 'ui',
                'condition' => [
                    '_infobox_skin' => ['_skin_3'],
                    '_free_media_type' => ['_free_image'],
                ],
            ]
        );
        $this->add_control(
            '_free_info_gradian_color_b',
            [
                'label' => esc_html__( 'Second Color', 'droit-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#FF92D6',
            'render_type' => 'ui',
            'condition' => [
                '_infobox_skin' => ['_skin_3'],
                '_free_media_type' => ['_free_image'],
            ],
           
            ]
        );
        $this->add_control(
            '_free_info_color_stop_b',
            [
                'label' => esc_html__( 'Location', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'render_type' => 'ui',
                'condition' => [
                    '_infobox_skin' => ['_skin_3'],
                    '_free_media_type' => ['_free_image'],
                ],
            ]
        );
        $this->add_control(
            '_free_info_gradient_type',
            [
                'label' => esc_html__( 'Type', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'linear' => esc_html__( 'Linear', 'droit-elementor-addons' ),
                    'radial' => esc_html__( 'Radial', 'droit-elementor-addons' ),
                ],
                'default' => 'linear',
                'render_type' => 'ui',
                'condition' => [
                     '_infobox_skin' => ['_skin_3'],
                    '_free_media_type' => ['_free_image'],
                ],
            ]
        );
        $this->add_control(
            '_free_info_gradient_angel',
            [
                'label' => esc_html__( 'Angle', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'default' => [
                    'unit' => 'deg',
                    'size' => 180,
                ],
                'range' => [
                    'deg' => [
                        'step' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .layout_three' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{_free_info_gradian_color_a.VALUE}} {{_free_info_color_stop_a.SIZE}}{{_free_info_color_stop_a.UNIT}}, {{_free_info_gradian_color_b.VALUE}} {{_free_info_color_stop_b.SIZE}}{{_free_info_color_stop_b.UNIT}})',
                ],
                'condition' => [
                     '_infobox_skin' => ['_skin_3'],
                    '_free_media_type' => ['_free_image'],
                    '_free_info_gradient_type' => 'linear',
                ],
            ]
        );
        $this->add_control(
            '_free_info_gradient_position',
            [
                'label' => esc_html__( 'Position', 'droit-elementor-addons' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'center center' => esc_html__( 'Center Center', 'droit-elementor-addons' ),
                'center left' => esc_html__( 'Center Left', 'droit-elementor-addons' ),
                'center right' => esc_html__( 'Center Right', 'droit-elementor-addons' ),
                'top center' => esc_html__( 'Top Center', 'droit-elementor-addons' ),
                'top left' => esc_html__( 'Top Left', 'droit-elementor-addons' ),
                'top right' => esc_html__( 'Top Right', 'droit-elementor-addons' ),
                'bottom center' => esc_html__( 'Bottom Center', 'droit-elementor-addons' ),
                'bottom left' => esc_html__( 'Bottom Left', 'droit-elementor-addons' ),
                'bottom right' => esc_html__( 'Bottom Right', 'droit-elementor-addons' ),
            ],
            'default' => 'center center',
            'selectors' => [
                '{{WRAPPER}} .layout_three' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{_free_info_gradian_color_a.VALUE}} {{_free_info_color_stop_a.SIZE}}{{_free_info_color_stop_a.UNIT}}, {{_free_info_gradian_color_b.VALUE}} {{_free_info_color_stop_b.SIZE}}{{_free_info_color_stop_b.UNIT}})',
            ],
            'condition' => [
                '_infobox_skin' => ['_skin_3'],
                '_free_media_type' => ['_free_image'],
                '_free_info_gradient_type' => 'radial',
            ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => '_free_info_image',
                'default'   => 'full',
                'separator' => 'none',
                'condition' => [
                    '_free_media_type' => '_free_info_image',
                ],
            ]
        );

        $this->add_responsive_control(
            '_free_image_align',
            [
                'label'     => __('Image Alignment', 'droit-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .info_box_icon_wrap'   => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    '_free_media_type' => ['_free_image'],
                ],
            ]
        );

        $this->add_responsive_control(
            '_free_shape_align',
            [
                'label'     => __('Shape Alignment', 'droit-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    '-13px' => [
                        'title' => __('Left', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    '50%'   => [
                        'title' => __('Center', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    '70%'   => [
                        'title' => __('Right', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .info_box_icon::after' => 'left: {{VALUE}};',
                ],
                'condition' => [
                    '_free_media_type' => ['_free_image'],
                    '_infobox_skin' => '_skin_1',
                ],
            ]
        );

        $this->end_controls_section();
    }
    public function register_infobox_image_style_section_controls(){

        $this->start_controls_section(
            'section_style_title',
            [
                'label'     => __('Image/Icon', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    '_free_media_type' => ['_free_image'],
                ],
            ]
        );
        $this->add_control(
            '_free_infobox_image_width',
            [
                'label'      => __('Width', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'   => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],

                'selectors'  => [
                    '{{WRAPPER}} .info_box_icon img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_free_infobox_image_height',
            [
                'label'      => __('Height', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'   => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em'  => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],

                'selectors'  => [
                    '{{WRAPPER}} .info_box_icon img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            '_free_image_ofset',
            [
                'label'        => __('Offset', 'droit-elementor-addons'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_on'     => __('Custom', 'droit-elementor-addons'),
                'label_off'    => __('None', 'droit-elementor-addons'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'image_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    '_free_image_ofset' => 'yes',
                ],
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'image_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'condition'  => [
                    '_free_image_ofset' => 'yes',
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dl-infobox-content-area' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .info_box_icon'  => '-ms-transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .info_box_icon'   => '-ms-transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .info_box_icon'   => '-ms-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'image_spacing',
            [
                'label'      => __('Spacing', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .info_box_icon_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->add_responsive_control(
            'image_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .info_box_icon_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->end_controls_section();
    }
//Content
public function register_infobox_content_section_controls(){

        $this->start_controls_section(
            '_infobox_content_section',
            [
                'label' => esc_html__('Info Box Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            '_infobox_title',
            [
                'label' => esc_html__( 'Title', 'droit-elementor-addons' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Type Info Box Title', 'droit-elementor-addons' ),
                'default' => __( 'Droit info box Title', 'droit-elementor-addons' ),
                'description' => __( 'Droit info box title goes here', 'droit-elementor-addons' ),
                'dynamic' => [
                    'active' => false,
                ]
            ]
        );

        $this->add_control(
            '_infobox_content',
            [
                'label' => esc_html__( 'Description', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Elements blocks from a range of categories to build pages that are rich in visual style.', 'droit-elementor-addons' ),
                'placeholder' => __( 'Type info box description.', 'droit-elementor-addons' ),
                'description' => __( 'Droit info box description goes here', 'droit-elementor-addons' ),
                'rows' => 6,
                'dynamic' => [
                    'active' => false,
                ]
            ]
        );

        $this->add_control(
            '_infobox_btn',
            [
                'label' => esc_html__( 'Button Text', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __( 'Learn More', 'droit-elementor-addons' ),
                'placeholder' => __( 'Type info box button text.', 'droit-elementor-addons' ),
                'description' => __( 'Droit info box button text goes here', 'droit-elementor-addons' ),
                'condition'   => [ 
                    '_infobox_skin!' => '_skin_1',
                ],
                'dynamic' => [
                    'active' => false,
                ]
            ]
        );
        $this->add_control(
            '_infobox_link',
            [
                'label' => esc_html__( 'Link', 'droit-elementor-addons' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#'
                ],
                'placeholder' => 'https://example.com',
                'dynamic' => [
                    'active' => false,
                ]
            ]
        );

        $this->add_control(
            '_infobox_title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'droit-elementor-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'label_block' => true,
                'description' => __( 'Choose info box title tag.', 'droit-elementor-addons' ),
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
                ],
                'default' => 'h4',
            ]
        );

        $this->end_controls_section();
}
//General
public function _droit_register_dl_infobox_general_style_controls(){
    $this->start_controls_section(
        '_dl_infobox_style_general',
        [
            'label' => esc_html__('General', 'droit-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    
    $this->add_responsive_control(
        '_dl_infobox_margin',
        [
            'label' => esc_html__('Margin', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .infobox-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
   
    $this->end_controls_section();
}
// Title Style
public function register_style_infobox_title_section_controls(){
    $this->start_controls_section(
        '_infobox_style_title',
        [
            'label' => esc_html__('Title', 'droit-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );

        $this->start_controls_tabs( '_infobox_tabs_title_style' );
   $this->start_controls_tab(
            '_title_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'droit-elementor-addons' ),
            ]
        );
    $this->add_control(
        '_infobox_title_color',
        [
            'label'     => __('Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-title' => 'color: {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_title_opacity',
        [
            'label'     => __('Opacity', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-title' => 'opacity: {{SIZE}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Css_Filter::get_type(),
        [
            'name'     => '_infobox_title_filter_css',
            'selector' => '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-title',
        ]
    );
    $this->add_control(
        '_infobox_title_ofset',
        [
            'label'        => __('Offset', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
        ]
    );

    $this->start_popover();

    $this->add_responsive_control(
        '_infobox_title_offset_x',
        [
            'label'       => __('Offset Left', 'droit-elementor-addons'),
            'type'        => Controls_Manager::SLIDER,
            'size_units'  => ['px', '%', 'em', 'rem'],
            'condition'   => [
                '_infobox_title_ofset' => 'yes',
            ],
            'range'       => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ],
            ],
            'render_type' => 'ui',
        ]
    );

    $this->add_responsive_control(
        '_infobox_title_offset_y',
        [
            'label'      => __('Offset Top', 'droit-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'condition'  => [
                '_infobox_title_ofset' => 'yes',
            ],
            'range'      => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .droit-infobox-title' => 'margin-top: {{SIZE}}{{UNIT}};',
                '(desktop){{WRAPPER}} .droit-infobox-title'  => '-ms-transform: translate({{_infobox_title_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_title_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_title_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y.SIZE || 0}}{{UNIT}});',
                '(tablet){{WRAPPER}} .droit-infobox-title'   => '-ms-transform: translate({{_infobox_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                '(mobile){{WRAPPER}} .droit-infobox-title'   => '-ms-transform: translate({{_infobox_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_title_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                
            ],
        ]
    );

    $this->end_popover();

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name'     => '_infobox__typography',
            'label'    => 'Title Typography',
            'selector' => '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-title',
            'global'   => [
                'default' => '',
            ],
        ]
    );
    $this->end_controls_tab();

    $this->start_controls_tab(
                '_title_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'droit-elementor-addons' ),
                ]
            );
    $this->add_control(
        '_infobox_title_hover_color',
        [
            'label'     => __('Hover Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .infobox-container:hover .droit-infobox-title' => 'color: {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_title_opacity_hover',
        [
            'label'     => __('Hover Opacity', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .infobox-container:hover .droit-infobox-title' => 'opacity: {{SIZE}};',
            ],
        ]
    );
    $this->end_controls_tab();

    $this->end_controls_tabs();
    $this->add_responsive_control(
        '_infobox_title_padding',
        [
            'label'      => __('Padding', 'droit-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
 
     $this->end_controls_section();
}
// Content Style
public function register_style_infobox_content_section_controls(){
    $this->start_controls_section(
        '_infobox_style_content',
        [
            'label' => esc_html__('Content', 'droit-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );
$this->start_controls_tabs( '_infobox_tabs_content_style' );
    $this->start_controls_tab(
            '_content_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'droit-elementor-addons' ),
            ]
        );
    $this->add_control(
        '_infobox_content_color',
        [
            'label'     => __('Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-description' => 'color: {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_content_opacity',
        [
            'label'     => __('Opacity', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-description' => 'opacity: {{SIZE}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Css_Filter::get_type(),
        [
            'name'     => '_infobox_content_filter_css',
            'selector' => '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-description',
        ]
    );
    $this->add_control(
        '_infobox_content_ofset',
        [
            'label'        => __('Offset', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
        ]
    );

    $this->start_popover();

    $this->add_responsive_control(
        '_infobox_content_offset_x',
        [
            'label'       => __('Offset Left', 'droit-elementor-addons'),
            'type'        => Controls_Manager::SLIDER,
            'size_units'  => ['px', '%', 'em', 'rem'],
            'condition'   => [
                $this->get_control_id('_infobox_content_ofset') =>  [ 'yes' ],
            ],
            'range'       => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ],
            ],
            'render_type' => 'ui',
        ]
    );

    $this->add_responsive_control(
        '_infobox_content_offset_y',
        [
            'label'      => __('Offset Top', 'droit-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'condition'  => [
                $this->get_control_id('_infobox_content_ofset') =>  [ 'yes' ],
            ],
            'range'      => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .droit-infobox-description' => 'margin-top: {{SIZE}}{{UNIT}};',
                '(desktop){{WRAPPER}} .droit-infobox-description'  => '-ms-transform: translate({{_infobox_content_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_content_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_content_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y.SIZE || 0}}{{UNIT}});',
                '(tablet){{WRAPPER}} .droit-infobox-description'   => '-ms-transform: translate({{_infobox_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                '(mobile){{WRAPPER}} .droit-infobox-description'   => '-ms-transform: translate({{_infobox_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_content_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                
            ],
        ]
    );

    $this->end_popover();
    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name'     => '_infobox_content_typography',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-description',
            'global'   => [
                'default' => '',
            ],
        ]
    );
    $this->end_controls_tab();

    $this->start_controls_tab(
                '_content_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'droit-elementor-addons' ),
                ]
            );
    $this->add_control(
        '_infobox_content_hover_color',
        [
            'label'     => __('Hover Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .infobox-container:hover .droit-infobox-description' => 'color: {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_content_opacity_hover',
        [
            'label'     => __('Hover Opacity', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .infobox-container:hover .droit-infobox-description' => 'opacity: {{SIZE}};',
            ],
        ]
    );
    $this->end_controls_tab();

    $this->end_controls_tabs();
    $this->add_responsive_control(
        '_infobox_content_padding',
        [
            'label'      => __('Padding', 'droit-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();
    
}
 // Button
public function register_style_infobox_button_section_controls()
{

    $this->start_controls_section(
        '_infobox_section_style_button',
        [
            'label'     => __('Button', 'droit-elementor-addons'),
             'tab'   => Controls_Manager::TAB_STYLE,
             'condition'   => [
                $this->get_control_id('_infobox_skin!') =>  [ '_skin_1' ],
            ],
        ]
    );

    $this->start_controls_tabs( '_infobox_tabs_button_style' );
    $this->start_controls_tab(
            '_button_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'droit-elementor-addons' ),
            ]
        );
    $this->add_control(
        '_infobox_button_color',
        [
            'label'     => __('Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-button' => 'color: {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
  $this->add_control(
    '_infobox_button_bg_color',
    [
        'label'     => __('Background Color', 'droit-elementor-addons'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-button' => 'background-color: {{VALUE}};',
        ],
        'global'    => [
            'default' => '',
        ],
        
    ]
    );
  $this->add_control(
        '_infobox_button_border_color',
        [
            'label'     => __('Border Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-button' => 'border: 1px solid {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_button_opacity',
        [
            'label'     => __('Opacity', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-button' => 'opacity: {{SIZE}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Css_Filter::get_type(),
        [
            'name'     => '_infobox_button_filter_css',
            'selector' => '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-button',
        ]
    );
    $this->add_control(
        '_infobox_button_ofset',
        [
            'label'        => __('Offset', 'droit-elementor-addons'),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_on'     => __('Custom', 'droit-elementor-addons'),
            'label_off'    => __('None', 'droit-elementor-addons'),
            'return_value' => 'yes',
        ]
    );

    $this->start_popover();

    $this->add_responsive_control(
        '_infobox_button_offset_x',
        [
            'label'       => __('Offset Left', 'droit-elementor-addons'),
            'type'        => Controls_Manager::SLIDER,
            'size_units'  => ['px', '%', 'em', 'rem'],
            'condition'   => [
                $this->get_control_id('_infobox_button_ofset') =>  [ 'yes' ],
            ],
            'range'       => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ],
            ],
            'render_type' => 'ui',
        ]
    );

    $this->add_responsive_control(
        '_infobox_button_offset_y',
        [
            'label'      => __('Offset Top', 'droit-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'condition'  => [
                $this->get_control_id('_infobox_button_ofset') =>  [ 'yes' ],
            ],
            'range'      => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .droit-infobox-button' => 'margin-top: {{SIZE}}{{UNIT}};',
                '(desktop){{WRAPPER}} .droit-infobox-button'  => '-ms-transform: translate({{_infobox_button_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_button_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_button_offset_x.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y.SIZE || 0}}{{UNIT}});',
                '(tablet){{WRAPPER}} .droit-infobox-button'   => '-ms-transform: translate({{_infobox_button_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_button_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_button_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                '(mobile){{WRAPPER}} .droit-infobox-button'   => '-ms-transform: translate({{_infobox_button_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{_infobox_button_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{_infobox_button_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{_infobox_button_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                
            ],
        ]
    );

    $this->end_popover();

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name'     => '_infobox_button_typography',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-button',
            'global'   => [
                'default' => '',
            ],
        ]
    );
    $this->end_controls_tab();

    $this->start_controls_tab(
                '_button_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'droit-elementor-addons' ),
                ]
            );
    $this->add_control(
        '_infobox_button_hover_color',
        [
            'label'     => __('Text Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .infobox-container:hover .droit-infobox-button:hover' => 'color: {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_button_hover_bg_color',
        [
            'label'     => __('Background Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .infobox-container .droit-infobox-button:hover' => 'background-color: {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_button_hover_border_color',
        [
            'label'     => __('Border Color', 'droit-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .infobox-container .droit-infobox-button:hover' => 'border: 1px solid {{VALUE}};',
            ],
            'global'    => [
                'default' => '',
            ],
        ]
    );
    $this->add_control(
        '_infobox_button_opacity_hover',
        [
            'label'     => __('Opacity', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .infobox-container:hover .droit-infobox-button:hover' => 'opacity: {{SIZE}};',
            ],
        ]
    );
    $this->end_controls_tab();

    $this->end_controls_tabs();
    $this->add_responsive_control(
        '_infobox_button_padding',
        [
            'label'      => __('Padding', 'droit-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .dl-infobox-content-area .droit-infobox-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator'  => 'after',
        ]
    );

    $this->end_controls_section();
}

//Box Shadow
public function register_style_infobox_box_shadow_section_controls()
    {

        $this->start_controls_section(
            '_infobox_section_style_box',
            [
                'label'     => __('Box Shadow', 'droit-elementor-addons'),
                 'tab'   => Controls_Manager::TAB_STYLE,
                 'condition'   => [
                    $this->get_control_id('_infobox_skin') =>  [ '_skin_2', '_skin_3' ],
                ],
            ]
        );
        $this->start_controls_tabs( '_infobox_tabs_box_shadow_style' );
            $this->start_controls_tab(
                    '_infobox_box_shadow_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', 'droit-elementor-addons' ),
                    ]
                );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_infobox_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'droit-elementor-addons' ),
                'selector' => '{{WRAPPER}} .dl_single_info_box.style_2, {{WRAPPER}} .dl_single_info_box.style_5',
            ]
        );
         $this->end_controls_tab();

        $this->start_controls_tab(
                '_infobox_box_shadow_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'droit-elementor-addons' ),
                ]
            );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_infobox_hover_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'droit-elementor-addons' ),
                'selector' => '{{WRAPPER}} .dl_single_info_box.style_2:hover, {{WRAPPER}} .dl_single_info_box.style_5:hover',
            ]
        );
        $this->end_controls_tab();

    $this->end_controls_tabs();
        $this->end_controls_section();
    }
public function register_style_infobox_animation_section_controls()
{
    $this->start_controls_section(
        '_infobox_style_animation',
        [
            'label' => esc_html__('Animation', 'droit-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );
    $this->add_control(
        '_infobox_animation',
        [
            'label' => esc_html__( 'Title Animation', 'droit-elementor-addons' ),
            'type' => Controls_Manager::ANIMATION,
            
        ]
    );

    $this->end_controls_section();
}
// Aligment
public function register_infobox_alignment_section_controls()
{

        $this->start_controls_section(
            'section_style_alignment',
            [
                'label'     => __('Alignment', 'droit-elementor-addons'),
            ]
        );
         $this->add_responsive_control(
            '_free_image_icon_align',
            [
                'label'     => __('Image Alignment', 'droit-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'droit-elementor-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infobox-container'   => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    $this->get_control_id('_free_media_type') =>  [ '_free_image' ],
                ],
                'description' => __('Shape automatically alignment after refresh', 'droit-elementor-addons')
            ]
        );
        $this->end_controls_section();
}
   
}
