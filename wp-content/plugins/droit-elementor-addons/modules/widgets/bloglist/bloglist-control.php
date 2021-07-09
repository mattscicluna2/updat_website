<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Bloglist;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) {exit;}
abstract class Bloglist_Control extends Widget_Base
{
	
	// Get Control ID
	protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_blog_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    //Preset
    public function register_blog_list_preset_controls(){
    	$this->start_controls_section(
            '_blog_list_layout_section',
            [
                'label' => esc_html__('Preset', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                ],
            ]
        );
    	$this->register_blog_list_skin();
    	$this->register_blog_list_thumbnail_size_controls();
    	$this->register_blog_list_columns_controls();
    	$this->register_blog_list_show_hide_controls();
    	$this->register_blog_list_read_more_controls();
    	$this->register_blog_list_link_controls();
    	$this->register_blog_list_meta_data_controls();
        $this->end_controls_section();
    }

	//Skin
	protected function register_blog_list_skin(){ 
    $this->add_control(
        '_blog_list_skin',
        [
            'label' => esc_html__( 'Design Format', 'droit-elementor-addons' ),
            'type' => Controls_Manager::SELECT,
            'label_block' => false,
            'options'   => [
                '_skin_1' => 'Style 01',
                '_skin_2' => 'Style 02',
                '_skin_3' => 'Style 03',
                '_skin_4' => 'Style 04',
            ],
            'default' => '_skin_1'
        ]
    );
    }

	//Thumbnail Size
	protected function register_blog_list_thumbnail_size_controls() {
        
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => '_blog_list_thumbnail_size',
                'default' => 'full',
                'condition' => [
                	$this->get_control_id( '_blog_list_show_thumb' ) => [ 'yes' ],
                ],
            ]
        );

        $this->add_responsive_control(
            '_blog_list_image_width',
            [
                'label' => __( 'Image Width', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
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
                'default' => [
                    'size' => '',
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => '%',
                ],
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post_list__thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_blog_list_image_height',
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
                'default' => [
                    'size' => '',
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => '%',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__wrap .droit-post_list__thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_blog_list_object-fit',
            [
                'label' => __( 'Object Fit', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,

                'condition' => [
                    $this->get_control_id('_blog_list_image_height[size]!') => '',
                ],
                'options' => [
                    '' => __( 'Default', 'droit-elementor-addons' ),
                    'fill' => __( 'Fill', 'droit-elementor-addons' ),
                    'cover' => __( 'Cover', 'droit-elementor-addons' ),
                    'contain' => __( 'Contain', 'droit-elementor-addons' ),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-post_list__thumbnail img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
    }

    //Column
    protected function register_blog_list_columns_controls() {
        $this->add_responsive_control(
            '_blog_list_columns',
            [
                'label' => __( 'Columns', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 6,
                'tablet_default' => 6,
                'mobile_default' => 12,
                'options' => [
                    '12' => '1',
                    '6' => '2',
                    '4' => '3',
                    '3' => '4',
                    '5' => '5',
                    '2' => '6',
                ],
            ]
        );
    }

    // Show Hide
    protected function register_blog_list_show_hide_controls(){
        $this->add_control(
            '_blog_list_show_title',
            [
                'label'     => __('Title', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'default'   => 'yes',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            '_blog_list_title_tag',
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
                            $this->get_control_id( '_blog_list_show_title' ) => 'yes',
                        ],
            ]
        );
        $this->add_control(
            '_blog_list_show_excerpt',
            [
                'label'     => __('Excerpt', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'default'   => 'yes',
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1', '_skin_4' ],
                ],
            ]
        );
        $this->add_control(
			'_blog_list_excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'droit-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => apply_filters( 'excerpt_length', 70 ),
				'condition' => [
					$this->get_control_id( '_blog_list_show_excerpt' ) => 'yes',
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1', '_skin_4' ],
				],

			]
		);
        
        $this->add_control(
            '_blog_list_show_thumb',
            [
                'label'     => __('Show Thumbnail', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'separator' => 'before',
            ]
        );
        $this->add_control(
            '_blog_list_show_author',
            [
                'label'     => __('Show Author', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1' ],
                ],
            ]
        );
        $this->add_control(
            '_blog_list_show_author_image',
            [
                'label'     => __('Show Author Image', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'condition' => [
					$this->get_control_id( '_blog_list_show_author' ) => 'yes',
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1' ],
				],
            ]
        );
        $this->add_control(
            '_blog_list_default_author_image', [
                'label'      => __('Default Auth', 'droit-elementor-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url' => '',
                ],
                'show_label' => true,
                'description' => __('Keep empty to display default image','droit-elementor-addons'),
                'condition' => [
					$this->get_control_id( '_blog_list_show_author' ) => 'yes',
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1' ],
				],
            ]
        );
        $this->add_control(
            '_blog_list_enable_author',
            [
                'label'     => __('Enable Author Link', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('No', 'droit-elementor-addons'),
                'label_on'  => __('Yes', 'droit-elementor-addons'),
                'condition' => [
					$this->get_control_id( '_blog_list_show_author' ) => 'yes',
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1' ],
				],
            ]
        );

        $this->add_control(
            '_blog_list_show_date',
            [
                'label'     => __('Show Date', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'separator' => 'before',
            ]
        );
    }

    // Read More
    protected function register_blog_list_read_more_controls(){
        $this->add_control(
            '_blog_list_show_read_more',
            [
                'label'     => __('Read More', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'default'   => 'yes',
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1', '_skin_4' ],
                ],
            ]
        );

        $this->add_control(
            '_blog_list_read_more_text',
            [
                'label'     => __('Read More Text', 'droit-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Read More »', 'droit-elementor-addons'),
                'condition' => [
					$this->get_control_id( '_blog_list_show_read_more' ) => 'yes',
                    $this->get_control_id( '_blog_list_skin' ) => [ '_skin_1', '_skin_4' ],
				],
            ]
        );
    }

    //Link
    protected function register_blog_list_link_controls() {
        $this->add_control(
            '_blog_list_open_new_tab',
            [
                'label' => __( 'Open in new window', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'droit-elementor-addons' ),
                'label_off' => __( 'No', 'droit-elementor-addons' ),
                'default' => 'no',
                'render_type' => 'none',
            ]
        );
    }

    //Query
    public function register_blog_list_query_controls(){
        $this->start_controls_section(
            '_blog_list_query_section',
            [
                'label' => esc_html__('Query', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            '_blog_list_post_type',
            [
                'label' => __( 'Source', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'options' => Droit_Utils::droit_get_post_types( [],[ 'elementor_library', 'attachment' ] ),
                'default' => 'post',
            ]
        );

        $this->add_control(
            '_blog_list_posts_per_page', [
                'label'       => esc_html__('Posts Per Page', 'droit-elementor-addons'),
                'type'        => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Enter Number', 'droit-elementor-addons'),
                'default'     => 2,
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                ],
            ]
        );

        $this->register_blog_list_order_orderby_controls();
        $this->end_controls_section();
    }

    // Order
    protected function register_blog_list_order_orderby_controls(){
        $this->add_control(
            '_blog_list_order_by',
            [
                'label'   => __('Order By', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'modified'   => __('Modified', 'droit-elementor-addons'),
                    'date'       => __('Date', 'droit-elementor-addons'),
                    'rand'       => __('Rand', 'droit-elementor-addons'),
                    'ID'         => __('ID', 'droit-elementor-addons'),
                    'title'      => __('Title', 'droit-elementor-addons'),
                    'author'     => __('Author', 'droit-elementor-addons'),
                    'name'       => __('Name', 'droit-elementor-addons'),
                    'parent'     => __('Parent', 'droit-elementor-addons'),
                    'menu_order' => __('Menu Order', 'droit-elementor-addons'),
                ],
                'separator' => 'before',
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                ],
            ]
        );
        $this->add_control(
            '_blog_list_order',
            [
                'label'   => __('Order', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'ase',
                'options' => [
                    'ase'  => __('Ascending Order', 'droit-elementor-addons'),
                    'desc' => __('Descending Order', 'droit-elementor-addons'),
                ],
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                ],
            ]
        );
        $this->add_control(
            '_blog_list_ignore_sticky_posts', [
            'label' => __( 'Ignore Sticky Posts', 'droit-elementor-addons' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => ['page', 'by_id', 'category'],
                ],
            'description' => __( 'Sticky-posts ordering is visible on frontend only', 'droit-elementor-addons' ),
            ]
        );
    }

    // Meta Data
    protected function register_blog_list_meta_data_controls() {
		$this->add_control(
			'_blog_list_meta_data',
			[
				'label' => __( 'Meta Data', 'droit-elementor-addons' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => [ 'date' ],
				'multiple' => true,
				'options' => [
					'tag' => __( 'Tag', 'droit-elementor-addons' ),
					'category' => __( 'Category', 'droit-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'_blog_list_meta_separator',
			[
				'label' => __( 'Separator Between', 'droit-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '///',
				'selectors' => [
					'{{WRAPPER}} .elementor-post__meta-data span + span:before' => 'content: "{{VALUE}}"',
				],
				'condition' => [
					$this->get_control_id( '_blog_list_meta_data!' ) => [],
				],
			]
		);
	}

	/* ==============Style Section==============*/

	//General
	public function register_blog_list_general_style_controls(){
		$this->start_controls_section(
            '_blog_list_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'_blog_list_align',
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
					'{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog_list_loop_post' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            '_blog_list_loop_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog_list_loop_post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_blog_list_loop_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
				'default'	=> [
					'top' => 0,
					'right' => 0,
                	'bottom' => 15,
					'left' => 0,
                	'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog_list_loop_post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => '_blog_list_loop_border',
                'label' => esc_html__('Border', 'droit-elementor-addons'),
                'selector' => '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog_list_loop_post',
            ]
        );

        $this->add_responsive_control(
            '_blog_list_loop_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog_list_loop_post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_blog_list_loop_box_shadow',
                'selector' => '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog_list_loop_post',
            ]
        );
        $this->end_controls_section();
	}
	//Title
	public function register_blog_list_title_style_controls(){
		$this->start_controls_section(
            '_blog_list_title_section',
            [
                'label' => esc_html__('Title', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                	$this->get_control_id( '_blog_list_show_title' ) => [ 'yes' ],
                ],
            ]
        );
			$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_blog_list_title_typography',
                'selector' => '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog-list-title a',
            ]
        );

        $this->add_responsive_control(
            '_blog_list_title_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog-list-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_blog_list_title_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('_blog_list_title_header_tabs');

        $this->start_controls_tab('_blog_list_title_header_normal_tab', 
        	['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        
        $this->add_control(
            '_blog_list_title_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog-list-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_blog_list_title_header_hover_tab', 
        	['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
 
        $this->add_control(
            '_blog_list_title_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-blog-list-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
	}

	//Content
	public function register_blog_list_content_style_controls(){
		$this->start_controls_section(
            '_blog_list_content_section',
            [
                'label' => esc_html__('Content', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                	$this->get_control_id( '_blog_list_show_excerpt' ) => [ 'yes' ],
                ],
            ]
        );
			$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_blog_list_content_typography',
                'selector' => '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_excerpt',
            ]
        );

        $this->add_responsive_control(
            '_blog_list_content_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_blog_list_content_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('_blog_list_content_header_tabs');

        $this->start_controls_tab('_blog_list_content_header_normal_tab', 
        	['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        
        $this->add_control(
            '_blog_list_content_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_blog_list_content_header_hover_tab', 
        	['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
 
        $this->add_control(
            '_blog_list_content_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_excerpt:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
	}

	//Author
	public function register_blog_list_author_style_controls(){
		$this->start_controls_section(
            '_blog_list_author_section',
            [
                'label' => esc_html__('Author', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                	$this->get_control_id( '_blog_list_show_author' ) => [ 'yes' ],
                ],
            ]
        );
			$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_blog_list_author_typography',
                'selector' => '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_author .droit-post_list_author_name',
            ]
        );

        $this->add_responsive_control(
            '_blog_list_author_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_blog_list_author_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('_blog_list_author_header_tabs');

        $this->start_controls_tab('_blog_list_author_header_normal_tab', 
        	['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        
        $this->add_control(
            '_blog_list_author_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_author .droit-post_list_author_name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_blog_list_author_header_hover_tab', 
        	['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
 
        $this->add_control(
            '_blog_list_author_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_author .droit-post_list_author_name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
	}
    //Date
    public function register_blog_list_date_style_controls(){
        $this->start_controls_section(
            '_blog_list_date_section',
            [
                'label' => esc_html__('Date', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                    $this->get_control_id( '_blog_list_show_date' ) => [ 'yes' ],
                ],
            ]
        );
            $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_blog_list_date_typography',
                'selector' => '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_date',
            ]
        );

        $this->add_responsive_control(
            '_blog_list_date_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_blog_list_date_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('_blog_list_date_header_tabs');

        $this->start_controls_tab('_blog_list_date_header_normal_tab', 
            ['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        
        $this->add_control(
            '_blog_list_date_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_blog_list_date_header_hover_tab', 
            ['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
 
        $this->add_control(
            '_blog_list_date_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_date:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
	//Read More
	public function register_blog_list_read_more_style_controls(){
		$this->start_controls_section(
            '_blog_list_read_more_section',
            [
                'label' => esc_html__('Read More', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                	$this->get_control_id( '_blog_list_post_type!' ) => [ 'category', 'by_id' ],
                	$this->get_control_id( '_blog_list_show_read_more' ) => [ 'yes' ],
                ],
            ]
        );
			$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_blog_list_read_more_typography',
                'selector' => '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more',
            ]
        );

        $this->add_responsive_control(
            '_blog_list_read_more_padding',
            [
                'label' => esc_html__('Padding', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_blog_list_read_more_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('_blog_list_read_more_header_tabs');

        $this->start_controls_tab('_blog_list_read_more_header_normal_tab', 
        	['label' => esc_html__('Normal', 'droit-elementor-addons')]
        );
        
        $this->add_control(
            '_blog_list_read_more_text_color',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_blog_list_read_more_bg_color',
            [
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_blog_list_read_more_border_radius',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('_blog_list_read_more_header_hover_tab', 
        	['label' => esc_html__('Hover', 'droit-elementor-addons')]
        );
 
        $this->add_control(
            '_blog_list_read_more_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            '_blog_list_read_more_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'droit-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_blog_list_read_more_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__wrap .droit-blog_list_loop_wrap .droit-post_list_read-more:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
	}
}
