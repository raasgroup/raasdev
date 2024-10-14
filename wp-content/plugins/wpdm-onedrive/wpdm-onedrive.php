<?php
/*
  Plugin Name: WPDM - OneDrive
  Description: OneDrive Explorer for WordPress Download Manager
  Plugin URI: http://www.wpdownloadmanager.com/
  Author: Jesmeen
  Version: 1.0.0
  Author URI: http://www.wpdownloadmanager.com/
 */


if (defined('WPDM_Version')) {
    require dirname(__FILE__) . '/liveconnect.php';


    if (!defined('WPDM_CLOUD_STORAGE'))
        define('WPDM_CLOUD_STORAGE', 1);

    class WPDMOneDrive {

        function __construct() {

            add_action("wpdm_cloud_storage_settings", array($this, "Settings"));
            add_action('wpdm_attach_file_metabox', array($this, 'BrowseButton'));
            add_action('admin_init', array($this, 'wpdm_onedrive_verification'));
        }

        function wpdm_onedrive_verification() {
            $wpdm_onedrive = maybe_unserialize(get_option('__wpdm_onedrive', array()));
            // Only add hooks when the current user has permissions AND is in Rich Text editor mode
            if (( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') && $wpdm_onedrive['client_id']) {

                // Live Connect JavaScript library
                wp_register_script('liveconnect',  'https://js.live.net/v5.0/wl' . (WPDM_ONEDRIVE_DEBUG ? '.debug' : '') . '.js');
                wp_enqueue_script('liveconnect');

                wp_enqueue_script('jquery');

                wp_register_script('wpdmonedrive', plugins_url('js/onedrive.js', __FILE__), array('jquery'));
                wp_enqueue_script('wpdmonedrive');
            }
        }

        function Settings() {
            global $current_user;
            if (isset($_POST['__wpdm_onedrive']) && count($_POST['__wpdm_onedrive']) > 0) {
                update_option('__wpdm_onedrive', $_POST['__wpdm_onedrive']);
                die('Settings Saves Successfully!');
            }
            $wpdm_onedrive = maybe_unserialize(get_option('__wpdm_onedrive', array()));
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><b><?php _e('OneDrive API Credentials', 'wpdmpro'); ?></b></div>

                <table class="table">



                    <tr>
                        <td>Redirect Url</td>
                        <td><input type="text" name="__wpdm_onedrive[redirect_url]" class="form-control"
                                   value="<?php echo isset($wpdm_onedrive['redirect_url']) ? $wpdm_onedrive['redirect_url'] : ''; ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Client ID</td>
                        <td><input type="text" name="__wpdm_onedrive[client_id]" class="form-control"
                                   value="<?php echo isset($wpdm_onedrive['client_id']) ? $wpdm_onedrive['client_id'] : ''; ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Client Secret</td>
                        <td><input type="text" name="__wpdm_onedrive[client_secret]" class="form-control"
                                   value="<?php echo isset($wpdm_onedrive['client_secret']) ? $wpdm_onedrive['client_secret'] : ''; ?>"/>
                        </td>
                    </tr>
                </table>

            </div>


            <?php
        }

        function BrowseButton() {
            $wpdm_onedrive = maybe_unserialize(get_option('__wpdm_onedrive', array()));
            ?>
            <div class="w3eden">

                <script type="text/javascript" src="https://js.live.net/v5.0/OneDrive.js" id="onedrive-js" client-id="<?php echo $wpdm_onedrive['client_id']; ?>"></script>

                <script type="text/javascript">
                    function launchOneDrivePicker() {
                        var pickerOptions = {
                            success: function (files) {
                                // Handle returned file object(s)
                                var id = files.values[0].fileName.replace(/([^a-zA-Z0-9]*)/g, "");
                                InsertOneDriveLink(files.values[0].link, id, files.values[0].fileName);
                            },
                            cancel: function () {
                                alert("You picked failed");
                                // handle when the user cancels picking a file
                            },
                            linkType: "webViewLink", // or "downloadLink",
                            multiSelect: false // or true
                        };
                        OneDrive.open(pickerOptions);
                    }

                    function InsertOneDriveLink(file, id, name) {

                        <?php if (version_compare(WPDM_Version, '4.0.0', '>')) { ?>
                            var html = jQuery('#wpdm-file-entry').html();
                            var ext = 'png'; //response.split('.');
                            //ext = ext[ext.length-1];
                            name = file.substring(0, 80) + "...";
                            var icon = "<?php echo WPDM_BASE_URL; ?>file-type-icons/48x48/" + ext + ".png";
                            html = html.replace(/##filepath##/g, file);
                            //html = html.replace(/##filepath##/g, file);
                            html = html.replace(/##fileindex##/g, id);
                            html = html.replace(/##preview##/g, icon);
                            jQuery('#currentfiles').prepend(html);

                        <?php } else { ?>
                            jQuery('#wpdmfile').val(file + "#" + name);
                            jQuery('#cfl').html('<div><strong>' + name + '</strong>').slideDown();
                        <?php } ?>
                    }


                    function popupwindow(url, title, w, h) {
                        var left = (screen.width / 2) - (w / 2);
                        var top = (screen.height / 2) - (h / 2);
                        return window.open(url, title, 'toolbar=0, location=0, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
                    }

                </script>


                <a href="#" id="btn-onedrive" style="margin-top: 10px;" title="Drobox" onclick="return launchOneDrivePicker()" class="btn btn-primary btn-block"><span class="left-icon"><i class="fa fa-windows"></i></span> OneDrive</a>
                <style>#btn-onedrive{ background: #094AB2 !important; }#btn-onedrive:hover{ background: #0959de !important; }</style>
            </div>


            <?php
        }

    }

    new WPDMOneDrive();
}
 

