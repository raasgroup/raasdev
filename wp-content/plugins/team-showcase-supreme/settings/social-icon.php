<?php
if (!defined('ABSPATH'))
   exit;

?>
<div class="wpm-6310">
   <h1>Team Showcase Social Icon <button class="wpm-btn-success" id="add-social-icon">Add New</button></h1>
   <?php
   $icon_table = $wpdb->prefix . 'wpm_6310_icons';
   wpm_6310_color_picker_script();

   if (!empty($_POST['delete']) && isset($_POST['id']) && is_numeric($_POST['id'])) {
      $nonce = $_REQUEST['_wpnonce'];
      if (!wp_verify_nonce($nonce, 'wpm-nonce-field-delete')) {
         die('You do not have sufficient permissions to access this page.');
      } else {
         $id = (int) $_POST['id'];
         $wpdb->query($wpdb->prepare("DELETE FROM {$icon_table} WHERE id = %d", $id));
      }
   } else if (!empty($_POST['save']) && $_POST['save'] == 'Save') {
      $nonce = $_REQUEST['_wpnonce'];
      if (!wp_verify_nonce($nonce, 'wpm-6310-nonce-add')) {
         die('You do not have sufficient permissions to access this page.');
      } else {
         $name = sanitize_text_field($_POST['name']);
         $class_name = sanitize_text_field($_POST['class_name']);
         $color = sanitize_text_field($_POST['color']);
         $bgcolor = sanitize_text_field($_POST['bgcolor']);

         $wpdb->query($wpdb->prepare("insert into $icon_table SET name = %s, class_name = %s, color = %s, bgcolor = %s", $name, $class_name, $color, $bgcolor));
      }
   } else if (!empty($_POST['update']) && $_POST['update'] == 'Update') {
      $nonce = $_REQUEST['_wpnonce'];
      if (!wp_verify_nonce($nonce, 'wpm-6310-nonce-update')) {
         die('You do not have sufficient permissions to access this page.');
      } else {
         $id = (int) sanitize_text_field($_POST['id']);
         $name = sanitize_text_field($_POST['name']);
         $class_name = sanitize_text_field($_POST['class_name']);
         $color = sanitize_text_field($_POST['color']);
         $bgcolor = sanitize_text_field($_POST['bgcolor']);

         $wpdb->query($wpdb->prepare("update $icon_table SET name = %s, class_name = %s, color = %s, bgcolor = %s where id=%d", $name, $class_name, $color, $bgcolor, $id));
      }
   } else if (!empty($_POST['edit']) && $_POST['edit'] == 'Edit') {
      $nonce = $_REQUEST['_wpnonce'];
      if (!wp_verify_nonce($nonce, 'wpm-nonce-field-edit')) {
         die('You do not have sufficient permissions to access this page.');
      } else {
         $id = (int) $_POST['id'];
         $selIcon = $wpdb->get_row($wpdb->prepare("SELECT * FROM $icon_table WHERE id = %d ", $id), ARRAY_A);
         ?>
         <div id="wpm-6310-modal-edit-social-icon" class="wpm-6310-modal">
            <div class="wpm-6310-modal-content wpm-6310-modal-sm">
               <form action="" method="post">
                  <input type="hidden" name="id" value="<?php echo esc_attr($selIcon['id']) ?>" />
                  <div class="wpm-6310-modal-header">
                     Social Settings
                     <span class="wpm-6310-close">&times;</span>
                  </div>
                  <div class="wpm-6310-modal-body-form">         
                     <?php wp_nonce_field("wpm-6310-nonce-update") ?>
                     <table border="0" width="100%" cellpadding="10" cellspacing="0">
                        <tr>
                           <td width="50%"><label class="wpm-form-label" for="icon_name">Icon Name:</label></td>
                           <td><input type="text" required="" name="name" id="icon_name" value="<?php echo esc_attr($selIcon['name']) ?>" class="wpm-form-input" /></td>
                        </tr>
                        <tr>
                           <td><label class="wpm-form-label" for="class_name">Font Awesome Class:</label></td>
                           <td><input type="text" required="" name="class_name" id="class_name" value="<?php echo esc_attr($selIcon['class_name']) ?>" class="wpm-form-input" /></td>
                        </tr>
                        <tr>
                           <td><label class="wpm-form-label" for="color">Color:</label></td>
                           <td><input type="text" name="color" id="color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" required="" data-opacity=".8" value="<?php echo esc_attr($selIcon['color']) ?>"></td>
                        </tr>
                        <tr>
                           <td><label class="wpm-form-label" for="bgcolor">Background Color:</label></td>
                           <td><input type="text" name="bgcolor" id="bgcolor" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" required="" data-opacity=".8" value="<?php echo esc_attr($selIcon['bgcolor']) ?>"></td>
                        </tr>
                     </table>

                  </div>
                  <div class="wpm-6310-modal-form-footer">
                     <button type="button" name="close" class="wpm-btn-danger wpm-pull-right">Close</button>
                     <input type="submit" name="update" class="wpm-btn-primary wpm-pull-right wpm-margin-right-10" value="Update"/>
                  </div>
               </form>
               <br class="wpm-6310-clear" />
            </div>
         </div>
         <?php
      }
   }
   ?>

   <table class="wpm-table">
      <tr>
         <td style="width: 120px">Icon Name</td>
         <td style="width: 120px">Font Awesome</td>
         <td style="width: 100px">Style</td>
         <td style="width: 100px">Edit Delete</td>
      </tr>

      <?php
      $customCSS = "";
      $data = $wpdb->get_results('SELECT * FROM ' . $icon_table . ' ORDER BY name ASC', ARRAY_A);
      foreach ($data as $value) {
         echo '<tr>';
         echo '<td>' . $value['name'] . '</td>';
         echo '<td>' . $value['class_name'] . '</td>';
         echo "<td>
                  <button class='wpm-btn-icon wpm-btn-icon-".esc_attr($value['id'])."'><i class='" . esc_attr($value['class_name']) . "'></i></button>
                  <i class='" . esc_attr($value['class_name']) . "' style='color: " . esc_attr($value['bgcolor']) . "'></i>
                  </td>";
         echo '<td>
                 <form method="post">
                   ' . wp_nonce_field("wpm-nonce-field-edit") . '
                          <input type="hidden" name="id" value="' . $value['id'] . '">
                          <button class="wpm-btn-success wpm-margin-right-10" style="float:left"  title="Edit"  type="submit" value="Edit" name="edit"><i class="fas fa-edit" aria-hidden="true"></i></button>  
                  </form>
                  <form method="post">
                   ' . wp_nonce_field("wpm-nonce-field-delete") . '
                          <input type="hidden" name="id" value="' . $value['id'] . '">
                          <button class="wpm-btn-danger wpm-6310-social-icon-delete" style="float:left"  title="Delete"  type="submit" value="delete" name="delete"><i class="far fa-times-circle" aria-hidden="true"></i></button>  
                  </form>
               </td>';
         $customCSS .= ".wpm-btn-icon-".esc_attr($value['id'])."{
            color:" . esc_attr($value['color']) . "; 
            background-color: " . ($value['bgcolor']) . "; 
            margin-right: 5px;
         }";     
      }
      wp_register_style("wpm-6310-custom-code-social-css", "");
      wp_enqueue_style("wpm-6310-custom-code-social-css");
      wp_add_inline_style("wpm-6310-custom-code-social-css", $customCSS);
      ?>


   </table> 
   <div id="wpm-6310-modal-add" class="wpm-6310-modal" style="display: none">
      <div class="wpm-6310-modal-content wpm-6310-modal-sm">
         <form action="" method="post">
            <div class="wpm-6310-modal-header">
               Social Settings
               <span class="wpm-6310-close">&times;</span>
            </div>
            <div class="wpm-6310-modal-body-form">         
               <?php wp_nonce_field("wpm-6310-nonce-add") ?>
               <table border="0" width="100%" cellpadding="10" cellspacing="0">
                  <tr>
                     <td width="50%"><label class="wpm-form-label" for="icon_name">Icon Name:</label></td>
                     <td><input type="text" required="" name="name" id="icon_name" value="" class="wpm-form-input" placeholder="Facebook" /></td>
                  </tr>
                  <tr>
                     <td><label class="wpm-form-label" for="class_name">Font Awesome Class:</label></td>
                     <td><input type="text" required="" name="class_name" id="class_name" value="" class="wpm-form-input" placeholder="fab fa-facebook-f" /></td>
                  </tr>
                  <tr>
                     <td><label class="wpm-form-label" for="color">Color:</label></td>
                     <td><input type="text" name="color" id="color" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" required="" data-opacity=".8" value="rgba(255, 255, 255, 1)"></td>
                  </tr>
                  <tr>
                     <td><label class="wpm-form-label" for="bgcolor">Background Color:</label></td>
                     <td><input type="text" name="bgcolor" id="bgcolor" class="wpm-form-input wpm_6310_color_picker" data-format="rgb" required="" data-opacity=".8" value=""></td>
                  </tr>
               </table>

            </div>
            <div class="wpm-6310-modal-form-footer">
               <button type="button" name="close" class="wpm-btn-danger wpm-pull-right">Close</button>
               <input type="submit" name="save" class="wpm-btn-primary wpm-pull-right wpm-margin-right-10" value="Save"/>
            </div>
         </form>
         <br class="wpm-6310-clear" />
      </div>
   </div>
</div>





