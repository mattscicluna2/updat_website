<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Blog\Blog_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Blog\Blog_Module as Module;
use \DROIT_ELEMENTOR\Images as Droit_Images;
use \Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) { exit;}

class Droit_Addons_Blog extends Control
{
    protected $current_permalink;

    public function get_name()
    {
        return Module::get_name();
    }

    public function get_title()
    {
        return Module::get_title();
    }

    public function get_icon()
    {
        return Module::get_icon();
    }

    public function get_categories()
    {
        return Module::get_categories();
    }

    public function get_keywords()
    {
        return Module::get_keywords();
    }

    protected function get_control_id( $control_id ) {
        return $control_id;
    }

    protected function _register_controls()
    {
        parent::_register_controls();
        $this->register_dl_blog_layout_controls();
        $this->register_dl_blog_query_section_controls();
        $this->register_dl_blog_general_style_section_controls();
        $this->register_dl_blog_thumbnail_style_section_controls();
        $this->register_dl_blog_title_style_section_controls();
        $this->register_dl_blog_content_style_section_controls();
        $this->register_dl_blog_cat_style_section_controls();
        $this->register_dl_blog_auth_style_section_controls();
        $this->register_dl_blog_date_style_section_controls();
        do_action('dl_widget/section/style/custom_css', $this);
    }

    protected function render_title(){
        $settings = $this->get_settings_for_display();
        if (!$this->get_blogs_settings('show_title')) {
            return;
        }
        $optional_attributes_html = $this->get_optional_link_attributes_html();

        $tag = !empty($this->get_blogs_settings('title_tag')) ? $this->get_blogs_settings('title_tag') : 'h3';
        ?>
    
    <<?php echo $tag; ?> class="dl_title droit-post__title"> <a href="<?php echo $this->current_permalink; ?>" <?php echo $optional_attributes_html; ?>><?php the_title();?></a> </<?php echo $tag; ?>>
    <?php
    }
    protected function render_thumbnail($_image_width, $_image_height){
        $settings = $this->get_settings_for_display();
        if (!$this->get_blogs_settings('show_thumb')) {
            return;
        }
       
         if ( has_post_thumbnail() ) : 
            Droit_Images::the_post_thumbnail( array(
            'size'   => 'custom',
            'width'  => $_image_width,
            'height' => $_image_height,
            ) ); 
         else: 
            Droit_Images::image_placeholder( 480, 480 );
         endif;
    }

    protected function render_thumbnails(){
        $settings = $this->get_settings_for_display();
        if (!$this->get_blogs_settings('show_thumb')) {
            return;
        }
        
        ?>
        <div class="droit-post__thumbnail">
            <?php
                 if ( has_post_thumbnail() ) :
                 $class = '';
                 switch ($this->get_blogs_settings('_dl_blog_skin')) {
                      case '_skin_1':
                           $class = ' dl_img_res zoom_in_img ';
                          break;
                      case '_skin_4':
                           $class = ' blog_masonry_thumb ';
                          break;
                  } 
                    $size = $this->get_blogs_settings('thumbnail_size_size');
                    the_post_thumbnail( $size, array( 'class' => $class . 'zoom_in_img dl_thumbnail_fluid ' ) );
                 else:
                    Droit_Images::image_placeholder( 480, 480 );
                 endif;
             ?>
        </div>
    <?php
    }
    protected function render_excerpt() {
        $settings = $this->get_settings_for_display();
        if ( !$this->get_blogs_settings('show_excerpt') ) {
            return;
        }

        ?>
        <div class="droit-post__excerpt dl_description droit-post__content dl_desc">
            <?php 
            if ( ! has_excerpt() ) {
                echo '<p>';
                echo wp_trim_words( get_the_content(), 10, '...' );
               echo '</p>';
            } else { 
                the_excerpt();
            }?>
        </div>
        <?php
    }

    protected function render_category( $taxonomy = 'category', $type = 'single' ){ //single or multiple
        $settings = $this->get_settings_for_display();
        if (!$this->get_blogs_settings('show_category')) {
            return;
        }
        $output = '';
        $class = $this->get_blogs_settings('_dl_blog_skin') == '_skin_2' || $this->get_blogs_settings('_dl_blog_skin') == '_skin_3' ? 'dl_tag droit-post__category' : 'd-inline-block dl_tag sa droit-post__category';
        if( 'category' == $taxonomy ) {
            if( $type == 'single' ){
                $category = get_the_category();
                if( !empty( $category ) ) {
                    $output = '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) .'" class="'.$class.'">'. esc_html( $category[0]->cat_name ) .'</a>';
                }
            }
            else{
                $category = get_the_category_list(', ');
                if( !empty( $category ) ) {
                    $output = '<a href="#" class="'.$class.'">'. esc_html( $category[0]->cat_name ) .'</a>';
                }
                
            }
        }
        else {
            $terms = get_the_terms( get_the_ID(), $taxonomy );
            $term_link = get_term_link( $terms[0], $taxonomy );

            if( !empty( $terms ) ) {
                $output = '<a href="' . esc_url( $term_link ) .'" class="'.$class.'">'. esc_html( $terms[0]->name ) .'</a>';
            }
        }
        echo $output;
    }
    protected function render_author(){
        $settings = $this->get_settings_for_display();
        if (!$this->get_blogs_settings('show_author')) {
            return;
        }

        ?>
        <p class="dl_post_author droit-post_author">
         <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author();?></a>
     </p>
     <?php
    }
    protected function render_avatar() {
        $args = array(
        'size'          => 45,
        'height'        => 45,
        'width'         => 45,
        'class'         => 'dl_author_img',
    );
        ?>
        <div class="droit-post__avatar">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 45, '', get_the_author_meta( 'display_name' ), $args ); ?>
        </div>
        <?php
    }
    protected function render_date() {   
    $settings = $this->get_settings_for_display();
    if (!$this->get_blogs_settings('show_date')) {
            return;
        }
        $author_prefix_text = $this->get_blogs_settings('_dl_blog_skin') == '_skin_1' ? ' By' : '';
        echo '<p class="dl_date droit-post__date"><a href="#">'.apply_filters('the_date', get_the_date(), get_option('date_format'), '', ''). $author_prefix_text . '</a></p>';
    }
    protected function render_tag() {    
        $settings = $this->get_settings_for_display();
        if (!$this->get_blogs_settings('show_tag')) {
            return;
        }
        $output = '';
        $post_tags = get_the_tags();
        $separator = ', ';
        if (!empty($post_tags)) {
            $output .= '<ul class="tag_list">';
            foreach ($post_tags as $tag) {
                $output .= '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>' . $separator;
            }
             $output .= '</ul>';
            echo trim($output, $separator);

        }
    }
    protected function render_meta()
    {
        $settings = $this->get_settings_for_display();
        if (!$this->get_blogs_settings('show_author') && !$this->get_blogs_settings('show_date')) {
            return;
        }
        ?>
        <div class="dl_post_meta">
            <?php 
                $this->render_date();
                $this->render_author();
            ?> 
        </div>
    <?php
}
protected function render_read_more() {
     $settings = $this->get_settings_for_display();
    if ( ! $this->get_blogs_settings('show_read_more') ) {
        return;
    }

    $optional_attributes_html = $this->get_optional_link_attributes_html();

    ?>
        <a class="droit-post__read-more read_more_btn" href="<?php echo $this->current_permalink; ?>" <?php echo $optional_attributes_html; ?>>
            <?php echo $this->get_blogs_settings('read_more_text'); ?>
        </a>
    <?php
}
protected function get_optional_link_attributes_html() {
    $settings = $this->get_settings_for_display();
    $new_tab_setting_key = $this->get_control_id( 'open_new_tab' );
    $optional_attributes_html = 'yes' === $this->get_blogs_settings($new_tab_setting_key) ? 'target="_blank"' : '';

    return $optional_attributes_html;
}
protected function get_grid_options( array $settings ) {
    $grid_options = [
        'type'  => $this->get_blogs_settings('_dl_masonary_type'),
        'ratio' => $this->get_blogs_settings('metro_image_ratio')['size'],
    ];

    // Columns.
    if ( ! empty( $this->get_blogs_settings('grid_columns') ) ) {
        $grid_options['columns'] = $this->get_blogs_settings('grid_columns');
    }

    if ( ! empty( $this->get_blogs_settings('grid_columns_tablet') ) ) {
        $grid_options['columnsTablet'] = $this->get_blogs_settings('grid_columns_tablet');
    }

    if ( ! empty( $this->get_blogs_settings('grid_columns_mobile') ) ) {
        $grid_options['columnsMobile'] = $this->get_blogs_settings('grid_columns_mobile');
    }

    // Gutter
    if ( ! empty( $this->get_blogs_settings('grid_gutter') ) ) {
        $grid_options['gutter'] = $this->get_blogs_settings('grid_gutter');
    }

    if ( ! empty( $this->get_blogs_settings('grid_gutter_tablet') ) ) {
        $grid_options['gutterTablet'] = $this->get_blogs_settings('grid_gutter_tablet');
    }

    if ( ! empty( $this->get_blogs_settings('grid_gutter_mobile') ) ) {
        $grid_options['gutterMobile'] = $this->get_blogs_settings('grid_gutter_mobile');
    }

    // Zigzag height.
    if ( ! empty( $this->get_blogs_settings('zigzag_height') ) ) {
        $grid_options['zigzagHeight'] = $this->get_blogs_settings('zigzag_height');
    }

    if ( ! empty( $this->get_blogs_settings('zigzag_height_tablet') ) ) {
        $grid_options['zigzagHeightTablet'] = $this->get_blogs_settings('zigzag_height_tablet');
    }

    if ( ! empty( $this->get_blogs_settings('zigzag_height_mobile') ) ) {
        $grid_options['zigzagHeightMobile'] = $this->get_blogs_settings('zigzag_height_mobile');
    }

    if ( ! empty( $this->get_blogs_settings('zigzag_reversed') ) && 'yes' === $this->get_blogs_settings('zigzag_reversed') ) {
        $grid_options['zigzagReversed'] = 1;
    }

    return $grid_options;
}

protected function get_grid_layout_four_options( array $settings ) {
    $grid_options = [
        'type'  => $this->get_blogs_settings('_dl_masonary_type_four'),
        'ratio' => 'null',
    ];

    // Columns.
    if ( ! empty( $this->get_blogs_settings('grid_columns_four') ) ) {
        $grid_options['columns'] = $this->get_blogs_settings('grid_columns_four');
    }

    if ( ! empty( $this->get_blogs_settings('grid_columns_four_tablet') ) ) {
        $grid_options['columnsTablet'] = $this->get_blogs_settings('grid_columns_four_tablet');
    }

    if ( ! empty( $this->get_blogs_settings('grid_columns_four_mobile') ) ) {
        $grid_options['columnsMobile'] = $this->get_blogs_settings('grid_columns_four_mobile');
    }

    // Gutter
    if ( ! empty( $this->get_blogs_settings('grid_gutter_four') ) ) {
        $grid_options['gutter'] = $this->get_blogs_settings('grid_gutter_four');
    }

    if ( ! empty( $this->get_blogs_settings('grid_gutter_four_tablet') ) ) {
        $grid_options['gutterTablet'] = $this->get_blogs_settings('grid_gutter_four_tablet');
    }

    if ( ! empty( $this->get_blogs_settings('grid_gutter_four_mobile') ) ) {
        $grid_options['gutterMobile'] = $this->get_blogs_settings('grid_gutter_four_mobile');
    }

    // Zigzag height.
    if ( ! empty( $this->get_blogs_settings('zigzag_height_four') ) ) {
        $grid_options['zigzagHeight'] = $this->get_blogs_settings('zigzag_height_four');
    }

    if ( ! empty( $this->get_blogs_settings('zigzag_height_four_tablet') ) ) {
        $grid_options['zigzagHeightTablet'] = $this->get_blogs_settings('zigzag_height_four_tablet');
    }

    if ( ! empty( $this->get_blogs_settings('zigzag_height_four_mobile') ) ) {
        $grid_options['zigzagHeightMobile'] = $this->get_blogs_settings('zigzag_height_four_mobile');
    }

    if ( ! empty( $this->get_blogs_settings('zigzag_reversed_four') ) && 'yes' === $this->get_blogs_settings('zigzag_reversed_four') ) {
        $grid_options['zigzagReversed'] = 1;
    }

    return $grid_options;
}

    protected function query_posts() {
        $settings = $this->get_settings_for_display();
        //order
        $order_by = !empty($this->get_blogs_settings('order_by')) ? $this->get_blogs_settings('order_by') : 'date';
        $order    = !empty($this->get_blogs_settings('order')) ? $this->get_blogs_settings('order') : 'asc';
        //post type
        $post_type = !empty($this->get_blogs_settings('post_type')) ? $this->get_blogs_settings('post_type') : 'post';
        //post sticky
        $sticky_post = $this->get_blogs_settings('ignore_sticky_posts') ? true : false;
        //posts per page
        $posts_per_page = $this->get_blogs_settings('posts_per_page');

        $arrayType = ['page', 'by_id', 'category'];

        $query_args = [
            'post_type'      =>  $post_type,
            'posts_ids'      => [],
            'orderby'        => $order_by,
            'order'          => $order,
            'offset'         => 0,
            'posts_per_page' => 6,
           
        ];
        if( !empty( $post_type ) && !in_array($post_type, $arrayType) ){
            $sticky_args = array(
                 'ignore_sticky_posts' => $sticky_post,
            );

            $query_args = array_merge( $query_args, $sticky_args );
        }
        if( !empty( $posts_per_page )){
            $per_page_args = array(
                'posts_per_page' => $posts_per_page,
            );

            $query_args = array_merge( $query_args, $per_page_args );
        }
        $tax_query[] = [
            'taxonomy' => 'post_format',
            'field'    => 'slug',
            'terms'    => ['post-format-quote', 'post-format-link'],
            'operator' => 'NOT IN',
        ];
        if ( !empty( $tax_query ) ) {
            $tax_query = array_merge( ['relation' => 'AND'], $tax_query );
            $query_args = array_merge( $query_args, ['tax_query' => $tax_query] );
        }
        
        $dl_query = new \WP_Query($query_args);
        return $dl_query;
    }
    //Html render
    protected function render(){ 
        $settings = $this->get_settings_for_display();

        $_dl_blog_skin  = isset($settings['_dl_blog_skin']) && !empty($settings['_dl_blog_skin']) ? $settings['_dl_blog_skin'] : '_skin_1';
   
        switch ($_dl_blog_skin) {
            case '_skin_1':
                 $this->_dl_blog_skin_one();
                break;
            case '_skin_2':
                 $this->_dl_blog_skin_two();
                break;
            case '_skin_3':
                 $this->_dl_blog_skin_three();
                break;
            case '_skin_4':
                 $this->_dl_blog_skin_four();
                break;
            default:
                $this->_dl_blog_skin_one();
                break;
        }
        ?>
        <script>
            jQuery(".dl_addons_grid_wrapper").each(function () {
                var dl_addons_grid_wrapper = jQuery('.dl_addons_grid_wrapper');
                if (dl_addons_grid_wrapper.length) {
                    jQuery(this).dlAddonsGridLayout();
                }
            });
        </script>   
        <?php
    }

    protected function _dl_blog_skin_one(){ 
        $settings = $this->get_settings_for_display();
        
        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }

        $this->add_render_attribute( 'wrapper', 'class', [
            'dl_addons_grid_wrapper dl_grid_metro',
            'style-masonary',
        ] );

        $this->add_render_attribute( 'wrapper', 'class', 'blog-grid-masonary' );
 
        $grid_options = $this->get_grid_options( $settings );

        $this->add_render_attribute( 'wrapper', 'data-grid', wp_json_encode( $grid_options ) );
        if ( isset( $settings['grid_metro_layout'] ) && !empty($settings['grid_metro_layout']) ) {
            $metro_layout = [];

        foreach ( $this->get_blogs_settings('grid_metro_layout') as $key => $value ) {
            $metro_layout[] = $value['size'];
            
            }
        } else {
            $metro_layout = [
                '2:2',
                '1:1',
                '1:1',
                '2:2',
                '1:1',      
                '1:1',      
            ];
        }
    if ( count( $metro_layout ) < 1 ) {
        return;
    }
    $metro_layout_count = count( $metro_layout );
    $metro_item_count   = 0;
    $count              = $query_posts->post_count;
        ?>

            <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <div class="dl_addons_grid">
                <div class="grid-sizer"></div>
                    <?php 
                    while ( $query_posts->have_posts() ) :
                        $query_posts->the_post();
                        $this->current_permalink = get_permalink();
                        $classes = "grid-item";
                         
                        $size   = $metro_layout[ $metro_item_count ];

                        $ratio  = explode( ':', $size );
                  
                        $ratioW = $ratio[0];
                        $ratioH = $ratio[1];

                        $_image_width  = $this->get_blogs_settings('metro_image_size_width');
                        $_image_height = $_image_width * isset($this->get_blogs_settings('metro_image_ratio')['size'])? $this->get_blogs_settings('metro_image_ratio')['size'] : '';
                         
                        if ( in_array( $ratioW, array( '2' ) ) ) {
                            $_image_width *= 1;
                        }

                        if ( in_array( $ratioH, array( '1.3', '2' ) ) ) {
                            $_image_height *= 2;
                        }
                    ?>
                      <div class="<?php echo $classes; ?>" data-width="<?php echo esc_attr( $ratioW ); ?>" data-height="<?php echo esc_attr( $ratioH ); ?>">

                        <div class="grid-item-height" style="height: 950px;">
                            <div class="grid-item-content dl_masonry_blog_post zoom_in_effect droit-post__area blog_grid_masonory">
                                <a href="<?php echo $this->current_permalink; ?>" class="dl_masonry_blog_thumb">
                                    <?php $this->render_thumbnails(); ?>
                                </a>
                                 <?php $this->render_category();  ?>
                                <div class="dl_masonry_blog_content blog_grid_masonory_content">
                                    <div class="dl_post_meta">
                                         <?php
                                            $this->render_date(); 
                                            $this->render_author();
                                        ?>
                                    </div>
                                    <?php $this->render_title(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    $metro_item_count++;
                    if ( $metro_item_count == $count || $metro_layout_count == $metro_item_count ) {
                        $metro_item_count = null;
                    }
                endwhile; 
                wp_reset_postdata();
                ?>
                 </div>
            </div>
    <?php }

    protected function render_post_header() {
        $settings = $this->get_settings_for_display();
        ?>
        <div <?php post_class( [  $this->get_blogs_settings('_dl_blog_skin'), 'dl_row' ] ); ?>>
        <?php
    }

    protected function render_post_footer() {
        ?>
        </div>
        <?php
    }
    protected function _dl_blog_skin_two()
    { 
        $settings = $this->get_settings_for_display();
        
        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }
        //Columns
        $columns = isset($settings['_dl_blog_columns']) && !empty($settings['_dl_blog_columns']) ? $settings['_dl_blog_columns'] : 4;
        
        $this->render_post_header();
        while ( $query_posts->have_posts() ) :
              $query_posts->the_post();
              $this->current_permalink = get_permalink();

        ?>
         <div class="dl_col_lg_<?php echo $columns; ?> dl_col_sm_<?php echo $this->get_blogs_settings('_dl_blog_columns_tablet'); ?>">
            
            <div class="droit-post__area blog_grid_masonory style_5 zoom_in_effect">
                <?php 
                if ( $this->get_blogs_settings('show_thumb') == 'yes'):
                 ?>
                <a href="<?php echo $this->current_permalink; ?>" class="post_thumb">
                    <?php $this->render_thumbnails();?>
                </a>
            <?php endif; ?>
                 <?php $this->render_category();  ?>
                <div class="blog_grid_masonory_content">
                     <?php $this->render_title(); ?>
                    <div class="dl_post_meta">
                        <?php
                            $this->render_author();
                            $this->render_date(); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
         <?php endwhile;
         wp_reset_postdata(); 
           $this->render_post_footer();
          ?>
   <?php }
    protected function _dl_blog_skin_three()
    { 
        $settings = $this->get_settings_for_display();
        
        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }
        //Columns
        $columns = isset($settings['_dl_blog_columns']) && !empty($settings['_dl_blog_columns']) ? $settings['_dl_blog_columns'] : 4;
        
        $this->render_post_header();
        while ( $query_posts->have_posts() ) :
              $query_posts->the_post();
              $this->current_permalink = get_permalink();
        ?>
         <div class="dl_col_lg_<?php echo $columns; ?> dl_col_sm_<?php echo $this->get_blogs_settings('_dl_blog_columns_tablet'); ?>">
            
            <div class="droit-post__area dl_blog_grid_masonory_post style_8 zoom_in_effect">
                 <a href="<?php echo $this->current_permalink; ?>" class="dl_blog_grid_masonory_img">
                    <?php $this->render_thumbnails();?>
                </a>
                <div class="dl_post_box_content">
                    <?php 
                        $this->render_category();
                        $this->render_title();
                        $this->render_excerpt()
                     ?>
                    <div class="dl_post_meta">
                        <?php
                            $this->render_avatar();
                            $this->render_author();
                            $this->render_date(); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
         <?php endwhile;
         wp_reset_postdata(); 
           $this->render_post_footer();
          ?>
   <?php }

   protected function _dl_blog_skin_four(){ 
        $settings = $this->get_settings_for_display();
        
        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }

        $this->add_render_attribute( 'wrapper', 'class', [
            'dl_addons_grid_wrapper dl_grid_metro',
            'style-masonary',
        ] );

        $this->add_render_attribute( 'wrapper', 'class', 'blog-grid-masonary' );

        $grid_options = $this->get_grid_layout_four_options( $settings );

        $this->add_render_attribute( 'wrapper', 'data-grid', wp_json_encode( $grid_options ) );

        $metro_item_count   = 0;
    
        ?>
            <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <div class="dl_addons_grid loaded">
                <div class="grid-sizer"></div>
                    <?php 
                    while ( $query_posts->have_posts() ) :
                        $query_posts->the_post();
                        $this->current_permalink = get_permalink();
                        $classes = "grid-item";

                        $_image_width  = $this->get_blogs_settings('metro_image_size_width_four');
                        $_image_height = $_image_width * isset($this->get_blogs_settings('metro_image_ratio_four')['size'])? $this->get_blogs_settings('metro_image_ratio_four')['size'] : '';

                    ?>
                      <div class="<?php echo $classes; ?>">
                        
                        <div class="droit-post__area dl_blog_grid_masonory_post style_6">
                            <a href="<?php echo $this->current_permalink; ?>" class="dl_blog_grid_masonory_post_thumb">
                               <?php $this->render_thumbnails(); ?>
                            </a>
                            <div class="dl_blog_grid_masonory_post_inner">
                                <div class="dl_post_meta">
                                    <?php 
                                        $this->render_avatar(); 
                                        $this->render_author(); 
                                        $this->render_date(); 
                                        ?>
                                </div>
                                <div class="dl_blog_grid_masonory_content">
                                    <?php $this->render_title(); ?>
                                    <?php $this->render_excerpt(); ?>
                                    <?php $this->render_read_more(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                 </div>
            </div>
    <?php }
    
    protected function content_template(){}
}
