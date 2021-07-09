<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Modules\Widgets\Blog;

use \DROIT_ELEMENTOR\Utils as Droit_Utils;
use \DROIT_ELEMENTOR\Module\Controls\Droit_Control as Droit_Control_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Core\Schemes;

if (!defined('ABSPATH')) { exit;}

abstract class Blog_Control extends Widget_Base
{
    
    // Get Control ID
    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    final public function get_blogs_settings( $control_key ) {
        $control_id = $this->get_control_id( $control_key );
        return $this->get_settings( $control_id );
    }
    // Layout
    public function register_dl_blog_layout_controls(){
        $this->start_controls_section(
            '_dl_blog_layout_section',
            [
                'label' => esc_html__('Layout', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
        '_dl_blog_skin',
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
        
            $this->register_dl_blog_thumbnail_size_controls();
            $this->register_dl_blog_columns_controls();
            $this->register_dl_blog_show_hide_controls();
            $this->register_dl_blog_read_more_controls();
            $this->register_dl_blog_link_controls();
            $this->end_controls_section();   
            $this->register_dl_blog_masonary_layout_one_controls();
            $this->register_dl_blog_masonary_layout_four_controls();
    }
    
    protected function register_dl_blog_thumbnail_size_controls() {
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_size',
                'default' => 'full',
            ]
        );
    }

    protected function register_dl_blog_columns_controls() {
        $this->add_responsive_control(
            '_dl_blog_columns',
            [
                'label' => __( 'Columns', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => '4',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '12' => '1',
                    '6' => '2',
                    '4' => '3',
                    '3' => '4',
                    '5' => '5',
                    '2' => '6',
                ],
                'condition' => [
                    $this->get_control_id('_dl_blog_skin!') => ['_skin_1', '_skin_4'],
                ],
            ]
        );
    } 

    // Query
    public function register_dl_blog_query_section_controls(){
        $this->start_controls_section(
            '_dl_blog_query_section',
            [
                'label' => esc_html__('Query', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label' => __( 'Source', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'options' => Droit_Utils::droit_get_post_types( [],[ 'elementor_library', 'attachment' ] ),
                'default' => 'post',
            ]
        );
        $this->register_dl_blog_notification_controls();
        $this->add_control(
            'posts_per_page', [
                'label'       => esc_html__('Posts Per Page', 'droit-elementor-addons'),
                'type'        => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Enter Number', 'droit-elementor-addons'),
                'default'     => '6',
            ]
        );

        
        $this->register_dl_blog_order_orderby_controls();
        $this->end_controls_section();
    }

    // Order
    protected function register_dl_blog_order_orderby_controls(){
        $this->add_control(
            'order_by',
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
            ]
        );
        $this->add_control(
            'order',
            [
                'label'   => __('Order', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'ase',
                'options' => [
                    'ase'  => __('Ascending Order', 'droit-elementor-addons'),
                    'desc' => __('Descending Order', 'droit-elementor-addons'),
                ],
            ]
        );
        $this->add_control(
            'ignore_sticky_posts', [
            'label' => __( 'Ignore Sticky Posts', 'droit-elementor-addons' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                $this->get_control_id('post_type!') => ['page', 'by_id', 'category'],
            ],
            'description' => __( 'Sticky-posts ordering is visible on frontend only', 'droit-elementor-addons' ),
            ]
        );
    }

    // Notification
    protected function register_dl_blog_notification_controls(){
        if (!did_action('droitPro/loaded')) {
             $this->add_control(
                '_dl_blog_message',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw'  => Droit_Control_Manager::droit_information_control([
                        'icon'     => drdt_core()->images. "pro_icon.svg",
                        'title'    => __('Meet Droit Addons Pro', 'droit-elementor-addons'),
                        'btn_text'    => __('Upgrade Droit Addons', 'droit-elementor-addons'),
                        'btn_url'    => droit_addons_pro_link(),
                        'messages' => __('Create stunning website effects on your site and blow everyone away.', 'droit-elementor-addons'),
                    ]),
                    'condition' => [
                        $this->get_control_id('post_type!') => ['post', 'page'],
                    ],
                ]
            );
        }else{
            $this->add_control(
                '_dl_blog_message',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw'  => Droit_Control_Manager::droit_information_control([
                        'icon'     => drdt_core()->images. "pro_icon.svg",
                        'messages' => __('Please use our pro widget widget for more feature', 'droit-elementor-addons'),
                    ]),
                    'condition' => [
                        $this->get_control_id('post_type!') => ['post', 'page'],
                    ],
                ]
            );
        }
    }
    
    // Show Hide
    protected function register_dl_blog_show_hide_controls(){
        $this->add_control(
            'show_title',
            [
                'label'     => __('Title', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'show_excerpt',
            [
                'label'     => __('Excerpt', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'default'   => 'yes',
                'separator' => 'before',
                'condition' => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_3'],
                ],
            ]
        );

        $this->add_control(
            'title_tag',
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
                    $this->get_control_id('show_title') => ['yes'],
                ],

            ]
        );
        $this->add_control(
            'show_category',
            [
                'label'     => __('Category', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'condition'   => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_1', '_skin_2', '_skin_3'],
                ],
            ]
        );
        $this->add_control(
            'show_tag',
            [
                'label'     => __('Tags', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'condition' => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_2'],
                ]
            ]
        );
        
        $this->add_control(
            'show_thumb',
            [
                'label'     => __('Show Image', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
            ]
        );
        $this->add_control(
            'show_author',
            [
                'label'     => __('Show Author', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'condition'   => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_2', '_skin_3', '_skin_4'],
                ],
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label'     => __('Show Date', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'label_on'  => __('Show', 'droit-elementor-addons'),
            ]
        );
    }

    // Read More
    protected function register_dl_blog_read_more_controls(){
        $this->add_control(
            'show_read_more',
            [
                'label'     => __('Read More', 'droit-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'droit-elementor-addons'),
                'label_off' => __('Hide', 'droit-elementor-addons'),
                'default'   => 'yes',
                'separator' => 'before',
                'condition'   => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_4'],
                ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'     => __('Read More Text', 'droit-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Learn More »', 'droit-elementor-addons'),
                'condition' => [
                    $this->get_control_id('show_read_more') => ['yes'],
                    $this->get_control_id('_dl_blog_skin') => ['_skin_4'],
                ] 
            ]
        );
    }
    // Open Link Tab
    protected function register_dl_blog_link_controls(){
        $this->add_control(
            'open_new_tab',
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

    // Masonary
    protected function register_dl_blog_masonary_layout_one_controls(){   
        $this->start_controls_section(
            '_dl_blog_masonary_section',
            [
                'label' => esc_html__('Masonary Layout', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_1'],
                ]
            ]
        );
        $this->add_control(
            '_dl_masonary_type',
            [
                'label'   => __('Masonary Type', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'metro',
                'options' => [
                    'metro'   => __('Metro', 'droit-elementor-addons'),
                    'masonry'       => __('Masonry', 'droit-elementor-addons'),
                ],
            ]
        );
        $this->add_responsive_control(
            'zigzag_height',
            [
                'label'     => esc_html__( 'Zigzag Height', 'droit-elementor-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'step'      => 1,
            ] 
        );

        $this->add_control(
            'zigzag_reversed',
            [
                'label'     => esc_html__( 'Zigzag Reversed?', 'droit-elementor-addons' ),
                'type'      => Controls_Manager::SWITCHER,   
            ] 
        );


        $this->add_control( 'metro_image_size_width', [
            'label'     => esc_html__( 'Image Size', 'droit-elementor-addons' ),
            'type'      => Controls_Manager::NUMBER,
            'step'      => 1,
            'default'   => 480,
        ] );

        $this->add_control( 'metro_image_ratio', [
            'label'     => esc_html__( 'Image Ratio', 'droit-elementor-addons' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 2,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'default'   => [
                'size' => 1,
            ],
            
        ] );

        $this->add_responsive_control( 'grid_columns', [
            'label'          => esc_html__( 'Columns', 'droit-elementor-addons' ),
            'type'           => Controls_Manager::NUMBER,
            'min'            => 1,
            'max'            => 12,
            'step'           => 1,
            'default'        => 4,
            'tablet_default' => 2,
            'mobile_default' => 1,
        ] );

        $this->add_responsive_control( 'grid_gutter', [
            'label'   => esc_html__( 'Gutter', 'droit-elementor-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 200,
            'step'    => 1,
            'default' => '',
        ] );

        $layout_repeater = new \Elementor\Repeater();

        $layout_repeater->add_control( 'size', [
            'label'   => esc_html__( 'Item Size', 'droit-elementor-addons' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '1:1',
            'options' => Droit_Utils::get_grid_metro_size(),
        ] );

        $this->add_control( 'grid_metro_layout', [
            'label'       => esc_html__( 'Metro Layout', 'droit-elementor-addons' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $layout_repeater->get_controls(),
            'default'     => [
                [ 'size' => '2:2' ],
                [ 'size' => '1:1' ],
                [ 'size' => '1:1' ],
                [ 'size' => '2:2' ],                    
                [ 'size' => '1:1' ],                    
                [ 'size' => '1:1' ],                    
            ],
            'title_field' => '{{{ size }}}',
        ] );
        $this->end_controls_section();
    }

    // Masonary 
    protected function register_dl_blog_masonary_layout_four_controls(){   
        $this->start_controls_section(
            '_dl_blog_masonary_four_section',
            [
                'label' => esc_html__('Masonary Layout', 'droit-elementor-addons'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_4'],
                ]
            ]
        );
        $this->add_control(
            '_dl_masonary_type_four',
            [
                'label'   => __('Masonary Type', 'droit-elementor-addons'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'masonry',
                'options' => [
                    'metro'   => __('Metro', 'droit-elementor-addons'),
                    'masonry'       => __('Masonry', 'droit-elementor-addons'),
                ],
            ]
        );
        $this->add_responsive_control(
            'zigzag_height_four',
            [
                'label'     => esc_html__( 'Zigzag Height', 'droit-elementor-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'step'      => 1, 
            ] 
        );

        $this->add_control(
            'zigzag_reversed_four',
            [
                'label'     => esc_html__( 'Zigzag Reversed?', 'droit-elementor-addons' ),
                'type'      => Controls_Manager::SWITCHER,
                
            ] 
        );


        $this->add_control( 'metro_image_size_width_four', [
            'label'     => esc_html__( 'Image Size', 'droit-elementor-addons' ),
            'type'      => Controls_Manager::NUMBER,
            'step'      => 1,
            'default'   => 480,
        ] );

        $this->add_control( 'metro_image_ratio_four', [
            'label'     => esc_html__( 'Image Ratio', 'droit-elementor-addons' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 2,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'default'   => [
                'size' => null,
            ],
            
        ] );

        $this->add_responsive_control( 'grid_columns_four', [
            'label'          => esc_html__( 'Columns', 'droit-elementor-addons' ),
            'type'           => Controls_Manager::NUMBER,
            'min'            => 1,
            'max'            => 12,
            'step'           => 1,
            'default'        => 2,
            'tablet_default' => 2,
            'mobile_default' => 1,
        ] );

        $this->add_responsive_control( 'grid_gutter_four', [
            'label'   => esc_html__( 'Gutter', 'droit-elementor-addons' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 200,
            'step'    => 1,
            'default' => 30,
        ] );
        $this->end_controls_section();
    }
    public function register_dl_blog_general_style_section_controls(){
        $this->start_controls_section(
            '_dl_blog_style_general',
            [
                'label' => esc_html__('General', 'droit-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            '_dl_blog_box_margin',
            [
                'label' => esc_html__('Margin', 'droit-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }
    // Thumbnail Style
    public function register_dl_blog_thumbnail_style_section_controls(){

        $this->start_controls_section(
            'section_style_image',
            [
                'label'     => __('Thumbnail', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    $this->get_control_id('show_thumb') => ['yes'],
                ],
            ]
        );
        $this->start_controls_tabs( '_dl_blog_thumbnail_tabs' );


        $this->start_controls_tab( '_dl_blog_thumbnail_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_responsive_control(
            '_free_dl_blog_image_width',
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
                    '{{WRAPPER}} .droit-post__area .droit-post__thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_free_dl_blog_image_height',
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
                    '{{WRAPPER}} .droit-post__area .droit-post__thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'dl_blog_object-fit',
            [
                'label' => __( 'Object Fit', 'droit-elementor-addons' ),
                'type' => Controls_Manager::SELECT,

                'condition' => [
                    $this->get_control_id('_free_dl_blog_image_height[size]!') => '',
                ],
                'options' => [
                    '' => __( 'Default', 'droit-elementor-addons' ),
                    'fill' => __( 'Fill', 'droit-elementor-addons' ),
                    'cover' => __( 'Cover', 'droit-elementor-addons' ),
                    'contain' => __( 'Contain', 'droit-elementor-addons' ),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__thumbnail img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            '_dl_blog_image_ofset',
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
                    $this->get_control_id('_dl_blog_image_ofset') => ['yes'],
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
                
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__thumbnail img' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-post__area .droit-post__thumbnail img'  => '-ms-transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x.SIZE || 0}}{{UNIT}}, {{image_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-post__area .droit-post__thumbnail img'   => '-ms-transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{image_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-post__area .droit-post__thumbnail img'   => '-ms-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{image_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{image_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
    
        $this->add_responsive_control(
            '_dl_blog_image_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_blog_image_radius',
            [
                'label'      => __('Border Radius', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['%', 'px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->end_controls_tab();
                
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    // Title Style
    public function register_dl_blog_title_style_section_controls(){

        $this->start_controls_section(
            '_dl_blog_section_style_title',
            [
                'label'     => __('Title', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id('show_title') => ['yes'],
                ]
            ]
        );
        $this->start_controls_tabs( '_dl_blog_title_tabs' );
        $this->start_controls_tab( '_dl_blog_title_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );

        $this->add_control(
        '_dl_blog_title_color',
            [
                'label'     => __('Text Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__title a' => 'color: {{VALUE}};',
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_blog_title_typography',
                'selector' => '{{WRAPPER}} .droit-post__area .droit-post__title a, {{WRAPPER}} .droit-post__area .droit-post__title',
            ]
        );
        $this->add_control(
            '_dl_blog_title_ofset',
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
            'blog_title_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_dl_blog_title_ofset') => ['yes'],
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
            'blog_title_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__title' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-post__area .droit-post__title'  => '-ms-transform: translate({{blog_title_offset_x.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_title_offset_x.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{blog_title_offset_x.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-post__area .droit-post__title'   => '-ms-transform: translate({{blog_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{blog_title_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-post__area .droit-post__title'   => '-ms-transform: translate({{blog_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{blog_title_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_title_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        
        $this->add_responsive_control(
            '_dl_blog_title_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( '_dl_blog_title_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
        '_dl_blog_title_h_color',
            [
                'label'     => __('Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__title a:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    // Content Style
    public function register_dl_blog_content_style_section_controls(){

        $this->start_controls_section(
            '_dl_blog_section_style_content',
            [
                'label'     => __('Content', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_3', '_skin_4'],
                    $this->get_control_id('show_excerpt') => ['yes'],
                ],
            ]
        );
        $this->start_controls_tabs( '_dl_blog_content_tabs' );


        $this->start_controls_tab( '_dl_blog_content_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
         $this->add_control(
        '_dl_blog_content_color',
            [
                'label'     => __('Text Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__content' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .droit-post__area .droit-post__content p' => 'color: {{VALUE}};',
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_blog_content_typography',
                'selector' => '{{WRAPPER}} .droit-post__area .droit-post__content p, {{WRAPPER}} .droit-post__area .droit-post__content',
            ]
        );
        $this->add_control(
            '_dl_blog_content_ofset',
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
            'blog_content_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_dl_blog_content_ofset') => ['yes'],
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
            'blog_content_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__content' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-post__area .droit-post__content'  => '-ms-transform: translate({{blog_content_offset_x.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_content_offset_x.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{blog_content_offset_x.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-post__area .droit-post__content'   => '-ms-transform: translate({{blog_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{blog_content_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-post__area .droit-post__content'   => '-ms-transform: translate({{blog_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{blog_content_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_content_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        
        $this->add_responsive_control(
            '_dl_blog_content_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
                
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    // Category Style
    public function register_dl_blog_cat_style_section_controls(){

        $this->start_controls_section(
            '_dl_blog_section_style_cat',
            [
                'label'     => __('Category', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_2', '_skin_3'],
                    $this->get_control_id('show_category') => ['yes'],
                ],
            ]
        );
        $this->start_controls_tabs( '_dl_blog_cat_tabs' );


        $this->start_controls_tab( '_dl_blog_cat_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
         $this->add_control(
        '_dl_blog_cat_color',
            [
                'label'     => __('Text Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__category' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => '',
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_blog_cat_typography',
                'selector' => '{{WRAPPER}} .droit-post__area .droit-post__category',
            ]
        );
         $this->add_control(
        '_dl_blog_cat_bg_color',
            [
                'label'     => __('Background Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__category' => 'background-color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            '_dl_blog_cat_ofset',
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
            'blog_cat_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_dl_blog_cat_ofset') => ['yes'],
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
            'blog_cat_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__category' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-post__area .droit-post__category'  => '-ms-transform: translate({{blog_cat_offset_x.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_cat_offset_x.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{blog_cat_offset_x.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-post__area .droit-post__category'   => '-ms-transform: translate({{blog_cat_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_cat_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{blog_cat_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-post__area .droit-post__category'   => '-ms-transform: translate({{blog_cat_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_cat_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{blog_cat_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_cat_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        
        $this->add_responsive_control(
            '_dl_blog_cat_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_blog_cat_radius',
            [
                'label'      => __('Border Radius', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['%', 'px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        $this->end_controls_tab();
                
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    // Author Style
    public function register_dl_blog_auth_style_section_controls(){

        $this->start_controls_section(
            '_dl_blog_section_style_auth',
            [
                'label'     => __('Author', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    $this->get_control_id('_dl_blog_skin') => ['_skin_2', '_skin_3', '_skin_4'],
                    $this->get_control_id('show_author') => ['yes'],
                ],
            ]
        );
        $this->start_controls_tabs( '_dl_blog_author_tabs' );


        $this->start_controls_tab( '_dl_blog_author_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
         $this->add_control(
        '_dl_blog_auth_color',
            [
                'label'     => __('Text Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post_author a' => 'color: {{VALUE}};',
                ],
            ]
        );
       $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_blog_auth_typography',
                'selector' => '{{WRAPPER}} .droit-post__area .droit-post_author a, .droit-post__area .droit-post_author',
            ]
        );
        $this->add_control(
            '_dl_blog_auth_ofset',
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
            'blog_auth_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_dl_blog_auth_ofset') => ['yes'],
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
            'blog_auth_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post_author' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-post__area .droit-post_author'  => '-ms-transform: translate({{blog_auth_offset_x.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_auth_offset_x.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{blog_auth_offset_x.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-post__area .droit-post_author'   => '-ms-transform: translate({{blog_auth_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_auth_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{blog_auth_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-post__area .droit-post_author'   => '-ms-transform: translate({{blog_auth_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_auth_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{blog_auth_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_auth_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        
        $this->add_responsive_control(
            '_dl_blog_auth_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post_author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_blog_auth_radius',
            [
                'label'      => __('Border Radius', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['%', 'px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_blog_author_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
        '_dl_blog_auth_h_color',
            [
                'label'     => __('Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post_author a:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->end_controls_tab();
                
        $this->end_controls_tabs();
        
        $this->end_controls_section();
    }

    // Date Style
    public function register_dl_blog_date_style_section_controls(){

        $this->start_controls_section(
            '_dl_blog_section_style_date',
            [
                'label'     => __('Date', 'droit-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->get_control_id('show_date') => ['yes'],
                ]
            ]
        );
        $this->start_controls_tabs( '_dl_blog_date_tabs' );


        $this->start_controls_tab( '_dl_blog_date_style',
            [ 
                'label' => esc_html__( 'Style', 'droit-elementor-addons')
            ] 
        );
        $this->add_control(
        '_dl_blog_date_color',
            [
                'label'     => __('Text Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__date a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => '_dl_blog_date_typography',
                'selector' => '{{WRAPPER}} .droit-post__area .droit-post__date a, .droit-post__area .droit-post__date',
            ]
        );
        $this->add_control(
            '_dl_blog_date_ofset',
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
            'blog_date_offset_x',
            [
                'label'       => __('Offset Left', 'droit-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'em', 'rem'],
                'condition'   => [
                    $this->get_control_id('_dl_blog_date_ofset') => ['yes'],
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
            'blog_date_offset_y',
            [
                'label'      => __('Offset Top', 'droit-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__date' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}} .droit-post__area .droit-post__date'  => '-ms-transform: translate({{blog_date_offset_x.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_date_offset_x.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{blog_date_offset_x.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .droit-post__area .droit-post__date'   => '-ms-transform: translate({{blog_date_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_date_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{blog_date_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .droit-post__area .droit-post__date'   => '-ms-transform: translate({{blog_date_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{blog_date_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{blog_date_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{blog_date_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                ],
            ]
        );

        $this->end_popover();
        
        $this->add_responsive_control(
            '_dl_blog_date_pading',
            [
                'label'      => __('Padding', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            '_dl_blog_date_radius',
            [
                'label'      => __('Border Radius', 'droit-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['%', 'px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .droit-post__area .droit-post__date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'after',
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab( '_dl_blog_date_hover',
            [ 
                'label' => esc_html__( 'Hover', 'droit-elementor-addons')
            ] 
        );
        
        $this->add_control(
        '_dl_blog_date_h_color',
            [
                'label'     => __('Color', 'droit-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .droit-post__area .droit-post__date a:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->end_controls_tab();
                
        $this->end_controls_tabs();
         
        $this->end_controls_section();
    }    
}
