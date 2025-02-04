<?php

//Get License key
$license_key = get_option('edd_'.$this->plugin_slug.'_license_key');

//Get License Status
$status = get_option('edd_'.$this->plugin_slug.'_license_status');

$sites = get_option('wdm_'.$this->plugin_slug.'_license_key_sites');

$renew_link = get_option('wdm_'.$this->plugin_slug.'_product_site');

include_once dirname(plugin_dir_path(__FILE__)).'/includes/class-wdm-wusp-get-data.php';

$active_site = \WuspGetDataFCC\WdmWuspGetData::getSiteList($this->plugin_slug);

$display = '';

if (!empty($active_site) || $active_site != '') {
    $display = '<ul>'.$active_site.'</ul>';
}

?>
<div class="wrap">
        <?php

        $license_key = trim(get_option('edd_'.$this->plugin_slug.'_license_key'));

        //Handle Submission of inputs on license page
        if (isset($GLOBALS['wdm_server_null_response']) && $GLOBALS['wdm_server_null_response'] == true) {
            add_settings_error(
                'wdm_'.$this->plugin_slug.'_errors',
                esc_attr('settings_updated'),
                __('No response from server. Please try again later.', 'fcc'),
                'error'
            );
        } elseif (isset($GLOBALS['wdm_license_activation_failed']) && $GLOBALS['wdm_license_activation_failed'] == true) {
            add_settings_error(
                'wdm_'.$this->plugin_slug.'_errors',
                esc_attr('settings_updated'),
                __('License Activation Failed. Please try again or contact support on support@wisdmlabs.com', 'fcc'),
                'error'
            );
        } elseif (isset($_POST['edd_'.$this->plugin_slug.'_license_key']) && empty($_POST['edd_'.$this->plugin_slug.'_license_key'])) {
            //If empty, show error message
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('Please enter license key.', 'fcc'),
                    'error'
                );
        } elseif ($status !== false && $status == 'valid') { //Valid license key
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('Your license key is activated.', 'fcc'),
                    'updated'
                );
        } elseif ($status !== false && $status == 'expired' && (!empty($display) || $display != '')) { //Expired license key
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('Your license key has Expired. Please, Renew it. <br/>Your License Key is already activated at : '.$display.' Please deactivate the license from one of the above site(s) to successfully activate it on your current site.', 'fcc'),
                    'error'
                );
        } elseif ($status !== false && $status == 'expired') { //Expired license key
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('Your license key has Expired. Please, Renew it.', 'fcc'),
                    'error'
                );
        } elseif ($status !== false && $status == 'disabled') { //Disabled license key
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('Your license key is Disabled.', 'fcc'),
                    'error'
                );
        } elseif ($status == 'invalid' && (!empty($display) || $display != '')) { //Invalid license key   and site
            add_settings_error(
                'wdm_'.$this->plugin_slug.'_errors',
                esc_attr('settings_updated'),
                __('Your License Key is already activated at : '.$display.' Please deactivate the license from one of the above site(s) to successfully activate it on your current site.', 'fcc'),
                'error'
            );
        } elseif ($status == 'invalid') { //Invalid license key
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('Please enter valid license key.', 'fcc'),
                    'error'
                );
        } elseif ($status == 'site_inactive' && (!empty($display) || $display != '')) { //Invalid license key   and site inactive
            add_settings_error(
                'wdm_'.$this->plugin_slug.'_errors',
                esc_attr('settings_updated'),
                __('Your License Key is already activated at : '.$display.' Please deactivate the license from one of the above site(s) to successfully activate it on your current site.', $this->plugin_slug.'_text_domain'),
                'error'
            );
        } elseif ($status == 'site_inactive') { //Site is inactive
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('Site inactive(Press Activate license to activate plugin)', $this->plugin_slug.'_text_domain'),
                    'error'
                );
        } elseif ($status == 'deactivated') { //Site is inactive
                add_settings_error(
                    'wdm_'.$this->plugin_slug.'_errors',
                    esc_attr('settings_updated'),
                    __('License Key is deactivated', 'fcc'),
                    'updated'
                );
        }

        settings_errors('wdm_'.$this->plugin_slug.'_errors');

        ?>
        <h2><?php _e('Frontend Course Creation License Options', 'fcc'); ?></h2>

        <form method="post" action="">
                <table class="form-table">
                        <tbody>
                                <tr valign="top">
                                        <th scope="row" valign="top">
                                            <?php _e('License Key', 'fcc'); ?>
                                        </th>
                                        <td>
                                            <?php
                                            if (($status == 'valid' || $status == 'expired') && (empty($display) || $display == '')) {
                                                ?>
                                            <input id="<?php echo 'edd_'.$this->plugin_slug.'_license_key'?>" name="<?php echo 'edd_'.$this->plugin_slug.'_license_key'?>" type="text" class="regular-text" value="<?php esc_attr_e($license_key);
                                                ?>" readonly/>
                                            <?php

                                            } else {
                                                ?>
                                                        <input id="<?php echo 'edd_'.$this->plugin_slug.'_license_key'?>" name="<?php echo 'edd_'.$this->plugin_slug.'_license_key'?>" type="text" class="regular-text" value="<?php esc_attr_e($license_key);
                                                ?>" />
                                                    <?php

                                            }

                                            ?>
                                            
                                                <label class="description" for="<?php echo 'edd_'.$this->plugin_slug.'_license_key'?>"></label>
                                        </td>
                                </tr>

                                <tr>
                                        <th scope="row" valign="top">
                                                <?php _e('License Status', 'fcc'); ?>
                                        </th>
                                        <td>
                                                <?php if ($status !== false && $status == 'valid') {
    ?>
                                                        <span style="color:green;"><?php _e('Active', 'fcc');
    ?></span>
                                                <?php

} elseif (get_option('edd_'.$this->plugin_slug.'_license_status') == 'site_inactive') {
    ?>
                                                        <span style="color:red;"><?php _e('Not Active', 'fcc') ?></span>
                                                <?php

} elseif (get_option('edd_'.$this->plugin_slug.'_license_status') == 'expired' && (!empty($display) || $display != '')) {
    ?>
                                                        <span style="color:red;"><?php  _e('Not Active', 'fcc') ?></span>
                                                <?php

} elseif (get_option('edd_'.$this->plugin_slug.'_license_status') == 'expired') {
    ?>
                                                        <span style="color:green;"><?php  _e('Active', 'fcc') ?></span>
                                                <?php

} elseif (get_option('edd_'.$this->plugin_slug.'_license_status') == 'invalid') {
    ?>
                                                        <span style="color:red;"><?php _e('Not Active', 'fcc');
    ?></span>
                                                        <?php

} else {
    ?>
        <span style="color:red;"><?php _e('Not Active', 'fcc');
    ?></span>
                                                <?php

}

                                                ?>
                                        </td>
                                </tr>
                                <tr valign="top">
                                        <th scope="row" valign="top">
                                                <?php _e('Activate License', 'fcc'); ?>
                                        </th>
                                        <td>
                                        <?php if ($status !== false && $status == 'valid') {
    ?>

                                            <?php wp_nonce_field('edd_'.$this->plugin_slug.'_nonce', 'edd_'.$this->plugin_slug.'_nonce');
    ?>
                                            <input type="submit" class="button-primary" name="<?php echo 'edd_'.$this->plugin_slug.'_license_deactivate';
    ?>" value="<?php _e('Deactivate License', 'fcc');
    ?>"/>

                                            <?php

} elseif ($status == 'expired' && (!empty($display) || $display != '')) {
    ?>

                                            <?php wp_nonce_field('edd_'.$this->plugin_slug.'_nonce', 'edd_'.$this->plugin_slug.'_nonce');
    ?>
                                            <input type="submit" class="button-primary" name="<?php echo 'edd_'.$this->plugin_slug.'_license_activate';
    ?>" 
                                                   value="<?php _e('Activate License', $this->plugin_slug.'_text_domain');
    ?>"/>
                                            <?php if (!empty($renew_link)) {
    ?>
                                            <input type="button" class="button-primary" name="<?php echo 'edd_'.$this->plugin_slug.'_license_renew';
    ?>" 
                                                   value="<?php _e('Renew License', 'fcc');
    ?>" onclick="window.open('<?php echo $renew_link;
    ?>')"/> 
											<?php 
}
} elseif ($status == 'expired') {
    ?>
                                            <?php wp_nonce_field('edd_'.$this->plugin_slug.'_nonce', 'edd_'.$this->plugin_slug.'_nonce');
    ?>
                                            <input type="submit" class="button-primary" name="<?php echo 'edd_'.$this->plugin_slug.'_license_deactivate';
    ?>"
                                                   value="<?php _e('Deactivate License', 'fcc');
    ?>"/>
                                            
                                             <input type="button" class="button-primary" name="<?php echo 'edd_'.$this->plugin_slug.'_license_renew';
    ?>"
                                                    value="<?php _e('Renew License', 'fcc');
    ?>" onclick="window.open('<?php echo $renew_link;
    ?>')"/>
                                            
                                            <?php

} else {
    wp_nonce_field('edd_'.$this->plugin_slug.'_nonce', 'edd_'.$this->plugin_slug.'_nonce');

    ?>
<input type="submit" class="button-primary" name="<?php echo 'edd_'.$this->plugin_slug.'_license_activate';
    ?>" value="<?php _e('Activate License', 'fcc');
    ?>"/>
                                        <?php

} ?>
                                        </td>
                                </tr>
                        </tbody>
                </table>
        </form>
</div>
