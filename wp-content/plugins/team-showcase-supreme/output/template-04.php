<?php
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
                  <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_caption">
                     <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_designation">
                        <?php echo wpm_6310_multi_language_get('designation', $value['designation'], $value['id']) ?>
                     </div>
                     <div class="wpm_6310_team_style_<?php echo $ids ?>_title">
                        <?php echo wpm_6310_multi_language_get('name', $value['name'], $value['id']) ?>
                     </div>
                     <?php
                        wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $ids, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                     ?>
                  </div>
               </figcaption>
               <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_overlay"></div>
               <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_icon">
                  <?php
                  if ($value['profile_details_type'] > 0) {
                     echo '<i class="fas fa-plus-circle"></i>';
                  }
                  ?>
               </div>
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
            <div <?php echo $link_type?>>
            <img src="<?php echo esc_attr($value['image']) ?>" data-6310-hover-image="<?php echo esc_attr($value['hover_image']) ?>" alt="<?php echo esc_attr($value['name']) ?>" data-wpm-6310-image-attr="<?php echo esc_attr($value['image']) ?>">
               <figcaption>
                  <div class="wpm_6310_team_style_<?php echo esc_attr($ids)?>_caption">
                     <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_designation">
                        <?php echo wpm_6310_multi_language_get('designation', $value['designation'], $value['id']) ?>
                     </div>
                     <div class="wpm_6310_team_style_<?php echo $ids ?>_title">
                        <?php echo wpm_6310_multi_language_get('name', $value['name'], $value['id']) ?>
                     </div>
                     <?php
                        wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $ids, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                     ?>
                  </div>
               </figcaption>
               <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_overlay"></div>
               <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_icon">
                  <?php
                  if ($value['profile_details_type'] > 0) {
                     echo '<i class="fas fa-plus-circle"></i>';
                  }
                  ?>
               </div>
         </div>
         </div>
<?php
      }
      echo "</div>";
   }
}
?>

<?php
        $customCSS = ".wpm_6310_team_style_".esc_attr($ids)."{
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
         box-shadow: 0 0 ".esc_attr((($allStyle[9] ? $allStyle[9] : 1) * 2))."px ".esc_attr($allStyle[8])."px ".esc_attr($allStyle[10]).";
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
      .wpm_6310_team_style_".esc_attr($ids)."_caption {
         padding: 15px 0 10px;
         text-align: center;
         float: left;
         width: 100%;
         position: absolute;
         height: 100%;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_designation {
         text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
         font-size: ".esc_attr($allStyle[19])."px;
         color: ".esc_attr($allStyle[20]).";
         font-weight: ".esc_attr($allStyle[21]).";
         text-transform: ".esc_attr($allStyle[22]).";
         font-family: ".esc_attr(str_replace("+", " ", $allStyle[23])).";
         line-height: ".esc_attr($allStyle[24])."px;
         bottom: 65px;
         padding: 3px 20px 3px 15px;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_title {
         font-size: ".esc_attr($allStyle[11])."px;
         color: ".esc_attr($allStyle[12]).";
         font-weight: ".esc_attr($allStyle[15]).";
         text-transform: ".esc_attr($allStyle[16]).";
         font-family: ".esc_attr(str_replace("+", " ", $allStyle[17])).";
         line-height: ".esc_attr($allStyle[18])."px;
         bottom: 40px;
         padding: 0 20px 5px 15px;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_title,
      .wpm_6310_team_style_".esc_attr($ids)."_designation {
         left: 0;
         position: absolute;
         background-color: #1F7DCF;
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social {
         padding: 0 !important;
         margin: 0 !important;
         width: 100%;
         position: absolute;
         bottom: -100%;
         z-index: 999;
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
         transition: all 0.5s ease 0s;
         border-radius: ".esc_attr($allStyle[30])."%;
         -moz-border-radius: ".esc_attr($allStyle[30])."%;
         -webkit-border-radius: ".esc_attr($allStyle[30])."%;
         -o-border-radius: ".esc_attr($allStyle[30])."%;
         -ms-border-radius: ".esc_attr($allStyle[30])."%;
         box-shadow: none;
         text-decoration: none;
         padding: 0 !important;
         margin: 0 !important;
      }
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li a:hover {
         box-shadow: none;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_icon {
         position: absolute;
         font-size: 50px;
         line-height: 50px;
         color: #FFF;
         text-align: center;
         width: 100%;
         top: -100px;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_icon .fa {
         color: #FFF;
      }
      .wpm_6310_team_style_".esc_attr($ids)."_overlay {
         position: absolute;
         width: 100%;
         height: 100%;
         left: 0;
         bottom: 0;
         padding: 0 10px;
         color: #fff;
         background: ".esc_attr($allStyle[7]).";
         opacity: 0;
      }
      .wpm_6310_team_style_".esc_attr($ids)." img,
      .wpm_6310_team_style_".esc_attr($ids)."_title,
      .wpm_6310_team_style_".esc_attr($ids)."_designation,
      ul.wpm_6310_team_style_".esc_attr($ids)."_social,
      ul.wpm_6310_team_style_".esc_attr($ids)."_social li a,
      .wpm_6310_team_style_".esc_attr($ids)."_icon,
      .wpm_6310_team_style_".esc_attr($ids)."_overlay {
         -webkit-transition: all 0.5s ease 0s;
         -moz-transition: all 0.5s ease 0s;
         -ms-transition: all 0.5s ease 0s;
         -o-transition: all 0.5s ease 0s;
         transition: all 0.5s ease 0s
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover .wpm_6310_team_style_".esc_attr($ids)."_designation,
      .wpm_6310_team_style_".esc_attr($ids).":hover .wpm_6310_team_style_".esc_attr($ids)."_title {
         left: -100%;
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover ul.wpm_6310_team_style_".esc_attr($ids)."_social {
         bottom: 40px;
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover img {
         transform: scale(1.05);
         opacity: .8
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover .wpm_6310_team_style_".esc_attr($ids)."_overlay {
         opacity: 1;
      }
      .wpm_6310_team_style_".esc_attr($ids).":hover .wpm_6310_team_style_".esc_attr($ids)."_icon {
         top: calc(50% - 25px);
         transform: rotate(720deg);
      }";
        wp_register_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css", "");
        wp_enqueue_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css");
        wp_add_inline_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css", $customCSS);
      ?>


<?php
include wpm_6310_plugin_url . "output/common-output-file.php";
wpm6310_common_output_css($ids);
?>