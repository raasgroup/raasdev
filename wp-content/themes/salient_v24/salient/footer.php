<?php 



$options = get_nectar_theme_options(); 

global $post;

$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';

$cta_link = ( !empty($options['cta-btn-link']) ) ? $options['cta-btn-link'] : '#';

$using_footer_widget_area = (!empty($options['enable-main-footer-area']) && $options['enable-main-footer-area'] == 1) ? 'true' : 'false';

$disable_footer_copyright = (!empty($options['disable-copyright-footer-area']) && $options['disable-copyright-footer-area'] == 1) ? 'true' : 'false';

$footer_reveal = (!empty($options['footer-reveal'])) ? $options['footer-reveal'] : 'false'; 

$footer_full_width = (!empty($options['footer-full-width'])) ? $options['footer-full-width'] : 'false'; 

$midnight_non_reveal = ($footer_reveal != 'false') ? null : 'data-midnight="light"';



$footer_bg_image_overlay = (!empty($options['footer-background-image-overlay'])) ? $options['footer-background-image-overlay'] : '0.8'; 

$footer_bg_image = (!empty($options['footer-background-image']) && !empty($options['footer-background-image']['url'])) ? nectar_options_img($options['footer-background-image']) : false;

$usingFooterBgImg = 'false';

$footer_bg_image_markup = '';



if($footer_bg_image && !empty($footer_bg_image)) {

	$usingFooterBgImg = 'true';

	$footer_bg_image_markup = 'style="background-image:url('.$footer_bg_image.');"';

}



$exclude_pages = (!empty($options['exclude_cta_pages'])) ? $options['exclude_cta_pages'] : array(); 

$footerColumns = (!empty($options['footer_columns'])) ? $options['footer_columns'] : '4'; 



?>



<div id="footer-outer" <?php echo $midnight_non_reveal; ?> data-cols="<?php echo $footerColumns; ?>" data-disable-copyright="<?php echo $disable_footer_copyright; ?>" data-using-bg-img="<?php echo $usingFooterBgImg; ?>" data-bg-img-overlay="<?php echo $footer_bg_image_overlay; ?>" data-full-width="<?php echo $footer_full_width; ?>" data-using-widget-area="<?php echo $using_footer_widget_area; ?>" <?php echo $footer_bg_image_markup;?>>

	

	<?php if(!empty($options['cta-text']) && current_page_url() != $cta_link && !in_array($post->ID, $exclude_pages)) {  

		$cta_btn_color = (!empty($options['cta-btn-color'])) ? $options['cta-btn-color'] : 'accent-color'; ?>



		<div id="call-to-action">

			<div class="container">

				<div class="triangle"></div>

				<span> <?php echo $options['cta-text']; ?> </span>

				<a class="nectar-button <?php if($cta_btn_color != 'see-through') echo 'regular-button '; ?> <?php echo $cta_btn_color;?>" data-color-override="false" href="<?php echo $cta_link ?>"><?php if(!empty($options['cta-btn'])) echo $options['cta-btn']; ?> </a>

			</div>

		</div>



	<?php } ?>



	<?php if( $using_footer_widget_area == 'true') { 



		

	?>

		

	<div id="footer-widgets" data-cols="<?php echo $footerColumns; ?>">

		

		<div class="container">

			

			<div class="row">

				

				<?php 

				

				if($footerColumns == '1'){

					$footerColumnClass = 'span_12';

				} else if($footerColumns == '2'){

					$footerColumnClass = 'span_6';

				} else if($footerColumns == '3'){

					$footerColumnClass = 'span_4';

				} else {

					$footerColumnClass = 'span_3';

				}

				?>

				

				<div class="col <?php echo $footerColumnClass;?>">

				      <!-- Footer widget area 1 -->

		              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 1') ) : else : ?>	

		              	  <div class="widget">		

						  	 <h4 class="widgettitle">Widget Area 1</h4>

						 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>

				     	  </div>

				     <?php endif; ?>

				</div><!--/span_3-->

				

				<?php if($footerColumns == '2' || $footerColumns == '3' || $footerColumns == '4' || $footerColumns == '5') { ?>



					<div class="col <?php echo $footerColumnClass;?>">

						 <!-- Footer widget area 2 -->

			             <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 2') ) : else : ?>	

			                  <div class="widget">			

							 	 <h4 class="widgettitle">Widget Area 2</h4>

							 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>

					     	  </div>

					     <?php endif; ?>

					     

					</div><!--/span_3-->



				<?php } ?>



				

				<?php if($footerColumns == '3' || $footerColumns == '4' || $footerColumns == '5') { ?>

					<div class="col <?php echo $footerColumnClass;?>">

						 <!-- Footer widget area 3 -->

			              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 3') ) : else : ?>		

			              	  <div class="widget">			

							  	<h4 class="widgettitle">Widget Area 3</h4>

							  	<p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>

							  </div>		   

					     <?php endif; ?>

					     

					</div><!--/span_3-->

				<?php } ?>

				

				<?php if($footerColumns == '4' || $footerColumns == '5') { ?>

					<div class="col <?php echo $footerColumnClass;?>">

						 <!-- Footer widget area 4 -->

			              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 4') ) : else : ?>	

			              	<div class="widget">		

							    <h4>Widget Area 4</h4>

							    <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>

							 </div><!--/widget-->	

					     <?php endif; ?>

					     

					</div><!--/span_3-->

				<?php } ?>

				

			</div><!--/row-->

			

		</div><!--/container-->

	

	</div><!--/footer-widgets-->

	

	<?php } //endif for enable main footer area





	   if( $disable_footer_copyright == 'false') { ?>



	

		<div class="row" id="copyright">

			

			<div class="container">

				

				<?php if($footerColumns != '1'){ ?>

					<div class="col span_5">

						

						<?php if(!empty($options['disable-auto-copyright']) && $options['disable-auto-copyright'] == 1) { ?>

							<p><?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>	

						<?php } else { ?>

							<p>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?>. <?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>

						<?php } ?>

						

					</div><!--/span_5-->

				<?php } ?>

				

				<div class="col span_7 col_last">

					<ul id="social">

						<?php  if(!empty($options['use-twitter-icon']) && $options['use-twitter-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['twitter-url']; ?>"><i class="fa fa-twitter"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-facebook-icon']) && $options['use-facebook-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['facebook-url']; ?>"><i class="fa fa-facebook"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-vimeo-icon']) && $options['use-vimeo-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['vimeo-url']; ?>"> <i class="fa fa-vimeo"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-pinterest-icon']) && $options['use-pinterest-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['pinterest-url']; ?>"><i class="fa fa-pinterest"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-linkedin-icon']) && $options['use-linkedin-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['linkedin-url']; ?>"><i class="fa fa-linkedin"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-youtube-icon']) && $options['use-youtube-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['youtube-url']; ?>"><i class="fa fa-youtube-play"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-tumblr-icon']) && $options['use-tumblr-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['tumblr-url']; ?>"><i class="fa fa-tumblr"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-dribbble-icon']) && $options['use-dribbble-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['dribbble-url']; ?>"><i class="fa fa-dribbble"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-rss-icon']) && $options['use-rss-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo (!empty($options['rss-url'])) ? $options['rss-url'] : get_bloginfo('rss_url'); ?>"><i class="fa fa-rss"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-github-icon']) && $options['use-github-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['github-url']; ?>"><i class="fa fa-github-alt"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-behance-icon']) && $options['use-behance-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['behance-url']; ?>"> <i class="fa fa-behance"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-google-plus-icon']) && $options['use-google-plus-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['google-plus-url']; ?>"><i class="fa fa-google-plus"></i> </a></li> <?php } ?>

						<?php  if(!empty($options['use-instagram-icon']) && $options['use-instagram-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['instagram-url']; ?>"><i class="fa fa-instagram"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-stackexchange-icon']) && $options['use-stackexchange-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['stackexchange-url']; ?>"><i class="fa fa-stackexchange"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-soundcloud-icon']) && $options['use-soundcloud-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['soundcloud-url']; ?>"><i class="fa fa-soundcloud"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-flickr-icon']) && $options['use-flickr-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['flickr-url']; ?>"><i class="fa fa-flickr"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-spotify-icon']) && $options['use-spotify-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['spotify-url']; ?>"><i class="icon-salient-spotify"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-vk-icon']) && $options['use-vk-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['vk-url']; ?>"><i class="fa fa-vk"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-vine-icon']) && $options['use-vine-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['vine-url']; ?>"><i class="fa-vine"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-houzz-icon']) && $options['use-houzz-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['houzz-url']; ?>"><i class="fa-houzz"></i></a></li> <?php } ?>

						<?php  if(!empty($options['use-yelp-icon']) && $options['use-yelp-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['yelp-url']; ?>"><i class="fa-yelp"></i></a></li> <?php } ?>

					</ul>

				</div><!--/span_7-->



				<?php if($footerColumns == '1'){ ?>

					<div class="col span_5">

						

						<?php if(!empty($options['disable-auto-copyright']) && $options['disable-auto-copyright'] == 1) { ?>

							<p><?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>	

						<?php } else { ?>

							<p>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?>. <?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>

						<?php } ?>

						

					</div><!--/span_5-->

				<?php } ?>

			

			</div><!--/container-->

			

		</div><!--/row-->

		

		<?php } //endif for enable main footer copyright ?>



</div><!--/footer-outer-->



<?php 



$mobile_fixed = (!empty($options['header-mobile-fixed'])) ? $options['header-mobile-fixed'] : 'false';

$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';



$sideWidgetArea = (!empty($options['header-slide-out-widget-area'])) ? $options['header-slide-out-widget-area'] : 'off';

$userSetSideWidgetArea = $sideWidgetArea;

if($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';



$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';

$fullWidthHeader = (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? true : false;

$sideWidgetClass = (!empty($options['header-slide-out-widget-area-style'])) ? $options['header-slide-out-widget-area-style'] : 'slide-out-from-right';



if($headerFormat == 'centered-menu-under-logo') { 

	if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') {

		$sideWidgetClass = 'slide-out-from-right';

	}

}



$sideWidgetOverlayOpacity = (!empty($options['header-slide-out-widget-area-overlay-opacity'])) ? $options['header-slide-out-widget-area-overlay-opacity'] : 'dark';

$prependTopNavMobile = (!empty($options['header-slide-out-widget-area-top-nav-in-mobile'])) ? $options['header-slide-out-widget-area-top-nav-in-mobile'] : 'false';

if($theme_skin == 'material') $prependTopNavMobile = '1';



$dropdownFunc = (!empty($options['header-slide-out-widget-area-dropdown-behavior'])) ? $options['header-slide-out-widget-area-dropdown-behavior'] : 'default';

if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt') {

	$dropdownFunc = 'default';

}



if($sideWidgetArea == '1') { 



	if($sideWidgetClass == 'fullscreen') echo '</div><!--blurred-wrap-->'; ?>



	<div id="slide-out-widget-area-bg" class="<?php echo $sideWidgetClass . ' '. $sideWidgetOverlayOpacity; ?>"><?php if($sideWidgetClass == 'fullscreen-alt') echo '<div class="bg-inner"></div>';?></div>

	<div id="slide-out-widget-area" class="<?php echo $sideWidgetClass; ?>" data-dropdown-func="<?php echo $dropdownFunc; ?>" data-back-txt="<?php echo __('Back', NECTAR_THEME_NAME); ?>">



		<?php if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt' || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right') || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right-hover') ) echo '<div class="inner-wrap">'; ?>



		<?php $prepend_mobile_menu = ($prependTopNavMobile == '1' && $has_main_menu == 'true' && $userSetSideWidgetArea != 'off') ? 'true' : 'false'; ?>

		<div class="inner" data-prepend-menu-mobile="<?php echo $prepend_mobile_menu; ?>">



		  <a class="slide_out_area_close" href="#">

		  	<?php 

		  	if($theme_skin != 'material') { 

			  	echo '<span class="icon-salient-x icon-default-style"></span>';

			  } else {

			  	echo '<span class="close-wrap"> <span class="close-line close-line1"></span> <span class="close-line close-line2"></span> </span>';

			  } ?>

		  </a>





		   <?php  



		   if($userSetSideWidgetArea == 'off' || $prependTopNavMobile == '1' && $has_main_menu == 'true') { ?>

			   <div class="off-canvas-menu-container mobile-only">

			  		<ul class="menu">

					   <?php 

					  		////use default top nav menu if ocm is not activated

					  	     ////but is needed for mobile when the mobile fixed nav is on

					   		wp_nav_menu( array('theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s')); 



					   		if($headerFormat == 'centered-menu' || $headerFormat == 'menu-left-aligned') {

					   			if(has_nav_menu('top_nav_pull_right')) {

									wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav_pull_right', 'container' => '', 'items_wrap' => '%3$s' ) );  

								}

							}

							

					   ?>

		

					</ul>



					<ul class="menu secondary-header-items"><?php 

						//material secondary nav in menu

						$using_secondary = (!empty($options['header_layout']) && $headerFormat != 'left-header') ? $options['header_layout'] : ' '; 

						if($theme_skin == 'material' && $using_secondary == 'header_with_secondary' && has_nav_menu('secondary_nav')) {

			   	  			 wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'secondary_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); 

						} ?>

					</ul>

				</div>

			<?php } 

		 

		  if(has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') { ?>

		 	 <div class="off-canvas-menu-container">

		  		<ul class="menu">

					    <?php wp_nav_menu( array('theme_location' => 'off_canvas_nav', 'container' => '', 'items_wrap' => '%3$s'));	



					  	?>	  

				</ul>

		    </div>

		    

		  <?php } 

		  

		   //widget area

		   if($sideWidgetClass != 'slide-out-from-right-hover') {

			   if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Off Canvas Menu') ) : elseif(!has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') : ?>	

			      <div class="widget">			

				 	 <h4 class="widgettitle">Side Widget Area</h4>

				 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign widgets to this area.</a></p>

			 	  </div>

			 <?php endif; 



			} ?>



		</div>



		<?php



			$usingSocialOrBottomText = (!empty($options['header-slide-out-widget-area-social']) && $options['header-slide-out-widget-area-social'] == '1' || !empty($options['header-slide-out-widget-area-bottom-text'])) ? true : false;

			

			echo '<div class="bottom-meta-wrap">';

			if($sideWidgetClass == 'slide-out-from-right-hover') {

			   if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Off Canvas Menu') ) : elseif(!has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') : ?>	

			      <div class="widget">			

				 	 <h4 class="widgettitle">Side Widget Area</h4>

				 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign widgets to this area.</a></p>

			 	  </div>

			 <?php endif; 



			} 



			global $using_secondary;

		 	/*social icons*/

			 if(!empty($options['header-slide-out-widget-area-social']) && $options['header-slide-out-widget-area-social'] == '1') {

			 	$social_link_arr = array('twitter-url','facebook-url','vimeo-url','pinterest-url','linkedin-url','youtube-url','tumblr-url','dribbble-url','rss-url','github-url','behance-url','google-plus-url','instagram-url','stackexchange-url','soundcloud-url','flickr-url','spotify-url','vk-url','vine-url','houzz-url', 'phone-url','email-url');

			 	$social_icon_arr = array('fa fa-twitter','fa fa-facebook','fa fa-vimeo','fa fa-pinterest','fa fa-linkedin','fa fa-youtube-play','fa fa-tumblr','fa fa-dribbble','fa fa-rss','fa fa-github-alt','fa fa-behance','fa fa-google-plus','fa fa-instagram','fa fa-stackexchange','fa fa-soundcloud','fa fa-flickr','icon-salient-spotify','fa fa-vk','fa-vine','fa-houzz','fa fa-phone', 'fa fa-envelope');

			 	

			 	echo '<ul class="off-canvas-social-links">';



			 	for($i=0; $i<sizeof($social_link_arr); $i++) {

			 		

			 		if(!empty($options[$social_link_arr[$i]]) && strlen($options[$social_link_arr[$i]]) > 1) echo '<li><a target="_blank" href="'.$options[$social_link_arr[$i]].'"><i class="'.$social_icon_arr[$i].'"></i></a></li>';

			 	}



			 	echo '</ul>';

			 } else if (!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary') {

			 	echo '<ul class="off-canvas-social-links mobile-only">';

				nectar_header_social_icons('off-canvas');

				echo '</ul>';

			 }



			 /*bottom text*/

			 if(!empty($options['header-slide-out-widget-area-bottom-text'])) {

			 	$desktop_social = (!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1') ? 'false' : 'true';

			 	echo '<p class="bottom-text" data-has-desktop-social="'. $desktop_social .'">'.$options['header-slide-out-widget-area-bottom-text'].'</p>';

			 }



			echo '</div><!--/bottom-meta-wrap-->';



			if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt' || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right') || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right-hover') ) echo '</div> <!--/inner-wrap-->'; ?>



	</div>

<?php } ?>
</div> <!--/ajax-content-wrap-->



<?php if(!empty($options['boxed_layout']) && $options['boxed_layout'] == '1' && $headerFormat != 'left-header') { echo '</div>'; } ?>



<?php if(!empty($options['back-to-top']) && $options['back-to-top'] == 1) { ?>

	<a id="to-top" class="<?php if(!empty($options['back-to-top-mobile']) && $options['back-to-top-mobile'] == 1) echo 'mobile-enabled'; ?>"><i class="fa fa-angle-up"></i></a>

<?php } 



$body_border = (!empty($options['body-border'])) ? $options['body-border'] : 'off';

if($body_border == '1') {

	echo '<div class="body-border-top"></div>

		<div class="body-border-right"></div>

		<div class="body-border-bottom"></div>

		<div class="body-border-left"></div>';

} 
?>
<div class="loader_custom">
   <center>
       <img class="loading-image" src="<?php echo site_url(); ?>/wp-content/themes/salient/img/loader_ras.gif" alt="loading..">
   </center>
</div>
<?php
wp_footer(); ?>	
<script>
	jQuery('#search_cat_parent').on('change', function() {
		  	var cat_parent2 = jQuery('#search_cat_parent').val();
		  	var p_cat_val2="true";
  			var subcat_parent2="";
  			var sort_by_val2="";
  			var sort_by2="";
			var child_of_child_cat = "";
  			get_ajax_record(cat_parent2,sort_by2,sort_by_val2,subcat_parent2,p_cat_val2);
	});

 jQuery('#child_of_childcategory').on('change', function() {
 
    var cat_parent = jQuery('#search_cat_parent').val();
	var p_cat_val="true";
	var sort_by_val="";
	var sort_by="";
	var child_of_child_cat = "";
  	var subcat_parent = jQuery('#child_of_childcategory').val(); 
  	var sort_by = jQuery('#sort_by').val();	
  //	var cat_parent = jQuery(this).val();
	if(jQuery('.child-cat-cls').val() != ''){
		subcat_parent=jQuery('.child-cat-cls').val();
  	}
 	if(jQuery(this).val() == "publish_date" || jQuery(this).val() == "post_modified"){
 		cat_parent=jQuery('#search_cat_parent').val();
 		p_cat_val="";
		sort_by_val=jQuery(this).val();
 	}
	get_ajax_record(cat_parent,sort_by,sort_by_val,subcat_parent,p_cat_val,child_of_child_cat);
}); 

 jQuery('#child_ofchild__childcategory').on('change', function() {
 
    var cat_parent = jQuery('#search_cat_parent').val();
	var p_cat_val="true";
	var sort_by_val="";
	var sort_by="";
  	var subcat_parent = ""; 
  	var sort_by = jQuery('#sort_by').val();	
	var child_of_child_cat = jQuery('#child_ofchild__childcategory').val();
  //	var cat_parent = jQuery(this).val();
	if(jQuery('.child-cat-cls').val() != ''){
		subcat_parent=jQuery('.child-cat-cls').val();
  	}
 	if(jQuery(this).val() == "publish_date" || jQuery(this).val() == "post_modified"){
 		cat_parent=jQuery('#search_cat_parent').val();
 		p_cat_val="";
		sort_by_val=jQuery('#sort_by').val();
 	}
	get_ajax_record(cat_parent,sort_by,sort_by_val,subcat_parent,p_cat_val,child_of_child_cat);
}); 

function get_ajax_record(cat_parent2,sort_by2,sort_by_val2,subcat_parent2,p_cat_val2,child_of_child_cat){

	var admin_url = "<?php echo admin_url('admin-ajax.php') ?>"; 
	 var pdata = {
        action: "get_child_category_by_parent_id_func",
        parent_cat_id: cat_parent2,
		sort_by:sort_by2,
		sort_by_val:sort_by_val2,
		 sub_cat_id: subcat_parent2,
		 sub_child_cat_id: child_of_child_cat,
		 p_cat_val: p_cat_val2,
    }
    jQuery('.loader_custom').show();
	 jQuery.ajax({
	      type: 'POST',
	      url : admin_url,
	      data : pdata,
	      dataType: "json",
	      success:  function (data) {
			  if(data['sel_data_key'] == 'true'){
				jQuery('select.child-cat-cls').html(data['option_val']);
				jQuery('#result').html(data['post_val']);
			  }
			  else if(data['sel_data_key'] == 'true_sub_cat'){
				  jQuery('select#child_ofchild__childcategory').html(data['option_val2']);
				  jQuery('#result').html(data['post_val']);
			  }
			  else{
			  	//alert(data['post_val']);
				  jQuery('#result').html(data['post_val']);
				  //alert(data['sel_data_key2']);
			  }
			  jQuery('.loader_custom').hide();
	      }
	}); 
	
 
}

</script>
<script>
 jQuery(document).ready(function() {
  var maxHeight = -1;

   jQuery('.w3eden .srch-content').each(function() {
    maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 });

  jQuery('.w3eden .srch-content').each(function() {
    jQuery(this).height(maxHeight);
 });
});

</script>
<script>

 jQuery(document).ready(function() {
var greatestWidth = 0;   // Stores the greatest width

jQuery('.w3eden .srch-content').each(function() {    // Select the elements you're comparing

    var theWidth = jQuery(this).width();   // Grab the current width

    if( theWidth > greatestWidth) {   // If theWidth > the greatestWidth so far,
        greatestWidth = theWidth;     //    set greatestWidth to theWidth
    }
});

jQuery('.w3eden .srch-content').width(greatestWidth);  
});
</script>
<script>
 jQuery(document).ready(function() {
  var maxHeight = -1;

   jQuery('.srch-content .medias').each(function() {
    maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 });

  jQuery('.srch-content .medias').each(function() {
    jQuery(this).height(maxHeight);
 });
});


</script>
<script>
 jQuery(document).ajaxComplete(function() {
  var maxHeight = -1;

   jQuery('#result .w3eden .srch-content').each(function() {
    maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 });

  jQuery('#result .w3eden .srch-content').each(function() {
    jQuery(this).height(maxHeight);
 });
});

 jQuery(document).ajaxComplete(function() {
  var maxHeight = -1;

   jQuery('#result .srch-content .medias').each(function() {
    maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 });

  jQuery('#result .srch-content .medias').each(function() {
    jQuery(this).height(maxHeight);
 });
});

 jQuery(document).ajaxComplete(function() {
  var maxHeight = -1;

   jQuery('#result .srch-content .medias').each(function() {
    maxHeight = maxHeight >  jQuery(this).height() ? maxHeight :      jQuery(this).height();
 });

  jQuery('#result .srch-content .medias').each(function() {
    jQuery(this).height(maxHeight);
 });
});

</script>

<?php if($theme_skin == 'material') { echo '</div></div><!--/ocm-effect-wrap-->'; } ?>



</body>

</html>