<?php
/*
 * Plugin Name:  Acquire
 * Plugin URI:   https://wordpress.org/plugins/acquire/
 * Description:  Unique Live Chat software provide video, voice and text chat solution with co browsing, screen sharing and real-time monitoring features.
 * Version:      1.0.2
 * Author:       Acquire Team
 * Text Domain: acquire
 * Domain Path: /languages
 * Author URI:   https://www.acquire.io
*/
define('ACQUIRE_URL','app.acquire.io');


function acquireio_custom_menu_page(){
    add_menu_page(
        'Acquire',
        'Acquire',
        'manage_options',
        'acquire','acquireio_custom_menu_page_render',
        plugins_url('images/acquire.png', __FILE__),
        90
    );
}
add_action( 'admin_menu', 'acquireio_custom_menu_page' );

function acquireio_live_chat_apply_widget()
{
    $get_acquire_user_acc_status=get_option('acquire_plugin_status');
    if($get_acquire_user_acc_status=='Active') {
        echo '<p>'.get_option('acquire_wp_live_chat_widget').'</p>';
    }
}
add_action( 'wp_footer', 'acquireio_live_chat_apply_widget' );

function prefix_plugin_update_message( $data, $response ) {
	if( isset( $data['upgrade_notice'] ) ) {
		printf(
			'<div class="update-message">%s</div>',
			wpautop( $data['upgrade_notice'] )
		);
	}
}
add_action( 'in_plugin_update_message-acquire/acquire.php', 'prefix_plugin_update_message', 10, 2 );

function acquireio_custom_menu_page_render(){
    if (is_user_logged_in()) {
        if (sanitize_text_field($_POST['acquire_remove_wp_plugin'])!='') {
            delete_option('acquire_user_account_ID');
            delete_option('acquire_wp_live_chat_widget');
            delete_option('acquire_plugin_status');
        }
        if (sanitize_text_field($_POST['acquire_user_login'])!='') {
            $acquire_user_account_id = sanitize_text_field($_POST['acquire_user_save_account_ID']);
            add_option('acquire_user_account_ID', "$acquire_user_account_id");
            add_option('acquire_plugin_status', 'Active');
        }
        $acquire_update_status = sanitize_text_field($_POST['acquire_user_account_status']);
        if ($acquire_update_status != '') {
            update_option('acquire_plugin_status', "$acquire_update_status");
        }
    }
    $get_acquire_config_user_account_id = get_option("acquire_user_account_ID");
    if (!empty($get_acquire_config_user_account_id) && is_user_logged_in()) {
        $code = '';
        $code .= '<script type="text/javascript">';
        $code .= '((function () { var load = function () {';
        $code .= 'var script = "https://s.acquire.io/a-' . $get_acquire_config_user_account_id . '/init.js?full";';
        $code .= 'var x = document.createElement(\'script\');';
        $code .= 'x.src = script; x.async = true;';
        $code .= 'var sx = document.getElementsByTagName(\'script\')[0];';
        $code .= 'sx.parentNode.insertBefore(x, sx);';
        $code .= '}; if (document.readyState === "complete") load();';
        $code .= 'else if (window.addEventListener) window.addEventListener(\'load\', load, false);';
        $code .= 'else if (window.attachEvent) {  window.attachEvent("onload", load); }';
        $code .= '})())</script>';
        $code .= '<noscript><a href="https://www.acquire.io?welcome" title="live chat software">Acquire</a></noscript>';
        add_option("acquire_wp_live_chat_widget", htmlspecialchars_decode($code), "yes");
        ?>
        <div class="wrap" style="display: block; background-color: #fff; padding: 20px; border-radius: 5px;">
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'acquire/images/logo-small-1.svg'; ?>" width="35" style="float: left; padding-right: 20px">
            <h1 style="font-weight: bold; line-height: 20px;">Acquire</h1>
            <br>
            <br>
            <div class="postbox"  style="padding: 15px; border-radius: 5px;">
                <div class="handlediv" title="Click to toggle">
                    <br>
                </div>
                <div class="inside">
                    <div class="main">
                        <h3 style="margin-top: 0;">Currently Activate Account</h3>
                        <p>To start Acquire Live Chat, Launch our dashboard for access all feature including widget customization</p>
                        <p><strong>ACCOUNT ID</strong> : <?= $get_acquire_config_user_account_id ?></p>
                        <br>
                        <form action="" method="post">
                            <a href="http://app.acquire.io/" target="_blank" style=" margin-right: 18px !important;" class="button button-secondary">Launch on Acquire
                                Dashboard</a>
                            <input type="submit" name="acquire_remove_wp_plugin" style="margin-right: 18px !important; background-color:#0066f9; border: 1px solid #0066f9; color: #fff; font-weight: 500;" value="Deactivate" class="button button-secondary">
                            <?php
                            $get_acquire_user_acc_status = get_option('acquire_plugin_status');
                            if ($get_acquire_user_acc_status == 'Active') {
                                echo '<input type="submit" name="acquire_user_account_status" value="Disable" style="margin-right: 18px !important; background-color: #af4848; color: #fff; font-weight: 500; border: 1px solid #af4848; " class="button button-secondary">';
                            } else {
                                echo '<input type="submit" name="acquire_user_account_status" value="Active" style="margin-right: 18px !important; background-color: #5da95d; text-shadow: none; font-weight: 500; border: 1px solid #5da95d; color: #fff;" class="button button-secondary">';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    if(empty($get_acquire_config_user_account_id) && is_user_logged_in()){
        ?>
        <div class="wrap" style="display: block; background-color: #fff; padding: 20px; border-radius: 5px;">
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'acquire/images/logo-small-1.svg'; ?>" width="35" style="float: left; padding-right: 20px">
            <h1 style="font-weight: bold; line-height: 20px;">Acquire</h1>
            <br>
            <div class="postbox" style="padding: 15px; border-radius: 5px;">
                <div class="handlediv" title="Click to toggle">
                </div>
                <h3 class="hndle" style="margin-top: 0; padding-bottom: 10px;">
                    <span>Linkup With Your Acquire Account  </span>
                </h3>

                <div class="inside">
                    <div class="main">
                        <form method="post" action="">
                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row" style="width: 90px;">ACCOUNT ID</th>
                                    <td style="width: 100px;"><input type="text" name="acquire_user_save_account_ID" value=""
                                                                     required="required"/></td>
                                    <td><input type="submit" name="acquire_user_login" id="acquire_user_login" class="button button-secondary"
                                               style="float: left; margin-right: 18px !important; background-color:#0066f9; border: 1px solid #0066f9; color: #fff; font-weight: 500;" value="Activate"></td>
                                </tr>
                            </table>
                            <p>The Acquire Chat Widget will Display on your Website after your account is linked
                                up.</p>
                            <h4>if you want know how get ACCOUNT ID and other help click here  <a  style="color:#0066f9;" href="https://acquire.io/integration/wordpress">Acquire Integration</a></h4>
                            <span>
                            <h4>Don't Have Acquire Account Please <a style="color:#0066f9; " target="_blank" href="https://app.acquire.io/site/signup">Click here</a></h4>
                            <h4>For acquire app personal dashboard development API Documenetion<a style="color:#0066f9; " target="_blank" href="https://developer.acquire.io/">Click here</a></h4>
                        </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
