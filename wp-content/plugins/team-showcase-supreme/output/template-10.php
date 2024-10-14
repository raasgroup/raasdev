<?php
$numberOfWords = 0;
if ($allSlider[0]) {
  echo "<div class='wpm-6310-carousel'>
  <div id='wpm-6310-slider-".esc_attr($ids)."' class='wpm-6310-owl-carousel'>";
  if ($members) {
    foreach ($members as $value) {
      if ($value['profile_details_type'] == 1) {
        $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_info' link-id='" . esc_attr($value['id']) . "' link-url='" . esc_attr(wpm_6310_validate_profile_url($value['profile_url'])) . "' target='" . esc_attr($value['open_new_tab']) . "' team-id='0'";
    } else if ($value['profile_details_type'] == 2) {
        $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_info' link-id='0' team-id='" . esc_attr($value['id']) . "'";
    } else if ($value['profile_details_type'] == 3) {
      $link_type = " class='wpm_6310_team_style_".esc_attr($ids)." wpm_6310_team_member_internal_link'data-wpm-link-url='" . get_permalink(esc_attr($value['post_id'])) . "'";
    } else {
        $link_type = " class='wpm_6310_team_style_".esc_attr($ids)."' link-id='0' team-id='0'";
    }
?>
      <div class="wpm-6310-item-<?php echo esc_attr($ids); ?>">
        <div <?php echo $link_type ?>>
          <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_pic">
          <img src="<?php echo esc_attr($value['image']) ?>" data-6310-hover-image="<?php echo esc_attr($value['hover_image']) ?>" alt="<?php echo esc_attr($value['name']) ?>" data-wpm-6310-image-attr="<?php echo esc_attr($value['image']) ?>">
            <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_social_team">
              <?php
              wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $ids, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
              ?>
            </div>
          </div>
          <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_team_content">
            <div class="wpm_6310_team_style_<?php echo $ids ?>_title">
              <?php echo wpm_6310_multi_language_get('name', $value['name'], $value['id']) ?>
            </div>
            <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_designation">
              <?php echo wpm_6310_multi_language_get('designation', $value['designation'], $value['id']) ?>
            </div>
            <?php
              wpm_6310_template_skills($value['skills'], $ids, $allSlider, $value['id'], ' wpm-6310-p-l-r-10');
              wpm_6310_extract_member_description($value, ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $ids);
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
        <div <?php echo $link_type ?>>
          <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_pic">
          <img src="<?php echo esc_attr($value['image']) ?>" data-6310-hover-image="<?php echo esc_attr($value['hover_image']) ?>" alt="<?php echo esc_attr($value['name']) ?>" data-wpm-6310-image-attr="<?php echo esc_attr($value['image']) ?>">
            <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_social_team">
              <?php
              wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $ids, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
              ?>
            </div>
          </div>
          <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_team_content">
            <div class="wpm_6310_team_style_<?php echo $ids ?>_title">
              <?php echo wpm_6310_multi_language_get('name', $value['name'], $value['id']) ?>
            </div>
            <div class="wpm_6310_team_style_<?php echo esc_attr($ids) ?>_designation">
              <?php echo wpm_6310_multi_language_get('designation', $value['designation'], $value['id']) ?>
            </div>
            <?php
              wpm_6310_template_skills($value['skills'], $ids, $allSlider, $value['id'], ' wpm-6310-p-l-r-10');
              wpm_6310_extract_member_description($value, ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $ids);
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
        $customCSS = ".wpm_6310_team_style_".esc_attr($ids)." {
          text-align: center;
          overflow: hidden;
          transition: all 0.3s ease 0s;
          background: ".esc_attr($allStyle[7]).";
          -webkit-border-radius: ".esc_attr($allStyle[2])."px;
          -o-border-radius: ".esc_attr($allStyle[2])."px;
          -moz-border-radius: ".esc_attr($allStyle[2])."px;
          -ms-border-radius: ".esc_attr($allStyle[2])."px;
          border-radius: ".esc_attr($allStyle[2])."px;
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
          background: #FFF;
          position: relative;
        }
        .wpm_6310_team_style_".esc_attr($ids).":hover {
          background: ".esc_attr($allStyle[7]).";
        }
        .wpm_6310_team_style_".esc_attr($ids)."_pic {
          position: relative;
          overflow: hidden;
        }
        .wpm_6310_team_style_".esc_attr($ids)."_pic img {
          width: 100%;
          height: auto;
          transition: all 0.2s ease 0s;
          position: relative;
          float: left;
          padding: 0 !important;
          margin: 0 !important;
          border-radius: 0;
        }
        .wpm_6310_team_style_".esc_attr($ids)."_social_team {
          position: absolute;
          bottom: -100px;
          background: ".esc_attr($allStyle[10]).";
          width: 100%;
          transition: all 0.35s ease 0s;
          opacity: 0;
          padding: 0;
          margin: 0;
        }
        .wpm_6310_team_style_".esc_attr($ids).":hover .wpm_6310_team_style_".esc_attr($ids)."_social_team {
          bottom: 0px;
          opacity: 1;
        }
        ul.wpm_6310_team_style_".esc_attr($ids)."_social {
          list-style: none;
          padding: 0 !important;
          margin: 10px 0 !important;
          float: left;
          width: 100%;
          display: ".esc_attr((!isset($allStyle[32]) || (isset($allStyle[32]) && $allStyle[32])) ? 'block' : 'none').";
        }
        ul.wpm_6310_team_style_".esc_attr($ids)."_social li {
          display: inline-block;
          margin: 0 8px 0 0 !important;
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
          display: block;
          transition: all 0.3s ease 0s;
          font-size: ".esc_attr(ceil((($allStyle[26] ? $allStyle[26] : 8) + ($allStyle[27] ? $allStyle[27] : 8)) / 4))."px;
          border-radius: ".esc_attr($allStyle[30])."%;
          -moz-border-radius: ".esc_attr($allStyle[30])."%;
          -webkit-border-radius: ".esc_attr($allStyle[30])."%;
          -o-border-radius: ".esc_attr($allStyle[30])."%;
          -ms-border-radius: ".esc_attr($allStyle[30])."%;
          text-align: center;
          box-shadow: none !important;
          text-decoration: none;
          padding: 0 !important;
          margin: 0 !important;
          color: #FFF;
        }
        ul.wpm_6310_team_style_".esc_attr($ids)."_social li a:hover {
          box-shadow: none;
        }
        .wpm_6310_team_style_".esc_attr($ids)."_team_content {
          margin-top: 10px;
          float: left;
          width: 100%;
        }
        .wpm_6310_team_style_".esc_attr($ids)."_title {
          margin: 15px 0px 5px;
          font-size: ".esc_attr($allStyle[11])."px;
          color: ".esc_attr($allStyle[12]).";
          font-weight: ".esc_attr($allStyle[15]).";
          text-transform: ".esc_attr($allStyle[16]).";
          font-family: ".esc_attr(str_replace("+", " ", $allStyle[17])).";
          line-height: ".esc_attr($allStyle[18])."px;
          transition: all 0.2s ease 0s;
        }
        .wpm_6310_team_style_".esc_attr($ids)."_designation {
          font-size: ".esc_attr($allStyle[19])."px;
          color: ".esc_attr($allStyle[20]).";
          font-weight: ".esc_attr($allStyle[21]).";
          text-transform: ".esc_attr($allStyle[22]).";
          font-family: ".esc_attr(str_replace("+", " ", $allStyle[23])).";
          line-height: ".esc_attr($allStyle[24])."px;
          display: block;
        }
        .wpm_6310_team_style_".esc_attr($ids)."_description{
          padding: 0 10px;
        }";
        wp_register_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css", "");
        wp_enqueue_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css");
        wp_add_inline_style("wpm-6310-custom-code-" . esc_attr($ids) . "-css", $customCSS);
      ?>

<?php
include wpm_6310_plugin_url . "output/common-output-file.php";
wpm6310_common_output_css($ids);
?>