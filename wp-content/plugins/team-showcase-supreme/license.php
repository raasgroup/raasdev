<?php
if (!defined('ABSPATH')) {
  exit;
}

?>
<div class="wpm-6310">
  <h1>Product License Activation</h1>
  <p>Activate your copy to get direct plugin updates and official support.</p>
  <?php
  if (!empty($_POST['save'])) {
    $nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($nonce, 'wpm-nonce-field-license')) {
      die('You do not have sufficient permissions to access this page.');
    } else {
      wpm_6310_check_license(sanitize_text_field($_POST['license']));
    }
  }
  ?>
  <form action="" method="post" style="width: 600px">
    <?php
    echo wp_nonce_field("wpm-nonce-field-license");
    ?>
    <table>
      <tr>
        <td>License Key:</td>
        <td>
          <input type="text" name="license" class="wpm-form-input">
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <br />
          <input type="submit" name="save" class="wpm-btn-primary">
        </td>
      </tr>
    </table>
  </form>
</div>