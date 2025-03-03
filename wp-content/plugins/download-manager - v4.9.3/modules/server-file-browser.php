<?php

function wpdm_dir_tree(){
    global $current_user;
    $root = get_option('_wpdm_file_browser_root', $_SERVER['DOCUMENT_ROOT']).'/';

    if(!is_user_logged_in()) return;
    if (!isset($_GET['task']) || $_GET['task'] != 'wpdm_dir_tree') return;

    $root = current_user_can('manage_options')?$root:UPLOAD_DIR.$current_user->user_login.'/';
    $uroot = current_user_can('manage_options')?'':$current_user->user_login.'/';

    if(!is_user_logged_in()) die("<ul><li>".__( "Not Allowed!" , "download-manager" )."</li></ul>");
    $dir = urldecode($_POST['dir']);
    if (file_exists($root.$dir)) {
        $files = scandir($root.$dir);

        natcasesort($files);
        if (count($files) > 2) { /* The 2 accounts for . and .. */
            echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
            // All dirs
            foreach ($files as $file) {
                $abspath = $root.$dir.$file;
                //$abspath = realpath($abspath);
                $relpath = str_replace($root, "", $abspath);
                if ($file != '.' && $file != '.htaccess' && $file != '..' && file_exists($abspath) && is_dir($abspath)) {
                    echo "<li class=\"directory collapsed\"><a id=\"" . uniqid() . "\" href=\"#\" rel=\"" . htmlentities($relpath) . "/\">" . htmlentities($file) . "</a></li>";
                }
            }
            // All files
            foreach ($files as $file) {
                $abspath = $root.$dir.$file;
                $abspath = realpath($abspath);
                $relpath = str_replace(UPLOAD_DIR, "", $abspath);
                if ($file != '.' && $file != '..' && $file != '.htaccess' && file_exists($abspath) && !is_dir($abspath)) {
                    $ext = preg_replace('/^.*\./', '', $file);
                    echo "<li class=\"file ext_$ext\"><a id=\"" . uniqid() . "\" href=\"#\" rel=\"" . htmlentities($relpath) . "\">" . htmlentities($file) . "</a></li>";
                }
            }
            echo "</ul>";
        }
    }
    die();

}

function wpdm_file_browser(){
    //if($_GET['task']!='wpdm_file_browser') return;
    if(!is_user_logged_in()) echo "<ul><li>".__( "Not Allowed!" , "download-manager" )."</li></ul>";
    else {
        ?>
        <script type="text/javascript" src="<?php echo plugins_url('/download-manager/assets/js/jqueryFileTree.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo plugins_url('/download-manager/assets/css/jqueryFileTree.css'); ?>"/>
        <style type="text/css">.jqueryFileTree li {
                line-height: 20px;
            }</style>
        <!--<div class="wrap">
        <div class="icon32" id="icon-categories"><br></div>
        <h2>Browse Files</h2>-->
        <div id="tree" style="height: 200px;overflow:auto"></div>
        <script language="JavaScript">
            <!--
            jQuery(function () {
                jQuery('#tree').fileTree({
                    root: '',
                    script: '<?php echo !is_admin()?home_url('?task=wpdm_dir_tree'):admin_url('?task=wpdm_dir_tree'); ?>',
                    expandSpeed: 1000,
                    collapseSpeed: 1000,
                    multiFolder: false
                }, function (file, id) {
                    var sfilename = file.split('/');
                    var filename = sfilename[sfilename.length - 1];
                    if (confirm('Add this file?')) {
                        var d = new Date();
                        var ID = d.getTime();

                        <?php

                        global $post;

                        $files = maybe_unserialize(get_post_meta($post->ID, '__wpdm_files', true));

                        if (!is_array($files)) $files = array();

                        //if(count($files) < 15){
                        ?>
                        var html = jQuery('#wpdm-file-entry').html();
                        var ext = file.split('.');
                        ext = ext[ext.length - 1];
                        var icon = "<?php echo WPDM_BASE_URL; ?>assets/file-type-icons/" + ext + ".png";

                        var title = filename;

                        html = html.replace(/##filepath##/g, file);
                        html = html.replace(/##filetitle##/g, title);
                        html = html.replace(/##fileindex##/g, ID);
                        html = html.replace(/##preview##/g, icon);


                        jQuery('#currentfiles').prepend(html);
                        <?php /* } else { ?>
                        jQuery('#wpdm-files').dataTable().fnAddData([
                            "<input type='hidden' id='in_" + ID + "' class='fa' name='file[files][" + ID + "]' value='" + file + "' /><i id='del_" + ID + "' class='fa fa-trash-o action-ico text-danger' rel='del'></i>",
                            file,
                            "<input class='form-control input-sm' type='text' name='file[fileinfo][" + ID + "][title]' value='" + file + "' onclick='this.select()'>",
                            "<div class='input-group'><input size='10' class='form-control input-sm' type='text' id='indpass_" + ID + "' name='file[fileinfo][" + ID + "][password]' value=''><span class='input-group-btn'><button class='genpass btn btn-secondary btn-sm' type='button' onclick=\"return generatepass('indpass_" + ID + "')\" title='Generate Password'><i class='fa fa-key'></i></button>"
                        ]);
                        jQuery('#wpdm-files tbody tr:not(.dfile):not(.cfile)').attr('id', ID).addClass('cfile');

                        jQuery("#wpdm-files tbody").sortable();

                        jQuery('#' + ID).fadeIn();

                        <?php }*/ ?>


                    }
                    //jQuery('#serverfiles').append('<li><label><input checked=checked type="checkbox" value="'+file+'" name="imports[]" class="role"> &nbsp; '+filename+'</label></li>');
                });

            });
            //-->
        </script>
        <!--</div> -->
        <?php
    }
    // die();
}

function wpmp_file_browser_metabox(){
    ?>

    <div class="postbox " id="action">
        <div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?php echo __( "Add file(s) from server" , "download-manager" ); ?></span></h3>
        <div class="inside" style="height: 200px;overflow: auto;">

            <?php wpdm_file_browser(); ?>

            <ul id="serverfiles">






            </ul>
            <div class="clear"></div>
        </div>
    </div>

    <?php
}

add_action("init","wpdm_dir_tree");

if(is_admin()){

    //add_action("init","wpdm_file_browser");

    add_action("add_new_file_sidebar","wpmp_file_browser_metabox");
}


