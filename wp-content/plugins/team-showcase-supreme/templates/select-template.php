<div class="wpm-6310">
  <?php
  if (!defined('ABSPATH'))
    exit;
  global $wpdb;

  $id = isset($_GET['template']) ? (int) $_GET['template'] : 0;
  if ($id) {
    $template_table = $wpdb->prefix . 'wpm_6310_template';

    //Update CSS
    if (!empty($_POST['update_style_change']) && $_POST['update_style_change'] == 'Save Changes') {
      $nonce = $_REQUEST['_wpnonce'];
      if (!wp_verify_nonce($nonce, 'wpm_6310_nonce_field_form')) {
        die('You do not have sufficient permissions to access this pagess.');
      } else {
        $css = wpm_6310_extract_data($_POST);
        $wpdb->query($wpdb->prepare("UPDATE $template_table SET css = %s WHERE name = %s", $css, $id));
      }
    }

    //Fetch CSS data from table
    $styledata = $wpdb->get_row($wpdb->prepare("SELECT * FROM $template_table WHERE name = %s ", $id), ARRAY_A);
    $css = explode("!!##!!", $styledata['css']);
    $key = explode(",", $css[0]);
    $value = explode("||##||", $css[1]);
    $cssData = array_combine($key, $value);
    wp_enqueue_media();

    include wpm_6310_plugin_url . "templates/setting-template-{$id}.php";
  } else {
  ?>

    <div class="wpm-6310-row wpm-6310-row-plugins">
      <h1 class="wpm-6310-wpmart-all-plugins">Profile details templates</h1>
      <div class="wpm-6310-col-3">
        <div class="wpm-6310-wpmart-plugins">
          <img src="<?php echo wpm_6310_plugin_dir_url ?>assets/images/template-1.png" class="wpm-image-responsive">
          <p>
            <a href="<?php echo admin_url("admin.php?page=team-showcase-supreme-details-template&template=1")  ?>" class="wpm-btn-success wpm-6310-edit-template">Edit Template 1 </a>
          </p>
        </div>
      </div>
      <div class="wpm-6310-col-3">
        <div class="wpm-6310-wpmart-plugins">
          <img src="<?php echo wpm_6310_plugin_dir_url ?>assets/images/template-2.png" class="wpm-image-responsive">
          <p>
            <a href="<?php echo admin_url("admin.php?page=team-showcase-supreme-details-template&template=2")  ?>" class="wpm-btn-success wpm-6310-edit-template">Edit Template 2 </a>
          </p>
        </div>
      </div>
      <div class="wpm-6310-col-3">
        <div class="wpm-6310-wpmart-plugins">
          <img src="<?php echo wpm_6310_plugin_dir_url ?>assets/images/template-3.png" class="wpm-image-responsive">
          <p>
            <a href="<?php echo admin_url("admin.php?page=team-showcase-supreme-details-template&template=3")  ?>" class="wpm-btn-success wpm-6310-edit-template">Edit Template 3 </a>
          </p>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<style>
  ul.wpm-nav-tab li {
    padding: 0 20px !important;
    font-weight: 600 !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    jQuery("body").on("click", "#top-text-bg-img-btn", function(e) {
      console.log(1111);
      e.preventDefault();
      var image = wp.media({
          title: 'Upload Background Image',
          multiple: false
        }).open()
        .on('select', function(e) {
          var uploaded_image = image.state().get('selection').first();
          var image_url = uploaded_image.toJSON().url;
          jQuery("#top-text-bg-img").val(image_url);
          //jQuery("#vkcmu-favicon-image").attr("src", image_url);
        });

      jQuery("#wpm_6310_add_new_media").css({
        "overflow-x": "hidden",
        "overflow-y": "auto"
      });
    });

    jQuery(
      "#tab-2, #tab-3, #tab-4, #tab-5, #tab-6, #tab-7, #tab-8, #tab-9, #tab-10, #tab-11, #tab-12, #tab-13, #tab-14, #tab-15"
    ).hide();
    jQuery("body").on("click", ".wpm-mytab", function() {
      jQuery(".wpm-mytab").removeClass("active");
      jQuery(this).addClass("active");
      var ids = jQuery(this).attr("id");
      ids = parseInt(ids.substring(3));
      jQuery(
        "#tab-1, #tab-2, #tab-3, #tab-4, #tab-5, #tab-6, #tab-7, #tab-8, #tab-9, #tab-10, #tab-11, #tab-12, #tab-13, #tab-14, #tab-15"
      ).hide();
      jQuery("#tab-" + ids).show();
      jQuery("#tab6").click(function(event) {
        jQuery(".codemirror-textarea").focus();
      });
      return false;
    });


    
    var imh_6310_Timeout;
    jQuery('body').on('input', 'input', function(){
      jQuery('.wpm-6310-red-border').removeClass('wpm-6310-red-border');
      jQuery('.wpm-6310-red-color').remove();
    });
    jQuery('body').on('click', '[name="update_style_change"]', function(event){
      clearTimeout(imh_6310_Timeout);
      jQuery('.wpm-6310-red-border').removeClass('wpm-6310-red-border');
      jQuery('.wpm-6310-red-color').remove();
      var allInput = jQuery("input[required]");
      var errorFound = false;
      var ids, that;
      allInput.each(function(){
        var value = jQuery(this).val(),
            type = jQuery(this).attr('type');
            
        if(type == 'number' && value == '')    {
          errorFound = true;
          jQuery(this).after('<div class="wpm-6310-red-color">This field value is required</div>');
          that = jQuery(this);
        } else if(type == 'number' && isNaN(value))    {
          errorFound = true;
          jQuery(this).after('<div class="wpm-6310-red-color">This field value must be a number</div>');
          that = jQuery(this);
        } else if(type == 'text' && value == '') {
          errorFound = true;
          jQuery(this).after('<div class="wpm-6310-red-color">This field value is required</div>');
          that = jQuery(this);
          
        }
      });

      if(errorFound){
        event.preventDefault();
        event.stopPropagation();
        that.addClass('wpm-6310-red-border');
        ids = that.closest('.wpm-6310-template-form').attr('id');
        ids = ids.replace('-', '');
        jQuery('#' + ids).click();

        imh_6310_Timeout = setTimeout(function(){
          jQuery('.wpm-6310-red-border').removeClass('wpm-6310-red-border');
          jQuery('.wpm-6310-red-color').remove();
        }, 5000);
        return false;
      }
    });
})
</script>