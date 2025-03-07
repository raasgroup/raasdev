<?php
        $customCSS = "
        .wpm-6310-row{
         width: 100%;
      }
   
      .nav-tabs > li.active > a,
      .nav-tabs > li.active > a:focus,
      .nav-tabs > li.active > a:hover
      {
         box-shadow: none;
         font-weight: bold;
      }
      .wpm-6310-col-2, .wpm-6310-col-3, .wpm-6310-col-4, .wpm-6310-col-5, .wpm-6310-col-6{
         margin-right: 30px;
         margin-bottom: 30px;
         float: left;
         position: relative;
      }
      .wpm-6310-col-1{
         width: 100%;
         margin-bottom: 30px;
         float: left;
         position: relative;
      }
      .wpm-6310-col-2{
         width: calc(50% - 15px);
      }
      .wpm-6310-col-3{
         width: calc(33.33% - 20px);
      }
      .wpm-6310-col-4{
         width: calc(25% - 23px);
      }
      .wpm-6310-col-5{
         width: calc(20% - 24px);
      }
      .wpm-6310-col-6{
         width: calc(16.6667% - 25px);
      }
      .wpm-6310-col-2:nth-child(2n), .wpm-6310-col-3:nth-child(3n), .wpm-6310-col-4:nth-child(4n), .wpm-6310-col-5:nth-child(5n), .wpm-6310-col-6:nth-child(6n){
         margin-right: 0;
      }
      #wpm-6310-slider-".esc_attr($styleId)." .wpm-6310-owl-nav div {
         position: absolute;
         top: calc(50% - 35px);
         background: ".esc_attr($allSlider[7]).";
         color: ".esc_attr($allSlider[8]).";
         margin: 0;
         transition: all 0.3s ease-in-out;
         font-size: ".esc_attr($allSlider[5])."px;
         line-height: ".esc_attr(($allSlider[5] ? $allSlider[5] : 0) + 15)."px;
         height: ".esc_attr(($allSlider[5] ? $allSlider[5] : 0) + 15)."px;
         width: ".esc_attr(($allSlider[5] ? $allSlider[5] : 0) + 15)."px;
         text-align: center;
         padding: 0;
      }
      #wpm-6310-slider-".esc_attr($styleId)." .wpm-6310-owl-nav div:hover{
         background: ".esc_attr($allSlider[9]).";
         color: ".esc_attr($allSlider[10]).";
      }
      #wpm-6310-slider-".esc_attr($styleId)." .wpm-6310-owl-nav div.wpm-6310-owl-prev {
         left: 0;
         border-radius: 0 ".esc_attr($allSlider[6])."% ".esc_attr($allSlider[6])."% 0;
      }
      #wpm-6310-slider-".esc_attr($styleId)." .wpm-6310-owl-nav div.wpm-6310-owl-next {
         right: ".esc_attr((((isset($allSlider[127]) && $allSlider[127])?$allSlider[127]:15) * 2))."px;
         border-radius: ".esc_attr($allSlider[6])."% 0 0 ".esc_attr($allSlider[6])."%;
      }
      #wpm-6310-slider-".esc_attr($styleId)." .wpm-6310-wpm-6310-owl-dots {
         text-align: center;
         padding-top: 15px;
      }
      #wpm-6310-slider-".esc_attr($styleId)." .wpm-6310-wpm-6310-owl-dots div {
         width: ".esc_attr($allSlider[12])."px;
         height: ".esc_attr($allSlider[13])."px;
         border-radius: ".esc_attr($allSlider[16])."%;
         display: inline-block;
         background-color: ".esc_attr($allSlider[15] ).";
         margin: 0 ".esc_attr($allSlider[17])."px;
      }
      #wpm-6310-slider-".esc_attr($styleId)." .wpm-6310-wpm-6310-owl-dots div.active {
         background-color: ".esc_attr($allSlider[14]).";
      }
        ";
        wp_register_style("wpm-6310-custom-slider-code-" . esc_attr($template_id) . "-css", "");
        wp_enqueue_style("wpm-6310-custom-slider-code-" . esc_attr($template_id) . "-css");
        wp_add_inline_style("wpm-6310-custom-slider-code-" . esc_attr($template_id) . "-css", $customCSS);
      ?>

<script>
   
   jQuery(document).ready(function () {
      jQuery("body").on("change", "#wpm_background_preview", function () {
         var value = jQuery(this).val();
         jQuery(".wpm_6310_tabs_panel_preview").css({"background": value});
      });

      var owl = jQuery("#wpm-6310-slider-<?php echo esc_attr($styleId) ?>");
      owl.tss6310OwlCarousel({
         autoplay: true,
         lazyLoad: true,
         loop: true,
         margin: 30,
         autoplayTimeout: <?php echo esc_attr($allSlider[2]) ?>,
         autoplayHoverPause: true,
         responsiveClass: true,
         autoHeight: true,
         nav: <?php echo esc_attr($allSlider[3]) ?>,
         dots: <?php echo esc_attr($allSlider[11]) ?>,
         navText: ["<i class='<?php echo esc_attr($allSlider[4]) ?>-left'></i>", "<i class='<?php echo esc_attr($allSlider[4]) ?>-right'></i>"],
         responsive: {
            0: {
               items: <?php echo esc_attr($mobile_row); ?>
            },
            600: {
               items: <?php echo esc_attr($tablet_row); ?>
            },
            1024: {
               items: <?php echo esc_attr($desktop_row) ?>
            },
            1366: {
               items: <?php echo esc_attr($desktop_row) ?>
            }
         }
      });
      owl.on('mouseleave', function () {
         owl.trigger('stop.owl.autoplay'); //this is main line to fix it
         owl.trigger('play.owl.autoplay', [<?php echo esc_attr($allSlider[2]) ?>]);
      });

<?php
if ($allSlider[0]) {
   echo "jQuery('#wpm-6310-noslider-{$styleId}').hide();";
} else {
   echo "jQuery('#wpm-6310-slider-{$styleId}').hide();";
}

if ($allSlider[3] == 'true') {
   echo ' jQuery(".wpm_6310_prev_next_act, #wpm_6310_prev, #wpm_6310_next, #wpm_6310_prev_font_icon, #wpm_6310_next_font_icon").show();';
} else {
   echo ' jQuery(".wpm_6310_prev_next_act, #wpm_6310_prev, #wpm_6310_next, #wpm_6310_prev_font_icon, #wpm_6310_next_font_icon").hide();';
}

if ($allSlider[11] == 'true') {
   echo 'jQuery(".wpm_6310_indicator_act, #wpm_6310_carousel_indicators").show();';
} else {
   echo 'jQuery(".wpm_6310_indicator_act, #wpm_6310_carousel_indicators").hide();';
}
?>

      //##############   Live preview settings Start  ##############################


      jQuery("body").on("change", "#wpm_6310_slider_duration_<?php echo esc_attr($styleId) ?>", function () {
         jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').data('owl.carousel').options.autoplayTimeout = jQuery('#wpm_6310_slider_duration_<?php echo esc_attr($styleId) ?>').val();
         jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').trigger('refresh.owl.carousel');
      });

      jQuery("body").on("change", "#wpm_6310_active_prev_next, #wpm_6310_deactive_prev_next", function () {
         if (jQuery("#wpm_6310_active_prev_next").prop('checked')) {
            jQuery(".wpm_6310_prev_next_act, #wpm_6310_prev, #wpm_6310_next, #wpm_6310_prev_font_icon, #wpm_6310_next_font_icon").show();
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').data('owl.carousel').options.nav = true;
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').trigger('refresh.owl.carousel');
         } else {
            jQuery(".wpm_6310_prev_next_act, #wpm_6310_prev, #wpm_6310_next, #wpm_6310_prev_font_icon, #wpm_6310_next_font_icon").hide();
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').data('owl.carousel').options.nav = false;
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').trigger('refresh.owl.carousel');
         }
      });

      jQuery("body").on("change", "#wpm_6310_icon_style", function () {
         jQuery("#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div.wpm-6310-owl-prev i").attr("class", jQuery(this).val() + "-left");
         jQuery("#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div.wpm-6310-owl-next i").attr("class", jQuery(this).val() + "-right");
      });

      jQuery("body").on("change", "#wpm_6310_prev_next_icon_size", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div { font-size:" + parseInt(jQuery(this).val()) + "px; line-height:" + (parseInt(jQuery(this).val()) + 15) + "px; height:" + (parseInt(jQuery(this).val()) + 15) + "px; width:" + (parseInt(jQuery(this).val()) + 15) + "px;} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_prev_next_icon_border_radius", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div.wpm-6310-owl-prev { border-radius:" + "0 " + parseInt(jQuery(this).val()) + "% " + parseInt(jQuery(this).val()) + "% 0" + ";} #wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div.wpm-6310-owl-next { border-radius:" + parseInt(jQuery(this).val()) + "% 0 0 " + parseInt(jQuery(this).val()) + "%" + ";}</style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_prev_next_bgcolor", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div { background:" + jQuery(this).val() + ";} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_prev_next_color", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div { color:" + jQuery(this).val() + ";} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_prev_next_hover_bgcolor", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div:hover { background:" + jQuery(this).val() + ";} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_prev_next_hover_color", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-owl-nav div:hover { color:" + jQuery(this).val() + ";} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_active_indicator, #wpm_6310_deactive_indicator", function () {
         if (jQuery("#wpm_6310_active_indicator").prop('checked')) {
            jQuery(".wpm_6310_indicator_act, #wpm_6310_carousel_indicators").show();
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').data('owl.carousel').options.dots = true;
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').trigger('refresh.owl.carousel');
         } else {
            jQuery(".wpm_6310_indicator_act, #wpm_6310_carousel_indicators").hide();
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').data('owl.carousel').options.dots = false;
            jQuery('#wpm-6310-slider-<?php echo esc_attr($styleId) ?>').trigger('refresh.owl.carousel');
         }
      });

      jQuery("body").on("change", "#wpm_6310_indicator_width", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-wpm-6310-owl-dots div { width:" + parseInt(jQuery(this).val()) + "px;} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_indicator_height", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-wpm-6310-owl-dots div { height:" + parseInt(jQuery(this).val()) + "px;} </style>").appendTo("body");
      });
      jQuery("body").on("change", "#wpm_6310_indicator_height", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-wpm-6310-owl-dots div { height:" + parseInt(jQuery(this).val()) + "px;} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_indicator_active_color", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-wpm-6310-owl-dots div.active{ background-color:" + jQuery(this).val() + ";} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_indicator_color", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-wpm-6310-owl-dots div { background-color:" + jQuery(this).val() + ";} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_indicator_border_radius", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-wpm-6310-owl-dots div { border-radius:" + parseInt(jQuery(this).val()) + "%;} </style>").appendTo("body");
      });

      jQuery("body").on("change", "#wpm_6310_indicator_margin", function () {
         jQuery("<style type='text/css'>#wpm-6310-slider-<?php echo esc_attr($styleId) ?> .wpm-6310-wpm-6310-owl-dots div{ margin: 0 " + parseInt(jQuery(this).val()) + "px;} </style>").appendTo("body");
      });
      //##############   Live preview settings End  ##############################
   });
</script>
