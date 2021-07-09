<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Newstricker;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}

abstract class Newstricker_Control extends Widget_Base
{
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_newstricker_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
	//Preset
   public function _droit_register_dl_newstricker_preset_controls() {
		$this->start_controls_section(
			'_dl_newstricker_preset_section',
			[
				'label' => __( 'Preset', 'droit-elementor-addons' ),
			]
		);

        $this->add_control(
		    '_dl_newstricker_skin',
		    [
			    'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
			    'type' => Controls_Manager::SELECT,
			    'label_block' => false,
			    'options'   => [
                    '_skin_1' => 'Style 01',
                    '_skin_2' => 'Style 02',
			    ],
			    'default' => '_skin_1'
		    ]
	    );

		$this->end_controls_section();
	}
   
	//General
	public function _droit_register_dl_newstricker_general_style_controls(){
		$this->start_controls_section(
            '_dl_newstricker_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        
        $this->add_responsive_control(
            '_dl_newstricker_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_news_tricker_wrapper .dl_input_group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_newstricker_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_news_tricker_wrapper .dl_input_group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
       
        $this->end_controls_section();
    }

    //Button 
   public function _droit_register_dl_newstricker_content_controls(){
        $this->start_controls_section(
            '_dl_newstricker_content_section',
            [
                'label' => __( 'News Content', 'droit-elementor-addons' ),
            ]
        );

        $this->add_control(
            '_dl_newstricker_title',
            [
                'label' => __( 'Button Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Breaking News', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );
        
        $this->add_control(
            '_dl_newstricker_show_as_default',
            [
                'label' => __('Set as Default', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            '_dl_newstricker_button_size',
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
                    'span'  => [
                        'title' => __( 'span', 'droit-elementor-addons' ),
                        'icon' => 'eicon-editor-span'
                    ],
                ],
                'default' => 'span',
                'toggle' => false,
                
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_newstricker_list_title',
            [
                'label' => __( 'Ticker Title', 'droit-elementor-addons' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Title Here', 'droit-elementor-addons' ),
                'placeholder' => __( 'Enter your title', 'droit-elementor-addons' ),
                'label_block' => true,
            ]
        );
        
        $repeater->add_control(
            '_dl_newstricker_url_show',
            [
                'label' => esc_html__('Enable URL', 'droit-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );
        
        $repeater->add_control(
            '_dl_newstricker_link',
            [
                'label' => __( 'Link', 'droit-elementor-addons' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'droit-elementor-addons' ),
                'condition' => [
                    $this->get_control_id( '_dl_newstricker_url_show' ) => [ 'yes' ],
                ],
            ]
        );
        
        $this->add_control(
            '_dl_newstricker_list',
            [
                'label'       => __('News Ticker', 'droit-elementor-addons'),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    ['_dl_newstricker_list_title' => esc_html__('news Ticker Title 1', 'droit-elementor-addons')],
                    ['_dl_newstricker_list_title' => esc_html__('news Ticker Title 2', 'droit-elementor-addons')],
                ],
                'title_field' => '{{{ _dl_newstricker_list_title }}}',
            ]
        );
        
        $this->end_controls_section();
}

//General
public function _droit_register_dl_newstricker_content_style_controls(){
    $this->start_controls_section(
        '_dl_newstricker_button_style_content',
        [
            'label' => esc_html__('Button style', 'droit-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        '_newsticker_button_color',
        [
            'label' => __( 'Color', 'droit-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_input_group_text' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        '_newsticker_button_bg_color',
        [
            'label' => __( 'Background Color', 'droit-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_input_group_text' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => '_newsticker_button_typography',
            'selector' => '{{WRAPPER}} .dl_input_group_text',
        ]
    );
    $this->add_responsive_control(
        '_dl_newstricker_button_margin',
        [
            'label' => esc_html__('Margin', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_input_group_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    $this->add_responsive_control(
        '_dl_newstricker_button_padding',
        [
            'label' => esc_html__('Padding', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_input_group_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
        
    $this->end_controls_section();


    $this->start_controls_section(
        '_dl_newstricker_text_style_content',
        [
            'label' => esc_html__('Content style', 'droit-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );
    $this->add_control(
        '_newsticker_text_bg_color',
        [
            'label' => __( 'Background Color', 'droit-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_news_tricker_wrapper .dl_input_group' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        '_newsticker_text_color',
        [
            'label' => __( 'Color', 'droit-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .dl_marquee_content_inner .dl_marquee_tag' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => '_newsticker_text_typography',
            'selector' => '{{WRAPPER}} .dl_marquee_content_inner .dl_marquee_tag',
        ]
    );

    $this->add_responsive_control(
        '_dl_newstricker_content_margin',
        [
            'label' => esc_html__('Margin', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_marquee_content_inner .dl_marquee_tag' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        '_dl_newstricker_content_padding',
        [
            'label' => esc_html__('Padding', 'droit-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .dl_marquee_content_inner .dl_marquee_tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    
    
    $this->end_controls_section();
}


	
}
