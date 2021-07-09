<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Bloglist\Bloglist_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Bloglist\Bloglist_Module as Module;
use \Elementor\Group_Control_Image_Size;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Bloglist extends Control
{

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

    public function get_script_depends()
    {
        return ['script-name'];
    }

    protected function _register_controls(){
      $this->register_blog_list_preset_controls();
      $this->register_blog_list_query_controls();
      $this->register_blog_list_general_style_controls();
      $this->register_blog_list_title_style_controls();
      $this->register_blog_list_content_style_controls();
      $this->register_blog_list_author_style_controls();
      $this->register_blog_list_date_style_controls();
      $this->register_blog_list_read_more_style_controls();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
        
        $cate_manual_arr = ['category', 'by_id'];

        if ( in_array( $this->get_blog_settings('_blog_list_post_type') , $cate_manual_arr ) ) {
                _droit_render_pro_message();
            }else{

            $_blog_skin  = !empty($this->get_blog_settings('_blog_list_skin')) ? $this->get_blog_settings('_blog_list_skin') : '_skin_1';

            switch ($_blog_skin) {
                case '_skin_1':
                    $this->_first_blog_list_layout();
                    break; 
                case '_skin_2':
                    $this->_second_blog_list_layout();
                    break;
                case '_skin_3':
                    $this->_third_blog_list_layout();
                    break;
                case '_skin_4':
                    $this->_four_blog_list_layout();
                    break;
                default:
                    $this->_first_blog_list_layout();
                    break;
            }
        }
    }

    //Query
    protected function query_posts() {

        //order
        $order_by = !empty($this->get_blog_settings('_blog_list_order_by')) ? $this->get_blog_settings('_blog_list_order_by') : 'date';
        $order    = !empty($this->get_blog_settings('_blog_list_order')) ? $this->get_blog_settings('_blog_list_order') : 'asc';
        //post type
        $post_type = !empty($this->get_blog_settings('_blog_list_post_type')) ? $this->get_blog_settings('_blog_list_post_type') : 'post';
        //post sticky
        $sticky_post = $this->get_blog_settings('_blog_list_ignore_sticky_posts') ? true : false;
        //posts per page
        $posts_per_page = $this->get_blog_settings('_blog_list_posts_per_page');

        $arrayType = ['page', 'by_id', 'category'];

        $query_args = [
            'post_type'      =>  $post_type,
            'posts_ids'      => [],
            'orderby'        => $order_by,
            'order'          => $order,
            'offset'         => 0,

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

    //Header
    protected function render_blog_list_post_header() {
        $settings = $this->get_settings_for_display();
        $p_id = get_the_ID();
        $this->add_render_attribute( 'blog_list_main_wrapper', 
            'class', [
            "droit-post__wrap dl_row {$this->get_blog_settings('_blog_list_skin')} post-{$p_id}",
        ] );

        $main_wrapper = $this->get_render_attribute_string( 'blog_list_main_wrapper' );
        ?>
        <div <?php echo $main_wrapper; ?>>
        <?php
    }

    //Footer
    protected function render_blog_list_post_footer() {
        ?>
        </div>
        <?php
    }

    protected function get_optional_link_attributes_html() {
        $settings = $this->get_settings_for_display();
        $new_tab_setting_key = $this->get_control_id( '_blog_list_open_new_tab' );
        $optional_attributes_html = 'yes' === $settings[ $new_tab_setting_key ] ? 'target="_blank"' : '';

        return $optional_attributes_html;
    }

    protected function render_title(){
        $settings = $this->get_settings_for_display();
        if (!$this->get_blog_settings('_blog_list_show_title')) {
            return;
        }
        $optional_attributes_html = $this->get_optional_link_attributes_html();

        $this->add_render_attribute( 'blog_list_title_wrapper', 'class', [
            "dl_title droit-blog-list-title",
        ] );

        $title_attributes = $this->get_render_attribute_string( 'blog_list_title_wrapper' );
        ?>
    
    <<?php echo esc_html( droit_title_tag($this->get_blog_settings('_blog_list_title_tag')) ); ?> <?php echo $title_attributes; ?>> 
        <a href="<?php echo esc_url($this->current_permalink); ?>" <?php echo $optional_attributes_html; ?>><?php the_title();?></a> 
    </<?php echo esc_html( droit_title_tag($this->get_blog_settings('_blog_list_title_tag')) ); ?>>
    <?php
    }

    protected function render_thumbnail() {
        $settings = $this->get_settings_for_display();
        
        if (!$this->get_blog_settings('_blog_list_show_thumb')) {
            return;
        }
        
        $setting_key = $this->get_control_id( '_blog_list_thumbnail_size' );
        $settings[ $setting_key ] = [
            'id' => get_post_thumbnail_id(),
        ];
        $thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, $setting_key );

        if ( empty( $thumbnail_html ) ) {
            return;
        }

        $optional_attributes_html = $this->get_optional_link_attributes_html();

        ?>
        <a class="dl_blog_thumb droit-post_list__thumbnail__link droit-post_list__thumbnail" href="<?php echo esc_url($this->current_permalink); ?>" <?php echo $optional_attributes_html; ?>>
            <?php echo $thumbnail_html; ?>
        </a>
        <?php
    }

    protected function render_excerpt() {
        $settings = $this->get_settings_for_display();
        
        if ( ! $this->get_blog_settings('_blog_list_show_excerpt') ) {
            return;
        }

         $content = strip_shortcodes( droit_shorten_text( get_the_excerpt(), $this->render_excerpt_length() ) ); 

        ?>
        <p class="droit-post_list_excerpt dl_description">
            <?php echo $content; ?>
        </p>
        <?php
    }

    protected function render_excerpt_length() {
        $settings = $this->get_settings_for_display();
        return $this->get_blog_settings('_blog_list_excerpt_length');
    }

    protected function _droit_get_link_attributes_html() {
        $settings = $this->get_settings_for_display();
        $new_tab_setting_key = $this->get_control_id( '_blog_list_open_new_tab' );
        $optional_attributes_html = 'yes' === $this->get_blog_settings($new_tab_setting_key ) ? 'target="_blank"' : '';

        return $optional_attributes_html;
    }

    protected function render_read_more(){

        $settings = $this->get_settings_for_display();
        if ( ! $this->get_blog_settings('_blog_list_show_read_more') ) {
            return;
        }

        $optional_attributes_html = $this->_droit_get_link_attributes_html();

        ?>
            <a class="droit-post_list_read-more dl_read_more_btn" href="<?php echo esc_url($this->current_permalink); ?>" <?php echo $optional_attributes_html; ?>>
                <?php echo $this->get_blog_settings('_blog_list_read_more_text'); ?>
            </a>
        <?php
    }

    protected function render_date() {
        $settings = $this->get_settings_for_display();
        
        if ( ! $this->get_blog_settings('_blog_list_show_date') ) {
            return;
        }
        ?>
        <a href="#" class="dl_date droit-post_list_date">
            <?php
            echo apply_filters( 'the_date', get_the_date(), get_option( 'date_format' ), '', '' );
            ?>
        </a>
        <?php
    }

    protected function render_author(){
        $settings = $this->get_settings_for_display();
        if (!$this->get_blog_settings('_blog_list_show_author')) {
            return;
        }
        $this->add_render_attribute( '_author_name', 'class', 'dl_post_author droit-post_list_author_name' );

        $icon_tag = 'span';

        if ( ! empty( $this->get_blog_settings('_blog_list_enable_author')) ) {
            $icon_tag = 'a';
            $auth_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
            $href = 'href="'.$auth_url.'"';
        }
        
        ?>
        <div class="dl_author_info droit-post_list_author">
            <?php $this->render_author_image(); ?>
            <<?php echo esc_html( $icon_tag ) . ' '. $href; ?> <?php echo $this->get_render_attribute_string( '_author_name' ); ?>><?php the_author();?></<?php echo esc_html($icon_tag); ?>>
        </div>
     <?php
    }

    protected function render_author_image(){
        $settings = $this->get_settings_for_display();
        if (!$this->get_blog_settings('_blog_list_show_author_image')) {
            return;
        }
        $author_id = get_the_author_meta( 'ID' );
        $auth_args = [
            'size' => '150',
        ];
        $auth_static = !empty($this->get_blog_settings('_blog_list_default_author_image')['url']) ? $this->get_blog_settings('_blog_list_default_author_image')['url'] : get_avatar_url($author_id, $auth_args); 
        
        ?>
       <img src="<?php echo $auth_static; ?>" alt="#" class="dl_author_img">
     <?php
    }


    // First Layout
    protected function _first_blog_list_layout(){
        $settings = $this->get_settings_for_display();

        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }
        //Columns
        $columns = !empty($this->get_blog_settings('_blog_list_columns')) ? $this->get_blog_settings('_blog_list_columns') : 2;
        
        $columns_mobile = !empty($this->get_blog_settings('_blog_list_columns_mobile')) ? $this->get_blog_settings('_blog_list_columns_mobile') : 12;
        
        $columns_tablet = !empty($this->get_blog_settings('_blog_list_columns_tablet')) ? $this->get_blog_settings('_blog_list_columns_tablet') : 6;

        $this->add_render_attribute( 'blog_list_wrapper', 'class', [
            "dl_col_lg_{$columns} dl_col_{$columns_mobile} dl_col_sm_{$columns_tablet} droit-blog_list_loop_wrap",
        ] );

        $this->add_render_attribute( 'blog_list_wrapper_inner', 'class', [
            "dl_blog_list_post dl_style_01 droit-blog_list_loop_post",
        ] );

        $wrapper_attributes = $this->get_render_attribute_string( 'blog_list_wrapper' );
        $wrapper_inner = $this->get_render_attribute_string( 'blog_list_wrapper_inner' );

        $this->render_blog_list_post_header();
        while ( $query_posts->have_posts() ) :
              $query_posts->the_post();
              $this->current_permalink = get_permalink();
        ?>
        <div <?php echo $wrapper_attributes; ?>>
            <div <?php echo $wrapper_inner; ?>>
                <?php echo $this->render_thumbnail(); ?>
                <div class="dl_blog_list_content_inner">
                    <?php $this->render_date(); ?>
                    <?php echo $this->render_title(); ?>
                   <?php echo $this->render_excerpt(); ?>
                    <div class="dl_post_meta">
                        <?php echo $this->render_author(); ?>
                        <?php echo $this->render_read_more(); ?>
                    </div>
                </div>
            </div>
        </div>
         <?php endwhile;
         wp_reset_postdata(); 
           $this->render_blog_list_post_footer();
          ?>
    <?php }

    // Second Layout
    protected function _second_blog_list_layout(){
        $settings = $this->get_settings_for_display();

        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }
        //Columns
        $columns = !empty($this->get_blog_settings('_blog_list_columns')) ? $this->get_blog_settings('_blog_list_columns') : 2;
        
         $columns_mobile = !empty($this->get_blog_settings('_blog_list_columns_mobile')) ? $this->get_blog_settings('_blog_list_columns_mobile') : 12;
        
        $columns_tablet = !empty($this->get_blog_settings('_blog_list_columns_tablet')) ? $this->get_blog_settings('_blog_list_columns_tablet') : 6;

        $this->add_render_attribute( 'blog_list_wrapper', 'class', [
            "dl_col_lg_{$columns} dl_col_{$columns_mobile} dl_col_sm_{$columns_tablet} droit-blog_list_loop_wrap",
        ] );

        $this->add_render_attribute( 'blog_list_wrapper_inner', 'class', [
            "dl_blog_list_post dl_style_03 droit-blog_list_loop_post",
        ] );

        $wrapper_attributes = $this->get_render_attribute_string( 'blog_list_wrapper' );
        $wrapper_inner = $this->get_render_attribute_string( 'blog_list_wrapper_inner' );

        $this->render_blog_list_post_header();
        while ( $query_posts->have_posts() ) :
              $query_posts->the_post();
              $this->current_permalink = get_permalink();
        ?>
        <div <?php echo $wrapper_attributes; ?>>
            <div <?php echo $wrapper_inner; ?>>
                <?php echo $this->render_thumbnail(); ?>
                <div class="dl_blog_list_content_inner">
                    <div class="dl_post_meta">
                        <?php $this->render_date(); ?>
                    </div>
                    <?php echo $this->render_title(); ?>
                </div>
            </div>
        </div>
         <?php endwhile;
            wp_reset_postdata(); 
           $this->render_blog_list_post_footer();
          ?>
    <?php }
    
    // Third Layout
    protected function _third_blog_list_layout(){
        $settings = $this->get_settings_for_display();

        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }
        //Columns
        $columns = !empty($this->get_blog_settings('_blog_list_columns')) ? $this->get_blog_settings('_blog_list_columns') : 2;
         $columns_mobile = !empty($this->get_blog_settings('_blog_list_columns_mobile')) ? $this->get_blog_settings('_blog_list_columns_mobile') : 12;
        
        $columns_tablet = !empty($this->get_blog_settings('_blog_list_columns_tablet')) ? $this->get_blog_settings('_blog_list_columns_tablet') : 6;

        $this->add_render_attribute( 'blog_list_wrapper', 'class', [
            "dl_col_lg_{$columns} dl_col_{$columns_mobile} dl_col_sm_{$columns_tablet} droit-blog_list_loop_wrap",
        ] );

        $this->add_render_attribute( 'blog_list_wrapper_inner', 'class', [
            "dl_blog_list_post dl_style_05 droit-blog_list_loop_post",
        ] );

        $wrapper_attributes = $this->get_render_attribute_string( 'blog_list_wrapper' );
        $wrapper_inner = $this->get_render_attribute_string( 'blog_list_wrapper_inner' );

        $this->render_blog_list_post_header();
        while ( $query_posts->have_posts() ) :
              $query_posts->the_post();
              $this->current_permalink = get_permalink();
        ?>
        <div <?php echo $wrapper_attributes; ?>>
            <div <?php echo $wrapper_inner; ?>>
                <?php echo $this->render_thumbnail(); ?>
                <div class="dl_blog_list_content_inner">
                    <?php $this->render_date(); ?>
                    <?php echo $this->render_title(); ?>
                </div>
            </div>
        </div>
         <?php endwhile;
            wp_reset_postdata(); 
           $this->render_blog_list_post_footer();
          ?>
    <?php }
    
    // Four Layout
    protected function _four_blog_list_layout(){
        $settings = $this->get_settings_for_display();

        $query_posts = $this->query_posts();
      
        if (!$query_posts->found_posts) {
            return;
        }
        //Columns
        $columns = !empty($this->get_blog_settings('_blog_list_columns')) ? $this->get_blog_settings('_blog_list_columns') : 2;
        
        $columns_mobile = !empty($this->get_blog_settings('_blog_list_columns_mobile')) ? $this->get_blog_settings('_blog_list_columns_mobile') : 12;
        
        $columns_tablet = !empty($this->get_blog_settings('_blog_list_columns_tablet')) ? $this->get_blog_settings('_blog_list_columns_tablet') : 6;

        $this->add_render_attribute( 'blog_list_wrapper', 'class', [
            "dl_col_lg_{$columns} dl_col_{$columns_mobile} dl_col_sm_{$columns_tablet} droit-blog_list_loop_wrap",
        ] );

        $this->add_render_attribute( 'blog_list_wrapper_inner', 'class', [
            "dl_blog_list_post dl_style_07 droit-blog_list_loop_post",
        ] );

        $wrapper_attributes = $this->get_render_attribute_string( 'blog_list_wrapper' );
        $wrapper_inner = $this->get_render_attribute_string( 'blog_list_wrapper_inner' );

        $this->render_blog_list_post_header();
        while ( $query_posts->have_posts() ) :
              $query_posts->the_post();
              $this->current_permalink = get_permalink();
        ?>
        <div <?php echo $wrapper_attributes; ?>>
            <div <?php echo $wrapper_inner; ?>>
                <?php echo $this->render_thumbnail(); ?>
                <div class="dl_blog_list_content_inner">
                    <?php $this->render_date(); ?>
                    <?php echo $this->render_title(); ?>
                    <?php echo $this->render_excerpt(); ?>
                    <div class="dl_post_meta">
                        <?php echo $this->render_read_more(); ?>
                    </div>
                </div>
            </div>
        </div>
         <?php endwhile;
            wp_reset_postdata(); 
           $this->render_blog_list_post_footer();
          ?>
    <?php }
    
    protected function content_template()
    {}
}
