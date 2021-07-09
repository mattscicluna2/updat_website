<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Table;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Table_Control extends Widget_Base
{
    
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_table_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_table_preset_controls(){
        $this->start_controls_section(
            '_dl_table__layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->register_table_skin();
        
        $this->end_controls_section();
    }
    protected function register_table_skin(){
         $this->add_control(
            '_dl_table__skin',
            [
                'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options'   => [
                    '' => 'Default',
                    '_skin_1' => 'Style 01',
                    '_skin_2' => 'Style 02',
                    '_skin_3' => 'Style 03',
                    '_skin_4' => 'Style 04',
                    '_skin_5' => 'Style 05',
                ],
                'default' => ''
            ]
        );   
    }

        //Content
    public function register_table_content_controls(){
        $this->start_controls_section(
            '_dl_table__content_layout_section',
            [
                'label' => esc_html__('Table Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->register_header_and_content_tab_section();
        
        $this->end_controls_section();
    }
    // Header & Content
    protected function register_header_and_content_tab_section(){
        $this->start_controls_tabs( '_dl_content_tabs' );

        
        $this->start_controls_tab( '_dl_header_content_style',
            [ 
                'label' => esc_html__( 'Header', 'droit-elementor-addons')
            ] 
        );
        $this->register_header_data_tab_section();
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_header_content_hover',
            [ 
                'label' => esc_html__( 'Content', 'droit-elementor-addons')
            ] 
        );
        $this->register_content_data_tab_section();
        $this->end_controls_tab();
        $this->end_controls_tabs();  
    }

    protected function register_header_data_tab_section(){
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_table_header_col',
            [
                'label' => esc_html__( 'Column Name', 'droit-elementor-addons'),
                'default' => 'Table Header',
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
            ]
        );

        $repeater->add_control(
            '_dl_table_header_col_span',
            [
                'label' => esc_html__( 'Column Span', 'droit-elementor-addons'),
                'default' => '',
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
            ]
        );


        
        $repeater->add_control(
            '_dl_table_header_css_class',
            [
                'label'         => esc_html__( 'CSS Class', 'droit-elementor-addons'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
            ]
        );

        $repeater->add_control(
            '_dl_table_header_css_id',
            [
                'label'         => esc_html__( 'CSS ID', 'droit-elementor-addons'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
            ]
        );
        $default_header = [
                    [ '_dl_table_header_col' => '#' ],
                    [ '_dl_table_header_col' => 'Name' ],
                    [ '_dl_table_header_col' => 'Phone' ],
                    [ '_dl_table_header_col' => 'Email' ],
                    [ '_dl_table_header_col' => 'Address' ],
                ];
        $this->add_control(
            '_dl_table_header_cols_data',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => $default_header,
                'fields'      => array_values( $repeater->get_controls() ),
                'title_field' => '{{_dl_table_header_col}}',
            ]
        );
    }
    
    protected function register_content_data_tab_section(){
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_table_content_row_type',
            [
                'label' => esc_html__( 'Row Type', 'droit-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'row',
                'label_block' => false,
                'options' => [
                    'row' => esc_html__( 'Row', 'droit-elementor-addons'),
                    'col' => esc_html__( 'Column', 'droit-elementor-addons'),
                ]
            ]
        );

        $repeater->add_control(
            '_dl_table_content_row_colspan',
            [
                'label'         => esc_html__( 'Col Span', 'droit-elementor-addons'),
                'type'          => Controls_Manager::NUMBER,
                'description'   => esc_html__( 'Default: 1 (optional).', 'droit-elementor-addons'),
                'default'       => 1,
                'min'           => 1,
                'label_block'   => true,
                'condition'     => [
                    '_dl_table_content_row_type' => 'col'
                ]
            ]
        );

        $repeater->add_control(
            '_dl_table_content_type',
            [
                'label'     => esc_html__( 'Content Type', 'droit-elementor-addons'),
                'type'  => Controls_Manager::CHOOSE,
                'options'               => [
                    'textarea'        => [
                        'title'   => esc_html__( 'Textarea', 'droit-elementor-addons'),
                        'icon'    => 'fa fa-text-width',
                    ],
                    'editor'       => [
                        'title'   => esc_html__( 'Editor', 'droit-elementor-addons'),
                        'icon'    => 'fa fa-pencil',
                    ],
                ],
                'default'   => 'textarea',
                'condition' => [
                    '_dl_table_content_row_type' => 'col'
                ]
            ]
        );

        $repeater->add_control(
            '_dl_table_content_row_rowspan',
            [
                'label'         => esc_html__( 'Row Span', 'droit-elementor-addons'),
                'type'          => Controls_Manager::NUMBER,
                'description'   => esc_html__( 'Default: 1 (optional).', 'droit-elementor-addons'),
                'default'       => 1,
                'min'           => 1,
                'label_block'   => true,
                'condition'     => [
                    '_dl_table_content_row_type' => 'col'
                ]
            ]
        );

        $repeater->add_control(
            '_dl_table_content_row_title',
            [
                'label' => esc_html__( 'Cell Text', 'droit-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => esc_html__( 'Content', 'droit-elementor-addons'),
                'condition' => [
                    '_dl_table_content_row_type' => 'col',
                    '_dl_table_content_type' => 'textarea'
                ]
            ]
        );

        $repeater->add_control(
            '_dl_table_content_row_content',
            [
                'label' => esc_html__( 'Cell Text', 'droit-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default' => esc_html__( 'Content', 'droit-elementor-addons'),
                'condition' => [
                    '_dl_table_content_row_type' => 'col',
                    '_dl_table_content_type' => 'editor'
                ]
            ]
        );

        $repeater->add_control(
            '_dl_table_content_row_title_link',
            [
                'label' => esc_html__( 'Link', 'droit-elementor-addons'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                        'url' => '',
                        'is_external' => '',
                     ],
                     'show_external' => true,
                     'separator' => 'before',
                 'condition' => [
                    '_dl_table_content_row_type' => 'col',
                    '_dl_table_content_type' => 'textarea'
                ],
            ]
        );

        $repeater->add_control(
            '_dl_table_content_row_css_class',
            [
                'label'         => esc_html__( 'CSS Class', 'droit-elementor-addons'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
                'condition'     => [
                    '_dl_table_content_row_type' => 'col'
                ]
            ]
        );

        $repeater->add_control(
            '_dl_table_content_row_css_id',
            [
                'label'         => esc_html__( 'CSS ID', 'droit-elementor-addons'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
                'condition'     => [
                    '_dl_table_content_row_type' => 'col'
                ]
            ]
        );
        $default_content = [
                    [ '_dl_table_content_row_type' => 'row' ],
                    [ '_dl_table_content_row_type' => 'col' ],
                    [ '_dl_table_content_row_type' => 'col' ],
                    [ '_dl_table_content_row_type' => 'col' ],
                    [ '_dl_table_content_row_type' => 'col' ],
                    [ '_dl_table_content_row_type' => 'col' ],
                ];
        $this->add_control(
            '_dl_table_content_rows',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => $default_content,
                'fields' => array_values( $repeater->get_controls() ),
                'title_field' => '{{_dl_table_content_row_type}}::{{_dl_table_content_row_title || _dl_table_content_row_content}}',
            ]
        );
    }

    // Table General
    public function register_general_style_section(){

        $this->start_controls_section(
            '_dl_table__general_style_section',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( '_dl_general_tabs' );

        
        $this->start_controls_tab( '_dl_general_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_table__background',
                'label' => __('Background', 'droit-elementor-addons'),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table',
            ]
        );
        $this->add_responsive_control(
            '_dl_table__width',
            [
                'label' => esc_html__('Width', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1500,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_table__margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_table__padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbodt tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_dl_table__border',
                'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_table__box_shadow',
                'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table',
            ]
        );
        $this->add_control(
            '_dl_table__general_radius',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap table.droit-table' => 'border-radius: {{SIZE}}px',
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th:last-child' => 'border-radius: 0px {{SIZE}}px 0px 0px;',
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr:last-child td:last-child' => 'border-radius: 0px 0px {{SIZE}}px 0px;',
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr:last-child td:first-child' => 'border-radius: 0px 0px 0px {{SIZE}}px;',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_general_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => '_dl_table__background_hover',
                'label' => __('Background', 'droit-elementor-addons'),
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_table__box_shadow_hover',
                'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table:hover',
            ]
        );

        $this->end_controls_tab();
                
        $this->end_controls_tabs();

        $this->end_controls_section();   
    }
    // Table Head
    public function register_header_style_section(){

        $this->start_controls_section(
            '_dl_table__head_style_section',
            [
                'label' => esc_html__('Table Head', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( '_dl_head_tabs' );


        $this->start_controls_tab( '_dl_head_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );

        $this->add_control(
            '_dl_table__head_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_table__head_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th',
            ]
        );
        $this->add_control(
            '_dl_table__title_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name' => '_dl_table__border_th',
                    'label' => esc_html__( 'Border', 'droit-elementor-addons'),
                    'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th'
                ]
        );
        $this->add_control(
            '_dl_table___header_radius',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th:last-child' => 'border-radius: 0px {{SIZE}}px 0px 0px;',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_table___header_padding',
            [
                'label' => esc_html__( 'Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_head_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
            '_dl_table__head_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th:hover' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            '_dl_table__title_bg_color_hover',
            [
                'label' => esc_html__( 'Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table thead tr th:hover' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();
                
        $this->end_controls_tabs();

        $this->end_controls_section();   
    }
    // Table Content
    public function register_content_style_section(){

        $this->start_controls_section(
            '_dl_table_content_style_section',
            [
                'label' => esc_html__('Table Content', 'droit-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( '_dl_contents_tabs' );


        $this->start_controls_tab( '_dl_content_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );

        $this->add_control(
            '_dl_table_content_color',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_table_content_typography',
                'label' => __('Typography', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr td',
            ]
        );
        $this->add_control(
            '_dl_table__content_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr td' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name' => '_dl_table_content_border',
                    'label' => esc_html__( 'Border', 'droit-elementor-addons'),
                    'selector' => '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr td'
                ]
        );
        $this->add_control(
            '_dl_table__content_radius',
            [
                'label' => esc_html__( 'Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr:last-child td:last-child' => 'border-radius: 0px 0px {{SIZE}}px 0px;',
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr:last-child td:first-child' => 'border-radius: 0px 0px 0px {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            '_dl_table__content_padding',
            [
                'label' => esc_html__( 'Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_content_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
            '_dl_table_content_color_hover',
            [
                'label' => __('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr td:hover' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            '_dl_table__content_bg_color_hover',
            [
                'label' => esc_html__( 'Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-table-wrap .droit-table tbody tr:hover td' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $this->end_controls_tab();
                
        $this->end_controls_tabs();

        $this->end_controls_section();   
    }
}