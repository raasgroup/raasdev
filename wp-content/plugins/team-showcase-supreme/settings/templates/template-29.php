<div class="wpm-6310">
    <div class="wpm-6310-sm">
        <?php
        $styleTemplate = 29;
        include wpm_6310_plugin_url . 'settings/helper/team-member-save.php';
        $numberOfWords = 0;
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
                $css .= "|";
                //0 - 5


                $css .= "|nai";
                $css .= "|" . sanitize_text_field($_POST['image_hover_background']);
                $css .= "|" . sanitize_text_field($_POST['box_shadow_width']);
                $css .= "|" . sanitize_text_field($_POST['box_shadow_blur']);
                $css .= "|" . sanitize_text_field($_POST['box_shadow_color']);
                //6 - 10

                $css .= "|" . sanitize_text_field($_POST['member_font_size']);
                $css .= "|" . sanitize_text_field($_POST['member_font_color']);
                $css .= "|";
                $css .= "|";
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
                $css .= "|";
                //21 - 25

                $css .= "|" . sanitize_text_field($_POST['social_icon_width']);
                $css .= "|" . sanitize_text_field($_POST['social_icon_height']);
                $css .= "|" . sanitize_text_field($_POST['social_border_width']);
                $css .= "|";
                $css .= "|" . sanitize_text_field($_POST['social_border_radius']);
                //26 - 30

                $css .= "|" . sanitize_text_field($_POST['real_image_radius']);
                $css .= "|" . sanitize_text_field($_POST['box_background']);
                $css .= "|" . sanitize_text_field($_POST['box_hover_background']);
                $css .= "|" . (isset($_POST['social_activation']) ? sanitize_text_field($_POST['social_activation']) : 0);

                // 31 - 35


                include wpm_6310_plugin_url . 'settings/helper/slider_form_save.php';
            }
        }
        $styledata = $wpdb->get_row($wpdb->prepare("SELECT * FROM $style_table WHERE id = %d ", $styleId), ARRAY_A);
        $allStyle = explode("|", $styledata['css']);
        $allSlider = explode("|", $styledata['slider']);
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
                <input type="hidden" name="styleid" value="<?php echo esc_attr($styleId) ?>" />
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
                      wpm_items_per_row($styleId, $allStyle[0], $styledata['name']); 
                    ?>
                                    <tr>
                                        <td><b>Items Alignment</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
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
                                                <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>

                                            <div class="wpm-6310-pro">*Preview-on-change  not available</div>
                                        </td>
                                        <td>
                                            <input type="number" name="item_margin" id="wpm_item_margin" class="wpm-form-input" value="<?php echo esc_attr((isset($allSlider[127]) && $allSlider[127])?$allSlider[127]:"15") ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Radius</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="image_radius" value="<?php echo esc_attr($allStyle[2]) ?>" class="wpm-form-input" id="wpm_image_radius" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Border Width</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="border_width" value="<?php echo esc_attr($allStyle[3]) ?>" class="wpm-form-input" id="wpm_border_width" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Border Color</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
                                        <td>
                                            <input type="text" name="border_color" id="wpm_border_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" data-opacity=".8" value="<?php echo esc_attr($allStyle[4]) ?>">
                                        </td>
                                    </tr>                                    
                                </table>
                            </div>
                            <div class="wpm-col-6">
                                <table class="table table-responsive wpm_6310_admin_table">
                                    <tr>
                                        <td><b>Image Radius</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="real_image_radius" value="<?php echo esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0) ?>" class="wpm-form-input" id="wpm_real_image_radius" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Image Hover Overlay Color</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
                                        <td>
                                            <input type="text" name="image_hover_background" id="wpm_image_hover_background" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" data-opacity=".8" value="<?php echo esc_attr($allStyle[7]) ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Background</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                    
                                        </td>
                                        <td>
                                            <input type="text" name="box_background" id="wpm_box_background" class="wpm-form-input wpm_6310_color_picker" data-opacity=".8" data-format="rgb" value="<?php echo esc_attr((isset($allStyle[32]) && $allStyle[32] !== '') ? $allStyle[32] : 'rgba(0, 153, 153, 1)' )?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Hover Background</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="text" name="box_hover_background" id="wpm_box_hover_background" class="wpm-form-input wpm_6310_color_picker" data-opacity=".8" data-format="rgb" value="<?php echo esc_attr((isset($allStyle[33]) && $allStyle[33] !== '') ? $allStyle[33] : '') ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Shadow Width</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="box_shadow_width" value="<?php echo esc_attr((isset($allStyle[8]) && $allStyle[8] !== '') ? $allStyle[8] : 0 )?>" class="wpm-form-input" step="1" id="wpm_box_shadow_width" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Shadow Blur</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>                                    
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="box_shadow_blur" value="<?php echo esc_attr($allStyle[9]) ?>" class="wpm-form-input" step="1" id="wpm_box_shadow_blur" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Box Shadow Color</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="text" name="box_shadow_color" id="wpm_box_shadow_color" class="wpm-form-input wpm_6310_color_picker" data-opacity=".8" data-format="rgb" value="<?php echo esc_attr($allStyle[10]) ?>">
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
                                        <td><b>Font Size</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="member_font_size" value="<?php echo esc_attr($allStyle[11]) ?>" class="wpm-form-input" step="1" id="wpm_member_font_size" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Font Color</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="text" name="member_font_color" id="wpm_member_font_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($allStyle[12]) ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Font Weight</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
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
                                                <option value="normal" <?php if ($allStyle[15] == 'normal') echo " selected=''" ?>>Normal</option>
                                                <option value="bold" <?php if ($allStyle[15] == 'bold') echo " selected=''" ?>>Bold</option>
                                                <option value="lighter" <?php if ($allStyle[15] == 'lighter') echo " selected=''" ?>>Lighter</option>
                                                <option value="initial" <?php if ($allStyle[15] == 'initial') echo " selected=''" ?>>Initial</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Text Transform</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
                                                                                ?></td>
                                        <td>
                                            <select name="member_text_transform" class="wpm-form-input" id="wpm_member_text_transform">
                                                <option value="capitalize" <?php if ($allStyle[16] == 'capitalize') echo " selected=''" ?>>Capitalize</option>
                                                <option value="uppercase" <?php if ($allStyle[16] == 'uppercase') echo " selected=''" ?>>Uppercase</option>
                                                <option value="lowercase" <?php if ($allStyle[16] == 'lowercase') echo " selected=''" ?>>Lowercase</option>
                                                <option value="none" <?php if ($allStyle[16] == 'none') echo " selected=''" ?>>As Input</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="wpm-col-6">
                                <table class="table table-responsive wpm_6310_admin_table">
                                    <tr>
                                        <td><b>Font Family</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
                                                                ?></td>
                                        <td>
                                            <input name="member_font_family" id="wpm_jquery_heading_font" type="text" value="<?php echo esc_attr($allStyle[17]) ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Line Height</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input name="member_line_height" id="wpm_heading_line_height" type="number" min="0" value="<?php echo esc_attr($allStyle[18]) ?>" class="wpm-form-input" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Margin Top</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input name="member_margin_top" id="wpm_member_margin_top" type="number" min="0" value="<?php echo esc_attr((isset($allSlider[41]) && $allSlider[41] !== '') ? $allSlider[41] : 15); ?>" class="wpm-form-input" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Margin Bottom</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This    feature is available on the pro version only.</div></span>
                                        </td>
                                        <td>
                                            <input name="member_margin_bottom" id="wpm_member_margin_bottom" type="number" min="0" value="<?php echo esc_attr((isset($allSlider[42]) && $allSlider[42] !== 0) ? $allSlider[42] : 0); ?>" class="wpm-form-input" />
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
                                        <td><b>Font Size</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="designation_font_size" value="<?php echo esc_attr($allStyle[19]) ?>" class="wpm-form-input" step="1" id="wpm_designation_font_size" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Font Color</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="text" name="designation_font_color" id="wpm_designation_font_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($allStyle[20]) ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Font Weight</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
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
                                                <option value="normal" <?php if ($allStyle[21] == 'normal') echo " selected=''" ?>>Normal</option>
                                                <option value="bold" <?php if ($allStyle[21] == 'bold') echo " selected=''" ?>>Bold</option>
                                                <option value="lighter" <?php if ($allStyle[21] == 'lighter') echo " selected=''" ?>>Lighter</option>
                                                <option value="initial" <?php if ($allStyle[21] == 'initial') echo " selected=''" ?>>Initial</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Text Transform</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
                                                                                ?></td>
                                        <td>
                                            <select name="designation_text_transform" class="wpm-form-input" id="wpm_designation_text_transform">
                                                <option value="capitalize" <?php if ($allStyle[22] == 'capitalize') echo " selected=''" ?>>Capitalize</option>
                                                <option value="uppercase" <?php if ($allStyle[22] == 'uppercase') echo " selected=''" ?>>Uppercase</option>
                                                <option value="lowercase" <?php if ($allStyle[22] == 'lowercase') echo " selected=''" ?>>Lowercase</option>
                                                <option value="none" <?php if ($allStyle[22] == 'none') echo " selected=''" ?>>As Input</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="wpm-col-6">
                                <table class="table table-responsive wpm_6310_admin_table">
                                    <tr>
                                        <td><b>Font Family</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
                                                                ?></td>
                                        <td>
                                            <input name="designation_font_family" id="wpm_jquery_designation_font" type="text" value="<?php echo esc_attr($allStyle[23]) ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Line Height</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input name="designation_line_height" id="wpm_designation_line_height" type="number" min="0" value="<?php echo esc_attr($allStyle[24]) ?>" class="wpm-form-input" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Margin Top</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input name="designation_margin_top" id="wpm_designation_margin_top" type="number" min="0" value="<?php echo esc_attr((isset($allSlider[51]) && $allSlider[51] !== '') ? $allSlider[51] : 10); ?>" class="wpm-form-input" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Margin Bottom</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input name="designation_margin_bottom" id="wpm_designation_margin_bottom" type="number" min="0" value="<?php echo esc_attr((isset($allSlider[52]) && $allSlider[52] !== '') ? $allSlider[52] : 4); ?>" class="wpm-form-input" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4">
                        <div class="row">
                            <div class="wpm-col-6">
                                <table class="table table-responsive wpm_6310_admin_table">
                                    <tr>
                                        <td>
                                            <b>Display Social Icons</b>
                                                <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                                <br />
                                        </td>
                                        <td>
                                            <label class="switch" for="wpm_social_activation">
                                                <input type="checkbox" name="social_activation" id="wpm_social_activation" value="1" <?php echo esc_attr((!isset($allStyle[34]) || (isset($allStyle[34]) && $allStyle[34])) ? 'checked' : '') ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    </tr>
                                     <tr class="social_act_field">
                                        <td><b>Social Icon Number</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
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
                                        <td><b>Social Icon Width</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="social_icon_width" value="<?php echo esc_attr($allStyle[26]) ?>" class="wpm-form-input" id="wpm_social_icon_width" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="wpm-col-6">
                                <table class="table table-responsive wpm_6310_admin_table">
                                     <tr class="social_act_field">
                                        <td><b>Social Icon Height</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
                                                                        ?></td>
                                        <td>
                                            <input type="number" min="0" name="social_icon_height" value="<?php echo esc_attr($allStyle[27]) ?>" class="wpm-form-input" id="wpm_social_icon_height" />
                                        </td>
                                    </tr>
                                     <tr class="social_act_field">
                                        <td><b>Social Icon Border Width</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        <?php
                                                                                        ?></td>
                                        <td>
                                            <input type="number" min="0" name="social_border_width" value="<?php echo esc_attr($allStyle[28]) ?>" class="wpm-form-input" id="wpm_social_border_width" />
                                        </td>
                                    </tr>
                                     <tr class="social_act_field">
                                        <td><b>Social Icon Border Radius</b>
                                            <span class="wpm-6310-pro">(Pro) <div class='wpm-6310-pro-text'>This feature is available on the pro version only. You can view changes in the admin panel, not in the output.</div></span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="social_border_radius" value="<?php echo esc_attr($allStyle[30]) ?>" class="wpm-form-input" id="wpm_social_border_radius" />
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
       <?php
        $customCSS = "
          .wpm_6310_tabs_panel_preview .wpm-6310-row {
                justify-content: ".esc_attr((isset($allSlider[126]) && $allSlider[126] !== '') ? $allSlider[126] : 'center')."!important;
            }

            .wpm_6310_team_style_29 {
                text-align: center;
                overflow: hidden;
                transition: all 0.3s ease 0s;
                -webkit-border-radius: ".esc_attr($allStyle[2])."px;
                -o-border-radius: ".esc_attr($allStyle[2])."px;
                -moz-border-radius:".esc_attr($allStyle[2])."px;
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
                width: calc(100% - 10px);
                float: left;
                position: relative;
                height: 100%;
                background-color: ".esc_attr((isset($allStyle[32]) && $allStyle[32] !== '') ? $allStyle[32] : '#009999').";
            }

            .wpm_6310_team_style_29:hover {
                background-color: ".esc_attr((isset($allStyle[33]) && $allStyle[33] !== '') ? $allStyle[33] : '').";
            }

            .wpm_6310_team_style_29_pic {
                position: relative;
                float: left;
                overflow: hidden;
                width: 100%;
            }

            .wpm_6310_team_style_29_pic:before {
                content: '';
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                box-shadow: 0 0 0 0 ".esc_attr($allStyle[7])." inset;
                opacity: 0.5;
                transition: all 1s ease-in-out 0s;
            }

            .wpm_6310_team_style_29:hover .wpm_6310_team_style_29_pic:before {
                box-shadow: 0 0 0 400px ".esc_attr($allStyle[7])." inset;
                -webkit-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                -o-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                -moz-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                -ms-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
            }

            .wpm_6310_team_style_29_pic img {
                width: 100%;
                height: auto;
                float: left;
                -webkit-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                -o-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                -moz-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                -ms-border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
                border-radius: ".esc_attr((isset($allStyle[31]) && $allStyle[31] !== '') ? $allStyle[31] : 0)."%;
            }

            .wpm_6310_team_style_29_social {
                display: ".esc_attr((!isset($allStyle[34]) || (isset($allStyle[34]) && $allStyle[34])) ? 'block' : 'none').";
                width: 100%;
                padding: 0;
                margin: 0;
                list-style: none;
                position: absolute;
                top: 50%;
                left: 0;
                margin-top: ".esc_attr((isset($allSlider[61]) && $allSlider[61] !== '') ? $allSlider[61] : 0)."px;
                margin-bottom: ".esc_attr((isset($allSlider[62]) && $allSlider[62] !== '') ? $allSlider[62] : 0)."px;
            }

            .wpm_6310_team_style_29_social li {
                display: inline-block;
                margin: 0 10px 10px 0;
                transform: scale(0, 0);
                transition: all 0.7s ease-in-out 0s;
            }

            .wpm_6310_team_style_29:hover .wpm_6310_team_style_29_social li:nth-child(1) {
                transition-delay: 0.1s;
                transform: scale(1, 1);
            }

            .wpm_6310_team_style_29:hover .wpm_6310_team_style_29_social li:nth-child(2) {
                transition-delay: 0.2s;
                transform: scale(1, 1);
            }

            .wpm_6310_team_style_29:hover .wpm_6310_team_style_29_social li:nth-child(3) {
                transform: scale(1, 1);
                transition-delay: 0.3s;
            }

            .wpm_6310_team_style_29:hover .wpm_6310_team_style_29_social li:nth-child(4) {
                transition-delay: 0.4s;
                transform: scale(1, 1);
            }

            .wpm_6310_team_style_29:hover .wpm_6310_team_style_29_social li:nth-child(5) {
                transition-delay: 0.5s;
                transform: scale(1, 1);
            }

            .wpm_6310_team_style_29_social li:last-child {
                margin-right: 0;
            }

            .wpm_6310_team_style_29_social li a {
                display: inline-block;
                width: ".esc_attr($allStyle[26])."px;
                height: ".esc_attr($allStyle[27])."px;
                line-height: ".esc_attr($allStyle[27])."px;
                font-size: ".esc_attr(ceil((($allStyle[26] ? $allStyle[26] : 8) + ($allStyle[27] ? $allStyle[27] : 8)) / 4))."px;
                border-radius: ".esc_attr($allStyle[30])."%;
                -moz-border-radius: ".esc_attr($allStyle[30])."%;
                -webkit-border-radius: ".esc_attr($allStyle[30])."%;
                -o-border-radius: ".esc_attr($allStyle[30])."%;
                -ms-border-radius: ".esc_attr($allStyle[30])."%;
                transition: all 0.5s ease 0s;
            }

            .wpm_6310_team_style_29_title {
                font-size: ".esc_attr($allStyle[11])."px;
                color: ".esc_attr($allStyle[12]).";
                font-weight: ".esc_attr($allStyle[15]).";
                text-transform: ".esc_attr($allStyle[16]).";
                font-family: ".esc_attr(str_replace("+", " ", $allStyle[17])).";
                line-height: ".esc_attr($allStyle[18])."px;
                float: left;
                width: 100%;
                margin-top: ".esc_attr((isset($allSlider[41]) && $allSlider[41] !== '') ? $allSlider[41] : 15)."px;
                margin-bottom: ".esc_attr((isset($allSlider[42]) && $allSlider[42] !== '') ? $allSlider[42] : 0)."px;
            }

            .wpm_6310_team_style_29_designation {
                display: block;
                font-size: ".esc_attr($allStyle[19])."px;
                color: ".esc_attr($allStyle[20]).";
                font-weight: ".esc_attr($allStyle[21]).";
                text-transform: ".esc_attr($allStyle[22]).";
                font-family: ".esc_attr(str_replace("+", " ", $allStyle[23])).";
                line-height: ".esc_attr($allStyle[24])."px;
                float: left;
                width: 100%;
                margin-top: ".esc_attr((isset($allSlider[51]) && $allSlider[51] !== '') ? $allSlider[51] : 10)."px;
                margin-bottom: ".esc_attr((isset($allSlider[52]) && $allSlider[52] !== '') ? $allSlider[52] : 4)."px;
            }
            .wpm-6310-tooltip:hover:after {
                margin: -85px -70px 0 !important;
            }
            .wpm_6310_team_style_".esc_attr($styleId)."_description {
                padding: 0 10px !important;
            }      
        ";
        wp_register_style("wpm-6310-custom-code-" . esc_attr($template_id) . "-css", "");
        wp_enqueue_style("wpm-6310-custom-code-" . esc_attr($template_id) . "-css");
        wp_add_inline_style("wpm-6310-custom-code-" . esc_attr($template_id) . "-css", $customCSS);
      ?>
        <?php
        include wpm_6310_plugin_url . 'settings/helper/template-29.php';
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
        data-modal-template="<?php echo esc_attr(isset($allSlider[131])?$allSlider[131]:1) ?>"
        data-main-template-id="<?php echo esc_attr($styleId) ?>"
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
            echo "<div class='wpm-6310-row wpm-6310-default-members'{$displayCSS}>";
                        foreach ($members as $value) {
                            $attr2 = [];
                             if ($value['profile_details_type'] == 1) {
                            $cls = " wpm_6310_team_member_info";
                            $attr = " link-id='" . esc_attr($value['id']) . "' link-url='" . wpm_6310_validate_profile_url($value['profile_url']) . "' target='" . esc_attr($value['open_new_tab']) . "' team-id='0'";
                            $attr2 = [
                                " link-id='" . esc_attr($value['id']) . "' team-id='0'",
                                wpm_6310_validate_profile_url($value['profile_url']),
                                esc_attr($value['open_new_tab'])
                            ];
                        } else if ($value['profile_details_type'] == 2) {
                            $cls = " wpm_6310_team_member_info";
                            $attr = " link-id='0' team-id='" . esc_attr($value['id']) . "'";
                            $attr2[] = $attr;
                        } else if ($value['profile_details_type'] == 3) {
                            $cls = " wpm_6310_team_member_internal_link";
                            $attr = " data-wpm-link-url='".get_permalink(esc_attr($value['post_id']))."'";
                            $attr2[] = $attr;
                          } else {
                            $cls = '';
                            $attr = " link-id='0' team-id='0'";
                            $attr2[] = $attr;
                        }
                        $readMoreActive = esc_attr(isset($allSlider[311]) && $allSlider[311] > 0 ? 1 : 0);
                    ?>
                            <div class="wpm-6310-col-<?php echo esc_attr($desktop_row); ?>">
                                <div class="wpm_6310_team_style_29<?php echo !$readMoreActive ? $cls : '' ?>" <?php echo !$readMoreActive ? $attr : '' ?> <?php echo !$readMoreActive ? $attr : '' ?>>
                                    <div class="wpm_6310_team_style_29_pic">
                                        <img src="<?php echo ($value['image'] ? $value['image'] : $value['hover_image']) ?>" data-6310-hover-image="<?php echo $value['hover_image'] ?>" class="img-responsive <?php echo $allStyle[1] ?>" alt="<?php echo $value['name'] ?>" >
                                        <?php
                                        wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $template_id, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                                        ?>
                                    </div>
                                    <div class="wpm_6310_team_style_29_title"><?php echo wpm_6310_replace(esc_attr($value['name'])) ?></div>
                                    <div class="wpm_6310_team_style_29_designation"><?php echo wpm_6310_replace(esc_attr($value['designation'])) ?></div>
                                    <?php
                                    wpm_6310_extract_contact_info(isset($value['contact_info']) ? $value['contact_info'] : '', $styleId);
                                    wpm_6310_template_skills_admin($value['skills'], $template_id, $allSlider, $value['id'], ' wpm-6310-p-l-r-10');
                                     wpm_6310_extract_member_description_admin($value['profile_details'], ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $styleId);
                                    wpm_6310_read_more($readMoreActive, $template_id, $allSlider, $cls, $attr2, 0);
                                ?>
                            </div>
                </div>
                <?php
                        }
                        echo "</div>";
                    }
                    if($filterList){
            $catIdList = explode(",", $styledata['categoryids']);
                        foreach ($filterList as $filterKey => $filterValue) {
                            $returnMember = wpm_6310_extract_members($filterValue);
                            $catMembers = $returnMember['members'];
                            if ($catMembers) {
                                if(isset($allSlider[101]) && $allSlider[101] == 1) {
                  $displayCSS = wpm_6310_first_category($catIdList[0], $filterKey);
                } else{
                  $displayCSS = " style='display:none';";
                }

                echo "<div class='wpm-6310-row wpm-6310-category-filter  ".esc_attr($filterKey)."'{$displayCSS}>";
                                foreach ($catMembers as $value) {
                                    $attr2 = [];
                                    if ($value['profile_details_type'] == 1) {
                                        $cls = " wpm_6310_team_member_info";
                                        $attr = " link-id='{$value['id']}' link-url='".wpm_6310_validate_profile_url($value['profile_url'])."' target='{$value['open_new_tab']}' team-id='0'";
                                        $attr2 = [
                                        " link-id='{$value['id']}' team-id='0'",
                                        wpm_6310_validate_profile_url($value['profile_url']),
                                        $value['open_new_tab']
                                        ];
                                    } else if ($value['profile_details_type'] == 2) {
                                        $cls = " wpm_6310_team_member_info";
                                        $attr = " link-id='0' team-id='{$value['id']}'";
                                        $attr2[] = $attr;
                                    } else if ($value['profile_details_type'] == 3) {
                                        $cls = " wpm_6310_team_member_internal_link";
                                        $attr = " data-wpm-link-url='".get_permalink(esc_attr($value['post_id']))."'";
                                        $attr2[] = $attr;
                                      } else {
                                        $cls = '';
                                        $attr = " link-id='0' team-id='0'";
                                        $attr2[] = $attr;
                                    }
                                    $readMoreActive = isset($allSlider[311]) && $allSlider[311] > 0 ? 1 : 0;
                ?>
                        <div class="wpm-6310-col-<?php echo esc_attr($desktop_row); ?>">
                            <div class="wpm_6310_team_style_29<?php echo !$readMoreActive ? $cls : '' ?>" <?php echo !$readMoreActive ? $attr : '' ?>>
                                <div class="wpm_6310_team_style_29_pic">
                                    <img src="<?php echo esc_attr(($value['image'] ? $value['image'] : $value['hover_image'])) ?>" data-6310-hover-image="<?php echo esc_attr($value['hover_image']) ?>" class="img-responsive <?php echo esc_attr($allStyle[1]) ?>" alt="<?php echo esc_attr($value['name']) ?>" >
                                    <?php
                                    wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $template_id, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                                    ?>
                                </div>
                                <div class="wpm_6310_team_style_29_title"><?php echo wpm_6310_replace(esc_attr($value['name'])) ?></div>
                                <div class="wpm_6310_team_style_29_designation"><?php echo wpm_6310_replace(esc_attr($value['designation'])) ?></div>
                                <?php
                                    wpm_6310_extract_contact_info(isset($value['contact_info']) ? $value['contact_info'] : '', $styleId);
                                    wpm_6310_template_skills_admin($value['skills'], $template_id, $allSlider, $value['id'], ' wpm-6310-p-l-r-10');
                                     wpm_6310_extract_member_description_admin($value['profile_details'], ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $styleId);
                                    wpm_6310_read_more($readMoreActive, $template_id, $allSlider, $cls, $attr2, 0);
                                    ?>
                        </div>
            </div>
<?php
                                }
                                echo "</div>";
                            }
                        }
                    }
?>
        </div>

        <div class="carousel">
            <div id="wpm-6310-slider-<?php echo esc_attr($styleId) ?>" class="wpm-6310-owl-carousel">
                <?php
                    if ($members) {
                        foreach ($members as $value) {
                            $attr2 = [];
                                if ($value['profile_details_type'] == 1) {
                            $cls = " wpm_6310_team_member_info";
                            $attr = " link-id='" . esc_attr($value['id']) . "' link-url='" . wpm_6310_validate_profile_url($value['profile_url']) . "' target='" . esc_attr($value['open_new_tab']) . "' team-id='0'";
                            $attr2 = [
                                " link-id='" . esc_attr($value['id']) . "' team-id='0'",
                                wpm_6310_validate_profile_url($value['profile_url']),
                                esc_attr($value['open_new_tab'])
                            ];
                        } else if ($value['profile_details_type'] == 2) {
                            $cls = " wpm_6310_team_member_info";
                            $attr = " link-id='0' team-id='" . esc_attr($value['id']) . "'";
                            $attr2[] = $attr;
                        } else if ($value['profile_details_type'] == 3) {
                            $cls = " wpm_6310_team_member_internal_link";
                            $attr = " data-wpm-link-url='".get_permalink(esc_attr($value['post_id']))."'";
                            $attr2[] = $attr;
                          } else {
                            $cls = '';
                            $attr = " link-id='0' team-id='0'";
                            $attr2[] = $attr;
                        }
                        $readMoreActive = esc_attr(isset($allSlider[311]) && $allSlider[311] > 0 ? 1 : 0);
                ?>
                        <div class="wpm-6310-item">
                            <div class="wpm_6310_team_style_29<?php echo !$readMoreActive ? $cls : '' ?>" <?php echo !$readMoreActive ? $attr : '' ?>>
                                <div class="wpm_6310_team_style_29_pic">
                                    <img src="<?php echo esc_attr(($value['image'] ? $value['image'] : $value['hover_image'])) ?>" data-6310-hover-image="<?php echo esc_attr($value['hover_image']) ?>" class="img-responsive <?php echo esc_attr($allStyle[1]) ?>" alt="<?php echo esc_attr($value['name']) ?>" >
                                    <?php
                                    wpm_6310_social_icon($value['iconids'], $value['iconurl'], $allStyle[28], $value['id'], $template_id, '', '', isset($allSlider['63']) ? $allSlider['63'] : 4);
                                    ?>
                                </div>
                                <div class="wpm_6310_team_style_29_title"><?php echo wpm_6310_replace(esc_attr($value['name'])) ?></div>
                                <div class="wpm_6310_team_style_29_designation"><?php echo wpm_6310_replace(esc_attr($value['designation'])) ?></div>
                                <?php
                                wpm_6310_extract_contact_info(isset($value['contact_info']) ? $value['contact_info'] : '', $styleId);
                                wpm_6310_template_skills_admin($value['skills'], $template_id, $allSlider, $value['id'], ' wpm-6310-p-l-r-10');
                                 wpm_6310_extract_member_description_admin($value['profile_details'], ((isset($allSlider[72]) && $allSlider[72] !== '') ? $allSlider[72] : $numberOfWords), $styleId);
                                wpm_6310_read_more($readMoreActive, $template_id, $allSlider, $cls, $attr2, 0);
                                ?>
                            </div>
                        </div>
                <?php
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
