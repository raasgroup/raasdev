<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#wpm_image_radius").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 { border-radius:" + value + "; -moz-border-radius:" + value + "; -ms-border-radius:" + value + "; -o-border-radius:" + value + "; -webkit-border-radius:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_real_image_radius").on("change", function () {
            var value = jQuery(this).val() + "%";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_pic_container { border-radius:" + value + "; -moz-border-radius:" + value + "; -ms-border-radius:" + value + "; -o-border-radius:" + value + "; -webkit-border-radius:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_border_width").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 { border-width:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_3610_img_border_size").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_preview_profile-image-border  { border-width:" + value +";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_3610_img_border_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_preview_profile-image-border  { border-color:" + value +";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_border_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41  { border-color:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });

        jQuery("#wpm_image_hover_background").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41:hover { background:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_box_shadow_width, #wpm_box_shadow_blur, #wpm_box_shadow_color").on("change", function () {
            var spread = jQuery("#wpm_box_shadow_width").val() + "px";
            var blur = (parseInt(jQuery("#wpm_box_shadow_blur").val()) * 2) + "px";
            var color = jQuery("#wpm_box_shadow_color").val().replace(/\+/g, ' ');
            color = color.split(':');
            jQuery("<style type='text/css'> .wpm_6310_team_style_41 { box-shadow: 0 0 " + blur + " " + spread + " " + color + "; -moz-box-shadow: 0 0 " + blur + " " + spread + " " + color + "; -webkit-box-shadow: 0 0 " + blur + " " + spread + " " + color + "; -ms-box-shadow: 0 0 " + blur + " " + spread + " " + color + "; -o-box-shadow: 0 0 " + blur + " " + spread + " " + color + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_member_font_size").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_title { font-size:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });

        jQuery("#wpm_member_font_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_title, .wpm_6310_team_style_41 .wpm_6310_team_style_41_title a { color:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_member_font_hover_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41:hover .wpm_6310_team_style_41_title { color:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_member_font_weight").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_title { font-weight:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_member_text_transform").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_title { text-transform:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_jquery_heading_font").on("change", function () {
            var value = jQuery(this).val().replace(/\+/g, ' ');
            value = value.split(':');
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_title { font-family:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_heading_line_height").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_41 .wpm_6310_team_style_41_title { line-height:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_designation_font_size").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_41_designation { font-size:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_designation_font_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_41_designation { color:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_designation_font_hover_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_41:hover .wpm_6310_team_style_41_designation { color:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });

        jQuery("#wpm_designation_font_weight").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_41_designation { font-weight:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_designation_text_transform").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_41_designation { text-transform:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_jquery_designation_font").on("change", function () {
            var value = jQuery(this).val().replace(/\+/g, ' ');
            value = value.split(':');
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_designation { font-family:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_designation_line_height").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_41_designation { line-height:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#social_from_content").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_designation { padding-bottom:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_social_icon_width").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_41 .wpm_6310_team_style_41_social li a { width:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_social_icon_height").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_41 .wpm_6310_team_style_41_social li a { height:" + value + "; line-height:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_social_border_width").on("change", function () {
            var value = jQuery(this).val() + "px !important";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_social li a { border-width:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_social_border_radius").on("change", function () {
            var value = jQuery(this).val() + "%";
            jQuery("<style type='text/css'> .wpm_6310_team_style_41 .wpm_6310_team_style_41_social li a { border-radius:" + value + "; -moz-border-radius:" + value + "; -webkit-border-radius:" + value + "; -o-border-radius:" + value + "; -ms-border-radius:" + value + "; } </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_member_margin_top").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_title { margin-top:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_member_margin_bottom").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_title { margin-bottom:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_designation_margin_top").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_designation { margin-top:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_designation_margin_bottom").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 .wpm_6310_team_style_41_designation { margin-bottom:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_social_margin_top").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 ul.wpm_6310_team_style_41_social { margin-top:" + value + " !important;} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_social_margin_bottom").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 ul.wpm_6310_team_style_41_social { margin-bottom:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_box_background").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 { background:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_img_overlay_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_pic_overlay { background:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_real_image_radius").on("change", function () {
            var value = jQuery(this).val() + "%";
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_pic_overlay { border-radius:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_img_background_color").on("change", function () {
         var value = jQuery(this).val();
         jQuery("<style type='text/css'>.wpm_6310_team_style_41 { background:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });

          jQuery("#wpm_img_content_background_left_color, #wpm_img_content_background_right_color").on("change", function () {
        var content_background_left_color = jQuery('#wpm_img_content_background_left_color').val();
        var content_background_right_color = jQuery('#wpm_img_content_background_right_color').val();

        let gradient = `linear-gradient(to right, ${content_background_left_color} 0%, ${content_background_right_color} 100%)`;

        jQuery('<style type="text/css">.wpm_6310_team_style_41_caption { background: ' + gradient + '; }</style>').appendTo(".wpm_6310_tabs_panel_preview");
    });

      jQuery("#wpm_icon_background_left_color, #wpm_icon_background_right_color").on("change", function () {
        var icon_background_left_color = jQuery('#wpm_icon_background_left_color').val();
        var icon_background_right_color = jQuery('#wpm_icon_background_right_color').val();

        let gradient = `linear-gradient(to right, ${icon_background_left_color} 0%, ${icon_background_right_color} 100%)`;

        jQuery('<style type="text/css">.wpm_6310_team_style_41_social { background: ' + gradient + '; }</style>').appendTo(".wpm_6310_tabs_panel_preview");
    });

            jQuery("#wpm_img_content_background_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41 { background:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });

          jQuery("#wpm_img_border_size").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_preview_profile-image-border { border:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_view_more_font_size").on("change", function () {
            var value = jQuery(this).val() + 'px';
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_pic_overlay_button { font-size: " + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_jquery_vm_font").on("change", function () {
            var value = jQuery(this).val().replace(/\+/g, ' ');
            value = value.split(':');
            jQuery("<style type='text/css'>.wpm_6310_team_style_41_pic_overlay_button { font-family:" + value + ";} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
        jQuery("#wpm_box_background, #wpm_box_background_2, #wpm_box_background_3, #wpm_real_image_radius").on("change", function () {
            var image_radius = Number(jQuery('#wpm_real_image_radius').val());
            var background_bg1 = jQuery('#wpm_box_background').val();
            var background_bg2 = jQuery('#wpm_box_background_2').val();
            var background_bg3 = jQuery('#wpm_box_background_3').val();
            let gradient = image_radius ? `linear-gradient(top, ${background_bg1} 0%, ${background_bg2} 48%, ${background_bg3} 99%)` : `linear-gradient(top, #fff 0%, ${background_bg1} 30%, ${background_bg2} 70%, ${background_bg3} 99%)`;
            jQuery(`<style type='text/css'>.wpm_6310_team_style_41 {
                background-color: ${background_bg1}; 
                background: -moz-${gradient};
                background: -webkit-${gradient}; 
                background: ${gradient};
            } </style>`).appendTo(".wpm_6310_tabs_panel_preview");
           
        });

        jQuery("#wpm_image_hover_background, #wpm_image_hover_background2, #wpm_image_hover_background3, #wpm_real_image_radius").on("change", function () {
            var image_radius = Number(jQuery('#wpm_real_image_radius').val());
            var hover_bg1 = jQuery('#wpm_image_hover_background').val();
            var hover_bg2 = jQuery('#wpm_image_hover_background2').val();
            var hover_bg3 = jQuery('#wpm_image_hover_background3').val();
            let gradient = image_radius ? `linear-gradient(top, ${hover_bg1} 0%, ${hover_bg2} 48%, ${hover_bg3} 99%)` : `linear-gradient(top, #fff 0%, ${hover_bg1} 30%, ${hover_bg2} 70%, ${hover_bg3} 99%)`;

            jQuery(`<style type='text/css'>.wpm_6310_team_style_41:hover { 
                background-color: ${hover_bg1}; 
                background: -moz-${gradient};
                background: -webkit-${gradient}; 
                background: ${gradient};    
            } </style>`).appendTo(".wpm_6310_tabs_panel_preview"); 
           
        });  
        <?php
        if(!(isset($allStyle[37]) && $allStyle[37] != '') ){
            echo 'jQuery(".social_act_field").hide();';
        }
        ?>
        jQuery('body').on('click', '#wpm_social_activation', function(){
            if (jQuery(this).prop('checked') == true) {
                jQuery("ul.wpm_6310_team_style_41_social").show();
                jQuery(".social_act_field").show();
            }
            else{
                jQuery("ul.wpm_6310_team_style_41_social").hide();
                jQuery(".social_act_field").hide();
            }
        });
        jQuery("#wpm_item_align").on("change", function () {
            var value = jQuery(this).val() ;
            jQuery("<style type='text/css'> .wpm_6310_tabs_panel_preview .wpm-6310-row { justify-content:" + value + " !important;} </style>").appendTo(".wpm_6310_tabs_panel_preview");
        });
    });
</script>
