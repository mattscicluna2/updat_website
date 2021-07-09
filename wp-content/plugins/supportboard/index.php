<?php

/*
 *
 * Plugin Name: Support Board
 * Plugin URI: https://board.support/
 * Description: WordPress Smart Chat Powered by Dialogflow and Slack.
 * Version: 3.0.8
 * Author: Schiocco
 * Author URI: https://schiocco.com/
 * © 2020 board.support. All rights reserved.
 *
 */

define('SB_WP', true);
if (file_exists('supportboard/config.php')) {
    require_once('supportboard/config.php');
}

function sb_boot_session() {
    require_once('supportboard/include/functions.php');
    if (sb_is_admin_page() && session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    sb_updates_check();
}

add_action('wp_loaded', 'sb_boot_session');

/*
 * ----------------------------------------------------------
 * # ADMIN AREA
 * ----------------------------------------------------------
 *
 * Display the administration area and the nav menu
 *
 */

function sb_set_admin_menu() {
    $current_user = wp_get_current_user();
    $allowed_roles = array('editor', 'administrator', 'author');
    if (array_intersect($allowed_roles, $current_user->roles)) {
        add_menu_page('Support Board', 'Support Board', 'read', 'support-board', 'sb_admin_action', SB_URL . '/media/icon-18x18.svg');
    }
}

function sb_admin_action() {
    global $SB_LOGIN;
    require_once('supportboard/include/functions.php');
    require_once('supportboard/include/components.php');
    require_once('supportboard/apps/wordpress/functions.php');
    if (sb_db_check_connection() !== true) {
        sb_installation(sb_installation_array());
    }
    if (!isset($_SESSION['sb-session']) || !sb_is_agent()) {
        $settings = false;
        $current_user = wp_get_current_user();
        $db_user = sb_db_get('SELECT id, profile_image, first_name, last_name, email, user_type, token, password FROM sb_users WHERE email = "' . $current_user->user_email . '" LIMIT 1');
        if (isset($db_user) && $db_user != '' && isset($db_user['password']) && $current_user->user_pass == $db_user['password']) {
            $settings =  ['id' => $db_user['id'], 'profile_image' => $db_user['profile_image'], 'first_name' => $db_user['first_name'], 'last_name' => $db_user['last_name'], 'email' => $db_user['email'], 'user_type' => $db_user['user_type'], 'token' => $db_user['token']];
        } else if (in_array('administrator', $current_user->roles)) {
            $wp_user = sb_wp_user_array($current_user);
            $now = gmdate('Y-m-d H:i:s');
            $token = bin2hex(openssl_random_pseudo_bytes(20));
            $profile_image = plugins_url() . '/supportboard/supportboard/media/user.svg';
            $first_name = sb_db_escape($wp_user['first-name'][0]);
            $last_name = sb_db_escape($wp_user['last-name'][0]);
            $email = $wp_user['email'][0] == '' ? 'NULL' : '"' . $wp_user['email'][0] . '"';
            $query = 'INSERT INTO sb_users(first_name, last_name, password, email, profile_image, user_type, creation_time, token, last_activity) VALUES ("' . $first_name . '", "' . $last_name . '", "' . sb_db_escape($wp_user['password'][0]) . '", ' . $email . ', "' . $profile_image . '", "admin", "' . $now . '", "' . $token . '", "' . $now . '")';
            $id = sb_db_query($query, true);
            if (!sb_is_error($id)) {
                $settings =  ['id' => $id, 'profile_image' => $profile_image, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'user_type' => 'admin', 'token' => $token];
            }
        }
        if ($settings != false) {
            $_SESSION['sb-session'] = $settings;
            $SB_LOGIN = $settings;
        }
    }
    sb_component_admin();
    sb_js_global();
    sb_js_admin();
}

function sb_enqueue_admin() {
    if (sb_is_admin_page()) {
        wp_enqueue_style('sb-admin-css', SB_URL . '/css/min/admin.min.css', [], SB_VERSION, 'all');
        wp_enqueue_style('sb-wp-admin-css', SB_URL . '/apps/wordpress/admin.css', [], SB_VERSION, 'all');
        wp_enqueue_script('sb-js', SB_URL . '/js/main.js', ['jquery'], SB_VERSION);
        wp_enqueue_script('sb-admin-js', SB_URL . '/js/admin.js', ['jquery'], SB_VERSION);
        wp_add_inline_script('sb-admin-js', 'var SB_WP = true;');
    }
}

function sb_on_user_update($meta, $user_data, $update) {
    if ($update !== true) return $meta;
    require_once('supportboard/include/functions.php');
    if ($meta['first_name'] == '') {
        $meta['first_name'] = ucfirst($meta['nickname']);
    }
    $result = sb_db_query('UPDATE sb_users SET first_name = "' . sb_db_escape($meta['first_name']) . '", last_name = "' . sb_db_escape($meta['last_name']) . '", email = "' . sb_db_escape($_POST['email']) . '"' . ($_POST['pass1'] != '' ? ', password = "' . wp_hash_password($_POST['pass1']) . '"' : '') .' WHERE email = "' . $user_data->data->user_email . '" LIMIT 1');
    return $meta;
}

/*
 * ----------------------------------------------------------
 * # FRONT END AREA
 * ----------------------------------------------------------
 *
 * Front end area functions
 *
 */

function sb_enqueue() {
    require_once('supportboard/include/functions.php');
    if (sb_get_setting('wp-manual') !== true) {
        $page_id = get_the_ID();
        $user_data = 'false';
        $lang = '';
        $inline_code = '';
        $exclusions = [sb_get_multi_setting('wp-visibility', 'wp-visibility-ids'), sb_get_multi_setting('wp-visibility', 'wp-visibility-post-types'), sb_get_multi_setting('wp-visibility', 'wp-visibility-type')];
        $exclusions = [($exclusions[0] == '' ? [] : array_map('trim', explode(',', $exclusions[0]))), ($exclusions[1] == '' ? [] : array_map('trim', explode(',', $exclusions[1]))), $exclusions[2]];
        $force_languge = sb_get_setting('wp-language');
        if ($exclusions[2] != false && (count($exclusions[0]) && (($exclusions[2] == 'show' && !in_array($page_id, $exclusions[0])) || ($exclusions[2] == 'hide' && in_array($page_id, $exclusions[0]))))) {
            return false;
        }
        if (count($exclusions[1])) {
            $post_type = get_post_type($page_id);
            if ((($exclusions[2] == 'show' && !in_array($post_type, $exclusions[1])) || ($exclusions[2] == 'hide' && in_array($post_type, $exclusions[1])))) {
                return false;
            }
        }
        if (!sb_get_setting('front-auto-translations') && $force_languge == false) {
            if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != 'en') {
                $lang = '?lang=' . ICL_LANGUAGE_CODE;
            } else {
                $locale = get_locale();
                if (isset($locale) && $locale != 'en') {
                    $lang = '?lang=' . substr($locale, 0, 2);
                }
            }
        } else if ($force_languge != false) {
            $lang = '?lang=' . $force_languge;
        }

        wp_enqueue_script('sb-js', SB_URL . '/js/min/init.min.js' . $lang, ['jquery'], SB_VERSION);
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $user_data = '"' . sb_encryption('encrypt', json_encode(['id' => $current_user->ID, 'email' => $current_user->user_email])) . '"';
        }
        $inline_code = 'var SB_INIT_URL = "' . SB_URL . $lang . '"; var SB_WP_ACTIVE_USER = ' . $user_data . '; var SB_WP_PAGE_ID = ' . ($page_id == '' ? -1 : $page_id) . ';';
        if (sb_get_setting('wp-multisite') && is_multisite()){
            global $blog_id;
            $blog_name = get_blog_details(['blog_id' => $blog_id])->blogname;
            if ($blog_name != '') {
                $departments = sb_get_departments();
                $department_id = -1;
                foreach ($departments as $key => $value) {
                    if ($value['name'] == $blog_name) {
                        $department_id = $key;
                        break;
                    }
                }
                if ($department_id == -1) {
                    $department_id = count($departments) + 1;
                    $settings = sb_get_settings();
                    $item = ['department-name' => sb_db_escape($blog_name), 'department-color' => '', 'department-image' => '', 'department-id' => $department_id];
                    if (is_array($settings['departments'][0])) {
                        array_push($settings['departments'][0], $item);
                    } else {
                        $settings['departments'] = [[$item], 'repeater'];
                    }
                    sb_save_settings($settings);
                }
                $inline_code .= ' var SB_DEFAULT_DEPARTMENT = ' . $department_id . ';';
            }
        }
        wp_add_inline_script('sb-js', $inline_code);
    }
}

/*
 * ----------------------------------------------------------
 * # TICKETS
 * ----------------------------------------------------------
 *
 * Tickets functions
 *
 */

function sb_tickets_shortcode() {
    wp_register_script('sb-tickets', '');
    wp_enqueue_script('sb-tickets');
    wp_add_inline_script('sb-tickets', 'var SB_TICKETS = true;');
    return '<div id="sb-tickets"></div>';
}

/*
 * ----------------------------------------------------------
 * # FUNCTIONS
 * ----------------------------------------------------------
 *
 * Various functions
 *
 */

function sb_is_admin_page() {
    return key_exists('page', $_GET) && $_GET['page'] == 'support-board';
}

function sb_on_activation() {
    global $SB_CONNECTION;
    if (!file_exists('supportboard/config.php')) {
        $raw = str_replace(['[url]', '[name]', '[user]', '[password]', '[host]', '[port]'], '', file_get_contents(__DIR__ . '/supportboard/resources/config-source.php'));
        $file = fopen(__DIR__ . '/supportboard/config.php', 'w');
        fwrite($file, $raw);
        fclose($file);
    }
    require_once('supportboard/include/functions.php');
    sb_installation(sb_installation_array());
}

function sb_installation_array() {
    return array_merge(['db-name' => [DB_NAME], 'db-user' => [DB_USER], 'db-password' => [DB_PASSWORD], 'db-host' => [DB_HOST], 'url' => plugins_url() . '/supportboard/supportboard'], sb_wp_user_array());
}

function sb_wp_user_array($user = false) {
    if ($user == false) {
        $user = wp_get_current_user();
    }
    return ['first-name' => [$user->user_firstname == '' ? esc_html($user->user_login) : esc_html($user->user_firstname)], 'last-name' => [esc_html($user->user_lastname)], 'email' => [esc_html($user->user_email)], 'password' => [$user->user_pass]];
}

function sb_chat_shortcode() {
    wp_register_script('sb-tickets', '');
    wp_enqueue_script('sb-tickets');
    wp_add_inline_script('sb-tickets', 'var SB_TICKETS = true;');
    return '<div id="sb-tickets"></div>';
}

/*
 * ------------------------------
 * # ACTIONS
 * ------------------------------
 */

add_shortcode('sb-tickets', 'sb_tickets_shortcode');
add_action('admin_menu', 'sb_set_admin_menu');
add_action('network_admin_menu', 'sb_set_admin_menu');
add_action('admin_enqueue_scripts', 'sb_enqueue_admin');
add_action('wp_enqueue_scripts', 'sb_enqueue');
add_filter('insert_user_meta', function($meta, $user_data, $update) { return sb_on_user_update($meta, $user_data, $update); }, 10, 3);
register_activation_hook(__FILE__, 'sb_on_activation');

