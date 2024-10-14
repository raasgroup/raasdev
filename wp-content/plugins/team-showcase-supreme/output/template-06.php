<?php
$numberOfWords = 0;
if ($allSlider[0]) {
   echo "<div class='wpm-6310-carousel'>
            <div id='wpm-6310-slider-".esc_attr($ids)."' class='wpm-6310-owl-carousel'>";
   if ($members) {
      foreach ($members as $value) {
        if ($value['profile_details_type'] == 1) {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_info' link-id='" . esc_attr($value['id']) . "' link-url='" . wpm_6310_validate_profile_url($value['profile_url']) . "' target='" . esc_attr($value['open_new_tab']) . "' team-id='0'";
      } else if ($value['profile_details_type'] == 2) {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_info' link-id='0' team-id='" . esc_attr($value['id']) . "'";
      } else if ($value['profile_details_type'] == 3) {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_internal_link'data-wpm-link-url='" . get_permalink(esc_attr($value['post_id'])) . "'";
      } else {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)."' link-id='0' team-id='0'";
      }

?>
         <div class="wpm-6310-item-<?php echo esc_attr($ids) ?>">
            <div <?php echo $link_type ?>>
            <img src="<?php echo esc_attr($value['image']) ?>" data-6310-hover-image="<?php echo esc_attr($value['hover_image']) ?>" alt="<?php echo esc_attr($value['name']) ?>" data-wpm-6310-image-attr="<?php echo esc_attr($value['image']) ?>">
               <figcaption>
                  <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_content">
                  <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_content_cell">
                     <div class="wpm_6310_team_style_<?php echo $ids ?>_title">
                        <?php echo wpm_6310_multi_language_get('name', $value['name'], $value['id']) ?>
                     </div>
                     <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_designation">
                        <?php echo wpm_6310_multi_language_get('designation', $value['designation'], $value['id']) ?>
                     </div>
                     <?php
                     wpm_6310_template_skills($value['skills'], $ids, $allSlider, $value['id'], ' wpm-6310-p-l-r-10');                  
                      wpm_6310_extract_member_description($value, ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $ids); 
                     wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $ids, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                     ?>
                  </div>
                  </div>
               </figcaption>
            </div>
         </div>
      <?php
      }
   }
   echo "</div>
        </div>";
} else {
   
   if ($members) {
      echo "<div class='wpm-6310-row'>";
      
      foreach ($members as $value) {
        if ($value['profile_details_type'] == 1) {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_info' link-id='" . esc_attr($value['id']) . "' link-url='" . wpm_6310_validate_profile_url($value['profile_url']) . "' target='" . esc_attr($value['open_new_tab']) . "' team-id='0'";
      } else if ($value['profile_details_type'] == 2) {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_info' link-id='0' team-id='" . esc_attr($value['id']) . "'";
      } else if ($value['profile_details_type'] == 3) {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_internal_link'data-wpm-link-url='" . get_permalink(esc_attr($value['post_id'])) . "'";
      } else {
         $link_type = " class='wpm_6310_team_style_".esc_attr($ids)."' link-id='0' team-id='0'";
      }

      ?>
         <div class="wpm-6310-col-<?php echo esc_attr($desktop_row) ?>">
            <div <?php echo $link_type ?>>
            <img src="<?php echo esc_attr($value['image']) ?>" data-6310-hover-image="<?php echo esc_attr($value['hover_image']) ?>" alt="<?php echo esc_attr($value['name']) ?>" data-wpm-6310-image-attr="<?php echo esc_attr($value['image']) ?>">
               <figcaption>
                  <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_content">
                  <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_content_cell">
                     <div class="wpm_6310_team_style_<?php echo $ids ?>_title">
                        <?php echo wpm_6310_multi_language_get('name', $value['name'], $value['id']) ?>
                     </div>
                     <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_designation">
                        <?php echo wpm_6310_multi_language_get('designation', $value['designation'], $value['id']) ?>
                     </div>
                     <?php
                     wpm_6310_template_skills($value['skills'], $ids, $allSlider, $value['id'], ' wpm-6310-p-l-r-10');
                      wpm_6310_extract_member_description($value, ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $ids); 
                     wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $ids, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                     ?>
                  </div>
                  </div>
               </figcaption>
         </div>
         </div>
<?php
      }
      echo "</div>";
   }
}
?>

<?php
        $customCSS = ".wpm_6310_team_style_".esc_attr($ids)." {
         text-align: center;
         overflow: hidden;
         position: relative;
         z-index: 1;
         letter-spacing: .04em;
         -webkit-border-radius: ".esc_attr($allStyle[2])."%;
         -o-border-radius: ".esc_attr($allStyle[2])."%;
         -moz-border-radius: ".esc_attr($allStyle[2])."%;
         -ms-border-radius: ".esc_attr($allStyle[2])."%;
         border-radius: ".esc_attr($allStyle[2])."%;
         border-style: solid;
         border-width: ".esc_attr($allStyle[3])."px;
         border-color: ".esc_attr($allStyle[4]).";
         box-shadow: 0 0 ".esc_attr($allStyle[9])."px ".esc_attr($allStyle[8])."px ".esc_attr($allStyle[10]).";
         -moz-box-shadow: 0 0 ".esc_attr($allStyle[9])."px ".esc_attr($allStyle[8])."px ".esc_attr($allStyle[10]).";
         -o-box-shadow: 0 0 ".esc_attr($allStyle[9])."px ".esc_attr($allStyle[8])."px ".esc_attr($allStyle[10]).";
         -webkit-box-shadow: 0 0 ".esc_attr($allStyle[9])."px ".esc_attr($allStyle[8])."px ".esc_attr($allStyle[10]).";
         -ms-box-shadow: 0 0 ".esc_attr($allStyle[9])."px ".esc_attr($allStyle[8])."px ".esc_attr($allStyle[10]).";
         width: 100%;
         float: left;
      }
      .wpm_6310_team_style_".esc_attr($ids)." img {
         width: 100%;
         height: auto;
         padding: 0 !important;
         margin: 0 !important;
         float: left;
         border-radius: 0 !important;
      }
      .wpm_6310_team_style_".esc_attr($ids)." figcaption {
         position: absolute;
         left: 0;
         right: 0;
         top: 0;
         bottom: 0;
         padding: 0;
         color: #fff;
         text-align: center;
         opacity: 0;
         -webkit-backface-visibility: hidden;
         -moz-backface-visibility: hidden;
         backface-visibility: hidden;
         transform: scale(0.6);
         -webkit-transform: scale(0.6);
         -moz-transform: scale(0.6);
         -webkit-transition: all 0.3s ease-in-out 0s;
         -moz-transition: all 0.3s ease-in-out 0s;
         -ms-transition: all 0.3s ease-in-out 0s;
         -o-transition: all 0.3s ease-in-out 0s;
         transition: all 0.3s ease-in-out 0s;
      }
      .wpm_6310_team_style_".esc_attr($ids)." figcaption:after {
         content: '';
         width: 0px;
         height: 100%;
         display: inline-block;
         vertical-align: middle;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_content {
         height: 100%;
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         padding: 0;
         background: ".esc_attr($allStyle[7]).";
         transition: all 0.20s ease 0s;
         width: 100%;
         display: table;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_content_cell {
         display: table-cell;
         vertical-align: middle;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_designation {
         font-size: ".esc_attr($allStyle[19])."px;
         color: ".esc_attr($allStyle[20]).";
         font-weight: ".esc_attr($allStyle[21]).";
         text-transform: ".esc_attr($allStyle[22]).";
         font-family: ".esc_attr(str_replace("+", " ", $allStyle[23])).";
         line-height: ".esc_attr($allStyle[24] )."px;
         padding-bottom: ".esc_attr($allStyle[25])."px;
         display: block;
         text-align: center !important;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_title {
         margin: 0;
         font-size: ".esc_attr($allStyle[11])."px;
         color: ".esc_attr($allStyle[12]).";
         font-weight: ".esc_attr($allStyle[15]).";
         text-transform: ".esc_attr($allStyle[16]).";
         font-family: ".esc_attr(str_replace("+", " ", $allStyle[17])).";
         line-height: ".esc_attr($allStyle[18])."px;
         text-align: center !important;
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover {
         border-color: ".esc_attr($allStyle[7]).";
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover figcaption {
         opacity: 1;
         transform: scale(1.02);
         -webkit-transform: scale(1.02);
         -moz-transform: scale(1.02);
      }
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_2,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_3,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_4,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_5,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_6,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_7,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_8,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_9,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_10,
      .wpm_6310_team_style_".esc_attr($ids)." img.wpm_6310_eff_11 {
         -webkit-transition: all 0.5s ease-in-out 0s;
         -moz-transition: all 0.5s ease-in-out 0s;
         -ms-transition: all 0.5s ease-in-out 0s;
         -o-transition: all 0.5s ease-in-out 0s;
         transition: all 0.5s ease-in-out 0s;
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_2 {
         -webkit-transform: translate3d(0, -100%, 0);
         -moz-transform: translate3d(0, -100%, 0);
         -o-transform: translate3d(0, -100%, 0);
         transform: translate3d(0, -100%, 0)
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_3 {
         -webkit-transform: translate3d(100%, 0, 0);
         -moz-transform: translate3d(100%, 0, 0);
         -o-transform: translate3d(100%, 0, 0);
         transform: translate3d(100%, 0, 0)
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_4 {
         -webkit-transform: translate3d(0, 100%, 0);
         -moz-transform: translate3d(0, 100%, 0);
         -o-transform: translate3d(0, 100%, 0);
         transform: translate3d(0, 100%, 0)
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_5 {
         -webkit-transform: translate3d(-100%, 0, 0);
         -moz-transform: translate3d(-100%, 0, 0);
         -o-transform: translate3d(-100%, 0, 0);
         transform: translate3d(-100%, 0, 0)
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_6 {
         -webkit-transform: rotate(360deg) scale(0.5);
         -moz-transform: rotate(360deg) scale(0.5);
         -ms-transform: rotate(360deg) scale(0.5);
         transform: rotate(360deg) scale(0.5);
         opacity: 0;
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_7 {
         -webkit-transform: rotate(-360deg) scale(0.5);
         -moz-transform: rotate(-360deg) scale(0.5);
         -ms-transform: rotate(-360deg) scale(0.5);
         transform: rotate(-360deg) scale(0.5);
         opacity: 0;
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_8 {
         -webkit-transform: translate3d(-100%, -100%, 0);
         -moz-transform: translate3d(-100%, -100%, 0);
         -o-transform: translate3d(-100%, -100%, 0);
         transform: translate3d(-100%, -100%, 0)
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_9 {
         -webkit-transform: translate3d(100%, -100%, 0);
         -moz-transform: translate3d(100%, -100%, 0);
         -o-transform: translate3d(100%, -100%, 0);
         transform: translate3d(100%, -100%, 0)
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_10 {
         -webkit-transform: translate3d(100%, 100%, 0);
         -moz-transform: translate3d(100%, 100%, 0);
         -o-transform: translate3d(100%, 100%, 0);
         transform: translate3d(100%, 100%, 0)
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img.wpm_6310_eff_11 {
         -webkit-transform: translate3d(-100%, 100%, 0);
         -moz-transform: translate3d(-100%, 100%, 0);
         -o-transform: translate3d(-100%, 100%, 0);
         transform: translate3d(-100%, 100%, 0)
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social {
         margin: 10px 0 0 !important;
         padding: 0 !important;
         list-style: none;
         text-align: center !important;
         display: ".esc_attr((!isset($allStyle[31]) || (isset($allStyle[31]) && $allStyle[31])) ? 'block' : 'none').";
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li {
         display: inline-block;
         margin: 0 8px 8px 0 !important;
         padding: 0 !important;
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li:last-child {
         margin-right: 0 !important;
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li:before,
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li:after {
         display: none !important;
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li a {
         display: inline-block;
         font-size: ".esc_attr(ceil((($allStyle[26] ? $allStyle[26] : 8) + ($allStyle[27] ? $allStyle[27] : 8)) / 4))."px;
         color: #fff;
         -webkit-transition: all 0.5s ease 0s;
         -moz-transition: all 0.5s ease 0s;
         -ms-transition: all 0.5s ease 0s;
         -o-transition: all 0.5s ease 0s;
         transition: all 0.5s ease 0s;
         border-radius: ".esc_attr($allStyle[30] )."%;
         -moz-border-radius: ".esc_attr($allStyle[30])."%;
         -webkit-border-radius: ".esc_attr($allStyle[30])."%;
         -o-border-radius: ".esc_attr($allStyle[30])."%;
         -ms-border-radius: ".esc_attr($allStyle[30])."%;
         box-shadow: none;
         text-decoration: none;
         margin: 0 !important;
         padding: 0 !important;
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li a:hover {
         box-shadow: none;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_description{
       padding: 0 10px;
     }
      .wpm_6310_link_activity {
         display: none;
      }";
        wp_register_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css", "");
        wp_enqueue_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css");
        wp_add_inline_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css", $customCSS);
      ?>
<?php
include wpm_6310_plugin_url . "output/common-output-file.php";
wpm6310_common_output_css($ids);
?>