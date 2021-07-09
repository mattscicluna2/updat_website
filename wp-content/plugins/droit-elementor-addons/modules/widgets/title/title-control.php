<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Title;

use DROIT_ELEMENTOR\Core\Utils as Droit_Utils;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {exit;}

abstract class Title_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_title_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
	//Preset
   public function _droit_register_dl_title_preset_controls() {
		$this->start_controls_section(
			'_dl_title_preset_section',
			[
				'label' => __( 'Preset', 'droit-elementor-addons' ),
			]
		);

        $this->add_control(
		    '_dl_title_skin',
		    [
			    'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
			    'type' => Controls_Manager::SELECT,
			    'label_block' => false,
                'options' => apply_filters('dl_widgets/lite/title/control_presets', [
                    '_skin_1' => 'Design 1',
                ]),
			    'default' => '_skin_1'
		    ]
        );
        
        $this->add_control(
            'show_dl_title_sub_revars',
            [
                'label'     => __('Title & Sub Title Position Reverse', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Yes', 'droit-elementor-addons'),
                'label_off' => __('No', 'droit-elementor-addons'),
                'default'   => 'no',
            ]
        );

		$this->end_controls_section();
	}
   
	
    //Content Title Section
    public function _droit_register_dl_dtitle_content_controls(){
        $this->start_controls_section(
            '_dl_title_content_section',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
            ]
        );
        $this->add_control(
            'show_dl_title',
            [
                'label'     => __('Title Text', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'default'   => 'yes',
                'condition' => [
                    $this->get_control_id('_dl_title_skin') => ['_skin_1'],
                ],
            ]
        );

        $this->add_control(
            'dl_title_tag',
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
                'default' => 'h3',
                'toggle' => false,
                'condition' => [
                    $this->get_control_id('show_dl_title') => ['yes'],
                ],

            ]
        );
        
        $this->add_control(
            '_dl_title_text',
            [
                'label' => __( 'Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Droit Element Addons', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter Your Title Text', 'droit-elementor-addons' ),
                'description' => __( 'Highlighted text must be write in { }. Example : Welcome to { Our Website }', 'droit-elementor-addons' ),
                'label_block' => true,
                'condition' => [
                    $this->get_control_id('show_dl_title') => ['yes'],
                ],
            ]
        );

    $this->end_controls_section();
}

 //Content Sub Title Section
 public function _droit_register_dl_sub_dtitle_content_controls(){
    $this->start_controls_section(
        '_dl_sub_title_content_section',
        [
            'label' => __( 'Sub Title', 'droit-elementor-addons' ),
        ]
    );
    $this->add_control(
        'show_dl_sub_title',
        [
            'label'     => __('Sub Title Text', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('Show', 'droit-elementor-addons'),
            'label_off' => __('Hide', 'droit-elementor-addons'),
            'default'   => 'yes',
            'condition' => [
                $this->get_control_id('_dl_title_skin') => ['_skin_1'],
            ],
        ]
    );

    $this->add_control(
        'dl_sub_title_tag',
        [
            'label' => __( 'Sub Title HTML Tag', 'droit-elementor-addons' ),
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
            'default' => 'h4',
            'toggle' => false,
            'condition' => [
                $this->get_control_id('show_dl_sub_title') => ['yes'],
            ],

        ]
    );
    
    $this->add_control(
        '_dl_sub_title_text',
        [
            'label' => __( 'Sub Title Text', 'droit-elementor-addons' ),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __( 'Droit Addons For Elementor', 'droit-elementor-addons' ),
            'placeholder' => __( 'Enter Your Title Text', 'droit-elementor-addons' ),
            'label_block' => true,
            'condition' => [
                $this->get_control_id('show_dl_sub_title') => ['yes'],
            ],
        ]
    );

$this->end_controls_section();
 //End Sub Title content Section  
}

//Content Text Section
public function _droit_register_dl_tcontent_content_controls(){
    $this->start_controls_section(
        '_dl_tcontent_content_section',
        [
            'label' => __( 'Content', 'droit-elementor-addons' ),
        ]
    );
    $this->add_control(
        'show_dl_tcontent',
        [
            'label'     => __('Show/Hide', 'droit-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('Show', 'droit-elementor-addons'),
            'label_off' => __('Hide', 'droit-elementor-addons'),
            'default'   => 'yes',
            'condition' => [
                $this->get_control_id('_dl_title_skin') => ['_skin_1'],
            ],
        ]
    );

    $this->add_control(
        '_dl_tcontent_text',
        [
            'label' => __( 'Text', 'droit-elementor-addons' ),
            'type' => Controls_Manager::WYSIWYG,
            'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'droit-elementor-addons' ),
            'placeholder' => __( 'Enter Your Content', 'droit-elementor-addons' ),
            'label_block' => true,
            'condition' => [
                $this->get_control_id('show_dl_tcontent') => ['yes'],
            ],
        ]
    );

$this->end_controls_section();
 //Content content Section  
}

//Title Style
public function _droit_register_dl_title_text_style_controls(){
    $this->start_controls_section(
        '_dl_title_style_title',
        [
            'label' => esc_html__('Title', 'droit-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                 $this->get_control_id('show_dl_title') => ['yes'],
                 $this->get_control_id('_dl_title_text!') => '',
            ]
        ]
    );
    $this->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => 'title_background',
            'label' => esc_html__('Background Color', 'droit-elementor-addons'),
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .dl_title_section .dl_title_text',
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => '_dl_title_text_typography',
            'selector' => '{{WRAPPER}} .dl_title_section .dl_title_text',
        ]
    );
    $this->add_control(
        '_dl_title_text_color',
        [
            'label' => esc_html__('Text Color', 'droit-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_title_text' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        '_dl_title_text_align',
        [
            'label'     => __('Text Alignment', 'droit-elementor-addons'),
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
                '{{WRAPPER}} .dl_title_section .dl_title_text'   => 'text-align: {{VALUE}};',
            ],
        ]
    );
    $this->add_responsive_control(
        '_dl_title_text_margin',
        [
            'label' => esc_html__('Margin', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_title_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    $this->add_responsive_control(
        '_dl_title_text_padding',
        [
            'label' => esc_html__('Padding', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_title_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();


    $this->start_controls_section(
        '_dl_high_title_style_title',
        [
            'label' => esc_html__('Highlighted Text', 'droit-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => '_dl_title_text',
                        'operator' => '!=',
                        'value' => ''
                    ],
                    [
                        'name' => '_dl_sub_title_text',
                        'operator' => '!=',
                        'value' => ''
                    ],
                    [
                        'name' => '_dl_tcontent_text',
                        'operator' => '!=',
                        'value' => ''
                    ]
                ]
            ]
        ]
    );
    $this->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => 'high_title_background',
            'label' => esc_html__('Background Color', 'droit-elementor-addons'),
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .dl_title_section .dl_title_text span',
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => '_dl_high_title_text_typography',
            'selector' => '{{WRAPPER}} .dl_title_section .dl_title_text span',
        ]
    );
    $this->add_control(
        '_dl_high_title_text_color',
        [
            'label' => esc_html__('Text Color', 'droit-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_title_text span' => 'color: {{VALUE}};',
            ],
        ]
    );
    $this->end_controls_section();
}

//Sub Title Style
public function _droit_register_dl_sub_title_text_style_controls(){
    $this->start_controls_section(
        '_dl_sub_title_style_title',
        [
            'label' => esc_html__('Sub Title', 'droit-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                 $this->get_control_id('show_dl_sub_title') => ['yes'],
                 $this->get_control_id('_dl_sub_title_text!') => '',
            ]
        ]
    );

    $this->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => 'sub_title_background',
            'label' => esc_html__('Background Color', 'droit-elementor-addons'),
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .dl_title_section .dl_sub_title_text',
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => '_dl_sub_title_text_typography',
            'selector' => '{{WRAPPER}} .dl_title_section .dl_sub_title_text',
        ]
    );
    $this->add_control(
        '_dl_sub_title_text_color',
        [
            'label' => esc_html__('Text Color', 'droit-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_sub_title_text' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        '_dl_sub_title_text_align',
        [
            'label'     => __('Text Alignment', 'droit-elementor-addons'),
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
                '{{WRAPPER}} .dl_title_section .dl_sub_title_text'   => 'text-align: {{VALUE}};',
            ],
        ]
    );
    $this->add_responsive_control(
        '_dl_sub_title_text_margin',
        [
            'label' => esc_html__('Margin', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_sub_title_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    $this->add_responsive_control(
        '_dl_sub_title_text_padding',
        [
            'label' => esc_html__('Padding', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_sub_title_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();
}

//Content Style
public function _droit_register_dl_title_contnet_style_controls(){
    $this->start_controls_section(
        '_dl_title_content_style_title',
        [
            'label' => esc_html__('Content', 'droit-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                 $this->get_control_id('show_dl_tcontent') => ['yes'],
                 $this->get_control_id('_dl_tcontent_text!') => '',
            ]
        ]
    );
    
    $this->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => 'dl_content_text_background',
            'label' => esc_html__('Background Color', 'droit-elementor-addons'),
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .dl_title_section .dl_content_text',
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => '_dl_content_text_typography',
            'selector' => '{{WRAPPER}} .dl_title_section .dl_content_text',
        ]
    );
    $this->add_control(
        '_dl_content_text_color',
        [
            'label' => esc_html__('Text Color', 'droit-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_content_text' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        '_dl_content_text_align',
        [
            'label'     => __('Text Alignment', 'droit-elementor-addons'),
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
                '{{WRAPPER}} .dl_title_section .dl_content_text'   => 'text-align: {{VALUE}};',
            ],
        ]
    );
    $this->add_responsive_control(
        '_dl_content_text_margin',
        [
            'label' => esc_html__('Margin', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_content_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    $this->add_responsive_control(
        '_dl_content_text_padding',
        [
            'label' => esc_html__('Padding', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_title_section .dl_content_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();
}

}
