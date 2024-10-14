<?php
if (!defined('ABSPATH'))
  exit;

if (!empty($_POST['submit']) && $_POST['submit'] == 'Save' && $_POST['style'] != '') {
  $nonce = $_REQUEST['_wpnonce'];
  if (!wp_verify_nonce($nonce, 'wpm-nonce-field')) {
    die('You do not have sufficient permissions to access this page.');
  } else {
    $name = sanitize_text_field($_POST['style_name']);
    $style_name = sanitize_text_field($_POST['style']);

    $defaultData = wpm_6310_default_value($_POST['style']);
    $css = $defaultData['css'];
    $slider = $defaultData['slider'];

    $members = $wpdb->get_results('SELECT * FROM ' . $member_table . ' ORDER BY name ASC', ARRAY_A);
    $membersId = "";
    if ($_POST['import_member'] == 1) {
      foreach ($members as $member) {
        if ($membersId) {
          $membersId .= ",";
        }
        $membersId .= $member['id'];
      }
    }

    $wpdb->query($wpdb->prepare("INSERT INTO {$style_table} (name, style_name, css, slider, memberid) VALUES ( %s, %s, %s, %s, %s )", array($name, $style_name, $css, $slider,  $membersId)));
    $redirect_id = $wpdb->insert_id;

    if ($redirect_id == 0) {
      $url = admin_url("admin.php?page=team-showcase-supreme");
    } else if ($redirect_id != 0) {
      $url = admin_url("admin.php?page=wpm-template-41-50&styleid=$redirect_id");
    }
    echo '<script type="text/javascript"> document.location.href = "' . $url . '"; </script>';
    exit;
  }
}

//Load Image
$arr = array(
  wpm_6310_plugin_dir_url . 'assets/images/1.jpg||||' . wpm_6310_plugin_dir_url . 'assets/images/1_hover.jpg',
  wpm_6310_plugin_dir_url . 'assets/images/2.jpg||||' . wpm_6310_plugin_dir_url . 'assets/images/2_hover.jpg',
  wpm_6310_plugin_dir_url . 'assets/images/3.jpg||||' . wpm_6310_plugin_dir_url . 'assets/images/3_hover.jpg',
  wpm_6310_plugin_dir_url . 'assets/images/4.jpg||||' . wpm_6310_plugin_dir_url . 'assets/images/4_hover.jpg',
  wpm_6310_plugin_dir_url . 'assets/images/5.jpg||||' . wpm_6310_plugin_dir_url . 'assets/images/5_hover.jpg'
);

$icons = array(
  '<li><a href="https://www.linkedin.com" class="open_in_new_tab_class wpm-social-link-linkedin" title="Linkedin" target="_blank" id=""><i class="fab fa-linkedin-in"></i></a></li>',
  '<li><a href="https://www.facebook.com" class="open_in_new_tab_class wpm-social-link-facebook" title="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a></li>',
  '<li><a href="https://www.youtube.com" class="open_in_new_tab_class wpm-social-link-youtube" title="Youtube" target="_blank"><i class="fab fa-youtube"></i></a></li>',
  '<li><a href="https://www.twitter.com" class="open_in_new_tab_class wpm-social-link-twitter" title="Twitter" target="_blank"><i class="fab fa-twitter"></i></a></li>',
  '<li><a href="https://www.google.com" class="open_in_new_tab_class wpm-social-link-google" title="Google Plus" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>',
  '<li><a href="https://www.pinterest.com" class="open_in_new_tab_class wpm-social-link-pinterest" title="Pinterest" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>',
  '<li><a href="https://www.whatsapp.com" class="open_in_new_tab_class wpm-social-link-whatsapp" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a></li>'
);
?>
<div class="wpm-6310">
  <h1>Select Template</h1>
  <!-- Temaplate 41 -->
  <?php shuffle($arr); ?>
  <div class="wpm-6310-row wpm-6310_team-style-boxed">
    <div class="wpm-padding-15">
      <div class="wpm-6310-col-3">
        <div class="wpm_6310_team_style_41_preview wpm_6310_hover_img_change">
          <div class="wpm_6310_team_style_41_preview_pic">
            <div class="wpm_6310_team_style_41_preview_pic_container">
              <div class="wpm_6310_team_style_41_preview_profile-image-border"></div>
              <?php $temp = explode("||||", $arr[0]);  ?>
              <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
            </div>
          </div>
          <figcaption>
            <div class="wpm_6310_team_style_41_preview_caption">
              <div class="wpm_6310_team_style_41_preview_title">Adam Smith</div>
              <div class="wpm_6310_team_style_41_preview_designation">Web Developer</div>

              <div class="wpm-custom-fields-31-preview">
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview">Fax</div>
                  <div class="wpm-custom-fields-list-content-31-preview">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview"><i class="far fa-address-card"></i></div>
                  <div class="wpm-custom-fields-list-content-31-preview">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview"><i class="fas fa-phone-square"></i></div>
                  <div class="wpm-custom-fields-list-content-31-preview">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social(' wpm-6310-p-l-r-10') ?>
              <div class="wpm_6310_team_style_41_preview_description">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>

            </div>
            <ul class="wpm_6310_team_style_41_preview_social">
              <?php
              shuffle($icons);
              for ($i = 0; $i < 4; $i++) {
                echo $icons[$i];
              }
              ?>
            </ul>

          </figcaption>

        </div>
      </div>

      <div class="wpm-6310-col-3">
        <div class="wpm_6310_team_style_41_preview wpm_6310_hover_img_change">
          <div class="wpm_6310_team_style_41_preview_pic">
            <div class="wpm_6310_team_style_41_preview_pic_container">
              <div class="wpm_6310_team_style_41_preview_profile-image-border"></div>
              <?php $temp = explode("||||", $arr[1]);  ?>
              <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
            </div>

          </div>
          <figcaption>
            <div class="wpm_6310_team_style_41_preview_caption">
              <div class="wpm_6310_team_style_41_preview_title">Adam Smith</div>
              <div class="wpm_6310_team_style_41_preview_designation">Web Developer</div>

              <div class="wpm-custom-fields-31-preview">
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview">Fax</div>
                  <div class="wpm-custom-fields-list-content-31-preview">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview"><i class="far fa-address-card"></i></div>
                  <div class="wpm-custom-fields-list-content-31-preview">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview"><i class="fas fa-phone-square"></i></div>
                  <div class="wpm-custom-fields-list-content-31-preview">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social(' wpm-6310-p-l-r-10') ?>
              <div class="wpm_6310_team_style_41_preview_description">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <ul class="wpm_6310_team_style_41_preview_social">
                <?php
                shuffle($icons);
                for ($i = 0; $i < 4; $i++) {
                  echo $icons[$i];
                }
                ?>
              </ul>
            </div>
          </figcaption>
        </div>
      </div>
      <div class="wpm-6310-col-3">
        <div class="wpm_6310_team_style_41_preview wpm_6310_hover_img_change">
          <div class="wpm_6310_team_style_41_preview_pic">
            <div class="wpm_6310_team_style_41_preview_pic_container">
              <div class="wpm_6310_team_style_41_preview_profile-image-border"></div>
              <?php $temp = explode("||||", $arr[2]);  ?>
              <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
            </div>

          </div>
          <figcaption>
            <div class="wpm_6310_team_style_41_preview_caption">
              <div class="wpm_6310_team_style_41_preview_title">Adam Smith</div>
              <div class="wpm_6310_team_style_41_preview_designation">Web Developer</div>

              <div class="wpm-custom-fields-31-preview">
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview">Fax</div>
                  <div class="wpm-custom-fields-list-content-31-preview">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview"><i class="far fa-address-card"></i></div>
                  <div class="wpm-custom-fields-list-content-31-preview">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-31-preview">
                  <div class="wpm-custom-fields-list-label-31-preview"><i class="fas fa-phone-square"></i></div>
                  <div class="wpm-custom-fields-list-content-31-preview">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social(' wpm-6310-p-l-r-10') ?>
              <div class="wpm_6310_team_style_41_preview_description">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <ul class="wpm_6310_team_style_41_preview_social">
                <?php
                shuffle($icons);
                for ($i = 0; $i < 4; $i++) {
                  echo $icons[$i];
                }
                ?>
              </ul>
            </div>
          </figcaption>
        </div>
      </div>
    </div>
    <div class="wpm-6310-template-list">
      Template 41 <small>(Single Effect)</small>
  <button type="button" class="wpm-6310-pro-only">Pro Only</button>
    </div>
    <br class="wpm-6310-clear" />

    <div id="wpm-6310-modal-add" class="wpm-6310-modal" style="display: none">
      <div class="wpm-6310-modal-content wpm-6310-modal-sm">
        <form action="" method="post">
          <div class="wpm-6310-modal-header">
            Create Team
            <div class="wpm-6310-close">&times;</div>
          </div>
          <div class="wpm-6310-modal-body-form">
            <?php wp_nonce_field("wpm-nonce-field") ?>
            <input type="hidden" name="style" id="wpm-style-hidden" />
            <table border="0" width="100%" cellpadding="10" cellspacing="0">
              <tr>
                <td width="50%"><label class="wpm-form-label" for="icon_name">Team Name:</label></td>
                <td><input type="text" required="" name="style_name" id="style_name" value="" class="wpm-form-input" placeholder="Team Name" /></td>
              </tr>
              <tr>
                <td><label class="wpm-form-label" for="icon_name">Import team members:</label></td>
                <td>
                  <input type="radio" name="import_member" value="1" checked />Yes
                  <input type="radio" name="import_member" value="0" />No
                </td>
              </tr>
            </table>
          </div>
          <div class="wpm-6310-modal-form-footer">
            <button type="button" name="close" class="wpm-btn-danger wpm-pull-right">Close</button>
            <input type="submit" name="submit" class="wpm-btn-primary wpm-pull-right wpm-margin-right-10" value="Save" />
          </div>
        </form>
        <br class="wpm-6310-clear" />
      </div>
    </div>
  </div>

  <!-- Temaplate 42 -->
  <?php shuffle($arr); ?>
  <div class="wpm-6310-row wpm-6310_team-style-boxed">
    <div class="wpm-padding-15">
      <div class="wpm-6310-col-3">
        <div class="wpm_6310_team_style_42 wpm_6310_hover_img_change">
          <div class="wpm_6310_team_style_42_image_wrapper">
            <div class="wpm_6310_team_style_42_divider">
              <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
              </svg>
            </div>
            <?php $temp = explode("||||", $arr[0]);  ?>
            <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
          </div>

          <figcaption>
            <div class="wpm_6310_team_style_42_caption">
              <div class="wpm_6310_team_style_42_top-section">
              <div class="wpm_6310_team_style_42_quote_icon">
                <i class="fas fa-quote-left"></i>
              </div>
              <div class="wpm_6310_team_style_42_description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <div class="wpm-custom-fields-42">
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42">Fax</div>
                  <div class="wpm-custom-fields-list-content-43">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42"><i class="far fa-address-card"></i></div>
                  <div class="wpm-custom-fields-list-content-43">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42"><i class="fas fa-phone-square"></i></div>
                  <div class="wpm-custom-fields-list-content-43">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social() ?>

              <ul class="wpm_6310_team_style_42_social">
                <?php
                shuffle($icons);
                for ($i = 0; $i < 4; $i++) {
                  echo $icons[$i];
                }
                ?>
              </ul>
              </div>

              <div class="wpm_6310_team_style_42_bottom_section">
              <div class="wpm_6310_team_style_42_designation">Web Developer</div>
              <div class="wpm_6310_team_style_42_title">Adam Smith</div>            
              </div>
            </div>
          </figcaption>
        </div>
      </div>

      <div class="wpm-6310-col-3">
        <div class="wpm_6310_team_style_42 wpm_6310_hover_img_change">
          <div class="wpm_6310_team_style_42_image_wrapper">
            <div class="wpm_6310_team_style_42_divider">
              <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
              </svg>
            </div>
            <?php $temp = explode("||||", $arr[1]);  ?>
            <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
          </div>

          <figcaption>
            <div class="wpm_6310_team_style_42_caption">
              <div class="wpm_6310_team_style_42_top-section">
              <div class="wpm_6310_team_style_42_quote_icon">
                <i class="fas fa-quote-left"></i>
              </div>
              <div class="wpm_6310_team_style_42_description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>   
              <div class="wpm-custom-fields-42">
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42">Fax</div>
                  <div class="wpm-custom-fields-list-content-43">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42"><i class="far fa-address-card"></i></div>
                  <div class="wpm-custom-fields-list-content-43">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42"><i class="fas fa-phone-square"></i></div>
                  <div class="wpm-custom-fields-list-content-43">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social() ?>

              <ul class="wpm_6310_team_style_42_social">
                <?php
                shuffle($icons);
                for ($i = 0; $i < 4; $i++) {
                  echo $icons[$i];
                }
                ?>
              </ul>           
              </div>
              <div class="wpm_6310_team_style_42_bottom_section">
              <div class="wpm_6310_team_style_42_designation">Web Developer</div>
              <div class="wpm_6310_team_style_42_title">Adam Smith</div>
             
              </div>
            </div>
          </figcaption>
        </div>
      </div>

      <div class="wpm-6310-col-3">
        <div class="wpm_6310_team_style_42 wpm_6310_hover_img_change">
          <div class="wpm_6310_team_style_42_image_wrapper">
            <div class="wpm_6310_team_style_42_divider">
              <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
              </svg>
            </div>
            <?php $temp = explode("||||", $arr[2]);  ?>
            <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
          </div>

          <figcaption>
            <div class="wpm_6310_team_style_42_caption">
              <div class="wpm_6310_team_style_42_top-section">
              <div class="wpm_6310_team_style_42_quote_icon">
                <i class="fas fa-quote-left"></i>
              </div>
              <div class="wpm_6310_team_style_42_description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <div class="wpm-custom-fields-42">
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42">Fax</div>
                  <div class="wpm-custom-fields-list-content-43">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42"><i class="far fa-address-card"></i></div>
                  <div class="wpm-custom-fields-list-content-43">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-42">
                  <div class="wpm-custom-fields-list-label-42"><i class="fas fa-phone-square"></i></div>
                  <div class="wpm-custom-fields-list-content-43">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social() ?>

              <ul class="wpm_6310_team_style_42_social">
                <?php
                shuffle($icons);
                for ($i = 0; $i < 4; $i++) {
                  echo $icons[$i];
                }
                ?>
              </ul>
              </div>
              <div class="wpm_6310_team_style_42_bottom_section">
              <div class="wpm_6310_team_style_42_designation">Web Developer</div>
              <div class="wpm_6310_team_style_42_title">Adam Smith</div>
             
              </div>
            </div>
          </figcaption>
        </div>
      </div>

    </div>
    <div class="wpm-6310-template-list">
      Template 42 <small>(Single Effect)</small>
     <button type="button" class="wpm-6310-pro-only">Pro Only</button>
    </div>
    <br class="wpm-6310-clear" />
  </div>

    <!-- Temaplate 43 -->
  <?php shuffle($arr); ?>

  <div class="wpm-6310-row wpm-6310_team-style-boxed">
    <div class="wpm_6310_team_style_43_custom_box_margin">
      <div class="wpm-6310-col-4 custom-margin-temp-43">
        <div class="wpm_6310_team_style_43 wpm_6310_hover_img_change">

          <?php $temp = explode("||||", $arr[0]);  ?>
          <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
       
          <figcaption>
            <div class="wpm_6310_team_style_43_caption">
              <div class="wpm_6310_team_style_43_designation">Web Developer</div>
              <div class="wpm_6310_team_style_43_title">Adam Smith</div>
              <div class="wpm-custom-fields-43">
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43">Fax</div>
                    <div class="wpm-custom-fields-list-content-43">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="far fa-address-card"></i></div>
                    <div class="wpm-custom-fields-list-content-43">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="fas fa-phone-square"></i></div>
                    <div class="wpm-custom-fields-list-content-43">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social() ?>
              <div class="wpm_6310_team_style_43_description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <ul class="wpm_6310_team_style_43_social">
                <?php
                        shuffle($icons);
                        for ($i = 0; $i < 4; $i++) {
                           echo $icons[$i];
                        }
                        ?>
              </ul>
            </div>
          </figcaption>
        </div>
      </div>
      <div class="wpm-6310-col-4 custom-margin-temp-43">
        <div class="wpm_6310_team_style_43 wpm_6310_hover_img_change">
          <?php $temp = explode("||||", $arr[1]);  ?>
          <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
          <figcaption>
            <div class="wpm_6310_team_style_43_caption">
              <div class="wpm_6310_team_style_43_designation">Web Developer</div>
              <div class="wpm_6310_team_style_43_title">Adam Smith</div>
              <div class="wpm-custom-fields-43">
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43">Fax</div>
                    <div class="wpm-custom-fields-list-content-43">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="far fa-address-card"></i></div>
                    <div class="wpm-custom-fields-list-content-43">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="fas fa-phone-square"></i></div>
                    <div class="wpm-custom-fields-list-content-43">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social() ?>
              <div class="wpm_6310_team_style_43_description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <ul class="wpm_6310_team_style_43_social">
                <?php
                        shuffle($icons);
                        for ($i = 0; $i < 4; $i++) {
                           echo $icons[$i];
                        }
                        ?>
              </ul>
            </div>
          </figcaption>
        </div>
      </div>
      <div class="wpm-6310-col-4 custom-margin-temp-43">
        <div class="wpm_6310_team_style_43 wpm_6310_hover_img_change">
        <?php $temp = explode("||||", $arr[2]);  ?>
          <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
          <figcaption>
            <div class="wpm_6310_team_style_43_caption">
              <div class="wpm_6310_team_style_43_designation">Web Developer</div>
              <div class="wpm_6310_team_style_43_title">Adam Smith</div>
              <div class="wpm-custom-fields-43">
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43">Fax</div>
                    <div class="wpm-custom-fields-list-content-43">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="far fa-address-card"></i></div>
                    <div class="wpm-custom-fields-list-content-43">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="fas fa-phone-square"></i></div>
                    <div class="wpm-custom-fields-list-content-43">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social() ?>
              <div class="wpm_6310_team_style_43_description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <ul class="wpm_6310_team_style_43_social">
                <?php
                        shuffle($icons);
                        for ($i = 0; $i < 4; $i++) {
                           echo $icons[$i];
                        }
                        ?>
              </ul>
            </div>
          </figcaption>
        </div>
      </div>

      <div class="wpm-6310-col-4 custom-margin-temp-43">
        <div class="wpm_6310_team_style_43 wpm_6310_hover_img_change">
          <?php $temp = explode("||||", $arr[1]);  ?>
          <img src="<?php echo $temp[0] ?>" data-6310-hover-image="<?php echo $temp[1] ?>" class="wpm-image-responsive" alt="Team Showcase">
          <figcaption>
            <div class="wpm_6310_team_style_43_caption">
              <div class="wpm_6310_team_style_43_designation">Web Developer</div>
              <div class="wpm_6310_team_style_43_title">Adam Smith</div>
              <div class="wpm-custom-fields-43">
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43">Fax</div>
                    <div class="wpm-custom-fields-list-content-43">03424387263</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="far fa-address-card"></i></div>
                    <div class="wpm-custom-fields-list-content-43">Dhaka, Bangladesh</div>
                </div>
                <div class="wpm-custom-fields-list-43">
                    <div class="wpm-custom-fields-list-label-43"><i class="fas fa-phone-square"></i></div>
                    <div class="wpm-custom-fields-list-content-43">1588104357</div>
                </div>
              </div>
              <?php echo wpm_6310_skills_social() ?>
              <div class="wpm_6310_team_style_43_description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
              <ul class="wpm_6310_team_style_43_social">
                <?php
                        shuffle($icons);
                        for ($i = 0; $i < 4; $i++) {
                           echo $icons[$i];
                        }
                        ?>
              </ul>
            </div>
          </figcaption>
        </div>
      </div>
    </div>
    <div class="wpm-6310-template-list">
      Template 43 <small>(Single Effect)</small>
     <button type="button" class="wpm-6310-pro-only">Pro Only</button>
    </div>
    <br class="wpm-6310-clear" />
  </div>


  <script>
    jQuery(document).ready(function() {
      jQuery("body").on("click", ".wpm_choosen_style", function() {
        jQuery("#wpm-6310-modal-add").fadeIn(500);
        jQuery("#wpm-style-hidden").val(jQuery(this).attr("id"));
        jQuery("body").css({
          "overflow": "hidden"
        });
        return false;
      });

      jQuery("body").on("click", ".wpm-6310-close, .wpm-btn-danger", function() {
        jQuery("#wpm-6310-modal-add").fadeOut(500);
        jQuery("body").css({
          "overflow": "initial"
        });
      });
      jQuery(window).click(function(event) {
        if (event.target == document.getElementById('wpm-6310-modal-add')) {
          jQuery("#wpm-6310-modal-add").fadeOut(500);
          jQuery("body").css({
            "overflow": "initial"
          });
        }
      });

      jQuery("body").on("mouseenter mouseleave", ".wpm_6310_hover_img_change", function(e) {
        e.preventDefault();
        var orgImage = jQuery(this).find('img').attr('src');
        var hoverImage = jQuery(this).find('img').attr('data-6310-hover-image');
        if (hoverImage && hoverImage.length > 5) {
          jQuery(this).find('img').attr("src", hoverImage);
          jQuery(this).find('img').attr("data-6310-hover-image", orgImage);
        }
      });
    });
  </script>