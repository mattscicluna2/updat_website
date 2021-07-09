<div class="dl_addons_element">
    <div class="dl_addons_container">
        <div class="dl_addons_row">
            <div class="dl_col_lg_12">
                <div class="dl_element_addons_dashboard_intro pro_banner">
                    <h2 class="title"><?php echo esc_html_e('Get Droit Elementor Addons Pro', 'droit-elementor-addons'); ?></h2>
                    <p class="description">Purchase the premium version of Droit Elementor Addons to get <br> additional and exclusive features.</p>
                </div>
            </div>
        </div>
    </div>
    <!--div class="dl_addons_container">
        <div class="dl_addons_row">
            <div class="dl_col_lg_12">
                <div class="dl_single_library_box">
                    <img src="<?php echo drdt_core()->images . 'Tabs.svg'; ?>" alt="pro" class="dl_box_icon">
                    <h5 class="title"><?php echo esc_html_e('Pro is coming soon, subscribe for Pro', 'droit-elementor-addons'); ?></h5>
                    <p class="description"><?php echo esc_html_e('Get additional features and widgets with the premium version of the plugin. Turn on automatic updates from the WordPress dashboard and enjoy updates without any hassle.', 'droit-elementor-addons'); ?></p>
                        <div class="dl_subscription_info_box dl_border_radius dl_subscribe_style_one dl_pt_50 dl_pb_60">
                             <?php 
                             include( drdt_core()->templates_dir . 'admin/form-data.php'); 
                             ?>
                        </div>
                </div>
            </div>
        </div>
    </div-->
    <div class="dl_addons_container">
        <div class="dl_addons_row">
            <div class="dl_col_lg_12">
                <div class="dl_kit_section_title dl_mb_15">
                    <h5 class="title"><?php echo esc_html_e('Premium Elements ', 'droit-elementor-addons'); ?></h5>
                    <p class="description"><?php echo esc_html_e('Have a look at the premium elements you will get to level up your website. ', 'droit-elementor-addons'); ?></p>
                </div>
            </div>
        </div>
        <div class="dl_addons_row">
        	<?php
				
				$elements_map = drdt_manager()->widgets->pro_widgets_maping([]);

                if( !empty($elements_map) ){
                    foreach($elements_map as $k=>$v){
                        $title            = isset($v['_title']) ? $v['_title'] : '';
                        $icon             = isset($v['_icon']) ? $v['_icon'] : '';
                        $demo_url             = isset($v['_demo_url']) ? $v['_demo_url'] : '';
                        $_droit_pro             = isset($v['_droit_pro']) ? $v['_droit_pro'] : false;
                        if($_droit_pro){
                        ?>
                            <div class="dl_col_lg_4 dl_col_sm_6">
                                <a href="<?php echo esc_url($demo_url); ?>" class="dl_pro_widget_list" target="_blank">
                                    <i class="droit_icon <?php echo esc_attr($icon); ?>"></i>
                                    <h4 class="title"><?php esc_html_e($title, 'droit-elementor-addons');?></h4>
                                </a>
                            </div>
                        <?php
                        }
                    }
                }
            ?>

        </div>
    </div>
</div>
