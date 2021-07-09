<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package saasland
 */

$allowed_html = array(
	'a' => array(
		'href' => array(),
		'title' => array()
	),
	'br' => array(),
	'em' => array(),
	'strong' => array(),
    'iframe' => array(
        'src' => array(),
    )
);
$opt = get_option( 'saasland_opt' );
$is_post_meta = isset($opt['is_post_meta']) ? $opt['is_post_meta'] : '1';
$is_post_author = isset($opt['is_post_author']) ? $opt['is_post_author'] : '1';
$is_post_date = isset($opt['is_post_date']) ? $opt['is_post_date'] : '1';
$is_post_cat = isset($opt['is_post_cat']) ? $opt['is_post_cat'] : '';
$read_more = isset($opt['read_more']) ? $opt['read_more'] : esc_html__( 'Read More', 'saasland' );
?>

<div <?php post_class( 'blog_list_item blog_list_item_two' ); ?>>
    <?php
    if ( is_sticky() ) {
        echo '<p class="sticky-label">'.esc_html__( 'Featured', 'saasland' ).'</p>';
    }
    if ( has_post_thumbnail() ) :
        if ( $is_post_date == '1' ) : ?>
            <div class="post_date">
                <h2> <?php the_time( 'd' ) ?> <span> <?php the_time( 'M' ) ?> </span> </h2>
            </div>
        <?php endif; ?>
        <a href="<?php the_permalink() ?>">
            <?php the_post_thumbnail( 'saasland_770x480', array( 'class' => 'img-fluid')) ?>
        </a>
        <?php
    endif;
    ?>
    <div class="blog_content">
        <a class="blog_title" href="<?php the_permalink() ?>">
            <h5 class="blog_title"> <?php the_title() ?>  </h5>
        </a>
        <p> <?php echo strip_shortcodes(saasland_excerpt( 'blog_excerpt', false)); ?> </p>
        <div class="post-info-bottom">
            <a href="<?php the_permalink() ?>" class="learn_btn_two">
                <?php echo esc_html($read_more) ?> <i class="ti-arrow-right"></i>
            </a>
            <a class="post-info-comments" href="<?php the_permalink() ?>#comments">
                <i class="icon_comment_alt" aria-hidden="true"></i>
                <span> <?php saasland_comment_count(get_the_ID()) ?> </span>
            </a>
        </div>
    </div>
</div>