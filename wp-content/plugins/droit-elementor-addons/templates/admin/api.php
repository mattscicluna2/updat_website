<div class="dl_tab_menu_title dl_d_flex dl_align_center dl_flex_justify">
  <div class="dl_tab_content">
    <div class="tab_content_inner">
      <div class="dl_widget_icon sidebar_icon_bg_color_6">
        <img src="<?php echo drdt_core()->images . 'sidebar_api.svg'; ?>" alt="">
      </div>
      <h4><?php esc_html_e('Api Data', 'droit-elementor-addons');?></h4>
    </div>
  </div>
  <button id="of_save_widget" type="submit" class="cu_btn btn_1 _is_disabled of_save_widget save_dl_api" data-layout='_dl_api'>
    <?php esc_html_e('Save Settings', 'droit-elementor-addons');?></button>
</div>
    <div class="dl_tab_content_wrapper">
       <?php  
        $widgetsOption = drdt_manager()->api->api_data();
        $api_map = drdt_manager()->api::api_map();

        ?>
        <div class="content_wrapper_flex">
          <div class="dl_api_container">
              <div class="dl_api">
                <?php 
                if( !empty($api_map) ){
                    foreach($api_map as $k=>$v){

                      $checked = in_array($k, $widgetsOption) ? 'checked' : '';

                      $name = isset($v['title']) ? $v['title'] : '';
                      $is_pro = isset($v['is_pro']) ? $v['is_pro'] : false;
                      $pro_class   = isset($v['is_pro']) && $v['is_pro'] ? 'ext-pro' : 'ext-free';
                      $is_pro_popup     = isset($v['is_pro']) && $v['is_pro'] && !did_action('droitPro/loaded') ? ' pro_popup' : '';
                      
                      $valueKey = isset($widgetsOption[$k]['key']) ? $widgetsOption[$k]['key'] : '';
                      
                      $is_pro_active = '';
                      if( $is_pro && !did_action('droitPro/loaded')){
                          $is_pro_active = 'disabled';
                      }
                        ?>
                         <div class="dl_api_item">
                            <div class="dl_api_item_title">
                                <h3 class="dl_api_title"><?php esc_html_e($name, 'droit-elementor-addons');?><span>(Pro)</span></h3>
                            </div>
                            <div class="dl_api_panel">
                                <div class="dl_api_inner dl_api_inner_form">
                                  <input type="text" id="api_<?php echo esc_attr($k);?>" name="dlsave[api][<?php echo esc_attr($k);?>][key]" placeholder="Api here." value="<?php echo esc_attr($valueKey);?>" <?php echo esc_attr($is_pro_active); ?> />
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                  
              </div>
          </div>
      </div>
  </div>

<div class="bottom-save-btn dl_d_flex dl_align_center dl_flex_justify">
  <button id="of_save_widget" type="submit" class="cu_btn btn_1 _is_disabled of_save_widget save_dl_api" data-layout='_dl_api'>
    <?php esc_html_e('Save Settings', 'droit-elementor-addons');?></button>
</div>