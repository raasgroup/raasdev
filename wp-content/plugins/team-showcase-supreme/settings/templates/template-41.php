<div class="wpm-6310">
  <div class="wpm-6310-sm">
    <?php
    include wpm_6310_plugin_url . 'settings/helper/team-member-save.php';
    $numberOfWords = 0;
    $styleTemplate = 31;

    if (!empty($_POST['update_style_change']) && $_POST['update_style_change'] == 'Save' && $_POST['styleid'] != '') {
      $nonce = $_REQUEST['_wpnonce'];
      if (!wp_verify_nonce($nonce, 'wpm_nonce_field_form')) {
        die('You do not have sufficient permissions to access this pagess.');
      } else {
        $css = "";
        $css .= sanitize_text_field($_POST['item_per_row_data_desktop']) . "@@##@@" . sanitize_text_field($_POST['item_per_row_data_tablet']) . "@@##@@" . sanitize_text_field($_POST['item_per_row_data_mobile']);
        $css .= "|";
        $css .= "|" . sanitize_text_field($_POST['image_radius']);
        $css .= "|" . sanitize_text_field($_POST['border_width']);
        $css .= "|" . sanitize_text_field($_POST['border_color']);
        $css .= "|" . sanitize_text_field($_POST['wpm_img_background_color']);
        //0 - 5


        $css .= "|" . sanitize_text_field($_POST['wpm_img_content_background_left_color']);
        $css .= "|" . sanitize_text_field($_POST['wpm_img_content_background_right_color']);
        $css .= "|" . sanitize_text_field($_POST['box_shadow_width']);
        $css .= "|" . sanitize_text_field($_POST['box_shadow_blur']);
        $css .= "|" . sanitize_text_field($_POST['box_shadow_color']);
        //6 - 10

        $css .= "|" . sanitize_text_field($_POST['member_font_size']);
        $css .= "|" . sanitize_text_field($_POST['member_font_color']);
        $css .= "|" . sanitize_text_field($_POST['member_font_hover_color']);
        $css .= "|" ;
        $css .= "|" . sanitize_text_field($_POST['member_font_weight']);
        //11 - 15

        $css .= "|" . sanitize_text_field($_POST['member_text_transform']);
        $css .= "|" . sanitize_text_field($_POST['member_font_family']);
        $css .= "|" . sanitize_text_field($_POST['member_line_height']);
        $css .= "|" . sanitize_text_field($_POST['designation_font_size']);
        $css .= "|" . sanitize_text_field($_POST['designation_font_color']);
        //16 - 20
        $css .= "|" . sanitize_text_field($_POST['designation_font_weight']);
        $css .= "|" . sanitize_text_field($_POST['designation_text_transform']);
        $css .= "|" . sanitize_text_field($_POST['designation_font_family']);
        $css .= "|" . sanitize_text_field($_POST['designation_line_height']);
        $css .= "|" . sanitize_text_field($_POST['designation_font_hover_color']);
        //21 - 25

        $css .= "|" . sanitize_text_field($_POST['social_icon_width']);
        $css .= "|" . sanitize_text_field($_POST['social_icon_height']);
        $css .= "|" . sanitize_text_field($_POST['social_border_width']);
        $css .= "|" . sanitize_text_field($_POST['wpm_3610_img_border_size']);
        $css .= "|" . sanitize_text_field($_POST['social_border_radius']);
        //26 - 30

        $css .= "|" . sanitize_text_field($_POST['wpm_3610_img_border_color']);
        $css .= "|" . sanitize_text_field($_POST['wpm_icon_background_left_color']);
        $css .= "|" . sanitize_text_field($_POST['wpm_icon_background_right_color']);
        $css .= "|";
        $css .= "|";
        // 31 - 35

        $css .= "|";
        $css .= "|" . (isset($_POST['social_activation']) ? sanitize_text_field($_POST['social_activation']) : 0);
        $css .= "|" ;
        $css .= "|" ;
        $css .= "|" ;
        // 36 - 40

        $css .= "|";
        // 41-45

        include wpm_6310_plugin_url . 'settings/helper/slider_form_save.php';
      }
    }
    $styledata = $wpdb->get_row($wpdb->prepare("SELECT * FROM $style_table WHERE id = %d ", $styleId), ARRAY_A);
    $allStyle = explode("|", $styledata['css']);
    $allSlider = explode("|", $styledata['slider']);
    $suffix = isset($allSlider[70]) ? $allSlider[70] : '';
    $results = wpm_6310_extract_members($styledata['memberid'], $styleId);
    $members = $results['members'];
    $filterList = $results['filter_activation'];

    $rows = explode("@@##@@", $allStyle[0]);
    $desktop_row = $rows[0];
    $tablet_row = isset($rows[1]) ? $rows[1] : 1;
    $mobile_row = isset($rows[2]) ? $rows[2] : 1;
    ?>
    <div class="wpm_6310_tabs_panel_settings">
      <form method="post">
        <?php wp_nonce_field("wpm_nonce_field_form") ?>
        <input type="hidden" name="styleid" value="<?php echo $styleId ?>" />
        <div class="wpm_6310_padding_15_px">
          <?php include wpm_6310_plugin_url . 'settings/helper/tab-menu.php'; ?>
        </div>
        <div class="wpm-tab-content">
          <div id="tab-1">
            <div class="row wpm_6310_padding_15_px">
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table">
                  <?php 
                      wpm_6310_change_template($styledata['style_name'], $styleId);  
                      wpm_items_per_row($styleId, $allStyle[0], $styledata['name']) 
                    ?>
                  <tr>
                    <td><b>Items Alignment</b></td>
                    <td>
                      <select name="item_align" class="wpm-form-input" id="wpm_item_align">
                        <option value="center" <?php if (!isset($allSlider[126]) || (isset($allSlider[126]) && $allSlider[126] == 'center')) echo " selected=''" ?>>Center</option>
                        <option value="flex-start" <?php if (isset($allSlider[126]) && $allSlider[126] == 'flex-start') echo " selected=''" ?>>Left</option>
                        <option value="flex-end" <?php if (isset($allSlider[126]) && $allSlider[126] == 'flex-end') echo " selected=''" ?>>Right</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                        <td>
                          <b>Items Margin</b>
                          <div class="wpm-6310-pro">*Preview-on-change  not available</div>
                      </td>
                        <td>
                          <input type="number" name="item_margin" id="wpm_item_margin" class="wpm-form-input" value="<?php echo (isset($allSlider[127]) && $allSlider[127] && $allSlider[127])?$allSlider[127]:"15" ?>">
                        </td>
                    </tr>
                  <tr>
                    <td><b>Box Radius</b></td>
                    <td>
                      <input type="number" min="0" name="image_radius" value="<?php echo $allStyle[2] ?>" class="wpm-form-input" id="wpm_image_radius" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Box Border Width</b></td>
                    <td>
                      <input type="number" min="0" name="border_width" value="<?php echo $allStyle[3] ?>" class="wpm-form-input" id="wpm_border_width" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Box Border Color</b></td>
                    <td>
                      <input type="text" name="border_color" id="wpm_border_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" data-opacity=".8" value="<?php echo $allStyle[4] ?>">
                    </td>
                  </tr>  
                              
                </table>
              </div>
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table">
                  <tr>
                    <td><b>Image Background Color</b></td>
                    <td>
                      <input type="text" name="wpm_img_background_color" id="wpm_img_background_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" data-opacity=".8" value="<?php echo $allStyle[5] ?>">
                    </td>
                  </tr>  

                  <tr>
                    <td><b>Content Background left Color</b></td>
                    <td>
                        <input type="text" name="wpm_img_content_background_left_color" id="wpm_img_content_background_left_color"
                        class="wpm-form-input wpm_6310_color_picker" data-opacity=".8" data-format="rgb"
                        value="<?php echo $allStyle[6]?>">
                    </td>
                  </tr>

                  <tr>
                    <td><b>Content Background right Color</b></td>
                    <td>
                        <input type="text" name="wpm_img_content_background_right_color" id="wpm_img_content_background_right_color"
                        class="wpm-form-input wpm_6310_color_picker" data-opacity=".8" data-format="rgb"
                        value="<?php echo $allStyle[7]?>">
                    </td>
                  </tr>

                  <tr>
                    <td><b>Image Border Size</b></td>
                    <td>
                      <input type="number" min="0" name="wpm_3610_img_border_size" id="wpm_3610_img_border_size" class="wpm-form-input" value="<?php echo $allStyle[29] ?>">
                    </td>
                  </tr>
                    <tr>
                    <td><b>Image Border Color</b></td>
                    <td>
                        <input type="text" name="wpm_3610_img_border_color" id="wpm_3610_img_border_color"
                        class="wpm-form-input wpm_6310_color_picker" data-opacity=".8" data-format="rgb"
                        value="<?php echo $allStyle[31] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td><b>Box Shadow Width</b></td>
                    <td>
                      <input type="number" min="0" name="box_shadow_width" value="<?php echo $allStyle[8] ?>" class="wpm-form-input" step="1" id="wpm_box_shadow_width" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Box Shadow Blur</b></td>
                    <td>
                      <input type="number" min="0" name="box_shadow_blur" value="<?php echo $allStyle[9] ?>" class="wpm-form-input" step="1" id="wpm_box_shadow_blur" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Box Shadow Color</b></td>
                    <td>
                      <input type="text" name="box_shadow_color" id="wpm_box_shadow_color" class="wpm-form-input wpm_6310_color_picker" data-opacity=".8" data-format="rgb" value="<?php echo $allStyle[10] ?>">
                    </td>
                  </tr>
              
                </table>
              </div>
            </div>
          </div>
          <div id="tab-2">
            <div class="row">
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table">
                  <tr>
                    <td><b>Font Size</b></td>
                    <td>
                      <input type="number" min="0" name="member_font_size" value="<?php echo $allStyle[11] ?>" class="wpm-form-input" step="1" id="wpm_member_font_size" />
                    </td>
                  </tr>
                  <tr>
                      <td><b>Mobile Font Size</b></td>
                        <td>
                          <input type="number" min="0" name="mobile_member_font_size" value="<?php echo isset($allSlider[362]) ? $allSlider[362] : $allStyle[11] ?>"
                            class="wpm-form-input" step="1" />
                        </td>
                  </tr>
                  <tr>
                    <td><b>Font Color</b></td>
                    <td>
                      <input type="text" name="member_font_color" id="wpm_member_font_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo $allStyle[12] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td><b>Font Hover Color</b></td>
                    <td>
                      <input type="text" name="member_font_hover_color" id="wpm_member_font_hover_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo $allStyle[13] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td><b>Font Weight</b><?php
                                                      ?></td>
                    <td>
                      <select name="member_font_weight" class="wpm-form-input" id="wpm_member_font_weight">
                        <option value="100" <?php if ($allStyle[15] == '100') echo " selected=''" ?>>100</option>
                        <option value="200" <?php if ($allStyle[15] == '200') echo " selected=''" ?>>200</option>
                        <option value="300" <?php if ($allStyle[15] == '300') echo " selected=''" ?>>300</option>
                        <option value="400" <?php if ($allStyle[15] == '400') echo " selected=''" ?>>400</option>
                        <option value="500" <?php if ($allStyle[15] == '500') echo " selected=''" ?>>500</option>
                        <option value="600" <?php if ($allStyle[15] == '600') echo " selected=''" ?>>600</option>
                        <option value="700" <?php if ($allStyle[15] == '700') echo " selected=''" ?>>700</option>
                        <option value="800" <?php if ($allStyle[15] == '800') echo " selected=''" ?>>800</option>
                        <option value="900" <?php if ($allStyle[15] == '900') echo " selected=''" ?>>900</option>
                        <option value="normal" <?php if ($allStyle[15] == 'normal') echo " selected=''" ?>>Normal
                        </option>
                        <option value="bold" <?php if ($allStyle[15] == 'bold') echo " selected=''" ?>>Bold</option>
                        <option value="lighter" <?php if ($allStyle[15] == 'lighter') echo " selected=''" ?>>Lighter
                        </option>
                        <option value="initial" <?php if ($allStyle[15] == 'initial') echo " selected=''" ?>>Initial
                        </option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Text Transform</b><?php
                                                          ?></td>
                    <td>
                      <select name="member_text_transform" class="wpm-form-input" id="wpm_member_text_transform">
                        <option value="capitalize" <?php if ($allStyle[16] == 'capitalize') echo " selected=''" ?>>
                          Capitalize</option>
                        <option value="uppercase" <?php if ($allStyle[16] == 'uppercase') echo " selected=''" ?>>
                          Uppercase</option>
                        <option value="lowercase" <?php if ($allStyle[16] == 'lowercase') echo " selected=''" ?>>
                          Lowercase</option>
                        <option value="none" <?php if ($allStyle[16] == 'none') echo " selected=''" ?>>As Input</option>

                      </select>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table">
                  <tr>
                    <td><b>Font Family</b></td>
                    <td>
                      <input name="member_font_family" id="wpm_jquery_heading_font" type="text" value="<?php echo $allStyle[17] ?>" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Line Height</b></td>
                    <td>
                      <input name="member_line_height" id="wpm_heading_line_height" type="number" min="0" value="<?php echo $allStyle[18] ?>" class="wpm-form-input" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Margin Top</b></td>
                    <td>
                      <input name="member_margin_top" id="wpm_member_margin_top" type="number" min="0" value="<?php echo (isset($allSlider[41]) && $allSlider[41] !== '') ? $allSlider[41] : 0; ?>" class="wpm-form-input" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Margin Bottom</b></td>
                    <td>
                      <input name="member_margin_bottom" id="wpm_member_margin_bottom" type="number" min="0" value="<?php echo (isset($allSlider[42]) && $allSlider[42] !== '') ? $allSlider[42] : 0; ?>" class="wpm-form-input" />
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div id="tab-3">
            <div class="row">
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table">
                  <tr>
                    <td><b>Font Size</b></td>
                    <td>
                      <input type="number" min="0" name="designation_font_size" value="<?php echo $allStyle[19] ?>" class="wpm-form-input" step="1" id="wpm_designation_font_size" />
                    </td>
                  </tr>
                  <tr>
                      <td><b>Mobile Font Size</b></td>
                        <td>
                          <input type="number" min="0" name="mobile_designation_font_size" value="<?php echo isset($allSlider[362]) ? $allSlider[363] : $allStyle[19] ?>" class="wpm-form-input" step="1" />
                        </td>
                    </tr>
                  <tr>
                    <td><b>Font Color</b></td>
                    <td>
                      <input type="text" name="designation_font_color" id="wpm_designation_font_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo $allStyle[20] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td><b>Font Hover Color</b></td>
                    <td>
                      <input type="text" name="designation_font_hover_color" id="wpm_designation_font_hover_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo $allStyle[25] ?>">
                    </td>
                  </tr>
                  <tr>
                    <td><b>Font Weight</b><?php
                                                      ?></td>
                    <td>
                      <select name="designation_font_weight" class="wpm-form-input" id="wpm_designation_font_weight">
                        <option value="100" <?php if ($allStyle[21] == '100') echo " selected=''" ?>>100</option>
                        <option value="200" <?php if ($allStyle[21] == '200') echo " selected=''" ?>>200</option>
                        <option value="300" <?php if ($allStyle[21] == '300') echo " selected=''" ?>>300</option>
                        <option value="400" <?php if ($allStyle[21] == '400') echo " selected=''" ?>>400</option>
                        <option value="500" <?php if ($allStyle[21] == '500') echo " selected=''" ?>>500</option>
                        <option value="600" <?php if ($allStyle[21] == '600') echo " selected=''" ?>>600</option>
                        <option value="700" <?php if ($allStyle[21] == '700') echo " selected=''" ?>>700</option>
                        <option value="800" <?php if ($allStyle[21] == '800') echo " selected=''" ?>>800</option>
                        <option value="900" <?php if ($allStyle[21] == '900') echo " selected=''" ?>>900</option>
                        <option value="normal" <?php if ($allStyle[21] == 'normal') echo " selected=''" ?>>Normal
                        </option>
                        <option value="bold" <?php if ($allStyle[21] == 'bold') echo " selected=''" ?>>Bold</option>
                        <option value="lighter" <?php if ($allStyle[21] == 'lighter') echo " selected=''" ?>>Lighter
                        </option>
                        <option value="initial" <?php if ($allStyle[21] == 'initial') echo " selected=''" ?>>Initial
                        </option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Text Transform</b></td>
                    <td>
                      <select name="designation_text_transform" class="wpm-form-input" id="wpm_designation_text_transform">
                        <option value="capitalize" <?php if ($allStyle[22] == 'capitalize') echo " selected=''" ?>>
                          Capitalize</option>
                        <option value="uppercase" <?php if ($allStyle[22] == 'uppercase') echo " selected=''" ?>>
                          Uppercase</option>
                        <option value="lowercase" <?php if ($allStyle[22] == 'lowercase') echo " selected=''" ?>>
                          Lowercase</option>
                        <option value="none" <?php if ($allStyle[22] == 'none') echo " selected=''" ?>>As Input</option>

                      </select>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table">
                  <tr>
                    <td><b>Font Family</b></td>
                    <td>
                      <input name="designation_font_family" id="wpm_jquery_designation_font" type="text" value="<?php echo $allStyle[23] ?>" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Line Height</b></td>
                    <td>
                      <input name="designation_line_height" id="wpm_designation_line_height" type="number" min="0" value="<?php echo $allStyle[24] ?>" class="wpm-form-input" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Margin Top</b></td>
                    <td>
                      <input name="designation_margin_top" id="wpm_designation_margin_top" type="number" min="0" value="<?php echo (isset($allSlider[51]) && $allSlider[51] !== '') ? $allSlider[51] : 0; ?>" class="wpm-form-input" />
                    </td>
                  </tr>
                  <tr>
                    <td><b>Margin Bottom</b></td>
                    <td>
                      <input name="designation_margin_bottom" id="wpm_designation_margin_bottom" type="number" min="0" value="<?php echo (isset($allSlider[52]) && $allSlider[52] !== '') ? $allSlider[52] : 0; ?>" class="wpm-form-input" />
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div id="tab-4">
            <div class="row">
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table" width="100%">
                  <tr>
                    <td>
                      <b>Display Social Icons</b><br />
                    </td>
                    <td>
                      <label class="switch" for="wpm_social_activation">
                        <input type="checkbox" name="social_activation" id="wpm_social_activation" value="1" <?php echo (isset($allStyle[37]) && $allStyle[37]) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                      </label>
                    </td>
                  </tr>
                  <tr class="social_act_field">
                    <td><b>Social Icon Number</b>
                      <div class="wpm-6310-pro">*Preview-on-change not available</div>
                    </td>
                    <td>
                      <select name="social_icon_number" id="social_icon_number" class="wpm-form-input">

                        <?php
                        for ($i = 1; $i <= 9; $i++) {
                          $items = $i == 1 ? ' item' : ' items';
                          if (!isset($allSlider[63]) && $i == 4) {
                            echo "<option selected value='{$i}'>{$i}{$items}</option>";
                          } else if (isset($allSlider[63]) && $allSlider[63] == $i) {
                            echo "<option selected value='{$i}'>{$i}{$items}</option>";
                          } else {
                            echo "<option value='{$i}'>{$i}{$items}</option>";
                          }
                        }
                        ?>
                      </select>
                    </td>
                  </tr>
                  <tr class="social_act_field">
                    <td><b>Social Icon Width</b></td>
                    <td>
                      <input type="number" min="0" name="social_icon_width" value="<?php echo $allStyle[26] ?>" class="wpm-form-input" id="wpm_social_icon_width" />
                    </td>
                  </tr>
                  <tr class="social_act_field">
                    <td><b>Social Icon Height</b><?php
                                                  ?></td>
                    <td>
                      <input type="number" min="0" name="social_icon_height" value="<?php echo $allStyle[27] ?>" class="wpm-form-input" id="wpm_social_icon_height" />
                    </td>
                  </tr>
                  <tr class="social_act_field">
                    <td><b>Social Icon Border Width</b><?php
                                                                    ?></td>
                    <td>
                      <input type="number" min="0" name="social_border_width" value="<?php echo $allStyle[28] ?>" class="wpm-form-input" id="wpm_social_border_width" />
                    </td>
                  </tr>
                  <tr class="social_act_field">
                    <td><b>Social Icon Border Radius</b></td>
                    <td>
                      <input type="number" min="0" name="social_border_radius" value="<?php echo $allStyle[30] ?>" class="wpm-form-input" id="wpm_social_border_radius" />
                    </td>
                  </tr>
                </table>
              </div>
              <div class="wpm-col-6">
                <table class="table table-responsive wpm_6310_admin_table social_act_field">
                <tr>
                    <td><b>Icon Left Background Color</b></td>
                    <td>
                      <input type="text" name="wpm_icon_background_left_color" id="wpm_icon_background_left_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" data-opacity=".8" value="<?php echo $allStyle[32] ?>">
                    </td>
                  </tr>

                <tr>
                    <td><b>Icon Right Background Color</b></td>
                    <td>
                      <input type="text" name="wpm_icon_background_right_color" id="wpm_icon_background_right_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" data-opacity=".8" value="<?php echo $allStyle[33] ?>">
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <?php
          include wpm_6310_plugin_url . 'settings/helper/slider_form.php'; 
              include wpm_6310_plugin_url . 'settings/helper/pagination_form.php'; 
          include wpm_6310_plugin_url . 'settings/helper/search_form.php';
          include wpm_6310_plugin_url . 'settings/helper/category_form.php';
          ?>

          <br class="wpm-6310-clear" />
          <br class="wpm-6310-clear" />
          <hr />
          <input type="submit" name="update_style_change" value="Save" class="wpm-btn-primary wpm-pull-right" style="margin-right: 15px; margin-bottom: 10px; display: block" />
          <br class="wpm-6310-clear" />
        </div>
      </form>
    </div>

    <style type="text/css">
      .wpm_6310_tabs_panel_preview .wpm-6310-row {
        justify-content: <?php echo (isset($allSlider[126]) && $allSlider[126] !== '') ? $allSlider[126] : 'center' ?> !important;
      }

      .wpm_6310_team_style_41 {
        text-align: center;
        padding-top: 10px;
        padding-left: 0;
        padding-right: 0;
        overflow: hidden;
        position: relative;
        z-index: 1;
        letter-spacing: .04em;
        background: <?php echo $allStyle[5] ?>;
        -webkit-border-radius: <?php echo $allStyle[2] ?>px;
        -o-border-radius: <?php echo $allStyle[2] ?>px;
        -moz-border-radius: <?php echo $allStyle[2] ?>px;
        -ms-border-radius: <?php echo $allStyle[2] ?>px;
        border-radius: <?php echo $allStyle[2] ?>px;
        border-style: solid;
        border-width: <?php echo $allStyle[3] ?>px;
        border-color: <?php echo $allStyle[4] ?>;
        box-shadow: 0 0px <?php echo $allStyle[9] ?>px <?php echo $allStyle[8] ?>px <?php echo $allStyle[10] ?>;
        height: 100%;
        padding-bottom: <?php echo isset($allStyle[27]) && $allStyle[27] > 0 ? ($allStyle[27] + 8) : 0 ?>px;
      }

      .wpm_6310_team_style_41:hover .wpm_6310_team_style_41_pic img {
        transform: unset !important;
      }

      .wpm_6310_team_style_41:hover  {
          transform: scale(1.03);
      }


      .wpm_6310_team_style_41_pic {
        position: relative;
        width: 100%;
        float: left;
        display: flex;
        justify-content: center;
      
      }

      .wpm_6310_team_style_41_pic_container {
        width: 150px;
        height: auto;
        position: relative;
        overflow: hidden;
        border-radius: 50%;
       
      }

      .wpm_6310_team_style_41_pic img {
        width: 100%;
        height: auto;
        padding: 0;
        margin: 0;
        float: left;
        transition-duration: 0.3s;
      }

      .wpm_6310_team_style_41:hover .wpm_6310_team_style_41_pic img {
        transform: scale(1.1);
      }


      .wpm_6310_team_style_41:hover .wpm_6310_team_style_41_pic_overlay {
        opacity: 1;
      }

      .wpm_6310_team_style_41_caption {
        margin: 10px;
        padding: 10px;
        text-align: center;
        float: left;
        width: calc(100% - 20px);
        border-radius: 10px;
        height: 100%;
        box-sizing: border-box;
        background: linear-gradient(90deg, <?php echo $allStyle[6] ?>, <?php echo $allStyle[7] ?>);
      }


      .wpm_6310_team_style_41_title {
        margin-top: <?php echo (isset($allSlider[41]) && $allSlider[41] !== '') ? $allSlider[41] : 0; ?>px;
        margin-bottom: <?php echo (isset($allSlider[42]) && $allSlider[42] !== '') ? $allSlider[42] : 0; ?>px;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        font-size: <?php echo $allStyle[11] ?>px;
        color: <?php echo $allStyle[12] ?>;
        font-weight: <?php echo $allStyle[15] ?>;
        text-transform: <?php echo $allStyle[16];
                        ?>;
        font-family: <?php echo str_replace("+", " ", $allStyle[17]);
                      ?>;
        line-height: <?php echo $allStyle[18] ?>px;
        float: left;
        width: 100%;
      }

      .wpm_6310_team_style_41_designation {
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        font-size: <?php echo $allStyle[19] ?>px;
        color: <?php echo $allStyle[20] ?>;
        font-weight: <?php echo $allStyle[21] ?>;
        text-transform: <?php echo $allStyle[22] ?>;
        font-family: <?php echo str_replace("+", " ", $allStyle[23]); ?>;
        line-height: <?php echo $allStyle[24] ?>px;
        float: left;
        width: 100%;
        margin-top: <?php echo (isset($allSlider[51]) && $allSlider[51] !== '') ? $allSlider[51] : 0; ?>px;
        margin-bottom: <?php echo (isset($allSlider[52]) && $allSlider[52] !== '') ? $allSlider[52] : 0; ?>px;
      }

      .wpm_6310_team_style_41_title,
      .wpm_6310_team_style_41_designation,
      .wpm_6310_team_style_41,
      .wpm_6310_team_style_41_caption {
        -webkit-transition: all 0.6s ease 0s;
        -moz-transition: all 0.6s ease 0s;
        -ms-transition: all 0.6s ease 0s;
        -o-transition: all 0.6s ease 0s;
        transition: all 0.6s ease 0s;
      }

      .wpm_6310_team_style_41:hover .wpm_6310_team_style_41_title {
        color: <?php echo $allStyle[13] ?>;
      }

      .wpm_6310_team_style_41:hover .wpm_6310_team_style_41_designation {
        color: <?php echo $allStyle[25] ?>;
      }

      .wpm_6310_team_style_41_social {
        display: <?php echo (isset($allStyle[37]) && $allStyle[37]) ? 'block' : 'none' ?>;
        margin: 0;
        list-style: none;
        width: 100%;
        float: left;
        padding: 4px 0;
        text-align: center;
        background: linear-gradient(90deg, <?php echo $allStyle[32] ?>, <?php echo $allStyle[33] ?>);
        transform: translateY(100px);
        transition: 0.3s ease-in-out;
        position: absolute;
        bottom: 0;
        left: 0;
      }

      .wpm_6310_team_style_41_social li {
        display: inline-block;
        margin: 4px 4px 4px 0;
      }

      .wpm_6310_team_style_41_social li:last-child {
        margin-right: 0;
      }

      .wpm_6310_team_style_41_social li a {
        display: inline-block;
        box-sizing: content-box !important;
        width: <?php echo $allStyle[26] ?>px;
        height: <?php echo $allStyle[27] ?>px;
        line-height: <?php echo $allStyle[27] ?>px;
        font-size: <?php echo ceil((($allStyle[26] ? $allStyle[26] : 8) + ($allStyle[27] ? $allStyle[27] : 8)) / 4) ?>px;
        margin: 0;
        -webkit-transition: all 0.5s ease 0s;
        -moz-transition: all 0.5s ease 0s;
        -ms-transition: all 0.5s ease 0s;
        -o-transition: all 0.5s ease 0s;
        transition: all 0.5s ease 0s;
        border-radius: <?php echo $allStyle[30] ?>%;
        -moz-border-radius: <?php echo $allStyle[30] ?>%;
        -webkit-border-radius: <?php echo $allStyle[30] ?>%;
        -o-border-radius: <?php echo $allStyle[30] ?>%;
        -ms-border-radius: <?php echo $allStyle[30] ?>%;
      }

      /* image border */
      .wpm_6310_team_style_41_preview_profile-image-border {
      position: absolute;
      width: 104%;
      height: 104%;
      border-width:  <?php echo $allStyle[29] . 'px'?> ;
      border-radius: 50%;
      animation: rotateBorder 4s infinite linear, blinkStars 2s infinite alternate;
      border-style: dotted dashed solid double;
      
      }
      @keyframes rotateBorder {
          0% {
              transform: rotate(0deg);
          }
          100% {
              transform: rotate(360deg);
          }
      }

      @keyframes blinkStars {
          0% {
              border-color: transparent;
          }
          100% {
              border-color: <?php echo $allStyle[31] ?>;
          }
      }

      .wpm_6310_team_style_41:hover .wpm_6310_team_style_41_social{
          transform: translateY(0);
      }
      .wpm-6310-owl-carousel .wpm-6310-owl-stage-outer {
        padding-top: 15px;
      }
      .wpm_6310_team_style_41:hover img.wpm-6310-hover-image{
          display: block !important;
        } 
        .wpm_6310_team_style_41:hover img.wpm-6310-main-image{
          display: none;
        } 
    </style>

    <?php
    include wpm_6310_plugin_url . 'settings/helper/template-41.php';
    ?>
    <div class="wpm-plugin-setting-left">
      <div class="wpm-preview-box">
        <div class="wpm-6310-preview">
          Preview
          <div style="display: inline; float: right">
            <input type="text" id="wpm_background_preview" class="wpm-form-input  wpm-pull-right wpm_6310_color_picker wpm_preview_color_chooser" data-format="rgb" data-opacity=".8" value="rgba(255, 255, 255, .8)"></div>
        </div>
        <hr />
      </div>
      <div 
        class="wpm_6310_tabs_panel_preview" 
        data-modal-template="<?php echo isset($allSlider[131])?$allSlider[131]:1 ?>"
        data-main-template-id="<?php echo $styleId ?>"
      >
        <div id="wpm-6310-noslider-<?php echo $styleId ?>">

          <?php
          wpm_6310_search_template($template_id, $allSlider, $desktop_row);
          wpm_6310_category_menu($categoryData, $styleId, $styledata['categoryids']);

          if ($members) {
            $displayCSS = '';
            if(!(!isset($allSlider[101]) || $allSlider[101] == 0)){
              $displayCSS = " style='display:none';";
            }
            echo "<div class='wpm-6310-row wpm-6310-default-members' {$displayCSS}>";
            $counter = 1;
            $currentPage = 1;
            $perPage = 0;
            if(isset($allSlider[400]) && $allSlider[400] == 1) {
                $perPage = isset($allSlider[401]) ? $allSlider[401] : 3;
            }

            foreach ($members as $value) {
              if ($value['profile_details_type'] == 1) {
                $link_type = " class='wpm_6310_team_style_41 wpm_6310_team_member_info' link-id='{$value['id']}' link-url='" . wpm_6310_validate_profile_url($value['profile_url']) . "' target='{$value['open_new_tab']}' team-id='0'";
              } else if ($value['profile_details_type'] == 2) {
                $link_type = " class='wpm_6310_team_style_41 wpm_6310_team_member_info' link-id='0' team-id='{$value['id']}'";
              } else {
                $link_type = " class='wpm_6310_team_style_41' link-id='0' team-id='0'";
              }
              $pageClassName = '';
              if($perPage){
                $currentPage = ceil($counter / $perPage);
                $pageClassName = $perPage ? " wpm-6310-pagination wpm-6310-pagination-{$styleId} wpm-6310-page-{$currentPage}" : '';
                $counter++;
              }
          ?>
              <div class="wpm-6310-col-<?php echo $desktop_row . $pageClassName; ?>">

                <div <?php echo $link_type ?>>
                  <div class="wpm_6310_team_style_41_pic">
                    <div class="wpm_6310_team_style_41_pic_container">                      
                      <div class="wpm_6310_team_style_41_preview_profile-image-border"></div>
                      <?php  echo wpm_6310_extract_image($value['image'], $value['hover_image'], $value['name'], $template_id); ?>

                    </div>
                  </div>
                  
                  <div class="wpm_6310_team_style_41_caption">
                    <div class="wpm_6310_team_style_41_title"><?php echo wpm_6310_replace(esc_attr($value['name'])) ?></div>
                    <div class="wpm_6310_team_style_41_designation"><?php echo wpm_6310_replace(esc_attr($value['designation'])) ?></div>
                    <?php
                    wpm_6310_extract_contact_info(isset($value['contact_info']) ? $value['contact_info'] : '', $styleId);
                    wpm_6310_template_skills($value['skills'], $template_id, $allSlider, $value['id']);
                    echo wpm_6310_extract_member_description_admin($value['profile_details'], ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $styleId, $suffix);
                  
                    ?>      
                        <?php
                        wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $template_id, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                          ?>    
                  </div>
              </div>
        </div>
        <?php
            }
            if($perPage){
              echo "<div class='wpm-6310-page-number-wrapper wpm-6310-page-number-wrapper-{$styleId}'>";
              for($x = 1; $x <= $currentPage; $x++){
                $active = $x == 1 ? ' wpm-6310-page-active' : '';
                echo "<div class='wpm-6310-page-number wpm-6310-page-number-{$styleId}{$active}' wpm-6310-page='{$x}'>{$x}</div>";
              }             
              echo "</div>";
            }
            echo "</div>";
          }
          if($filterList){
            $catIdList = explode(",", $styledata['categoryids']);
            foreach ($filterList as $filterKey => $filterValue) {
              $returnMember = wpm_6310_extract_members($filterValue, 0, $results['teamOrder']);
              $catMembers = $returnMember['members'];

              if(wpm_6310_order_type($styledata['memberid']) == 1) {
                shuffle($catMembers);
              }
              if ($catMembers) {
                if(isset($allSlider[101]) && $allSlider[101] == 1) {
                  $displayCSS = wpm_6310_first_category($catIdList[0], $filterKey);
                } else{
                  $displayCSS = " style='display:none';";
                }

                echo "<div class='wpm-6310-row wpm-6310-category-filter {$filterKey}' {$displayCSS}>";
                $counter = 1;
                $currentPage = 1;
                $perPage = 0;
                if(isset($allSlider[400]) && $allSlider[400] == 1) {
                   $perPage = isset($allSlider[401]) ? $allSlider[401] : 3;
                }
                foreach ($catMembers as $value) {
                  if ($value['profile_details_type'] == 1) {
                    $link_type = " class='wpm_6310_team_style_41 wpm_6310_team_member_info' link-id='{$value['id']}' link-url='" . wpm_6310_validate_profile_url($value['profile_url']) . "' target='{$value['open_new_tab']}' team-id='0'";
                  } else if ($value['profile_details_type'] == 2) {
                    $link_type = " class='wpm_6310_team_style_41 wpm_6310_team_member_info' link-id='0' team-id='{$value['id']}'";
                  } else {
                    $link_type = " class='wpm_6310_team_style_41' link-id='0' team-id='0'";
                  }
                  $pageClassName = '';
                  if($perPage){
                    $currentPage = ceil($counter / $perPage);
                    $pageClassName = $perPage ? " wpm-6310-pagination wpm-6310-pagination-{$styleId} wpm-6310-page-{$currentPage}" : '';
                    $counter++;
                  }
        ?>
            <div class="wpm-6310-col-<?php echo $desktop_row . $pageClassName; ?>">
              <div <?php echo $link_type ?>>
                  <div class="wpm_6310_team_style_41_pic">
                    <div class="wpm_6310_team_style_41_pic_container">                     
                      <div class="wpm_6310_team_style_41_preview_profile-image-border"></div>
                      <?php  echo wpm_6310_extract_image($value['image'], $value['hover_image'], $value['name'], $template_id); ?>
                    </div>
                  </div>
                  
                    <div class="wpm_6310_team_style_41_caption">
                      <div class="wpm_6310_team_style_41_title"><?php echo wpm_6310_replace(esc_attr($value['name'])) ?></div>
                      <div class="wpm_6310_team_style_41_designation"><?php echo wpm_6310_replace(esc_attr($value['designation'])) ?></div>
                      <?php
                      wpm_6310_extract_contact_info(isset($value['contact_info']) ? $value['contact_info'] : '', $styleId);
                      wpm_6310_template_skills($value['skills'], $template_id, $allSlider, $value['id']);
                      echo wpm_6310_extract_member_description_admin($value['profile_details'], ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $styleId, $suffix);
                    
                      ?>      
                          <?php
                          wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $template_id, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                            ?>    
                    </div>
                  
              </div>
            </div>
<?php
                }
                if($perPage){
                  echo "<div class='wpm-6310-page-number-wrapper wpm-6310-page-number-wrapper-{$styleId}'>";
                  for($x = 1; $x <= $currentPage; $x++){
                    $active = $x == 1 ? ' wpm-6310-page-active' : '';
                    echo "<div class='wpm-6310-page-number wpm-6310-page-number-{$styleId}{$active}' wpm-6310-page='{$x}'>{$x}</div>";
                  }
                  echo "</div>";
                }
                echo "</div>";
              }
            }
?>
    </div>

    <div class="carousel">
      <div id="wpm-6310-slider-<?php echo $styleId ?>" class="wpm-6310-owl-carousel">
        <?php
            if ($members) {
              foreach ($members as $value) {
                if ($value['profile_details_type'] == 1) {
                  $link_type = " class='wpm_6310_team_style_41 wpm_6310_team_member_info' link-id='{$value['id']}' link-url='" . wpm_6310_validate_profile_url($value['profile_url']) . "' target='{$value['open_new_tab']}' team-id='0'";
                } else if ($value['profile_details_type'] == 2) {
                  $link_type = " class='wpm_6310_team_style_41 wpm_6310_team_member_info' link-id='0' team-id='{$value['id']}'";
                } else {
                  $link_type = " class='wpm_6310_team_style_41' link-id='0' team-id='0'";
                }
        ?>
            <div class="wpm-6310-item">
              <div <?php echo $link_type ?>>
                    <div class="wpm_6310_team_style_41_pic">
                      <div class="wpm_6310_team_style_41_pic_container">                   
                        <div class="wpm_6310_team_style_41_preview_profile-image-border"></div>
                        <?php  echo wpm_6310_extract_image($value['image'], $value['hover_image'], $value['name'], $template_id); ?>
                      </div>
                    </div>
                    
                      <div class="wpm_6310_team_style_41_caption">
                        <div class="wpm_6310_team_style_41_title"><?php echo wpm_6310_replace(esc_attr($value['name'])) ?></div>
                        <div class="wpm_6310_team_style_41_designation"><?php echo wpm_6310_replace(esc_attr($value['designation'])) ?></div>
                        <?php
                        wpm_6310_extract_contact_info(isset($value['contact_info']) ? $value['contact_info'] : '', $styleId);
                        wpm_6310_template_skills($value['skills'], $template_id, $allSlider, $value['id']);
                        echo wpm_6310_extract_member_description_admin($value['profile_details'], ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $styleId, $suffix);
                      
                        ?>      
                            <?php
                            wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $template_id, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                              ?>    
                      </div>                  
                </div>
            </div>
      <?php
              }
            }
          }
      ?>
      </div>
    </div>
  </div>
  <br />

</div>
<div class="wpm-plugin-setting-right">
  <?php wpm_6310_add_new_media($styleId, $member_table, $icon_table, $styledata['memberid'], $styledata['style_name']) ?>
</div>
</div>
</div>
<?php wpm_6310_modal_settings_for_member_description($loading, wpm_6310_plugin_url, $allSlider); ?>
<script>
  jQuery(document).ready(function(){
    jQuery('#tab12').hide();
  });
</script>