<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#wpm_image_radius").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 { border-radius:" + value + "; -moz-border-radius:" + value + "; -ms-border-radius:" + value + "; -o-border-radius:" + value + "; -webkit-border-radius:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_real_image_radius").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_img { width:" + value + "} </style>").appendTo("body");
        });    
        jQuery("#wpm_image_border_color_2, #wpm_image_border_color").on("change", function () {
            var border_color_1 = jQuery('#wpm_image_border_color').val();
            var border_color_2 = jQuery('#wpm_image_border_color_2').val();           
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_img:after {border-color:" + border_color_1 + border_color_2 + border_color_2 + border_color_1 +";} </style>").appendTo("body");
        });

        jQuery("#wpm_border_width").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 { border-width:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_border_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_32  { border-color:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_image_hover_background").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_32:hover { background:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_box_shadow_width, #wpm_box_shadow_blur, #wpm_box_shadow_color").on("change", function () {
            var spread = jQuery("#wpm_box_shadow_width").val() + "px";
            var blur = jQuery("#wpm_box_shadow_blur").val() + "px";
            var color = jQuery("#wpm_box_shadow_color").val().replace(/\+/g, ' ');
            color = color.split(':');
            jQuery("<style type='text/css'> .wpm_6310_team_style_32 { box-shadow: 0 1px " + blur + " " + spread + " " + color + "; -moz-box-shadow: 0 1px " + blur + " " + spread + " " + color + "; -webkit-box-shadow: 0 1px " + blur + " " + spread + " " + color + "; -ms-box-shadow: 0 1px " + blur + " " + spread + " " + color + "; -o-box-shadow: 0 1px " + blur + " " + spread + " " + color + ";} </style>").appendTo("body");

            jQuery("<style type='text/css'>.wpm_6310_team_style_32:hover { box-shadow: 0 5px calc(" + blur + " * 5) " + spread + " " + color + "; -moz-box-shadow: 0 5px calc(" + blur + " * 5) " + spread + " " + color + "; -webkit-box-shadow: 0 5px calc(" + blur + " * 5) " + spread + " " + color + "; -ms-box-shadow: 0 5px calc(" + blur + " * 5) " + spread + " " + color + "; -o-box-shadow: 0 5px calc(" + blur + " * 5) " + spread + " " + color + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_member_font_size").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_title { font-size:" + value + ";} </style>").appendTo("body");
        });

        jQuery("#wpm_member_font_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_title, .wpm_6310_team_style_32 .wpm_6310_team_style_32_title a { color:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_member_font_hover_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_32:hover .wpm_6310_team_style_32_title { color:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_member_font_weight").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_title { font-weight:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_member_text_transform").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_title { text-transform:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_jquery_heading_font").on("change", function () {
            var value = jQuery(this).val().replace(/\+/g, ' ');
            value = value.split(':');
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_title { font-family:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_heading_line_height").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_32 .wpm_6310_team_style_32_title { line-height:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_name_border_width").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_title:after { width:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_name_border_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_title:after { background:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_designation_font_size").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_designation { font-size:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_designation_font_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_designation { color:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_designation_font_hover_color").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_32:hover .wpm_6310_team_style_32_designation { color:" + value + ";} </style>").appendTo("body");
        });

        jQuery("#wpm_designation_font_weight").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_designation { font-weight:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_designation_text_transform").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_designation { text-transform:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_jquery_designation_font").on("change", function () {
            var value = jQuery(this).val().replace(/\+/g, ' ');
            value = value.split(':');
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_designation { font-family:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_designation_line_height").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'> .wpm_6310_team_style_32_designation { line-height:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#social_from_content").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_designation { padding-bottom:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_social_icon_width").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_social a { width:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_social_icon_height").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_social a { height:" + value + "; line-height:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_social_border_width").on("change", function () {
            var value = jQuery(this).val() + "px !important";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_social a { border-width:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_social_border_radius").on("change", function () {
            var value = jQuery(this).val() + "%";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_social a { border-radius:" + value + "; -moz-border-radius:" + value + "; -webkit-border-radius:" + value + "; -o-border-radius:" + value + "; -ms-border-radius:" + value + "; } </style>").appendTo("body");
        });
        jQuery("#wpm_member_margin_top").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_title { margin-top:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_member_margin_bottom").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_title { margin-bottom:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_designation_margin_top").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_designation { margin-top:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_designation_margin_bottom").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 .wpm_6310_team_style_32_designation { margin-bottom:" + value + ";} </style>").appendTo("body");
        });
        jQuery("#wpm_social_margin_top").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_social { margin-top:" + value + " !important;} </style>").appendTo("body");
        });
        jQuery("#wpm_social_margin_bottom").on("change", function () {
            var value = jQuery(this).val() + "px";
            jQuery("<style type='text/css'>.wpm_6310_team_style_32_social { margin-bottom:" + value + " !important;} </style>").appendTo("body");
        });
        jQuery("#wpm_box_background").on("change", function () {
            var value = jQuery(this).val();
            jQuery("<style type='text/css'>.wpm_6310_team_style_32 { background:" + value + ";} </style>").appendTo("body");
        });
        <?php
        if((isset($allStyle[33]) && ($allStyle[33] == '' || $allStyle[33] == 0)) ){
            echo 'jQuery(".social_act_field").hide();';
        }
        ?>
        jQuery('body').on('click', '#wpm_social_activation', function(){
            if (jQuery(this).prop('checked') == true) {
                jQuery(".wpm_6310_team_style_32_social").show();
                jQuery(".social_act_field").show();
            }
            else{
                jQuery(".wpm_6310_team_style_32_social").hide();
                jQuery(".social_act_field").hide();
            }
        });
        jQuery("#wpm_item_align").on("change", function () {
            var value = jQuery(this).val() ;
            jQuery("<style type='text/css'> .wpm_6310_tabs_panel_preview .wpm-6310-row { justify-content:" + value + " !important;} </style>").appendTo("body");
        });
    });
</script>
