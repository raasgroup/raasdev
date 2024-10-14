<form action="" method="post">
  <?php wp_nonce_field("wpm_6310_nonce_field_form") ?>
  <div class="row wpm_6310_padding_15_px">
    <ul class="wpm-nav-tab">
      <li class="wpm-mytab active" id="tab1">Top Text</li>
      <li class="wpm-mytab" id="tab2">Name</li>
      <li class="wpm-mytab" id="tab3">Designation</li>
      <li class="wpm-mytab" id="tab4">Social Icon</li>
      <li class="wpm-mytab" id="tab5">Profile Details</li>
      <li class="wpm-mytab" id="tab6">Technical Skill</li>
      <li class="wpm-mytab" id="tab7">Contact Info</li>
    </ul>

    <div class="wpm-6310-template-form" id="tab-1">
      <h3 style="text-align: center; color: #b52703; font-size: 24px; margin-bottom: 10px">Top Text Settings</h3>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Image section width (%)</b>
            </td>
            <td>
              <input required type="number" name="template_left_width" class="wpm-form-input" value="<?php echo esc_attr($cssData['template_left_width']); ?>" min="10" max="80" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Left right padding</b>
            </td>
            <td>
              <input required type="number" name="template_left_right_padding" class="wpm-form-input" value="<?php echo esc_attr($cssData['template_left_right_padding']); ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Margin Top Desktop</b>
            </td>
            <td>
              <input required type="number" name="top_text_margin_desktop" class="wpm-form-input" value="<?php echo ($cssData['top_text_margin_desktop']); ?>" min="0" max="200">
            </td>
          </tr>
          <tr>
            <td>
              <b>Margin Top Mobile</b>
            </td>
            <td>
              <input required type="number" name="top_text_margin_mobile" class="wpm-form-input" value="<?php echo ($cssData['top_text_margin_mobile']); ?>" min="0" max="200">
            </td>
          </tr>
        </table>
      </div>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Top Text</b>
            </td>
            <td>
              <input required type="text" name="top_text" class="wpm-form-input" value="<?php echo wpm_6310_replace($cssData['top_text']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Text color</b>
            </td>
            <td>
              <input required type="text" name="top_text_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['top_text_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Desktop font size</b>
            </td>
            <td>
              <input required type="number" name="top_text_font_size_desktop" class="wpm-form-input" value="<?php echo ($cssData['top_text_font_size_desktop']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Mobile font size</b>
            </td>
            <td>
              <input required type="number" name="top_text_font_size_mobile" class="wpm-form-input" value="<?php echo ($cssData['top_text_font_size_mobile']) ?>" />
            </td>
          </tr>
        </table>
      </div>
    </div>


    <div class="wpm-6310-template-form" id="tab-2">
      <h3 style="text-align: center; color: #b52703; font-size: 24px; margin-bottom: 10px">Name Settings</h3>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Desktop font size</b>
            </td>
            <td>
              <input required type="number" name="title_font_size_desktop" class="wpm-form-input" value="<?php echo ($cssData['title_font_size_desktop']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Mobile font size</b>
            </td>
            <td>
              <input required type="number" name="title_font_size_mobile" class="wpm-form-input" value="<?php echo ($cssData['title_font_size_mobile']) ?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Text color</b>
            </td>
            <td>
              <input required type="text" name="title_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['title_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Font weight</b>
            </td>
            <td>
              <select name="title_font_weight" class="wpm-form-input">
                <?php
                $list = [100, 200, 300, 400, 500, 600, 700, 800, 900, 'normal', 'bold', 'lighter', 'initial'];
                foreach ($list as $index) {
                  $selected = $index == $cssData['title_font_weight'] ? 'selected' : '';
                  echo "<option value='{$index}' {$selected}>" . ucfirst($index) . "</option>";
                }
                ?>
              </select>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="wpm-6310-template-form" id="tab-3">
      <h3 style="text-align: center; color: #b52703; font-size: 24px; margin-bottom: 10px">Designation Settings</h3>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Desktop font size</b>
            </td>
            <td>
              <input required type="number" name="designation_font_size_desktop" class="wpm-form-input" value="<?php echo ($cssData['designation_font_size_desktop']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Mobile font size</b>
            </td>
            <td>
              <input required type="number" name="designation_font_size_mobile" class="wpm-form-input" value="<?php echo ($cssData['designation_font_size_mobile']) ?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Text color</b>
            </td>
            <td>
              <input required type="text" name="designation_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['designation_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Font weight</b>
            </td>
            <td>
              <select name="designation_font_weight" class="wpm-form-input">
                <?php
                $list = [100, 200, 300, 400, 500, 600, 700, 800, 900, 'normal', 'bold', 'lighter', 'initial'];
                foreach ($list as $index) {
                  $selected = $index == $cssData['designation_font_weight'] ? 'selected' : '';
                  echo "<option value='{$index}' {$selected}>" . ucfirst($index) . "</option>";
                }
                ?>
              </select>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="wpm-6310-template-form" id="tab-4">
      <h3 style="text-align: center; color: #b52703; font-size: 24px; margin-bottom: 10px">Social Icon Settings</h3>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Display Social Icons </b>
            </td>
            <td>
              <label class="switch" for="social_status">
                <input type="checkbox" name="social_status" id="social_status" value="1" <?php if (isset($cssData['social_status'])) echo 'checked=""'; ?>>
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
          <tr>
            <td>
              <b>Desktop font size</b>
            </td>
            <td>
              <input required type="number" name="social_font_size_desktop" class="wpm-form-input" value="<?php echo ($cssData['social_font_size_desktop']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Mobile font size</b>
            </td>
            <td>
              <input required type="number" name="social_font_size_mobile" class="wpm-form-input" value="<?php echo ($cssData['social_font_size_mobile']) ?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Gap between icon</b>
            </td>
            <td>
              <input required type="number" name="social_gap" class="wpm-form-input" value="<?php echo esc_attr($cssData['social_gap']); ?>">
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="wpm-6310-template-form" id="tab-5">
      <h3 style="text-align: center; color: #b52703; font-size: 24px; margin-bottom: 10px">Profile Details Settings</h3>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Details heading Text</b>
            </td>
            <td>
              <input type="text" name="details_text" class="wpm-form-input" value="<?php echo wpm_6310_replace($cssData['details_text']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Details heading desktop font size</b>
            </td>
            <td>
              <input required type="number" name="details_text_font_size_desktop" class="wpm-form-input" value="<?php echo ($cssData['details_text_font_size_desktop']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Details heading mobile font size</b>
            </td>
            <td>
              <input required type="number" name="details_text_font_size_mobile" class="wpm-form-input" value="<?php echo ($cssData['details_text_font_size_mobile']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Details heading color</b>
            </td>
            <td>
              <input required type="text" name="details_text_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['details_text_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Details line color</b>
            </td>
            <td>
              <input required type="text" name="details_text_line_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['details_text_line_color']); ?>">
            </td>
          </tr>
        </table>
      </div>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Details paragraph color</b>
            </td>
            <td>
              <input required type="text" name="details_paragraph_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['details_paragraph_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Details paragraph desktop font size</b>
            </td>
            <td>
              <input required type="number" name="details_paragraph_font_size_desktop" class="wpm-form-input" value="<?php echo ($cssData['details_paragraph_font_size_desktop']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Details paragraph mobile font size</b>
            </td>
            <td>
              <input required type="number" name="details_paragraph_font_size_mobile" class="wpm-form-input" value="<?php echo ($cssData['details_paragraph_font_size_mobile']) ?>" />
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="wpm-6310-template-form" id="tab-6">
      <h3 style="text-align: center; color: #b52703; font-size: 24px; margin-bottom: 10px">Technical Skill Settings</h3>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Display Technical Skill</b>
            </td>
            <td>
              <label class="switch" for="technical_skill_status">
                <input type="checkbox" name="technical_skill_status" id="technical_skill_status" value="1" <?php if (isset($cssData['technical_skill_status'])) echo 'checked=""'; ?>>
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
          <tr>
            <td>
              <b>Technical skill label color</b>
            </td>
            <td>
              <input required type="text" name="technical_skill_label_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['technical_skill_label_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Technical skill label desktop font size</b>
            </td>
            <td>
              <input required type="number" name="technical_skill_label_font_size_desktop" class="wpm-form-input" value="<?php echo ($cssData['technical_skill_label_font_size_desktop']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Technical skill label mobile font size</b>
            </td>
            <td>
              <input required type="number" name="technical_skill_label_font_size_mobile" class="wpm-form-input" value="<?php echo ($cssData['technical_skill_label_font_size_mobile']) ?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          
          <tr>
            <td>
              <b>Progress bar color</b>
            </td>
            <td>
              <input required type="text" name="technical_skill_progress_bar_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['technical_skill_progress_bar_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Progress bar border color</b>
            </td>
            <td>
              <input required type="text" name="technical_skill_progress_bar_border_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['technical_skill_progress_bar_border_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Progress bar height</b>
            </td>
            <td>
              <input required type="number" name="technical_skill_progress_bar_height" class="wpm-form-input" value="<?php echo esc_attr($cssData['technical_skill_progress_bar_height']); ?>">
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div class="wpm-6310-template-form" id="tab-7">
      <h3 style="text-align: center; color: #b52703; font-size: 24px; margin-bottom: 10px">Contact Info Settings</h3>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Display contact info </b>
            </td>
            <td>
              <label class="switch" for="contact_info_status">
                <input type="checkbox" name="contact_info_status" id="contact_info_status" value="1" <?php if (isset($cssData['contact_info_status'])) echo 'checked=""'; ?>>
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
          <tr>
            <td>
              <b>Contact info icon color</b>
            </td>
            <td>
              <input required type="text" name="contact_info_icon_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['contact_info_icon_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Contact info icon desktop font size</b>
            </td>
            <td>
              <input required type="number" name="contact_info_icon_desktop_font_size" class="wpm-form-input" value="<?php echo ($cssData['contact_info_icon_desktop_font_size']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Contact info icon mobile font size</b>
            </td>
            <td>
              <input required type="number" name="contact_info_icon_mobile_font_size" class="wpm-form-input" value="<?php echo ($cssData['contact_info_icon_mobile_font_size']) ?>" />
            </td>
          </tr>
        </table>
      </div>
      <div class="wpm-col-6">
        <table class="table table-responsive wpm_6310_admin_table">
          <tr>
            <td>
              <b>Contact info text color</b>
            </td>
            <td>
              <input required type="text" name="contact_info_text_color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" value="<?php echo esc_attr($cssData['contact_info_text_color']); ?>">
            </td>
          </tr>
          <tr>
            <td>
              <b>Contact info text desktop font size</b>
            </td>
            <td>
              <input required type="number" name="contact_info_text_desktop_font_size" class="wpm-form-input" value="<?php echo ($cssData['contact_info_text_desktop_font_size']) ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <b>Contact info text mobile font size</b>
            </td>
            <td>
              <input required type="number" name="contact_info_text_mobile_font_size" class="wpm-form-input" value="<?php echo ($cssData['contact_info_text_mobile_font_size']) ?>" />
            </td>
          </tr>
        </table>
      </div>
    </div>

    <div style="background: #FFF; float: left; width: calc(100% - 26px); padding-top: 8px; margin-top: 2px">
      <div>
        <input required type="submit" name="update_style_change" value="Save Changes" class="wpm-btn-primary wpm-pull-right" style="margin-right: 10px; margin-bottom: 10px; display: block">
      </div>
    </div>
  </div>
</form>

