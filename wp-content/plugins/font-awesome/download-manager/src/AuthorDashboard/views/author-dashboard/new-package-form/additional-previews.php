<?php
/**
 * Base: wpdmpro
 * Developer: shahjada
 * Team: W3 Eden
 * Date: 15/12/19 18:49
 */
if(!defined("ABSPATH")) die();
?>
<?php if (!in_array('images', $hide)) { ?>
    <?php
    if(!defined("ABSPATH")) die("Shit happens!");
    ?>
    <style>.adp img{ width: 78px; height: 78px; }</style>
    <div class="card">
        <div class="card-header"><?= esc_attr__( 'Additional Previews', WPDM_TEXT_DOMAIN ); ?></div>
        <div class="card-body">
            <div id="adpcon">
        <a id="add-prev-img" href="#" style='float:left;margin:3px;padding:3px;width: 68px; height: 68px;border: 2px dashed #ddd;background: url(<?php echo WPDM_BASE_URL; ?>assets/images/plus.svg) no-repeat center center;background-size: 32px'></a>
        <?php

        $mpvs = get_post_meta($post->ID,'__wpdm_additional_previews', true);

        $mmv = 0;

        if(is_array($mpvs)){
            foreach($mpvs as $mpv){
                $image = ((int)$mpv > 0) ? wp_get_attachment_image($mpv) : "<img src='".wpdm_dynamic_thumb($mpv, array(128, 128), true)."' />";
                ?>
                <div id='<?php echo ++$mmv; ?>' style='float:left;margin:3px;' class='adp'>
                    <input type='hidden'  id='in_<?php echo $mmv; ?>' name='file[additional_previews][]' value='<?php echo $mpv; ?>' />
                    <img style='position:absolute;z-index:9999;cursor:pointer;width: 16px;height: 16px' id='del_<?php echo $mmv; ?>' rel="<?php echo $mmv; ?>" src='<?php echo plugins_url(); ?>/download-manager/assets/images/delete.svg' class="del_adp" align=left />
                    <?php echo $image; ?>
                    <div style='clear:both'></div>
                </div>
                <?php
            }
        }
        ?>
    </div>
            <div class="clear"></div>
        </div>
    </div>

    <script type="text/javascript">

        jQuery(document).ready(function() {

            var file_frame;

            jQuery('body').on('click', '#add-prev-img', function( event ){

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: jQuery( this ).data( 'uploader_title' ),
                    button: {
                        text: jQuery( this ).data( 'uploader_button_text' )
                    },
                    library: {
                        type: [ 'image' ]
                    },
                    multiple: true  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    // We set multiple to false so only get one image from the uploader
                    file_frame.state().get('selection').each(function (image) {
                        attachment = image.toJSON();
                        var imgurl = attachment.sizes.thumbnail !== undefined ? attachment.sizes.thumbnail.url : attachment.url;
                        var imgid = attachment.id;
                        var newDate = new Date;
                        var ID = newDate.getTime();
                        jQuery('#adpcon').append("<div id='" + ID + "' style='display:none;float:left;margin:3px;padding:5px;height:68px;width:68px;background: url(" + imgurl + ") no-repeat;background-size:cover;' class='adp'><input type='hidden' id='in_" + ID + "' name='file[additional_previews][]' value='" + imgid + "' /><nobr><b><img style='width:16px;position:absolute;z-index:9999;cursor:pointer;' id='del_" + ID + "' src='<?php echo plugins_url(); ?>/download-manager/assets/images/delete.svg' rel='del' align=left /></b></nobr><div style='clear:both'></div></div>");
                        jQuery('#' + ID).fadeIn();
                        jQuery('#del_' + ID).click(function () {
                            if (confirm('Are you sure?')) {
                                jQuery('#' + ID).fadeOut().remove();
                            }

                        });
                    });

                    // Do something with attachment.id and/or attachment.url here
                });

                // Finally, open the modal
                file_frame.open();
                return false;
            });





            jQuery('.del_adp').click(function(){
                if(confirm('Are you sure?')){
                    jQuery('#'+jQuery(this).attr('rel')).fadeOut().remove();
                }

            });

            jQuery('#adpcon').sortable();
        });

    </script>

<?php } ?>
