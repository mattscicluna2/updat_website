<div class="droitdark-license">
    <div class="droitdark_container">
        <h1> <?php echo esc_html('Active License', 'droit-dark');?></h1>
        
            <div class="ins-active-license">
                <ol class="nextul">
                    <li> <?php esc_html_e( 'Login to your', 'droit-dark' );?><a href="https://account.droitthemes.com/" target="_blank"> <?php esc_html_e( 'DroitThemes Account', 'droit-dark' );?> </a></li>
                    <li> <?php esc_html_e( 'Go to the ', 'droit-dark' );?> <a href="https://account.droitthemes.com/?views=products" target="_blank"><?php esc_html_e( 'License', 'droit-dark' );?>  </a> <?php esc_html_e( ' tab, you will see a list of your purchases.', 'droit-dark' );?> </li>
                    <li> <?php _e( 'Click <strong>Licenses</strong> link, you will be asked to enter the domain address where you want to use this license.', 'droit-dark' );?> </li>
                    <li> <?php esc_html_e( 'After adding the domain you will get the license key.', 'droit-dark' );?> </li>
                    <li> <?php esc_html_e( 'Copy the license key and paste it here in the following field. Click "Active License" button.', 'droit-dark' );?> </li>
                </ol>
            </div>
            <div class="ins-active-license">
               
                <?php if($status == 'active'){?>
                    <div class="droitdark-message next-success"><a href="" class="__revoke_license" data-keys="<?php echo esc_attr($key_data);?>" > <?php echo esc_html('Click to Revoke License. ', 'droit-dark');?> </a></div>
                <?php }else{?>
                    <div class="license-key">
                    <label for="_license_key">
                        <input type="text" name="key_license" id="key_license" class="license-input" placeholder="<?php echo esc_attr('Please paste your license key', 'droit-dark'); ?>" value="<?php echo esc_attr($key_data);?>">
                    </label>
                    <button type="button" class="next_active_license-button"><?php echo esc_html('Active License', 'droit-dark');?> </button>
                </div>
                <div class="droitdark-message"></div>
                <?php }?>

                <div style="margin-top: 30px;"><p><?php esc_html_e('If you face any issue generating the license key or activating the license key please contact our support.', 'droit-dark');?></p></div>

            </div>
        
    </div>  
</div>