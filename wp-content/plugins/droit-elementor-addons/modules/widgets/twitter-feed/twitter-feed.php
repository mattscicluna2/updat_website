<?php
/**
 * @package droitelementoraddons
 * @developer DroitLab Team
 *
 */
namespace DROIT_ELEMENTOR\Widgets;

use \DROIT_ELEMENTOR\Modules\Widgets\Twitter_Feed\Twitter_Feed_Control as Control;
use \DROIT_ELEMENTOR\Modules\Widgets\Twitter_Feed\Twitter_Feed_Module as Module;
use \Elementor\Group_Control_Image_Size;
use \DROIT_ELEMENTOR\Utils as Droit_Utils;
if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Twitter_Feed extends Control
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
      $this->register_twitter_feed_preset_controls();
      $this->register_twitter_feed_option_controls();
      $this->register_general_style_section();
      $this->register_users_style_section();
      $this->register_content_style_section();
      $this->register_date_style_section();
      do_action('dl_widget/section/style/custom_css', $this);
    }

    //Html render
    protected function render(){
        
        $settings = $this->get_settings_for_display();

         $_dl_twitter_feed_skin  =  !empty($this->get_twitter_feed_settings('_dl_twitter_feed_skin')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_skin') : '';

        switch ($_dl_twitter_feed_skin) {
            case '_skin_1':
                 $this->_second_twitter_feed_layout();
                break;
            case '_skin_2':
                 $this->_third_twitter_feed_layout();
                break;
            default:
                $this->_default_twitter_feed_layout();
                break;
        } 
    }


   protected function _default_twitter_feed_layout(){
    $settings = $this->get_settings_for_display();

    
    $token = get_option($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_token');
    $items = get_transient($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_cache');

    if (empty($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_key')) || empty($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_secret'))) {
            return;
        }

    if ($items === false) {
        if (empty($token)) {
             $credentials = base64_encode($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_key') . ':' . $this->get_twitter_feed_settings('_dl_twitter_feed_consumer_secret'));

              add_filter('https_ssl_verify', '__return_false');
                $response = wp_remote_post('https://api.twitter.com/oauth2/token', [
                    'method' => 'POST',
                    'httpversion' => '1.1',
                    'blocking' => true,
                    'headers' => [
                        'Authorization' => 'Basic ' . $credentials,
                        'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                    ],
                    'body' => ['grant_type' => 'client_credentials'],
                ]);
                $body = json_decode(wp_remote_retrieve_body($response));

                if ($body) {
                    update_option($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_token', $body->access_token);
                    $token = $body->access_token;
                }
                $body = json_decode(wp_remote_retrieve_body($response));       
            }
             
            add_filter('https_ssl_verify', '__return_false');

            $response = wp_remote_get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '&count=999&tweet_mode=extended', [
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => [
                    'Authorization' => "Bearer $token",
                ],
            ]);

            if (!is_wp_error($response)) {
                $items = json_decode(wp_remote_retrieve_body($response), true);
                //set_transient($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_cache', $items, 1800);
            }
        }
        if (empty($items)) {
            return;
        }

        $items = array_splice($items, 0, $this->get_twitter_feed_settings('_dl_twitter_feed_post_limit'));

        //Columns
        $columns_desc = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type') : 4;

        $columns_tablet = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_tablet')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_tablet') : 6;

        $columns_mobile = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_mobile')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_mobile') : 12;

        //Wrapper class
        $this->add_render_attribute( 'twitter_feed_wraper', 'class', [
            "droit-twiter-feed-wrapper",
            "dl_col_lg_{$columns_desc}",
            "dl_col_sm_{$columns_tablet}",
            "dl_col_sm_{$columns_mobile}",
        ] );

        $wrapper_attributes = $this->get_render_attribute_string( 'twitter_feed_wraper' );
        
        $this->add_render_attribute( 'twitter_feed_inner_wraper', 'class', [
            "dl_social_feed_wrapper",
            "dl_style_02",
            "droit-twiter-feed-wrapper-inner",
        ] );

        $wrapper_attributes_inner = $this->get_render_attribute_string( 'twitter_feed_inner_wraper' );

        //Account information
        $acc_name = $this->get_twitter_feed_settings('_dl_twitter_feed_account_name');
        $desc_length = $this->get_twitter_feed_settings('_dl_twitter_feed_content_length');
        $readmore_text = $this->get_twitter_feed_settings('_dl_twitter_feed_readmore_text');
    ?>

   <div class="dl_row">
    <?php if ($items > 0): ?>
    <?php foreach ($items as $index => $item): 
        $date = date( 'F j, Y', strtotime($item['created_at']));
        $description = strlen($item['full_text']) > $desc_length ? '...' : '';
        $link_free_text = isset($item['entities']['urls'][0]['url'])?str_replace($item['entities']['urls'][0]['url'], '', $item['full_text']):$item['full_text'];

        $details_url = @$item['user']['screen_name'] . '/status/' . $item['id_str'];
        ?>
        <div <?php echo $wrapper_attributes;?>>
            <div <?php echo $wrapper_attributes_inner;?>>
                <div class="top_social_feed droit-twitter-social-feed">
                    <div class="top_social_feed_info">
                        <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_name') === 'yes'): ?>
                        <h4 class="dl_name droit-twitter-name"><?php echo esc_html($item['user']['name']); ?></h4>
                    <?php endif;?>
                        <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_user_name') === 'yes'): ?>
                        <a href="//twitter.com/<?php echo $acc_name; ?>" target="_blank" class="dl_username droit-twitter-username"><?php echo esc_html($acc_name); ?></a>
                    <?php endif;?>
                    </div>
                    <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_logo') === 'yes'): ?>
                        <div class="social_icon droit-twitter-social">
                            <a href="//twitter.com/<?php echo $acc_name; ?>" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="//twitter.com/<?php echo $details_url; ?>" target="_blank">
                    <p class="dl_desc droit-twitter-desc"> <?php echo esc_attr(substr( $link_free_text, 0, $desc_length) . $description); ?> </p>
                </a>
                <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_date') === 'yes'): ?>
                    <p class="dl_date droit-twitter-date"><?php echo $date; ?></p>
                <?php endif; ?>
                
            </div>
        </div>
   <?php endforeach; endif ?>
        </div>
  <?php }

   protected function _second_twitter_feed_layout(){
    $settings = $this->get_settings_for_display();

    
    $token = get_option($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_token');
    $items = get_transient($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_cache');

    if (empty($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_key')) || empty($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_secret'))) {
            return;
        }

    if ($items === false) {
        if (empty($token)) {
             $credentials = base64_encode($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_key') . ':' . $this->get_twitter_feed_settings('_dl_twitter_feed_consumer_secret'));

              add_filter('https_ssl_verify', '__return_false');
                $response = wp_remote_post('https://api.twitter.com/oauth2/token', [
                    'method' => 'POST',
                    'httpversion' => '1.1',
                    'blocking' => true,
                    'headers' => [
                        'Authorization' => 'Basic ' . $credentials,
                        'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                    ],
                    'body' => ['grant_type' => 'client_credentials'],
                ]);
                $body = json_decode(wp_remote_retrieve_body($response));
                if ($body) {
                    update_option($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_token', $body->access_token);
                    $token = $body->access_token;
                }
                $body = json_decode(wp_remote_retrieve_body($response));
                 
        }

        $args = array(
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => array(
                    'Authorization' => "Bearer $token",
                ),
            );

            add_filter('https_ssl_verify', '__return_false');

            $response = wp_remote_get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '&count=999&tweet_mode=extended', [
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => [
                    'Authorization' => "Bearer $token",
                ],
            ]);

            if (!is_wp_error($response)) {
                $items = json_decode(wp_remote_retrieve_body($response), true);
                //set_transient($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_cache', $items, 1800);
            }
    }

        if (empty($items)) {
            return;
        }

        $items = array_splice($items, 0, $this->get_twitter_feed_settings('_dl_twitter_feed_post_limit'));

        //Columns
        $columns_desc = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type') : 4;

        $columns_tablet = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_tablet')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_tablet') : 6;

        $columns_mobile = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_mobile')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_mobile') : 12;

        //Wrapper class
        $this->add_render_attribute( 'twitter_feed_wraper', 'class', [
            "droit-twiter-feed-wrapper",
            "dl_col_lg_{$columns_desc}",
            "dl_col_sm_{$columns_tablet}",
            "dl_col_sm_{$columns_mobile}",
        ] );

        $wrapper_attributes = $this->get_render_attribute_string( 'twitter_feed_wraper' );
        
        $this->add_render_attribute( 'twitter_feed_inner_wraper', 'class', [
            "dl_social_feed_wrapper",
            "dl_style_06",
            "droit-twiter-feed-wrapper-inner",
        ] );

        $wrapper_attributes_inner = $this->get_render_attribute_string( 'twitter_feed_inner_wraper' );

        //Account information
        $acc_name = $this->get_twitter_feed_settings('_dl_twitter_feed_account_name');
        $desc_length = $this->get_twitter_feed_settings('_dl_twitter_feed_content_length');
    ?>

   <div class="dl_row">
    <?php foreach ($items as $index => $item): 
        $description = strlen($item['full_text']) > $desc_length ? '...' : '';
        $link_free_text = isset($item['entities']['urls'][0]['url'])?str_replace($item['entities']['urls'][0]['url'], '', $item['full_text']):$item['full_text'];
        $details_url = @$item['user']['screen_name'] . '/status/' . $item['id_str'];
        ?>
        <div <?php echo $wrapper_attributes;?>>
            <div <?php echo $wrapper_attributes_inner;?>>
                <a href="//twitter.com/<?php echo $details_url; ?>" target="_blank">
                    <p class="dl_desc droit-twitter-desc"> <?php echo esc_attr(substr( $link_free_text, 0, $desc_length) . $description); ?> </p>
                </a>
                
                <div class="top_social_feed">
                    <div class="dl_prodile_info">
                        <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_avater') === 'yes'): ?>
                            <img src="<?php echo esc_url($item['user']['profile_image_url_https']); ?>" alt="#" class="dl_client_thumb droit-feed-profile-image">
                        <?php endif;?>
                        <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_name') === 'yes'): ?>
                            <h4 class="dl_name">
                                <a href="//twitter.com/<?php echo $acc_name; ?>" target="_blank" class="droit-twitter-name"><?php echo esc_html($item['user']['name']); ?></a>
                            </h4>
                        <?php endif;?>
                    </div>
                    <a href="//twitter.com/<?php echo $details_url; ?>" target="_blank" class="social_icon">
                        <?php echo esc_html( $item['favorite_count'] ); ?>
                        <?php if ($item['favorite_count'] == 0): ?>
                            <i class="fa fa-heart-o"></i>
                        <?php else: ?>
                            <i class="fas fa-heart"></i>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
   <?php endforeach ?>
        </div>
  <?php }

protected function _third_twitter_feed_layout(){
    $settings = $this->get_settings_for_display();

    
    $token = get_option($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_token');
    $items = get_transient($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_cache');

    if (empty($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_key')) || empty($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_secret'))) {
            return;
        }

    if ($items === false) {
        if (empty($token)) {
             $credentials = base64_encode($this->get_twitter_feed_settings('_dl_twitter_feed_consumer_key') . ':' . $this->get_twitter_feed_settings('_dl_twitter_feed_consumer_secret'));

              add_filter('https_ssl_verify', '__return_false');
                $response = wp_remote_post('https://api.twitter.com/oauth2/token', [
                    'method' => 'POST',
                    'httpversion' => '1.1',
                    'blocking' => true,
                    'headers' => [
                        'Authorization' => 'Basic ' . $credentials,
                        'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                    ],
                    'body' => ['grant_type' => 'client_credentials'],
                ]);
                $body = json_decode(wp_remote_retrieve_body($response));
                if ($body) {
                    update_option($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_token', $body->access_token);
                    $token = $body->access_token;
                }
                $body = json_decode(wp_remote_retrieve_body($response));
                 
        }

            add_filter('https_ssl_verify', '__return_false');

            $response = wp_remote_get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '&count=999&tweet_mode=extended', [
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => [
                    'Authorization' => "Bearer $token",
                ],
            ]);

            if (!is_wp_error($response)) {
                $items = json_decode(wp_remote_retrieve_body($response), true);
                //set_transient($this->get_id() . '_' . $this->get_twitter_feed_settings('_dl_twitter_feed_account_name') . '_twitter_feed_cache', $items, 1800);
            }
    }

        if (empty($items)) {
            return;
        }

        $items = array_splice($items, 0, $this->get_twitter_feed_settings('_dl_twitter_feed_post_limit'));

        //Columns
        $columns_desc = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type') : 4;

        $columns_tablet = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_tablet')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_tablet') : 6;

        $columns_mobile = !empty($this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_mobile')) ? $this->get_twitter_feed_settings('_dl_twitter_feed_type_col_type_mobile') : 12;

        //Wrapper class
        $this->add_render_attribute( 'twitter_feed_wraper', 'class', [
            "droit-twiter-feed-wrapper",
            "dl_col_lg_{$columns_desc}",
            "dl_col_sm_{$columns_tablet}",
            "dl_col_sm_{$columns_mobile}",
        ] );

        $wrapper_attributes = $this->get_render_attribute_string( 'twitter_feed_wraper' );
        
        $this->add_render_attribute( 'twitter_feed_inner_wraper', 'class', [
            "dl_social_feed_wrapper",
            "dl_style_08",
            "droit-twiter-feed-wrapper-inner",
        ] );

        $wrapper_attributes_inner = $this->get_render_attribute_string( 'twitter_feed_inner_wraper' );

        //Account information
        $acc_name = $this->get_twitter_feed_settings('_dl_twitter_feed_account_name');
        $desc_length = $this->get_twitter_feed_settings('_dl_twitter_feed_content_length');
    ?>

   <div class="dl_row">
    <?php foreach ($items as $index => $item): 
        $description = strlen($item['full_text']) > $desc_length ? '...' : '';
        $link_free_text = isset($item['entities']['urls'][0]['url'])?str_replace($item['entities']['urls'][0]['url'], '', $item['full_text']):$item['full_text'];
        $details_url = @$item['user']['screen_name'] . '/status/' . $item['id_str'];
        ?>
        <div <?php echo $wrapper_attributes;?>>
            <div <?php echo $wrapper_attributes_inner;?>>
                <a href="//twitter.com/<?php echo $details_url; ?>" target="_blank">
                    <p class="dl_desc droit-twitter-desc"> <?php echo esc_attr(substr( $link_free_text, 0, $desc_length) . $description); ?> </p>
                </a>
                <div class="top_social_feed">
                    <div class="dl_prodile_info">
                        <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_avater') === 'yes'): ?>
                            <img src="<?php echo esc_url($item['user']['profile_image_url_https']); ?>" alt="#" class="dl_client_thumb droit-feed-profile-image">
                        <?php endif;?>
                        <?php if ($this->get_twitter_feed_settings('_dl_twitter_feed_show_name') === 'yes'): ?>
                            <h4 class="dl_name">
                                <a href="//twitter.com/<?php echo $acc_name; ?>" target="_blank" class="droit-twitter-name"><?php echo esc_html($item['user']['name']); ?></a>
                            </h4>
                        <?php endif;?>
                    </div>
                    <a href="//twitter.com/<?php echo $details_url; ?>" target="_blank" class="social_icon">
                        <?php echo esc_html( $item['favorite_count'] ); ?>
                        <?php if ($item['favorite_count'] == 0): ?>
                            <i class="fa fa-heart-o"></i>
                        <?php else: ?>
                            <i class="fas fa-heart"></i>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
   <?php endforeach ?>
        </div>
  <?php }
protected function content_template(){}
}
