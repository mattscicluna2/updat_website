<div id="wrapper">
    <form action="" class="dtdr-dark-form" method="post">
        <div class="dl_elementor_addons_pack dl_sidebar_tab">
            <div class="dl_elementor_addon_content dl_d_flex">
                <div class="dl_tab_menu_content">
                    <div class="sticky_sldebar">
                        <h4 class="droit-logo-text"><?php esc_html_e( 'Droit Dark Mode', 'droit-elementor-addons' );?>
                        </h4>
                        <div class="tab-menu tab_left_content">
                            <?php  if( class_exists('\DroitDarkPro\Includes\Dtdr_Features') ){?>
                            <button class="tab-menu-link" type="button" data-content="droit_license">
                                <div class="dl_tab_content">
                                    <div class="tab_content_inner">
                                        <div class="droit_dark_sidebar_menu">
                                            <img src="<?php echo plugin_dir_url( __DIR__ ).'../assets/images/sidebar_icon/active_license.svg'; ?>" alt="#">
                                        </div>
                                        <div class="tab_content">
                                            <h4 class="admin_tab_title"><?php esc_html_e( 'Active License', 'droit-dark' );?></h4>
                                            <span class="admin_tab_desc"><?php esc_html_e( 'Enter license key', 'droit-dark' );?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <?php }?>
                            <button class="tab-menu-link active" type="button" data-content="droit_general">
                                <div class="dl_tab_content">
                                    <div class="tab_content_inner">
                                        <div class="droit_dark_sidebar_menu">
                                            <img src="<?php echo plugin_dir_url( __DIR__ ).'../assets/images/sidebar_icon/general.svg'; ?>" alt="#">
                                        </div>
                                        <div class="tab_content">
                                            <h4 class="admin_tab_title"><?php esc_html_e( 'General Settings', 'droit-dark' );?></h4>
                                            <span class="admin_tab_desc"><?php esc_html_e( 'Basic settings for dark mode', 'droit-dark' );?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button class="tab-menu-link" type="button" data-content="droit_display">
                                <div class="dl_tab_content">
                                    <div class="tab_content_inner">
                                        <div class="droit_dark_sidebar_menu">
                                            <img src="<?php echo plugin_dir_url( __DIR__ ).'../assets/images/sidebar_icon/display.svg'; ?>" alt="#">
                                        </div>
                                        <div class="tab_content">
                                            <h4 class="admin_tab_title"><?php esc_html_e( 'Display Settings', 'droit-dark' );?></h4>
                                            <span class="admin_tab_desc"><?php esc_html_e( 'Display settings for dark mode', 'droit-dark' );?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button class="tab-menu-link" type="button" data-content="droit_advance">
                                <div class="dl_tab_content">
                                    <div class="tab_content_inner">
                                        <div class="droit_dark_sidebar_menu">
                                            <img src="<?php echo plugin_dir_url( __DIR__ ).'../assets/images/sidebar_icon/adv.svg'; ?>" alt="#">
                                        </div>
                                        <div class="tab_content">
                                            <h4 class="admin_tab_title"> <?php esc_html_e( 'Advance Settings', 'droit-dark' );?></h4>
                                            <span class="admin_tab_desc"><?php esc_html_e( 'Advanced settings for dark mode', 'droit-dark' );?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button class="tab-menu-link" type="button" data-content="droit_preset">
                                <div class="dl_tab_content">
                                    <div class="tab_content_inner">
                                        <div class="droit_dark_sidebar_menu">
                                            <img src="<?php echo plugin_dir_url( __DIR__ ).'../assets/images/sidebar_icon/preset.svg'; ?>" alt="#">
                                        </div>
                                        <div class="tab_content">
                                            <h4 class="admin_tab_title"> <?php esc_html_e( 'Preset Color', 'droit-dark' );?></h4>
                                            <span class="admin_tab_desc"><?php esc_html_e( 'By default preset design for dark mode', 'droit-dark' );?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button class="tab-menu-link" type="button" data-content="droit_image">
                                <div class="dl_tab_content">
                                    <div class="tab_content_inner">
                                        <div class="droit_dark_sidebar_menu">
                                            <img src="<?php echo plugin_dir_url( __DIR__ ).'../assets/images/sidebar_icon/Dark_Image.svg'; ?>" alt="#">
                                        </div>
                                        <div class="tab_content">
                                            <h4 class="admin_tab_title"><?php esc_html_e( 'Dark Image', 'droit-dark' );?></h4>
                                            <span class="admin_tab_desc"><?php esc_html_e( 'Replace image when dark mode', 'droit-dark' );?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button class="tab-menu-link" type="button" data-content="droit_time">
                                <div class="dl_tab_content">
                                    <div class="tab_content_inner">
                                        <div class="droit_dark_sidebar_menu">
                                            <img src="<?php echo plugin_dir_url( __DIR__ ).'../assets/images/sidebar_icon/Time.svg'; ?>" alt="#">
                                        </div>
                                        <div class="tab_content">
                                            <h4 class="admin_tab_title"><?php esc_html_e( 'Time Base', 'droit-dark' );?>
                                            </h4>
                                            <span class="admin_tab_desc"><?php esc_html_e( 'Set time base dark mode', 'droit-dark' );?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            
                            <?php do_action('drdt-settings-tabs-menu');?>
                            <a style="text-align: center; text-decoration: none;" href="https://droitthemes2.ticksy.com/submit/">
                                <h4 style="margin: 15px auto;"><?php esc_html_e( 'Get Support', 'droit-dark' );?></h4>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-bar">
                    <div class="setting-submit-section dt-top dt-justify dt-center">
                        <button class="setting-submit sty1" type="submit"><i class=""></i>
                            <?php esc_html_e('Save Settings', 'droit-dark');?></button>
                    </div>
                   
                    <div class="tab-bar-content active" id="droit_general">
                        <?php include_once( __DIR__ . '/view/general.php');?>
                    </div>
                    <div class="tab-bar-content" id="droit_display">
                        <?php include_once( __DIR__ . '/view/display.php');?>
                    </div>
                    <div class="tab-bar-content" id="droit_advance">
                        <?php include_once( __DIR__ . '/view/advance.php');?>
                    </div>
                    <div class="tab-bar-content" id="droit_preset">
                        <?php include_once( __DIR__ . '/view/preset.php');?>
                    </div>
                    <div class="tab-bar-content" id="droit_image">
                        <?php include_once( __DIR__ . '/view/image.php');?>
                    </div>
                    <div class="tab-bar-content" id="droit_time">
                        <?php include_once( __DIR__ . '/view/time.php');?>
                    </div>


                    <?php  if( class_exists('\DroitDarkPro\Includes\Dtdr_Features') ){?>
                    <div class="tab-bar-content" id="droit_license">
                        <?php include_once( __DIR__ . '/view/active-pro.php');?>
                    </div>
                    <?php }?>

                    <?php do_action('drdt-settings-tabs-content');?>

                    <div class="setting-submit-section dt-justify dt-center">
                        <button class="setting-submit sty1" type="submit"><i class=""></i>
                            <?php esc_html_e('Save Settings', 'droit-dark');?></button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>