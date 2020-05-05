<?php
class WPGravityFormsToPipeDriveCRMOptions {
	
	var $_wpgf2pdcrm_plugin_page_url = '';
	var $_wpgf2pdcrm_token_option_name = '';
	var $_wpgf2pdcrm_debug_enable_option = '';
	var $_wpgf2pdcrm_active_deactive_error_message_option = '';
    
    var $_wpgf2pdcrm_enable_cache_organisations_option = '';
    var $_wpgf2pdcrm_enable_cache_people_option = '';
    var $_wpgf2pdcrm_enable_cache_product_list_option = '';
    
	var $_wpgf2pdcrm_plugin_folder_url = '';
	
	public function __construct( $args ) {
		$this->_wpgf2pdcrm_plugin_page_url = $args['plugin_page_url'];
		$this->_wpgf2pdcrm_token_option_name = $args['token_option_name'];
		$this->_wpgf2pdcrm_debug_enable_option = $args['debug_enable_option'];
        $this->_wpgf2pdcrm_enable_cache_organisations_option = $args['enable_cache_organisations_option'];
        $this->_wpgf2pdcrm_enable_cache_people_option = $args['enable_cache_people_option'];
        $this->_wpgf2pdcrm_enable_cache_product_list_option = $args['enable_cache_product_list_option'];
		$this->_wpgf2pdcrm_active_deactive_error_message_option = $args['active_deactive_error_message_option'];
		
		$this->_wpgf2pdcrm_plugin_folder_url = $args['plugin_folder_url'];
		
		if( is_admin() ){
			add_action( 'wpgf2pdcrm_action_save_plugin_settings', array($this, 'wpgf2pdcrm_action_save_plugin_settings_fun') );	
		}
	}
	
	function wpgf2pdcrm_options_plugin_page() {
		$wpgf2pdcrm_license_key = trim(get_option('wpgf2pdcrm_license_key'));
		$wpgf2pdcrm_license_key_status = trim(get_option('wpgf2pdcrm_license_key_status'));
		if( !$wpgf2pdcrm_license_key || $wpgf2pdcrm_license_key_status != 'valid' ){
			delete_option( 'wpgf2pdcrm_license_key_status' );
		}
		
		$readOnlyStr = ''; 
		if ( $wpgf2pdcrm_license_key !== false && $wpgf2pdcrm_license_key_status == 'valid' ) {
			$readOnlyStr = 'readonly';
		}
	  
	?>
        <div id="inline_msg"><?php echo $this->wpgf2pdcrm_setting_text(); ?></div>
        <div style="margin-top:30px;">
            <form action="<?php echo $this->_wpgf2pdcrm_plugin_page_url; ?>" method="POST" id="wpgf2pdcrm_setting_form_id">
	            <hr>
            <h3>Plugin Licence Activation</h3>
            <p>In the field below please enter your license key to activate this plugin</p>
            <p>
                <input id="wpgf2pdcrm_license_key_id" name="wpgf2pdcrm_license_key" type="text" value="<?php echo $wpgf2pdcrm_license_key; ?>" size="50" <?php echo $readOnlyStr; ?> />
                <?php
                if( $wpgf2pdcrm_license_key_status !== false && $wpgf2pdcrm_license_key_status == 'valid' ) {
                    echo '<span style="color:green;">Active</span>';
                    echo '<input type="submit" class="button-secondary" name="wpgf2pdcrm_license_deactivate" value="Deactivate License" style="margin-left:20px;" />';
                }else{
                    if ($wpgf2pdcrm_license_key !== false && strlen($wpgf2pdcrm_license_key) > 0) { 
                        echo '<span style="color:red;">Inactive</span>'; 
                    }
                    echo '<input type="submit" class="button-secondary" name="wpgf2pdcrm_license_activate" value="Activate License" style="margin-left:20px;" />';
                }
                wp_nonce_field( 'wpgf2pdcrm_license_key_nonce', 'wpgf2pdcrm_license_key_nonce' );
                ?>	
            </p>
            <?php
			$error_message = get_option( $this->_wpgf2pdcrm_active_deactive_error_message_option, '' );
			if( $error_message ){
				echo '<p style="color:red;">'.$error_message.'</p>';
			}
			?>
            <?php 
			global $_wpgf2pdcrm_messager;
				
			$_wpgf2pdcrm_messager->eddslum_plugin_option_page_update_center();
			$_wpgf2pdcrm_messager->eddslum_plugin_option_page_expiry_coming();
			?>
            </form>
        </div>
    <?php
	}
	
	function wpgf2pdcrm_options_plugin_settings(){
        ?>
        
        <table class="form-table">
            <tbody>
                <tr>
                    <th>Pipedrive API token</th>
                    <td>
                        <?php 
                        $token_saved = get_option( $this->_wpgf2pdcrm_token_option_name, false );
                        if ( $token_saved ){
                        ?>
                        <img src="<?PHP echo $this->_wpgf2pdcrm_plugin_folder_url; ?>images/password-saved.png" align="left"/>&nbsp;&nbsp;a token is saved
                        <?php }else{ ?>
                        <span style="color:#FF0000;">no saved API token, enter below</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th>New API token ?</th>
                    <td>
                        <input type="text" name="wpgf2pdcrm_request_new_token" id="wpgf2pdcrm_request_new_token_id" value="" style="width:70%;"/>
                    </td>
                </tr>
                <tr>
                    <th>Cache Organiations ?</th>
                    <td>
                        <label>
                            <input type="checkbox" name="wpgf2pdcrm_enable_cache_organisations" value="Yes" <?php if( get_option( $this->_wpgf2pdcrm_enable_cache_organisations_option, false ) == true ) echo 'checked="checked"'?>/>&nbsp;Check this box to cache organisations
                        </label>
                    </td>
                </tr>
                <tr>
                    <th>Cache People ?</th>
                    <td>
                        <label>
                            <input type="checkbox" name="wpgf2pdcrm_enable_cache_people" value="Yes" <?php if( get_option( $this->_wpgf2pdcrm_enable_cache_people_option, false ) == true ) echo 'checked="checked"'?>/>&nbsp;Check this box to cache people
                        </label>
                    </td>
                </tr>
                <tr>
                    <th>Cache Products  ?</th>
                    <td>
                        <label>
                            <input type="checkbox" name="wpgf2pdcrm_enable_cache_product_list" value="Yes" <?php if( get_option( $this->_wpgf2pdcrm_enable_cache_product_list_option, false ) == true ) echo 'checked="checked"'?>/>&nbsp;Check this box to cache products
                        </label>
                    </td>
                </tr>
                <tr>
                    <th>Debug mode ?</th>
                    <td>
                        <label><input type="checkbox" name="wpgf2pdcrm_enable_debug" value="Yes" <?php if( get_option( $this->_wpgf2pdcrm_debug_enable_option, false ) == true ) echo 'checked="checked"'?>/>&nbsp;Check this box to show debug into when a mapped form is submitted</label><br /><i>do not leave on for production sites!</i></td>
                </tr>
                <tr>
                    <th><input type="submit" name="wpgf2pdcrm_save_setting_button" id="wpgf2pdcrm_save_setting_button_id" class="button-primary" value="<?php _e('Save Settings') ?>" /></th>
                    <td>
                        <input type="hidden" name="wpgf2pdcrm_action" value="save_plugin_settings" />
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
	}
	
	function wpgf2pdcrm_action_save_plugin_settings_fun(){
		if( isset($_POST['wpgf2pdcrm_request_new_token']) && trim($_POST['wpgf2pdcrm_request_new_token']) ){
			update_option( $this->_wpgf2pdcrm_token_option_name, trim($_POST['wpgf2pdcrm_request_new_token']) );
		}
		$_wpgf2pdcrm_debug_enable_option = false;
        if( isset($_POST['wpgf2pdcrm_enable_debug']) && $_POST['wpgf2pdcrm_enable_debug'] == 'Yes' ){
            $_wpgf2pdcrm_debug_enable_option = true;
        }
        update_option( $this->_wpgf2pdcrm_debug_enable_option, $_wpgf2pdcrm_debug_enable_option );
        
        $wpgf2pdcrm_enable_cache_organisations = false;
        if( isset($_POST['wpgf2pdcrm_enable_cache_organisations']) && $_POST['wpgf2pdcrm_enable_cache_organisations'] == 'Yes' ){
            $wpgf2pdcrm_enable_cache_organisations = true;
        }
        update_option( $this->_wpgf2pdcrm_enable_cache_organisations_option, $wpgf2pdcrm_enable_cache_organisations );
        
        $wpgf2pdcrm_enable_cache_people = false;
        if( isset($_POST['wpgf2pdcrm_enable_cache_people']) && $_POST['wpgf2pdcrm_enable_cache_people'] == 'Yes' ){
            $wpgf2pdcrm_enable_cache_people = true;
        }
        update_option( $this->_wpgf2pdcrm_enable_cache_people_option, $wpgf2pdcrm_enable_cache_people );
        
        $wpgf2pdcrm_enable_cache_product_list = false;
        if( isset($_POST['wpgf2pdcrm_enable_cache_product_list']) && $_POST['wpgf2pdcrm_enable_cache_product_list'] == 'Yes' ){
            $wpgf2pdcrm_enable_cache_product_list = true;
        }
        update_option( $this->_wpgf2pdcrm_enable_cache_product_list_option, $wpgf2pdcrm_enable_cache_product_list );
        
	}
	
	function wpgf2pdcrm_setting_text(){
		
		$gforms_url = admin_url( 'admin.php?page=gf_settings&subview=gf2pdcrm' );
		
		$out = '<div style="clear:both;"></div>';
		$out .= "<div style=\"margin-top:30px;\">
					<h3>Plugin Setup</h3>" .
					"<ol id='settings_text'>".
					"<li>Register your plugin by entering the license key below</li>" .
					"<li>If you need to obtain your license key - visit the <a href='http://helpforwp.com/checkout/purchase-history/' target='_blank'>Purchase History</a> page on our website</a>" . 
					"<li>Next, you have to obtain your API token from your Pipedrive account - see documentation link below for help on this</li>" .
					"<li><a href='". $gforms_url . "'>Visit the plugin settings page</a> within Gravity Forms to store your API token" .
					"<li>On the same settings page, use the 'Test connection...' button to confirm that the connection is working</li>" .  
					"<li>Full documentation is available <a href='http://helpforwp.com/plugins/gravity-forms-to-pipe-drive-crm-documentation/' target='_blank'>here.</a></li>" . 
					"<li>Visit our <a href='http://helpforwp.com/forum/' target='_blank'>Support Page</a> if you have a question or problem. If you required an installation/setup service we also offer that, see our Priority Support option.</li>" . 
					"<li>Got a feature request? <a href=\"http://helpforwp.com/wordpress-feature-request/\" target=_blank>We would love to hear it.</a>" .
					"</ol>
				</div>";
		
		$out .= "<div style=\"margin-top:30px;\"><h3>Get started</h3>".  
				"Start mapping your forms in the Gravity Forms editor." .
				"</div>";
		
		$out .= "<hr><div style=\"margin-top:30px;\">
					<h3> Documentation and support</h3>". 
					"<p>Full documentation is available <a href='https://helpforwp.com/plugins/gravity-forms-to-pipe-drive-crm-documentation/' target='_blank'>here.</a></p>" . 
					"<p>Visit our <a href='http://helpforwp.com/forum/' target='_blank'>Support Page</a> if you have a question or problem." . 
					"<p>Got a feature request? <a href=\"http://helpforwp.com/wordpress-feature-request/\" target=_blank>We would love to hear it.</a></p>
				 </div>";
		return $out;
	}
}


