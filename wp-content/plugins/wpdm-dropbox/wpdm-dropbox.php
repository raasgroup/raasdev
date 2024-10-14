<?php
/*
Plugin Name: WPDM - Dropbox Explorer
Description: Dropbox Explorer for WPDM
Plugin URI: http://www.wpdownloadmanager.com/
Author: Shaon
Version: 1.2.0
Author URI: http://www.wpdownloadmanager.com/
*/

if (defined('WPDM_Version')) {


    if (!defined('WPDM_CLOUD_STORAGE'))
        define('WPDM_CLOUD_STORAGE', 1);


    class WPDMDropbox
    {
        function __construct()
        {

            add_action("wpdm_cloud_storage_settings", array($this, "Settings"));
            add_action('wpdm_attach_file_metabox', array($this, 'BrowseButton'));


        }


        function Settings()
        {
            global $current_user;
            if (isset($_POST['__wpdm_dropbox']) && count($_POST['__wpdm_dropbox']) > 0) {
                update_option('__wpdm_dropbox', $_POST['__wpdm_dropbox']);
                die('Settings Saves Successfully!');
            }
            $wpdm_dropbox = maybe_unserialize(get_option('__wpdm_dropbox', array()));
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><b><?php _e('Dropbox API Credentials', 'wpdmpro'); ?></b></div>

                <table class="table">



                    <tr>
                        <td>App Key</td>
                        <td><input type="text" name="__wpdm_dropbox[app_key]" class="form-control"
                                   value="<?php echo isset($wpdm_dropbox['app_key']) ? $wpdm_dropbox['app_key'] : ''; ?>"/>
                        </td>
                    </tr>
                    <!--tr>
                        <td>Client Secret</td>
                        <td><input type="text" name="__wpdm_dropbox[client_secret]" class="form-control"
                                   value="<?php echo isset($wpdm_dropbox['client_secret']) ? $wpdm_dropbox['client_secret'] : ''; ?>"/>
                        </td>
                    </tr-->

                </table>
                <!--div class="panel-footer">
                    <b>Redirect URI:</b> &nbsp; <input onclick="this.select()" type="text" class="form-control" style="background: #fff;cursor: copy;display: inline;width: 400px" readonly="readonly" value="<?php echo admin_url('?page=wpdm-google-drive'); ?>" />
                </div-->
            </div>


            </div>

        <?php
        }



        function BrowseButton()
        {
            $wpdm_dropbox = maybe_unserialize(get_option('__wpdm_dropbox', array()));

            ?>
            <div class="w3eden">

                <a href="#" id="btn-dropbox" style="margin-top: 10px" title="Drobox" onclick="return false;" class="btn btn-primary btn-block"><span class="left-icon"><i class="fa fa-dropbox"></i></span> Select From Dropbox</a>
                <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php echo $wpdm_dropbox['app_key'];?>"></script>

                <script>

                    var dropbox;

                    function InsertDropBoxLink(file, id, name) {
                        <?php if(version_compare(WPDM_Version, '4.0.0', '>')){  ?>
                        var html = jQuery('#wpdm-file-entry').html();
                        var ext = 'png'; //response.split('.');
                        //ext = ext[ext.length-1];
                        file = file.replace('dl=0','dl=1');
                        name = file.substring(0, 80)+"...";
                        var icon = "<?php echo WPDM_BASE_URL; ?>file-type-icons/48x48/" + ext + ".png";
                        html = html.replace(/##filepath##/g, file);
                        //html = html.replace(/##filepath##/g, file);
                        html = html.replace(/##fileindex##/g, id);
                        html = html.replace(/##preview##/g, icon);
                        jQuery('#currentfiles').prepend(html);

                        <?php } else { ?>
                        jQuery('#wpdmfile').val(file+"#"+name);
                        jQuery('#cfl').html('<div><strong>'+name+'</strong>').slideDown();
                        <?php } ?>
                    }

                    function popupwindow(url, title, w, h) {
                        var left = (screen.width/2)-(w/2);
                        var top = (screen.height/2)-(h/2);
                        return window.open(url, title, 'toolbar=0, location=0, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
                    }

                    jQuery(function () {

                        var options = {

                            // Required. Called when a user selects an item in the Chooser.
                            success: function(files) {
                                console.log(files);
                                var id = files[0].name.replace(/([^a-zA-Z0-9]*)/g, "");
                                InsertDropBoxLink(files[0].link, id, files[0].name)
                            },


                            cancel: function() {

                            },


                            linkType: "preview",

                            multiselect: false
                        };


                        jQuery('#btn-dropbox').click(function () {
                            dropbox = Dropbox.choose(options);
                            return false;
                        });


                    });


                </script>
            </div>


        <?php
        }




    }

    new WPDMDropbox();

}
 

